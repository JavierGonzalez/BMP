<?php # BMP

$_template['title'] = 'Action: '.$_GET[2];



$action = sql("SELECT height, (SELECT hash FROM blocks WHERE height = actions.height LIMIT 1) AS block_hash, txid, address, time, op_return, action, p1, p2, p3, p4, p5, p6, power, hashpower FROM actions WHERE txid = '".e($_GET[2])."'")[0];


$proof['bmp'] = array(
        'title'         => 'BMP '.$_template['title'],
        'version'       => BMP_VERSION,
        'chain'         => BLOCKCHAIN,
        'block_window'  => BLOCK_WINDOW,
    );

$proof['miner']  = sql("SELECT height, (SELECT hash FROM blocks WHERE height = miners.height LIMIT 1) AS block_hash, txid, address, method, power, hashpower FROM miners WHERE address = '".$action['address']."'");

$proof['action'] = $action;


print_r2($proof);
