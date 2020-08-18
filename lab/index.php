<?php # BMP - Javier González González

echo '    <style type="text/css">
    body {
        font-family: monospace, monospace;
    font-size: 10px;
    }
    </style>';



function bitcoin_hash_calculation(array $block) {

    $hex = [
        'version_hex'       => revert_bytes($block['version_hex']),
        'previousblockhash' => revert_bytes($block['previousblockhash']),
        'merkleroot'        => revert_bytes($block['merkleroot']),
        'time'              => revert_bytes(dechex(strtotime($block['time']))),
        'bits'              => revert_bytes($block['bits']),
        'nonce'             => revert_bytes(str_pad(dechex($block['nonce']), 8, "00", STR_PAD_LEFT)),
        ];

    return revert_bytes(hash('sha256',hash('sha256',hex2bin(implode('', $hex)), true), false));
}



$result = sql("SELECT * FROM blocks ORDER BY height DESC");

foreach ($result AS $r) {

    $hash = bitcoin_hash_calculation($r);

    $table_data = $hex;
    $table_data['result'] = ($hash===$r['hash']?'TRUE':'FALSE');
    $table_data['hash'] = $hash;
    $table[] = $table_data;



    //echo '<b>'.($hash===$r['hash']?'TRUE':'FALSE').'</b> '.$r['blockchain'].' '. $r['height'].' '.$hash.'<br />';

    if (false AND $hash!==$r['hash']) {
        print_r2($hex);
        echo implode('', $hex).'<br />';
    }


}



echo html_table($table);




exit;

pool_identify();

exit;


$test = false;

if ($test = true AND true)
    $asdasd = false;

__($test);


__(sql("SELECT blockchain, SUM(hashpower) AS hashpower FROM blocks GROUP BY 1 ORDER BY 2 DESC"));


__(sql("SELECT blockchain, SUM(hashpower) AS hashpower FROM miners GROUP BY 1 ORDER BY 2 DESC"));

exit;

pool_identify();

exit;


$output = rpc_create_raw_transaction();

__($output);




exit;




$pools = json_decode(file_get_contents('lib/pools.json'), true);

foreach (sql("SELECT pool FROM blocks WHERE pool IS NOT NULL GROUP BY pool") AS $r) {
    foreach (array_merge($pools['coinbase_tags'], $pools['payout_addresses']) AS $pool) {
        if ($pool['name']===$r['pool'] AND $pool['link']) {
            __($r['pool'].' '.$pool['link']);
            sql_update('blocks', array('pool_link' => $pool['link']), "pool = '".$r['pool']."'");
        }
    }
}

exit;


$r = sql("SELECT id, blockchain, height FROM blocks WHERE blockchain = 'BCH' ORDER BY height DESC");
foreach ($r AS $r) {

    $block = rpc_get_block($r['height'], $r['blockchain']);
    $block_hashpower = $block['difficulty'] * pow(2,32) / 600; // Hashpower = Hashes per second.
    
    $coinbase = rpc_get_transaction($block['tx'][0], $blockchain);
    $coinbase_hashpower = coinbase_hashpower($coinbase);

    $pool_decode = pool_decode($coinbase, $coinbase_hashpower);

    __($pool_decode['name']);

    sql_update('blocks', ['pool' => $pool_decode['name']], "id = '".$r['id']."'");

}

