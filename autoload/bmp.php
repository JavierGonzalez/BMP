<?php # BMP — Javier González González



function block_insert($height) {

    if (sql("SELECT id FROM blocks WHERE height = '".e($height)."' LIMIT 1"))   
        return false;

    $info = get_block_info($height);

    sql_insert('blocks',  $info['block']);
    
    foreach (sql("SELECT height FROM blocks ORDER BY height DESC LIMIT ".BLOCK_WINDOW.",".BLOCK_WINDOW) AS $r)
        block_delete($r['height']);

    sql_insert('miners',  $info['miners']);
    
    miners_power();
    
    foreach ((array)$info['actions'] AS $action)
        sql_update('actions', $action, "txid = '".$action['txid']."'", true); // Update (0-conf) or insert.


    
    foreach (sql("SELECT address, p2 AS nick FROM actions WHERE action = 'miner_parameter' AND p1 = 'nick'") AS $r)
        sql_update('miners', array('nick' => $r['nick']), "address = '".$r['address']."'");

    return $info;
}



function get_block_info($height) {
    set_time_limit(10*60);

    $block = rpc_get_block($height); 

    $coinbase = rpc_get_transaction($block['tx'][0]);
    
    foreach ($coinbase['vout'] AS $tx_vout)
        if ($tx_vout['value']>0 AND $tx_vout['scriptPubKey']['addresses'][0])
            $block_coinbase_value += $tx_vout['value'];

            
    /// Block
    $output['block'] = array(
            'chain'                 => BLOCKCHAIN,
            'height'                => $block['height'],
            'hash'                  => $block['hash'],
            'size'                  => $block['size'],
            'tx_count'              => count($block['tx']),
            'version_hex'           => $block['versionHex'],
            'previousblockhash'     => $block['previousblockhash'],
            'merkleroot'            => $block['merkleroot'],
            'time'                  => date("Y-m-d H:i:s", $block['time']),
            'time_median'           => date("Y-m-d H:i:s", $block['mediantime']),
            'bits'                  => $block['bits'],
            'nonce'                 => $block['nonce'],
            'difficulty'            => $block['difficulty'],
            'coinbase'              => $coinbase['vin'][0]['coinbase'],
            'pool'                  => pool_decode(hex2bin($coinbase['vin'][0]['coinbase']))['name'],
            'hashpower'             => block_hashpower($block, $coinbase),
        );


    /// Miners
    foreach ((array)$coinbase['vout'] AS $tx_vout)
        if ($tx_vout['value']>0 AND $tx_vout['scriptPubKey']['addresses'][0])
            $output['miners'][] = array(
                    'chain'         => BLOCKCHAIN,
                    'txid'          => $coinbase['txid'],
                    'height'        => $block['height'],
                    'address'       => address_normalice($tx_vout['scriptPubKey']['addresses'][0]),
                    'method'        => 'value',
                    'value'         => $tx_vout['value'],
                    'quota'         => null,
                    'power'         => null,
                    'hashpower'     => ($output['block']['hashpower']*(($tx_vout['value']*100)/$block_coinbase_value))/100,
                );


    /// Actions
    foreach ($block['tx'] AS $key => $txid)
        if ($key!==0)
            if ($action = get_action($txid, $block))
                $output['actions'][] = $action;
    
    
    return $output;
}



function miners_power() {

    $hashpower_total = sql("SELECT SUM(hashpower) AS ECHO FROM blocks ORDER BY time DESC LIMIT ".BLOCK_WINDOW);

    sql("UPDATE miners SET power = ROUND((hashpower*100)/".$hashpower_total.", ".POWER_PRECISION.")");

}



function get_mempool() {
    
    foreach (rpc_get_mempool() AS $txid)
        if (!sql("SELECT id FROM actions WHERE txid = '".$txid."' LIMIT 1"))
            if ($action = get_action($txid))
                $actions[] = $action;

    return $actions;
}



function get_action($txid, $block=false) {

    $tx = rpc_get_transaction($txid);

    $action = array(
            'chain'     => BLOCKCHAIN,
            'txid'      => $tx['txid'],
            'height'    => ($block?$block['height']:null),
        );

    if (!$tx_info = get_action_tx($tx))
        return false;

    
    $power = sql("SELECT SUM(power) AS power, SUM(hashpower) AS hashpower 
    FROM miners WHERE address = '".e($tx_info['address'])."'")[0];


    // Actions without hashpower are ignored.
    if (!$power['power'])
        return false;


    if (!$op_return_decode = op_return_decode($tx_info['op_return']))
        return false;


    $action = array_merge($action, $tx_info, $op_return_decode, $power);


    if (!$block)
        $action['time'] = date("Y-m-d H:i:s");
    else if ($action['action']=='chat')
        $action['time'] = date("Y-m-d H:i:s", $action['p1']);
    else
        $action['time'] = date("Y-m-d H:i:s", $block['time']);


    if ($nick = sql("SELECT p2 AS ECHO FROM actions WHERE action = 'miner_parameter' AND p1 = 'nick' AND address = '".$action['address']."' ORDER BY time DESC LIMIT 1"))
        if (!is_array($nick))
            $action['nick'] = $nick;

    return $action;
}



function get_action_tx($tx) {
    global $bmp_protocol;

    if (count($tx['vout'])!==2)
        return false;


    // OUTPUT OP_RETURN (index = 1)
    $action['op_return'] = $tx['vout'][1]['scriptPubKey']['hex'];

    if (substr($action['op_return'],0,2)!='6a')
        return false;

    if (substr($action['op_return'],4,2)!=$bmp_protocol['prefix'] AND substr($action['op_return'],6,2)!=$bmp_protocol['prefix']) // Refact
        return false;


    // OUTPUT ADDRESS (index = 0)
    $action['address'] = $tx['vout'][0]['scriptPubKey']['addresses'][0];

    if (!$action['address'])
        return false;


    // OUTPUT ADDRESS is in PREV OUTPUT ADDRESS
    $tx_prev = rpc_get_transaction($tx['vin'][0]['txid']);
    foreach ($tx_prev['vout'] AS $tx_vout)
        if ($action['address']===$tx_vout['scriptPubKey']['addresses'][0])
            $address_valid = true;
    
    if (!$address_valid)
        return false;

    
    $action['address'] = address_normalice($action['address']);

    return $action;
}



function op_return_decode($op_return) {
    global $bmp_protocol;
    
    if (!ctype_xdigit($op_return))
        return false;
        
    if (substr($op_return,0,2)!=='6a')
        return false;
        
    if (substr($op_return,4,2)===$bmp_protocol['prefix']) // Refact
        $metadata_start_bytes = 3;
    else if (substr($op_return,6,2)===$bmp_protocol['prefix']) // Refact
        $metadata_start_bytes = 4;
        
    if (!$metadata_start_bytes)
        return false;

    $action_id  = substr($op_return, $metadata_start_bytes*2, 2);

    if (!$bmp_protocol['actions'][$action_id])
        return false;

    $output = array(
            'action_id' => $action_id,
            'action'    => $bmp_protocol['actions'][$action_id]['action'],
        );

    $counter = $metadata_start_bytes+1;
    foreach ($bmp_protocol['actions'][$action_id] AS $p => $v) {
        if (is_numeric($p)) {
            if ($parameter = substr($op_return, $counter*2, $v['size']*2)) {
    
                if (!$v['hex'])
                    $parameter = trim(injection_filter(hex2bin($parameter)));

                $output['p'.$p] = $parameter;

                $counter += $v['size'];
            }
        }
    }

    $output['json'] = null;

    return $output;
}


