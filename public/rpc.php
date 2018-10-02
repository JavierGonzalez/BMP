<?php

$template = 'api';



require_once('lib/easybitcoin.php');

crono();

$sb = parse_url(SERVER_BCH);
$bitcoin = new Bitcoin($sb['user'], $sb['pass'], $sb['host'], $sb['port']);

crono();
print_r($bitcoin->getinfo());


crono();
print_r($bitcoin->getnetworkinfo());

crono();

print_r($bitcoin->getblockchaininfo());
crono();

print_r($bitcoin->getblock('0000000000000000006f802570ad354d89ea87a1ab049b0947ec4822a48c1400'));

crono();

print_r($bitcoin->getrawtransaction('81a0a2d1c0123bc1fcf3c92b0f1676d934cc2d8078732c1d504c85cbe1c4bd0a', 1));
crono();


