<?php # BMP — Javier González González


define('BMP_VERSION', '0.4.2');

define('BLOCK_WINDOW', 4032); // Blocks for hashpower calculation
// /voting/67302f9a415ac5956403720793b92055a0b63342ee6848c65083e4a21ff88008

define('BLOCKCHAINS', [
    'BCH' => [
        'name'              => 'Bitcoin Cash',
        'bmp_start'         => 588996,
        'background_color'  => '#FCC201',
        'actions'           => true,
    ], 
]);

define('BLOCKCHAIN_ACTIONS', 'BCH');

define('POWER_PRECISION', 6); // Decimals of %

define('OP_RETURN_MAX_SIZE', 220); // Bytes

define('FEE_PER_BYTE', 0.00002); // Bitcoin/kb

define('URL_EXPLORER_TX',    'https://blockchair.com/bitcoin-cash/transaction/');
define('URL_EXPLORER_BLOCK', 'https://blockchair.com/bitcoin-cash/block/');



error_reporting(error_reporting() & ~E_NOTICE & ~E_WARNING);

date_default_timezone_set('UTC');

$maxsim['output'] = 'template';
