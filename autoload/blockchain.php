<?php # BMP


function block_insert($height) {

    $info = get_block_info($height);


    sql_insert('blocks',  $info['block']);
    
    foreach (sql("SELECT height FROM blocks ORDER BY height DESC LIMIT ".BLOCK_WINDOW.",".BLOCK_WINDOW) AS $r)
        block_delete($r['height']);

    sql_insert('miners',  $info['miners']);
    
    miners_power();
    
    sql_insert('actions', $info['actions']);


    if (DEBUG)
        print_r2($info);
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
            'reward_coinbase'       => $block_coinbase_value,
            'reward_fees'           => null,
            'coinbase'              => $coinbase['vin'][0]['coinbase'],
            'pool'                  => pool_decode(hex2bin($coinbase['vin'][0]['coinbase']))['name'],
            'signals'               => null,
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
            if ($tx_raw = rpc_get_transaction($txid))
                if ($action = action_decode($tx_raw, $block))
                    $output['actions'][] = $action;
    
    
    return $output;
}


function miners_power() {

    $bitcoin_hashpower = sql("SELECT SUM(hashpower) AS ECHO FROM blocks ORDER BY time DESC LIMIT ".BLOCK_WINDOW);

    sql("UPDATE miners SET power = ROUND((hashpower*100)/".$bitcoin_hashpower.", ".MINERS_POWER_PRECISION.")");

}



function action_decode($tx, $block) {

    $action = array(
            'chain'     => BLOCKCHAIN,
            'txid'      => $tx['txid'],
            'height'    => $block['height'],
            'time'      => date("Y-m-d H:i:s", $block['time']),
        );

    if (!$tx_info = get_tx_info($tx))
        return false;

    if (!$op_return_decode = op_return_decode($tx_info['op_return']))
        return false;

    $action = array_merge($action, $tx_info, $op_return_decode);


    $action = array_merge($action, 
            sql("SELECT SUM(power) AS power, SUM(hashpower) AS hashpower 
            FROM miners WHERE address = '".e($action['address'])."'")[0]
        );


    if (!$action['power'] AND DEBUG) {
        $action['power']     = 0;
        $action['hashpower'] = 0;
    }

    return $action;
}



function get_tx_info($tx) {
    global $bmp_protocol;
    
    if (count($tx['vout'])!==2)
        return false;


    // OUTPUT OP_RETURN
    foreach ($tx['vout'] AS $tx_vout)
        if ($tx_vout['value']==0)
            if ($op_return = $tx_vout['scriptPubKey']['hex'])
                if (substr($op_return,0,2)=='6a')
                    if (substr($op_return,4,2)==$bmp_protocol['prefix'] OR substr($op_return,6,2)==$bmp_protocol['prefix'])
                        $output['op_return'] = $op_return;

    if (!$output['op_return'])
        return false;


    // INPUT ADDRESS
    $tx_prev = rpc_get_transaction($tx['vin'][0]['txid']);
    foreach ($tx_prev['vout'] AS $tx_vout)
        if ($output['address'] = address_normalice($tx_vout['scriptPubKey']['addresses'][0]))
            break;
    
    if (!$output['address'])
        return false;


    return $output;
}



function op_return_decode($op_return) {
    global $bmp_protocol;

    if (!ctype_xdigit($op_return))
        return false;

    if (substr($op_return,0,2)!=='6a')
        return false;

    if (substr($op_return,4,2)===$bmp_protocol['prefix'])
        $metadata_start_bytes = 3;
    else if (substr($op_return,6,2)===$bmp_protocol['prefix'])
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
            $parameter = substr($op_return, $counter*2, $v['size']*2);
            if ($parameter) {
    
                if (!$v['hex'])
                    $parameter = injection_filter(hex2bin($parameter));

                $output['p'.$p] = $parameter;

                $counter += $v['size'];
            }
        }
    }

    $output['json'] = null;

    return $output;
}




function get_new_block() {
    
    $rpc_height = rpc_get_info()['blocks'];
    
    $bmp_height = sql("SELECT height FROM blocks ORDER BY height DESC LIMIT 1")[0]['height'];
    
    if ($rpc_height==$bmp_height)
        return false;
    
    
    if (!$bmp_height)
        $height = $rpc_height - BLOCK_WINDOW;
    else
        $height = $bmp_height + 1;
    

    block_insert($height);
    

    return true;
}


function block_delete($height) {
    sql("DELETE FROM blocks  WHERE height = ".$height);
    sql("DELETE FROM miners  WHERE height = ".$height);
    sql("DELETE FROM actions WHERE height = ".$height);
}

