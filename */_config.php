<?php # BMP — Javier González González


define('BMP_VERSION', '0.4.1');

define('BLOCK_WINDOW', 2016); // Blocks

define('BLOCKCHAINS', [
        
    'BTC' => [
        'name'              => 'Bitcoin Core',
        'bmp_genesis'       => 580670,
        'background_color'  => '#FFDF00',
        ], 
    
    'BCH' => [
        'name'              => 'Bitcoin Cash',
        'bmp_genesis'       => 586980,
        'background_color'  => '#FCC201',
        'actions'           => true,
        ], 
    
    'BSV' => [
        'name'              => 'Bitcoin SV',
        'bmp_genesis'       => 586842,
        'background_color'  => '#E2BF4E'
        ], 
    
    ]);

define('BLOCKCHAIN_ACTIONS', 'BCH');

define('POWER_PRECISION', 8); // Decimals of %

define('OP_RETURN_MAX_SIZE', 220); // Bytes

define('FEE_PER_BYTE', 0.00002); // Bitcoin/kb

date_default_timezone_set('UTC');

ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);

ini_set('display_errors', 1);