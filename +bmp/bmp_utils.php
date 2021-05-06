<?php # BMP — Javier González González



function get_new_blocks() {
    $output = false;
    
    foreach (BLOCKCHAINS AS $blockchain => $config)
        if (get_new_block($blockchain))
            $output = true;

    return $output;
}



function get_new_block($blockchain=BLOCKCHAIN_ACTIONS) {
    
    $height_rpc = rpc_get_best_height($blockchain);
    if (!$height_rpc)
        exit;

    $height_bmp = sql("SELECT height AS ECHO FROM blocks WHERE blockchain = '".$blockchain."' ORDER BY height DESC LIMIT 1");
    
    if (!is_numeric($height_rpc) OR $height_rpc==$height_bmp)
        return false;
    
    if ($height_bmp)
        $height = $height_bmp + 1;
    else
        $height = BLOCKCHAINS[$blockchain]['bmp_start'];

    block_insert($height, $blockchain);


    return true;
}


function block_delete_from($height, $blockchain=BLOCKCHAIN_ACTIONS) {
    if ($height < 0)
        $height = rpc_get_best_height($blockchain)-$height;

    sql("DELETE FROM blocks  WHERE blockchain = '".$blockchain."' AND height >= ".e($height));
    sql("DELETE FROM miners  WHERE blockchain = '".$blockchain."' AND height >= ".e($height));
    sql("DELETE FROM actions WHERE blockchain = '".$blockchain."' AND height >= ".e($height));

    update_power();
    update_actions($blockchain);
}


function revert_bytes($hex) {
    $hex = str_split($hex, 2);
    $hex = array_reverse($hex);
    return implode('', $hex);
}


function pool_decode($coinbase) {
    global $__pools_json_cache;

    if (!isset($__pools_json_cache) AND file_exists('lib/pools.json'))
        $__pools_json_cache = json_decode(file_get_contents('lib/pools.json'), true);


    if (is_array($coinbase))
        foreach ($__pools_json_cache['payout_addresses'] AS $address => $pool)
            foreach ((array)$coinbase['vout'] AS $vout)
                if ($address === $vout['scriptPubKey']['addresses'][0])
                    return $pool;


    $coinbase_hex = (is_array($coinbase)?$coinbase['vin'][0]['coinbase']:$coinbase);
    foreach ($__pools_json_cache['coinbase_hex'] AS $hex => $pool)
        if (strpos($coinbase_hex, $hex) !== false)
            return $pool;


    $coinbase_text = hex2bin($coinbase_hex);
    foreach ($__pools_json_cache['coinbase_tags'] AS $tag => $pool)
        if (strpos($coinbase_text, $tag) !== false)
            return $pool;


    return null;
}


function pool_identify() {
    foreach (sql("SELECT id, coinbase FROM blocks") AS $r) {
        if ($pool = pool_decode($r['coinbase']))
            sql_update('blocks', ['pool' => $pool['name'], 'pool_link' => ($pool['link']?$pool['link']:null)], "id = '".$r['id']."'");
        else
            sql_update('blocks', ['pool' => null, 'pool_link' => null], "id = '".$r['id']."'");
    }
}


function address_normalice($address) {
    $address = trim($address);

    if (substr($address,0,12)=='bitcoincash:') {
        include_once('lib/cashaddress.php');
        $address = \CashAddress\CashAddress::new2old($address, false);
    }

    return $address;
}


function address_validate($address) {

    if (substr($address,0,3)=='bc1' AND strlen($address)==42) // Hack
        return true;

    include_once('lib/AddressValidator.php');
    $result = \LinusU\Bitcoin\AddressValidator::isValid($address);

    return $result;
}


function hashpower_humans($hps, $unit=false, $decimals=0) {

    if (!is_numeric($hps) OR $hps==0)
        return '';

    $units = [
        'Z' => 1000000000000000000000,
        'E' =>    1000000000000000000,
        'P' =>       1000000000000000,
        'T' =>          1000000000000,
        'G' =>             1000000000,
        'M' =>                1000000,
        ];
    
    if ($unit!==false AND $units[$unit])
        return num($hps/$units[$unit], $decimals).' '.$unit.'H/s';

    foreach ($units AS $u => $x)
        if ($u=='M' OR $hps/$x>1)
            return num($hps/$x, $decimals).' '.$u.'H/s';

}


function hashpower_humans_phs($hps, $decimals=0) {
    return hashpower_humans($hps, 'P', $decimals);
}


function hex2bin_print($hex) {

    foreach (str_split($hex,2) AS $byte)
        $output .= (ctype_print(hex2bin($byte))?'<b>'.hex2bin($byte).'</b>':$byte);

    return str_replace('</b><b>', '', $output);
}


function replace_hash_to_link($text) {

    $text = preg_replace( 
        "/[0]{10}[A-Fa-f0-9]{54}/i", 
        "<a href=\"".URL_EXPLORER_BLOCK."\\0\" target=\"blank\" rel=\"noopener\">\\0</a>", $text);

    $text = preg_replace( 
        "/((?!(0000000000))[A-Fa-f0-9]{64})/i", 
        "<a href=\"".URL_EXPLORER_TX."\\0\" target=\"blank\" rel=\"noopener\">\\0</a>", $text);

    return $text;
}