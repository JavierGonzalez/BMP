<?php # BMP — Javier González González


function block_insert($height, $blockchain=BLOCKCHAIN_ACTIONS) {

    if (sql("SELECT id FROM blocks WHERE blockchain = '".$blockchain."' AND height = ".e($height)))
        return false;

    ini_set('memory_limit', '15G');


    $block = rpc_get_block($height, $blockchain);
    $block_hashpower = $block['difficulty'] * pow(2,32) / 600; // Hashpower = Hashes per second.
    
    $coinbase = rpc_get_transaction($block['tx'][0], $blockchain);
    $coinbase_hashpower = coinbase_hashpower($coinbase);
    
    if (!$coinbase)
        return false;

    $pool = pool_decode($coinbase, $coinbase_hashpower);
    
    /// BLOCK
    sql_insert('blocks', [
        'blockchain'            => $blockchain,
        'height'                => $block['height'],
        'hash'                  => $block['hash'],
        'size'                  => $block['size'],
        'tx_count'              => count($block['tx']),
        'version_hex'           => $block['versionHex'],
        'previousblockhash'     => $block['previousblockhash'],
        'merkleroot'            => $block['merkleroot'],
        'time'                  => date('Y-m-d H:i:s', $block['time']),
        'time_median'           => date('Y-m-d H:i:s', $block['mediantime']),
        'bits'                  => $block['bits'],
        'nonce'                 => $block['nonce'],
        'difficulty'            => $block['difficulty'],
        'coinbase'              => $coinbase['vin'][0]['coinbase'],
        'pool'                  => $pool['name'],
        'pool_link'             => ($pool['link']?$pool['link']:null),
        'power_by'              => $coinbase_hashpower['power_by'],
        'quota_total'           => $coinbase_hashpower['quota_total'],
        'hashpower'             => $block_hashpower,
        ]);

    foreach (sql("SELECT height FROM blocks WHERE blockchain = '".$blockchain."' ORDER BY height DESC LIMIT ".BLOCK_WINDOW.",".BLOCK_WINDOW) AS $r)
        block_delete($r['height'], $blockchain);

    

    /// MINERS
    foreach ((array)$coinbase_hashpower['miners'] AS $miner)
        sql_insert('miners', [
            'blockchain'    => $blockchain,
            'txid'          => $coinbase['txid'],
            'height'        => $block['height'],
            'address'       => $miner['address'],
            'quota'         => $miner['quota'],
            'hashpower'     => round(($block_hashpower * $miner['quota']) / $coinbase_hashpower['quota_total']),
            ]);
    
    update_power();


    if ($blockchain != BLOCKCHAIN_ACTIONS)
        return true;


    /// ACTIONS
    foreach ($block['tx'] AS $key => $txid)
        if ($key!==0)
            if ($action = get_action($txid, $blockchain, $block))
                sql_update('actions', $action, "txid = '".$action['txid']."'", true);

    update_actions();

    return true;
}



function update_power() {

    $total_hashpower = sql("SELECT SUM(hashpower) AS ECHO FROM miners");

    sql("UPDATE miners SET power = (hashpower*100)/".$total_hashpower);

}



function coinbase_hashpower($coinbase) {

    // Power by OP_RETURN in coinbase.
    foreach ($coinbase['vout'] AS $tx_vout)
        if ($coinbase_action = op_return_decode($tx_vout['scriptPubKey']['hex']))
            $output['miners'][] = [
                'quota'   => $coinbase_action['p1'],
                'address' => address_normalice($coinbase_action['p2']),
                ];


    if ($output['miners']) {
        $output['power_by'] = 'opreturn';
    
    } else {
        $output['power_by'] = 'value';

        foreach ($coinbase['vout'] AS $tx_vout)
            if ($tx_vout['value']>0 AND $tx_vout['scriptPubKey']['addresses'][0])
                $output['miners'][] = [
                    'quota'   => $tx_vout['value'],
                    'address' => address_normalice($tx_vout['scriptPubKey']['addresses'][0]),
                    ];

    }
    
    foreach ($output['miners'] AS $miner)
        $output['quota_total'] += $miner['quota'];

    return $output;
}



function get_action($txid, $blockchain=BLOCKCHAIN_ACTIONS, $block=false) {

    $tx = rpc_get_transaction($txid, $blockchain);
    
    $action = [
        'blockchain'    => BLOCKCHAIN_ACTIONS,
        'txid'          => $tx['txid'],
        ];
    
    if ($block)
        $action['height'] = $block['height'];


    if (!$tx_info = get_action_tx($tx, $blockchain))
        return false;

    
    $power = sql("SELECT SUM(power) AS power, SUM(hashpower) AS hashpower 
                  FROM miners WHERE address = '".$tx_info['address']."'")[0];
    

    // Actions without hashpower are ignored.
    if (!$power['hashpower'])
        return false;


    if (!$op_return_decode = op_return_decode($tx_info['op_return']))
        return false;


    $action = array_merge($action, $tx_info, $op_return_decode, $power);


    if (!$block)
        $action['time'] = date('Y-m-d H:i:s');                      // By BMP server
    else if ($action['action']=='chat' AND $action['p1']<=time())
        $action['time'] = date('Y-m-d H:i:s', $action['p1']);       // By user
    else
        $action['time'] = date('Y-m-d H:i:s', $block['time']);      // By hashpower

    
    if ($block AND sql("SELECT id FROM actions WHERE txid = '".$action['txid']."' LIMIT 1"))
        unset($action['time']);


    $nick = sql("SELECT p2 AS ECHO FROM actions 
        WHERE action = 'miner_parameter' AND p1 = 'nick' AND address = '".$action['address']."' 
        ORDER BY time DESC LIMIT 1");
    if ($nick AND !is_array($nick))
        $action['nick'] = $nick;
    

    $proof['miner'] = sql("SELECT blockchain, height, (SELECT hash FROM blocks WHERE height = miners.height LIMIT 1) AS block_hash, txid, address, power, hashpower FROM miners WHERE address = '".$action['address']."' ORDER BY height ASC");
    $action['json'] = json_encode($proof);
        
    return $action;
}



function get_action_tx($tx, $blockchain=BLOCKCHAIN_ACTIONS) {

    if (count($tx['vout'])!==2)
        return false;


    // OUTPUT OP_RETURN (index = 1)
    $action['op_return'] = $tx['vout'][1]['scriptPubKey']['hex'];

    if (substr($action['op_return'],0,2)!='6a')
        return false;

    if (!in_array(BMP_PROTOCOL['prefix'], [substr($action['op_return'],4,2), substr($action['op_return'],6,2)]))
       return false;  // Refact


    // ADDRESS (index = 0)
    $action['address'] = $tx['vout'][0]['scriptPubKey']['addresses'][0];

    if (!$action['address'])
        return false;


    // ADDRESS is in PREV OUTPUT
    $tx_prev = rpc_get_transaction($tx['vin'][0]['txid'], $blockchain);
    foreach ($tx_prev['vout'] AS $tx_vout)
        if ($action['address']===$tx_vout['scriptPubKey']['addresses'][0])
            $address_valid = true;
   
    if (!$address_valid)
        return false;


    $action['address'] = address_normalice($action['address']);

    return $action;
}



function op_return_decode($op_return) {

    if (!ctype_xdigit($op_return))
        return false;
        
    if (substr($op_return,0,2)!=='6a')
        return false;
        
    if (substr($op_return,4,2)===BMP_PROTOCOL['prefix']) // Refact
        $metadata_start_bytes = 3;
    else if (substr($op_return,6,2)===BMP_PROTOCOL['prefix']) // Refact
        $metadata_start_bytes = 4;
        
    if (!$metadata_start_bytes)
        return false;

    $action_id  = substr($op_return, $metadata_start_bytes*2, 2);

    if (!BMP_PROTOCOL['actions'][$action_id])
        return false;

    $output = [
        'action_id' => $action_id,
        'action'    => BMP_PROTOCOL['actions'][$action_id]['action'],
        ];

    $counter = $metadata_start_bytes + 1;

    foreach (BMP_PROTOCOL['actions'][$action_id] AS $p => $v) {
        if (is_numeric($p) AND $parameter = substr($op_return, $counter*2, $v['size']*2)) {

            $counter += $v['size'];

            if ($v['decode']=='hex2bin')
                $parameter = injection_filter(hex2bin($parameter));

            if ($v['decode']=='hexdec')
                $parameter = hexdec($parameter);

            if ($v['decode']=='hextobase58')
                $parameter = hextobase58($parameter);
            
            $parameter = trim($parameter);

            if (is_array($v['options']) AND !array_key_exists($parameter, $v['options']))
                return false;

            if ($v['min'] AND $parameter < $v['min'])
                return false;

            if ($v['max'] AND $parameter > $v['max'])
                return false;

            $output['p'.$p] = $parameter;
        }
    }

    return $output;
}



function get_mempool($blockchain=BLOCKCHAIN_ACTIONS) {
    global $__mempool_cache;

    foreach (rpc_get_mempool($blockchain) AS $txid)
        if (!$__mempool_cache[$txid] AND $__mempool_cache[$txid] = true)
            if (!sql("SELECT id FROM actions WHERE txid = '".$txid."' LIMIT 1"))
                if ($action = get_action($txid, $blockchain))
                    $actions[] = $action;
    
    return $actions;
}



function block_delete($height, $blockchain=BLOCKCHAIN_ACTIONS) {
    sql("DELETE FROM blocks WHERE blockchain = '".$blockchain."' AND height = ".$height);
    sql("DELETE FROM miners WHERE blockchain = '".$blockchain."' AND height = ".$height);
}
