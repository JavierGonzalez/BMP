<?php # BMP

$_['template']['api'] = array();


crono();

// var_dump($rpc->error); crono();

print_r($rpc->getinfo()); crono();

//print_r($rpc->getnetworkinfo()); crono();

//print_r($rpc->getblockchaininfo()); crono();

// print_r($rpc->getblock('00000000b8980ec1fe96bc1b4425788ddc88dd36699521a448ebca2020b38699')); crono();

print_r($rpc->getrawtransaction('f88b785e991d238695e6d84058cf29b67ed1af50cfbc710c35cf0449d11b4e2b', 1)); crono();
print_r($rpc->getrawtransaction('18d9753cce93b20980ca33b860d24c537f5990034c0a3dc140ea36945c065986', 1)); crono();

/*
0x01000000
0xfdc947f860cf1b7e4a51e2679b478e5a5cc132a5bf0644832806786700000000
0x75136392769af5bfec0272ba7f18118ee708a48adab6b584b39be628a79cd1df
0xc5fd4f94





    [time] => 1556989107
    [blocktime] => 1556989107

    [time] => 1556989107
    [blocktime] => 1556989107

*/







// block validation
$block_hash = '000000000000000001457cc026ece6647031bb4c2f1627731171647c59d4efa5';

$block = $rpc->getblock($block_hash);
print_r($block);


echo $block_hash; 
echo "\n";

$block_params = array(
        //'version'               => revert_bytes('00000001'),
        'version'               => revert_bytes('20800000'),
        'previousblockhash'     => revert_bytes($block['previousblockhash']),
        'merkleroot'            => revert_bytes($block['merkleroot']),
        'time'                  => revert_bytes(dechex($block['time'])),
        'bits'                  => revert_bytes($block['bits']),
        'nonce'                 => revert_bytes(dechex($block['nonce'])),
    );


var_dump($block_params); echo "\n\n";

$target = implode('', $block_params);
print_r($target);

echo "\n";

echo revert_bytes(hash('sha256', hash('sha256', hex2bin($target), true), false));


// $target = '01000000bddd99ccfda39da1b108ce1a5d70038d0a967bacb68b6b63065f626a0000000044f672226090d85db9a9f2fbfe5f0f9609b387af7be5b7fbb7a1767c831c9e995dbe6649ffff001d05e0ed6d';
// echo hash('sha256', hash('sha256', "\x01\x00\x00\x00\xbd\xDD\x99\xCC\xFD\xA3\x9D\xA1\xB1\x08\xCE\x1A\x5D\x70\x03\x8D\x0A\x96\x7B\xAC\xB6\x8B\x6B\x63\x06\x5F\x62\x6A\x00\x00\x00\x00\x44\xF6\x72\x22\x60\x90\xD8\x5D\xB9\xA9\xF2\xFB\xFE\x5F\x0F\x96\x09\xB3\x87\xAF\x7B\xE5\xB7\xFB\xB7\xA1\x76\x7C\x83\x1C\x9E\x99\x5D\xBE\x66\x49\xFF\xFF\x00\x1D\x05\xE0\xED\x6D", true), false);