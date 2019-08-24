<?php # BMP — Javier González González

$__template['title'] = 'Action: '.$_GET[2];


$proof['bmp'] = [
    'title'                 => $__template['title'],
    'version'               => BMP_VERSION,
    'block_window'          => BLOCK_WINDOW,
    'blockchains'           => array_keys(BLOCKCHAINS),
    ];



$action = sql("SELECT blockchain, height, (SELECT hash FROM blocks WHERE height = actions.height LIMIT 1) AS block_hash, txid, address, time, op_return, action, action_id, p1, p2, p3, p4, p5, p6, power, hashpower FROM actions WHERE txid = '".e($_GET[2])."'")[0];



$proof['action'] = $action;

$proof['miner']  = sql("SELECT blockchain, height, (SELECT hash FROM blocks WHERE height = miners.height LIMIT 1) AS block_hash, txid, address, power, hashpower FROM miners WHERE address = '".$action['address']."' ORDER BY height ASC");


echo '<span style="font-size:11px;">';

print_r2(json_encode($proof, JSON_PRETTY_PRINT));

echo '</span>';