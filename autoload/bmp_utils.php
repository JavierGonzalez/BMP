<?php # BMP — Javier González González



function get_new_blocks() {
    $output = false;
    
    foreach (BLOCKCHAINS AS $blockchain)
        if (get_new_block($blockchain))
            $output = true;

    return $output;
}



function get_new_block($blockchain=BLOCKCHAIN_ACTIONS) {
    
    $rpc_height = rpc_get_best_height($blockchain);
    
    $bmp_height = sql("SELECT height AS ECHO FROM blocks WHERE blockchain = '".$blockchain."' ORDER BY height DESC LIMIT 1");
    
    if (!is_numeric($rpc_height) OR $rpc_height==$bmp_height)
        return false;
    
    if ($bmp_height)
        $height = $bmp_height + 1;
    else if ($blockchain==BLOCKCHAIN_ACTIONS)
        $height = BMP_GENESIS_BLOCK;
    else
        $height = rpc_get_best_height($blockchain)-BLOCK_WINDOW;
    

    block_insert($height, $blockchain);


    return true;
}


function block_delete_from($height, $blockchain=BLOCKCHAIN_ACTIONS) {
    sql("DELETE FROM blocks  WHERE blockchain = '".$blockchain."' AND height >= ".e($height));
    sql("DELETE FROM miners  WHERE blockchain = '".$blockchain."' AND height >= ".e($height));
    sql("DELETE FROM actions WHERE blockchain = '".$blockchain."' AND height >= ".e($height));
    update_power();
    update_actions();
}


function revert_bytes($hex) {
    $hex = str_split($hex, 2);
    $hex = array_reverse($hex);
    return implode('', $hex);
}


function pool_decode($coinbase, $coinbase_hashpower=false) {
    global $__pools_json_cache;

    if (!$__pools_json_cache)
        $__pools_json_cache = json_decode(file_get_contents('lib/pools.json'), true);


    foreach ($__pools_json_cache['payout_addresses'] AS $address => $pool)
        foreach ((array)$coinbase['vout'] AS $vout)
            if ($address === $vout['scriptPubKey']['addresses'][0])
                return $pool;


    $coinbase_text = hex2bin($coinbase['vin'][0]['coinbase']);
    foreach ($__pools_json_cache['coinbase_tags'] AS $tag => $pool)
        if (strpos($coinbase_text, $tag)!==false)
            return $pool;


    if (count((array)$coinbase_hashpower['miners'])>=20) // Hack
        return array('name' => 'P2Pool');

    return null;
}


function address_normalice($address) {
    
    if (substr($address,0,12)=='bitcoincash:') {
        include_once('lib/cashaddress.php');
        $address = \CashAddress\CashAddress::new2old($address, false);
    }

    return trim($address);
}


function hashpower_humans($hps, $unit=false, $decimals=0) {

    if (!is_numeric($hps) OR $hps==0)
        return '';

    $units = array(
            'E' => 1000000000000000000,
            'P' =>    1000000000000000,
            'T' =>       1000000000000,
        );
    
    if ($units[$unit])
        return num($hps/$units[$unit], $decimals).'&nbsp;'.$unit.'H/s';

    foreach ($units AS $u => $x)
        if ($hps/$x>=100 OR $u=='T')
            return num($hps/$x, $decimals).'&nbsp;'.$u.'H/s';

}


function hashpower_humans_phs($hps, $decimals=0) {
    return hashpower_humans($hps, 'P', $decimals);
}


function hextobase58($hex) {
    include_once('lib/base58.php');
    $base58 = new Base58;
    return $base58->encode($hex);
}
