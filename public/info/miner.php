<?php # BMP

$_template['title'] = 'Miner: '.$_GET[2];


$proof['bmp'] = array(
    'title'         => 'BMP '.$_template['title'],
    'version'       => BMP_VERSION,
    'chain'         => BLOCKCHAIN,
    'block_window'  => BLOCK_WINDOW,
    'height'        => sql("SELECT height AS ECHO FROM blocks ORDER BY height DESC LIMIT 1"),
    'block_hash'    => sql("SELECT hash AS ECHO FROM blocks ORDER BY height DESC LIMIT 1"),
);

$proof['miner'] = sql("SELECT height, (SELECT hash FROM blocks WHERE height = miners.height LIMIT 1) AS block_hash, 
    txid, address, method, power, hashpower 
    FROM miners WHERE address = '".e($_GET[2])."'");


print_r2($proof);