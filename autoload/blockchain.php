<?php # BMP


function get_block_info($height) {
    
    set_time_limit(10*60);

    $block = get_block($height); 

    $coinbase = get_raw_transaction($block['tx'][0]);

    foreach ($coinbase['vout'] AS $tx)
        if ($tx['value']>0 AND $tx['scriptPubKey']['addresses'][0])
            $coinbase_value_total += $tx['value'];
    

    /// Block
    $output['block'] = array(
            'blockchain'            => BLOCKCHAIN,
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
            'reward_coinbase'       => $coinbase_value_total,
            'reward_fees'           => null,
            'coinbase'              => $coinbase['vin'][0]['coinbase'],
            'pool'                  => null,
            'signals'               => null,
            'hashpower'             => block_hashpower($block),
        );


    /// Miners
    foreach ((array)$coinbase['vout'] AS $tx)
        if ($tx['value']>0 AND $tx['scriptPubKey']['addresses'][0])
            $output['miners'][] = array(
                    'blockchain'        => BLOCKCHAIN,
                    'txid'              => $coinbase['txid'],
                    'height'            => $block['height'],
                    'address'           => str_replace('bitcoincash:', '', $tx['scriptPubKey']['addresses'][0]),
                    'method'            => 'value',
                    'value'             => $tx['value'],
                    'quota'             => null,
                    'power'             => (($tx['value']*100)/$coinbase_value_total),
                    'hashpower'         => ($output['block']['hashpower']*(($tx['value']*100)/$coinbase_value_total))/100,
                );


    /// Actions
    foreach ($block['tx'] AS $key => $txid)
        if ($key!==0)
            if ($tx_raw = get_raw_transaction($txid))
                if ($action = action_decode($tx_raw, $block))
                    $output['actions'][] = $action;
    
    
    return $output;
}



function action_decode($tx, $block) {

    $action = array(
            'blockchain'    => BLOCKCHAIN,
            'txid'          => $tx['txid'],
            'height'        => $block['height'],
            'time'          => date("Y-m-d H:i:s", $block['time']),
            'address'       => str_replace('bitcoincash:', '', $tx['vout'][0]['scriptPubKey']['addresses'][0]),
            'op_return'     => $tx['vout'][1]['scriptPubKey']['hex'],
        );

    if (!$op_return_decode = op_return_decode($action['op_return']))
        return false;

    $action = array_merge($action, $op_return_decode);

    $action['power']     = null;
    $action['hashpower'] = null;

    return $action;
}



function get_new_block() {
    
    $rpc_height = get_info()['blocks'];
    
    $bmp_height = sql("SELECT height FROM blocks ORDER BY height DESC LIMIT 1")[0]['height'];
    
    if ($rpc_height==$bmp_height)
        return false;
    
    
    if (!$bmp_height)
        $height = $rpc_height - BLOCK_WINDOW;
    else
        $height = $bmp_height + 1;
    

    block_insert($height);
    

    foreach (sql("SELECT height FROM blocks ORDER BY height DESC LIMIT ".BLOCK_WINDOW.",".BLOCK_WINDOW) AS $r)
        block_delete($r['height']);

    return true;
}



function block_insert($height) {
    
    $info = get_block_info($height);

    sql_insert('blocks',  $info['block']);
    sql_insert('miners',  $info['miners']);
    sql_insert('actions', $info['actions']);


    if (DEBUG)
        print_r2($info);
}



function block_delete($height) {
    sql("DELETE FROM blocks  WHERE height = ".$height);
    sql("DELETE FROM miners  WHERE height = ".$height);
    sql("DELETE FROM actions WHERE height = ".$height);
}



function block_hashpower($block) {
    return ($block['difficulty'] * pow(2,32) / 600); // Hashes per second.
}



function revert_bytes($hex) {
    $hex = str_split($hex, 2);
    $hex = array_reverse($hex);
    return implode('', $hex);
}
