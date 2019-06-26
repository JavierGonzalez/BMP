<?php # BMP — Javier González González


function rpc_connect() {
    global $_rpc;

    if (!$_rpc) {
        require_once('lib/easybitcoin.php');
        $sb = parse_url(URL_BCH);
        $_rpc = new Bitcoin($sb['user'], $sb['pass'], $sb['host'], $sb['port']);
        if (!$_rpc)
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


function rpc_get_info() {
    $b = rpc_connect();
    return $b->getinfo();
}


function rpc_error() {
    $b = rpc_connect();
    return $b->error;
}
