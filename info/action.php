<?php # BMP — Javier González González

$maxsim['template']['title'] = 'Action: '.$_GET[1];


$proof['bmp'] = [
    'title'                 => $maxsim['template']['title'],
    'version'               => BMP_VERSION,
    'block_window'          => BLOCK_WINDOW,
    'blockchains'           => array_keys(BLOCKCHAINS),
    ];



$action = sql("SELECT blockchain, height, 
    (SELECT hash FROM blocks WHERE blockchain = actions.blockchain AND height = actions.height LIMIT 1) AS block_hash, 
    txid, address, time, op_return, action, action_id, p1, p2, p3, p4, p5, p6, power, hashpower 
    FROM actions WHERE txid = '".e($_GET[1])."'")[0];

$proof['action'] = $action;

$proof['miner']  = json_decode(sql("SELECT evidence FROM actions WHERE txid = '".e($_GET[1])."'")[0]['evidence'], true)['miner'];



?>

<h1>Evidence</h1>

<pre>
<?=replace_hash_to_link(json_encode($proof, JSON_PRETTY_PRINT))?>
</pre>