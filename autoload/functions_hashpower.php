<?php



function block_info_raw($height='latest') {
    
    $json = file_get_contents('https://bch-chain.api.btc.com/v3/block/'.$height);
    $output = json_decode($json, true)['data']; 
    
    $json = file_get_contents('https://bch-chain.api.btc.com/v3/block/'.$height.'/tx?verbose=3');
    $output['coinbase'] = json_decode($json, true)['data']['list'][0]; 
    
    
    if (!$output['height'])
        return false;
    
    return $output;
}



function block_info($height='latest') {
    
    $block_raw = block_info_raw($height);
    
    foreach (explode(' ', 'height timestamp nonce hash size difficulty tx_count reward_block reward_fees') AS $element)
        $output[$element] = $block_raw[$element];
    
    if (count($block_raw['coinbase']['outputs'])>1)
        $output['bmp'] = 'true';
    
    
    $output['hashpower'] = block_hashpower($block_raw);
    $output['hashpower_humans'] = hashpower_humans($output['hashpower']);
    
    
    $output['coinbase_text_hex'] = $block_raw['coinbase']['inputs'][0]['script_hex'];
    $output['coinbase_text'] = hex2bin($output['coinbase_text_hex']);
    $output['coinbase_text_signals'] = array_filter(explode('/', $output['coinbase_text']));
    
    
    foreach ((array)$block_raw['coinbase']['outputs'] AS $tx)
        if ($tx['value']>0 AND $tx['addresses'][0])
            $value_total += $tx['value'];
    
    
    foreach ((array)$block_raw['coinbase']['outputs'] AS $tx)
        if ($tx['value']>0 AND $tx['addresses'][0])
            $output['coinbase_addresses'][] = array(
                    'address'           => $tx['addresses'][0],
                    'value'             => $tx['value'],
                    'share'             => (($tx['value']*100)/$value_total),
                    'hashpower'         => ($output['hashpower']/(($tx['value']*100)/$value_total/100)),
                    'hashpower_humans'  => hashpower_humans(($output['hashpower']*$tx['value'])/$value_total),
                );
    
    
    if ($output['coinbase_addresses'])
        usort($output['coinbase_addresses'], function($a, $b) {
                return $b['value'] - $a['value'];
            });
    
    
    return $output;
}



function block_hashpower($block) {
    return ($block['difficulty'] * pow(2,32) / 600); // hps = hashesh per second
}



function hashpower_humans($hps) {
    return num($hps/1000/1000000/1000000, 2).' PH/s';
}



function block_height_last() {
    $json = file_get_contents('https://bch-chain.api.btc.com/v3/block/latest');
    return json_decode($json, true)['data']['height'];
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
    
    $block = block_info($height_next);    
    
    var_dump($block);
    
    block_update_insert($block);
    
    return true;
}


function block_update_insert($block) {
    
    foreach (explode(' ', 'height date nonce hash size difficulty tx_count reward_block reward_fees hashpower coinbase_text_hex coinbase_text') AS $value)
        $insert_block[$value] = $block[$value];

    sql_insert('blocks', $insert_block);
    
    
    foreach ((array)$block['coinbase_addresses'] AS $value)
        $insert_addresses[] = array(
                'height'        => $block['height'],
                'address'       => $value['address'],
                'value'         => $value['value'],
                'share'         => $value['share'],
                'hashpower'     => $value['hashpower'],
            );
    
    
    sql_insert('addresses', $insert_addresses);
    
    
    event_chat('<b>[BLOCK] '.$block['height'].'</b> '.num($block['tx_count']).' tx, '.hashpower_humans($block['hashpower']));
    
    return true;
}
