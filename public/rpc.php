<?php

$template = 'api';



require_once('lib/easybitcoin.php');

crono();

$sb = parse_url(SERVER_BCH);
$bitcoin = new Bitcoin($sb['user'], $sb['pass'], $sb['host'], $sb['port']);

/*
crono();
print_r($bitcoin->getinfo());


crono();
print_r($bitcoin->getnetworkinfo());

crono();

print_r($bitcoin->getblockchaininfo());
crono();
*/
print_r($bitcoin->getblock('00000000839a8e6886ab5951d76f411475428afc90947ee320161bbf18eb6048'));

crono();

print_r($bitcoin->getrawtransaction('f65ab879ca91a256f3eb366af1b7e50f975c5c3b7cd881da5e978ab3d2b60a55', 1));
crono();


