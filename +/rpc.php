<?php # BMP — Javier González González


function rpc_connect($blockchain=false) {
    global $__rpc;

    if (!$blockchain)
        $blockchain = BLOCKCHAIN_ACTIONS;

    if (!$__rpc[$blockchain]) {
        require_once('lib/easybitcoin.php');

        $sb = parse_url(PASSWORDS['rpc_'.strtolower($blockchain)]);
        $__rpc[$blockchain] = new Bitcoin($sb['user'], $sb['pass'], $sb['host'], $sb['port']);

        if (!$__rpc[$blockchain])
            echo $__rpc[$blockchain]->error();
    }

    $__rpc['count']++;

    return $__rpc[$blockchain];
}


function rpc_get_block($hash, $blockchain=false) {
    $b = rpc_connect($blockchain);

    if (is_numeric($hash) AND strlen($hash)!==64)
        $hash = $b->getblockhash((int)$hash);

    return $b->getblock($hash);
}


function rpc_get_transaction($txid, $blockchain=false) {
    $b = rpc_connect($blockchain);
    return $b->getrawtransaction($txid, 1);
}


function rpc_get_mempool($blockchain=false) {
    $b = rpc_connect($blockchain);
    return $b->getrawmempool();
}

function rpc_get_mempool_info($blockchain=false) {
    $b = rpc_connect($blockchain);
    return $b->getmempoolinfo();
}


function rpc_get_best_height($blockchain=false) {
    $b = rpc_connect($blockchain);
    return $b->getblock($b->getbestblockhash())['height'];
}


function rpc_get_network_info($blockchain=false) {
    $b = rpc_connect($blockchain);
    return $b->getnetworkinfo();
}


function rpc_get_peer_info($blockchain=false) {
    $b = rpc_connect($blockchain);
    return $b->getpeerinfo();
}


function rpc_uptime($blockchain=false) {
    $b = rpc_connect($blockchain);
    return $b->uptime();
}


function rpc_error($blockchain=false) {
    $b = rpc_connect($blockchain);
    return $b->error;
}
