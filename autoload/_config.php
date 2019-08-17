<?php # BMP — Javier González González


define('BMP_VERSION', '0.2-beta');

define('BLOCK_WINDOW', 2016); // Blocks

define('BLOCKCHAINS', [
        
        'BTC' => [
                'name'          => 'Bitcoin Core',
                'bmp_genesis'   => 580670,
            ], 
        
        'BCH' => [
                'name'          => 'Bitcoin Cash',
                'bmp_genesis'   => 586980,
                'actions'       => true,
            ], 
        
        'BSV' => [
                'name'          => 'Bitcoin SV',
                'bmp_genesis'   => 586842,
            ], 
    
    ]);

define('BLOCKCHAIN_ACTIONS', 'BCH');

define('POWER_PRECISION', 5); // Decimals of %

define('OP_RETURN_MAX_SIZE', 220); // Bytes

define('FEE_PER_BYTE', 0.00002); // Bitcoin/kb
