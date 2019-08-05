<?php # BMP — Javier González González


function rpc_connect($blockchain=false) {
    global $_rpc;

    if ($blockchain===false)
        $blockchain = BLOCKCHAIN;

    if (!$_rpc[$blockchain]) {
        require_once('lib/easybitcoin.php');

        $sb = parse_url(constant('URL_RPC_'.$blockchain));
        $_rpc[$blockchain] = new Bitcoin($sb['user'], $sb['pass'], $sb['host'], $sb['port']);

        if (!$_rpc[$blockchain])
            echo $_rpc[$blockchain]->error();
    }

    return $_rpc[$blockchain];
}


function rpc_get_block($hash, $blockchain=false) {
    $b = rpc_connect($blockchain);

    if (strlen($hash)!==64)
        $hash = $b->getblockhash($hash);

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


function rpc_get_best_height($blockchain=false) {
    $b = rpc_connect($blockchain);
    return $b->getblock($b->getbestblockhash())['height'];
}


function rpc_error($blockchain=false) {
    $b = rpc_connect($blockchain);
    return $b->error;
}
