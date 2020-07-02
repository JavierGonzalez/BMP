<?php # BMP - Javier González González


__($maxsim);

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

