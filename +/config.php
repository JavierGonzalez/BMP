<?php # BMP — Javier González González


define('BMP_VERSION', '0.4.2');

define('BLOCK_WINDOW', 4032); // Blocks for hashpower calculation
// /voting/67302f9a415ac5956403720793b92055a0b63342ee6848c65083e4a21ff88008

define('BLOCKCHAINS', [
        
    'BTC' => [
        'name'              => 'Bitcoin Core',
        'bmp_start'         => 578654,
        'background_color'  => '#FFDF00',
        ], 
    
    'BCH' => [
        'name'              => 'Bitcoin Cash',
        'bmp_start'         => 584964,
        'background_color'  => '#FCC201',
        'actions'           => true,
        ], 
    
    'BSV' => [
        'name'              => 'Bitcoin SV',
        'bmp_start'         => 584826,
        'background_color'  => '#E2BF4E'
        ], 
    
    ]);

define('BLOCKCHAIN_ACTIONS', 'BCH');

define('POWER_PRECISION', 7); // Decimals of %

define('OP_RETURN_MAX_SIZE', 220); // Bytes

define('FEE_PER_BYTE', 0.00002); // Bitcoin/kb

define('URL_EXPLORER_TX',    'https://blockchair.com/bitcoin-cash/transaction/');
define('URL_EXPLORER_BLOCK', 'https://blockchair.com/bitcoin-cash/block/');

define('DEV', passwords['dev']);


$maxsim['output'] = 'template';

date_default_timezone_set('UTC');
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 1);