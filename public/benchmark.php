<?php # BMP — Javier González González


$random_tx = rpc_get_block(rand(1,100000), 'BTC')['tx'][0];
$random_height = rand(1,500000);

___('BENCHMARK');


echo '<hr/>rpc_get_block()';
foreach (BLOCKCHAINS AS $blockchain => $config)
    ___($blockchain.' '.rpc_get_block($random_height, $blockchain)['time']);


echo '<hr/>rpc_get_transaction()';
foreach (BLOCKCHAINS AS $blockchain => $config)
    ___($blockchain.' '.rpc_get_transaction($random_tx, $blockchain)['time']);

echo '<hr/>rpc_get_best_height()';
foreach (BLOCKCHAINS AS $blockchain => $config)
    ___($blockchain.' '.rpc_get_best_height($blockchain));

echo '<hr/>rpc_get_network_info()';
foreach (BLOCKCHAINS AS $blockchain => $config)
    ___($blockchain.' '.rpc_get_network_info($blockchain)['connections']);

echo '<hr/>rpc_uptime()';
foreach (BLOCKCHAINS AS $blockchain => $config)
    ___($blockchain.' '.rpc_uptime($blockchain));


exit;