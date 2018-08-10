<?php 


$template = false;



function block_info_raw($height='latest') {
    
    // $height = 'latest';
    
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
    
    foreach (explode(' ', 'height timestamp nonce hash size difficulty tx_count reward_block reward_fees confirmations') AS $element)
        $output[$element] = $block_raw[$element];
    
    
    $output['hashpower'] = block_hashpower($block_raw);
    $output['hashpower_humans'] = hashpower_humans($output['hashpower']);
    
    
    $output['coinbase_text_hex'] = $block_raw['coinbase']['inputs'][0]['script_hex'];
    $output['coinbase_text'] = hex2bin($output['coinbase_text_hex']);
    $output['coinbase_text_signals'] = array_filter(explode('/', $output['coinbase_text']));
    
    
    foreach ($block_raw['coinbase']['outputs'] AS $tx)
        if ($tx['value']>0 AND $tx['addresses'][0])
            $value_total += $tx['value'];
    
    
    foreach ($block_raw['coinbase']['outputs'] AS $tx)
        if ($tx['value']>0 AND $tx['addresses'][0])
            $output['coinbase_addresses'][] = array(
                    'address'           => $tx['addresses'][0],
                    'value'             => $tx['value'],
                    'share'             => (($tx['value']*100)/$value_total),
                    'hashpower'         => ($output['hashpower']/(($tx['value']*100)/$value_total/100)),
                    'hashpower_humans'  => hashpower_humans(($output['hashpower']*$tx['value'])/$value_total),
                );
    
    
    
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



//////////////////////////////////////////


$height = 459871;

$block = block_info_raw($height);
// print_r($block);


$block = block_info($height);
print_r($block);

echo "\n";

$hps = block_hashpower($block);
print_r($hps);

echo "\n";

$output = hashpower_humans($hps);
print_r($output);


