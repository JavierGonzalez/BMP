<?php # BMP


function block_hashpower($block) {
    return ($block['difficulty'] * pow(2,32) / 600); // Hashes per second.
}



function revert_bytes($hex) {
    $hex = str_split($hex, 2);
    $hex = array_reverse($hex);
    return implode('', $hex);
}



function pool_decode($coinbase) {
    global $pools_json;

    if (!is_array($pools_json))
        $pools_json = json_decode(file_get_contents('public/static/pools.json'), true);


    foreach ($pools_json['coinbase_tags'] AS $tag => $pool)
        if (strpos($coinbase, $tag)!==false)
            return $pool;

    return null;
}



function address_normalice($address) {
    return str_replace('bitcoincash:', '', $address);
}



function hashpower_humans($hps, $decimals=0) {
    return num($hps/1000000/1000000, $decimals).'&nbsp;TH/s';
}
