<?php # BMP — Javier González González


function revert_bytes($hex) {
    $hex = str_split($hex, 2);
    $hex = array_reverse($hex);
    return implode('', $hex);
}


function pool_decode($coinbase) {
    global $pools_json_cache;

    if (!$pools_json_cache)
        $pools_json_cache = json_decode(file_get_contents('public/static/pools.json'), true);


    foreach ($pools_json_cache['coinbase_tags'] AS $tag => $pool)
        if (strpos($coinbase, $tag)!==false)
            return $pool;

    return null;
}


function address_normalice($address) {
    
    include_once('lib/cashaddress.php');

    if (substr($address,0,12)=='bitcoincash:')
        $address = \CashAddress\CashAddress::new2old($address, false);

    return trim($address);
}


function hashpower_humans($hps, $decimals=0) {

    if (!is_numeric($hps) OR $hps==0)
        return '';

    $prefix = array(
               1000000000000000000 => 'E',
                  1000000000000000 => 'P',
                     1000000000000 => 'T',
                        1000000000 => 'G',
        );

    foreach ($prefix AS $x => $p)
        if ($hps/$x >= 10 OR $x==1000000000)
            return num($hps/$x, $decimals).'&nbsp;'.$p.'H/s';

}


function get_new_block() {
    
    $rpc_height = rpc_get_info()['blocks'];
    
    $bmp_height = sql("SELECT height FROM blocks ORDER BY height DESC LIMIT 1")[0]['height'];
    
    if ($rpc_height==$bmp_height)
        return false;
    
    if (!$bmp_height)
        $height = $rpc_height - BLOCK_WINDOW; // Refact
    else
        $height = $bmp_height + 1;
    
    
    $info = block_insert($height);
    
    return $info;
}


function block_delete_from($height) {
    sql("DELETE FROM blocks  WHERE height >= ".$height);
    sql("DELETE FROM miners  WHERE height >= ".$height);
    sql("DELETE FROM actions WHERE height >= ".$height);
    update_power();
    update_actions();
}


function hextobase58($hex) {
    include_once('lib/base58.php');
    $base58 = new Base58;
    
    return $base58->encode($hex);
}
