<?php # BMP — Javier González González

$__template['title'] = 'Miner: '.$_GET[2];


$proof['bmp'] = array(
    'title'         => $__template['title'],
    'version'       => BMP_VERSION,
    'block_window'  => BLOCK_WINDOW,
);

$proof['miner'] = sql("SELECT blockchain, height, (SELECT hash FROM blocks WHERE height = miners.height LIMIT 1) AS block_hash, 
    txid, address, power, hashpower 
    FROM miners WHERE address = '".e($_GET[2])."' ORDER BY id DESC");



echo '<span style="font-size:11px;">';

print_r2(json_encode($proof, JSON_PRETTY_PRINT));

echo '</span>';