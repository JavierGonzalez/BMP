<?php



function block_info_raw($height='latest') {
    
    $json = file_get_contents('https://bch-chain.api.btc.com/v3/block/'.$height);
    $output = json_decode($json, true)['data']; 
    
    $json = file_get_contents('https://bch-chain.api.btc.com/v3/block/'.$height.'/tx?verbose=3');
    file_put_contents('temp/blocks_api/'.$height.'_tx.txt', $json);
    $output['coinbase'] = json_decode($json, true)['data']['list'][0]; 
    
    $output['outputs'] = json_decode($json, true);
    
    
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
        if ($tx['value']>0 AND $tx['addresses'][0] AND $tx['addresses'][0]!='1111111111111111111114oLvT2')
            $value_total += $tx['value'];
    
    
    foreach ((array)$block_raw['coinbase']['outputs'] AS $tx)
        if ($tx['value']>0 AND $tx['addresses'][0] AND $tx['addresses'][0]!='1111111111111111111114oLvT2')
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
    
    for ($h=$height_next;$h<=($height_next+20)&&$h<=$height_last;$h++) {
        crono();
        $block = block_info($h);    
        
        var_dump($block);
        
        block_insert($block);
    }
    
    return true;
}


function block_insert($block) {
    
    block_delete($block['height']);
    
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
    
    
    foreach (sql("SELECT height FROM blocks ORDER BY height DESC LIMIT ".BLOCK_WINDOW.",".BLOCK_WINDOW) AS $r) {
        $heights_delete[] = $r['height'];
    }
    block_delete($heights_delete);
    
    
    event_chat('<b>[BLOCK] '.$block['height'].'</b> · '.hashpower_humans($block['hashpower']).', '.num($block['tx_count']).' tx');
    
    return true;
}


function block_delete($blocks) {
    
    if (!is_array($blocks))
        $blocks = array($blocks);
    
    sql("DELETE FROM blocks WHERE height IN (".implode(',', (array)$blocks).")");
    sql("DELETE FROM addresses WHERE height IN (".implode(',', (array)$blocks).")");
}