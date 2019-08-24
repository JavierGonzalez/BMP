<?php # BMP — Javier González González


define('BMP_VERSION', '0.2-beta');

define('BLOCK_WINDOW', 2016); // Blocks

define('BLOCKCHAINS', [
        
    'BTC' => [
        'name'              => 'Bitcoin Core',
        'bmp_genesis'       => 580670,
        'background_color'  => '#E2BF4E',
        ], 
    
    'BCH' => [
        'name'              => 'Bitcoin Cash',
        'bmp_genesis'       => 586980,
        'actions'           => true,
        'background_color'  => '#FCC201',
        ], 
    
    'BSV' => [
        'name'              => 'Bitcoin SV',
        'bmp_genesis'       => 586842,
        'background_color'  => '#FFDF00'
        ], 
    
    ]);

define('BLOCKCHAIN_ACTIONS', 'BCH');

define('POWER_PRECISION', 5); // Decimals of %

define('OP_RETURN_MAX_SIZE', 220); // Bytes

define('FEE_PER_BYTE', 0.00002); // Bitcoin/kb

date_default_timezone_set('UTC');