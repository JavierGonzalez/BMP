<?php

$_['template'] = 'api';


crono();
print_r($rpc->getinfo());

/*
crono();
print_r($rpc->getnetworkinfo());
*/

crono();

print_r($rpc->getblockchaininfo());
crono();

print_r($rpc->getblock('00000000839a8e6886ab5951d76f411475428afc90947ee320161bbf18eb6048'));

crono();

print_r($rpc->getrawtransaction('f65ab879ca91a256f3eb366af1b7e50f975c5c3b7cd881da5e978ab3d2b60a55', 1));
crono();
