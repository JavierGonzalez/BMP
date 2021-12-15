<?php # BMP — Javier González González


function block_insert($height, $blockchain=BLOCKCHAIN_ACTIONS) {

    if (sql("SELECT id FROM blocks WHERE blockchain = '".e($blockchain)."' AND height = ".e($height)))
        return false;

    $block = rpc_get_block($height, $blockchain);
    $block_hashpower = round($block['difficulty'] * pow(2,32) / 600);
    
    $coinbase = rpc_get_transaction($block['tx'][0], $blockchain);
    if (!$coinbase)
        return false;
    
    $coinbase_quota = coinbase_quota($coinbase);
	$coinbase_quota_total = 0;
    foreach ((array)$coinbase_quota['miners'] AS $miner)
        $coinbase_quota_total += $miner['quota'];

    $pool = pool_decode($coinbase);
    
    
    /// BLOCK
    sql_insert('blocks', [
        'blockchain'            => $blockchain,
        'height'                => $block['height'],
        'hash'                  => $block['hash'],
        'size'                  => $block['size'],
        'tx_count'              => count($block['tx']),
        'version_hex'           => $block['versionHex'],
        'time'                  => date('Y-m-d H:i:s', $block['time']),
        'time_median'           => date('Y-m-d H:i:s', $block['mediantime']),
        'difficulty'            => $block['difficulty'],
        'coinbase'              => $coinbase['vin'][0]['coinbase'],
        'pool'                  => $pool['name'],
        'pool_link'             => ($pool['link']?$pool['link']:null),
        'power_by'              => $coinbase_quota['power_by'],
        'quota_total'           => $coinbase_quota_total,
        'hashpower'             => $block_hashpower,
    ]);

    /// MINERS
    foreach ((array)$coinbase_quota['miners'] AS $miner)
        sql_insert('miners', [
            'blockchain'    => $blockchain,
            'txid'          => $coinbase['txid'],
            'height'        => $block['height'],
            'address'       => $miner['address'],
            'quota'         => $miner['quota'],
            'hashpower'     => round(($block_hashpower * $miner['quota']) / $coinbase_quota_total / BLOCK_WINDOW),
        ]);
    

    foreach (sql("SELECT height FROM blocks WHERE blockchain = '".e($blockchain)."' ORDER BY height DESC LIMIT ".e(BLOCK_WINDOW).",".e(BLOCK_WINDOW)) AS $r)
        block_delete($r['height'], $blockchain);

    
    update_power();


    if ($blockchain != BLOCKCHAIN_ACTIONS)
        return true;


    /// ACTIONS
    foreach ($block['tx'] AS $key => $txid)
        if ($key!==0 AND $action = get_action($txid, $blockchain, $block))
            sql_update('actions', $action, "txid = '".e($action['txid'])."'", true);

    update_actions($blockchain, $block['height']);

    return true;
}



function update_power() {
    $total_hashpower = sql("SELECT SUM(hashpower) AS ECHO FROM miners");
    sql("UPDATE miners SET power = (hashpower*100)/".e($total_hashpower));
}



function coinbase_quota($coinbase) {

    // power_by_opreturn
    foreach ($coinbase['vout'] AS $tx_vout)
        if ($action = op_return_decode($tx_vout['scriptPubKey']['hex']))
            if ($action['action_id']=='00')
                $output['miners'][] = [
                    'power_by' => 'opreturn',
                    'quota'    => $action['p1'],
                    'address'  => address_normalice($action['p2']),
                ];

    if ($output['miners']) {
        $output['power_by'] = 'opreturn';


    } else {
        // power_by_value
        foreach ($coinbase['vout'] AS $tx_vout)
            if ($tx_vout['value']>0 AND $tx_vout['scriptPubKey']['addresses'][0])
                $output['miners'][] = [
                    'power_by' => 'value',
                    'quota'    => $tx_vout['value'],
                    'address'  => address_normalice($tx_vout['scriptPubKey']['addresses'][0]),
                ];

        $output['power_by'] = 'value';
    }

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
                  FROM miners WHERE address = '".e($tx_info['address'])."'")[0];
    

    // Actions without hashpower are ignored.
    if (!$power['hashpower'])
        return false;


    if (!$op_return_decode = op_return_decode($tx_info['op_return']))
        return false;


    $action = array_merge($action, $tx_info, $op_return_decode, $power);


    if (!$block)
        $action['time'] = date('Y-m-d H:i:s');                      // By BMP server
    else if ($action['action']=='chat' AND $action['p1']<=time() AND $action['p1']>($block['time']-1800))
        $action['time'] = date('Y-m-d H:i:s', $action['p1']);       // By user
    else
        $action['time'] = date('Y-m-d H:i:s', $block['time']);      // By hashpower

    
    if ($block AND sql("SELECT id FROM actions WHERE txid = '".e($action['txid'])."' LIMIT 1"))
        unset($action['time']);


    $nick = sql("SELECT p2 AS ECHO FROM actions 
        WHERE action = 'miner_parameter' AND p1 = 'nick' AND address = '".e($action['address'])."' 
        ORDER BY time DESC LIMIT 1");
    if ($nick AND !is_array($nick))
        $action['nick'] = $nick;
    

    $evidence['miner'] = sql("SELECT blockchain, height, (SELECT hash FROM blocks WHERE blockchain = miners.blockchain AND height = miners.height LIMIT 1) AS block_hash, txid, address, power, hashpower 
        FROM miners WHERE address = '".e($action['address'])."' ORDER BY height ASC");
    $action['evidence'] = json_encode($evidence);
        
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

    $action_id = substr($op_return, $metadata_start_bytes*2, 2);

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

            // Decodification
            if ($v['decode']=='hex2bin')
                $parameter = injection_filter(hex2bin($parameter));

            if ($v['decode']=='hexdec')
                $parameter = hexdec($parameter);
            
            $parameter = trim($parameter);


            // Validation
            if (is_array($v['options']) AND !array_key_exists($parameter, $v['options']))
                return false;

            if ($v['min'] AND $parameter < $v['min'])
                return false;

            if ($v['max'] AND $parameter > $v['max'])
                return false;

            if ($v['validate']=='address' AND address_validate($parameter)!==true)
                return false;


            $output['p'.$p] = $parameter;
        }
    }

    return $output;
}