<?php # BMP


require_once('lib/easybitcoin.php');
$sb = parse_url(URL_BCH);
$rpc = new Bitcoin($sb['user'], $sb['pass'], $sb['host'], $sb['port']);



function block_get_info($height) {
    global $rpc;
    
    $block = $rpc->getblock($rpc->getblockhash($height)); 

    $coinbase = $rpc->getrawtransaction($block['tx'][0], 1);

    foreach ((array)$coinbase['vout'] AS $tx)
        if ($tx['value']>0 AND $tx['scriptPubKey']['addresses'][0])
            $coinbase_value_total += $tx['value'];



    /// Block
    $output['block'] = array(
            'blockchain'            => BLOCKCHAIN,
            'height'                => $block['height'],
            'hash'                  => $block['hash'],
            'hashpower'             => block_hashpower($block),
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
        );


    /// Miners
    foreach ((array)$coinbase['vout'] AS $tx)
        if ($tx['value']>0 AND $tx['scriptPubKey']['addresses'][0])
            $output['miners'][] = array(
                    'blockchain'        => BLOCKCHAIN,
                    'txid'              => $coinbase['txid'],
                    'height'            => $block['height'],
                    'address'           => $tx['scriptPubKey']['addresses'][0],
                    'method'            => 'value',
                    'value'             => $tx['value'],
                    'quota'             => null,
                    'power'             => (($tx['value']*100)/$coinbase_value_total),
                    'hashpower'         => ($output['block']['hashpower']*(($tx['value']*100)/$coinbase_value_total))/100,
                );
    

    // Order by value desc
    usort($output['miners'], function($a, $b) { 
            return $b['value'] - $a['value']; 
        });


    /// Actions
    foreach ($block['tx'] AS $key => $txid)
        if ($key!==0 AND false)
            $output['actions'][] = action_decode($rpc->getrawtransaction($txid, 1), $block);
    
    
    return $output;
}


function action_decode($tx, $block) {

    $output = array(
            'blockchain'    => BLOCKCHAIN,
            'txid'          => $tx['txid'],
            'height'        => $block['height'],
            'time'          => date("Y-m-d H:i:s", $block['time']),
            'address'       => null,
            'op_return'     => null,
            'action'        => null,
            'action_id'     => null,
            'p1'            => null,
            'p2'            => null,
            'p3'            => null,
            'p4'            => null,
            'p5'            => null,
            'p6'            => null,
            'json'          => null,
            'power'         => null,
            'hashpower'     => null,
        );

    return $output;
}



function block_update() {
    
    $height_last = block_height_last();
    
    $bmp_height_last = sql("SELECT height FROM blocks ORDER BY height DESC LIMIT 1")[0]['height'];
    
    if ($height_last==$bmp_height_last)
        return false;
    
    
    if (!$bmp_height_last)
        $height_next = $height_last-BLOCK_WINDOW;
    else
        $height_next = $bmp_height_last + 1;
    

    for ($h=$height_next;$h<=($height_next+0)&&$h<=$height_last;$h++)
        block_insert($h);
    

    return true;
}



function block_insert($height) {
    
    $info = block_get_info($height);

    print_r2($info);

    block_delete($info['block']['height']);


    sql_insert('blocks', $info['block']);

    sql_insert('miners', $info['miners']);

    // sql_insert('actions', $info['actions']);


    foreach (sql("SELECT height FROM blocks ORDER BY height DESC LIMIT ".BLOCK_WINDOW.",".BLOCK_WINDOW) AS $r)
        block_delete($r['height']);


    // event_chat('<b>[BLOCK] '.$block['height'].'</b> · '.hashpower_humans($block['hashpower']).', '.num($block['tx_count']).' tx');
    
    return true;
}



function block_delete($height) {
    
    if (!is_array($height))
        $height = array($height);
    
    sql("DELETE FROM blocks WHERE height IN (".implode(',', (array)$height).")");
    sql("DELETE FROM miners WHERE height IN (".implode(',', (array)$height).")");
}





function block_hashpower($block) {
    return ($block['difficulty'] * pow(2,32) / 600); // hps = hashesh per second
}



function hashpower_humans($hps, $decimals=2) {
    return num($hps/1000000/1000000, $decimals).'&nbsp;TH/s';
}



function block_height_last() {
    global $rpc;
    return $rpc->getinfo()['blocks'];
}



function revert_bytes($input) {
    $output = str_split($input, 2);
    $output = array_reverse($output);
    $output = implode('', $output);
    return $output;
}