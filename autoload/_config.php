<?php # BMP — Javier González González


define('BMP_VERSION', '0.2-beta');

define('BLOCK_WINDOW', 2016); // Blocks

define('BLOCKCHAINS', ['BTC', 'BCH', 'BSV']);

define('BLOCKCHAIN_ACTIONS', 'BCH');

define('POWER_PRECISION', 5); // Decimals of %

define('BMP_GENESIS_BLOCK', 588996 - BLOCK_WINDOW);

define('OP_RETURN_MAX_SIZE', 220); // Bytes

define('FEE_PER_BYTE', 0.00002); // Bitcoin/kb
