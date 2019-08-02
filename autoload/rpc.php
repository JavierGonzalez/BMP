<?php # BMP — Javier González González


function rpc_connect($blockchain='BCH') {
    global $_rpc;

    if (!$_rpc[$blockchain]) {
        require_once('lib/easybitcoin.php');
        $sb = parse_url(URL_BCH);
        $_rpc[$blockchain] = new Bitcoin($sb['user'], $sb['pass'], $sb['host'], $sb['port']);
        if (!$_rpc[$blockchain])
            echo $_rpc->error();
    }

    return $_rpc;
}


function rpc_get_block($hash) {
    $b = rpc_connect();

    if (strlen($hash)!==64)
        $hash = $b->getblockhash($hash);

    return $b->getblock($hash);
}


function rpc_get_transaction($txid) {

    $b = rpc_connect();

    $bottleneck = $b->getrawtransaction($txid, 1);

    return $bottleneck;
}


function rpc_get_mempool() {
    $b = rpc_connect();
    return $b->getrawmempool();
}


function rpc_get_best_height() {
    $b = rpc_connect();
    return $b->getblock($b->getbestblockhash())['height'];
}


function rpc_error() {
    $b = rpc_connect();
    return $b->error;
}
