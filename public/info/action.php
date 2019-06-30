<?php # BMP — Javier González González

$_template['title'] = 'Action: '.$_GET[2];


$proof['bmp'] = array(
        'title'         => 'BMP '.$_template['title'],
        'version'       => BMP_VERSION,
        'blockchain'    => BLOCKCHAIN,
        'block_window'  => BLOCK_WINDOW,
    );



$action = sql("SELECT height, (SELECT hash FROM blocks WHERE height = actions.height LIMIT 1) AS block_hash, txid, address, time, op_return, action, action_id, p1, p2, p3, p4, p5, p6, power, hashpower FROM actions WHERE txid = '".e($_GET[2])."'")[0];



$proof['action'] = $action;
$proof['action']['p'] = action_parameters_pretty($action);

$proof['miner']  = sql("SELECT height, (SELECT hash FROM blocks WHERE height = miners.height LIMIT 1) AS block_hash, txid, address, power, hashpower FROM miners WHERE address = '".$action['address']."' ORDER BY height ASC");


echo '<span style="font-size:11px;">';

print_r2(json_encode($proof, JSON_PRETTY_PRINT));

echo '</span>';