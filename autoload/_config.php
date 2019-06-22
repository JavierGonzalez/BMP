<?php # BMP — Javier González González

define('BMP_VERSION', '2019.06-alpha');

define('DEBUG', true);

define('BLOCKCHAIN', 'BCH');

define('BLOCK_WINDOW', 2016); // Blocks

define('BMP_GENESIS_BLOCK', 999999 - BLOCK_WINDOW); // First BMP action - BLOCK

define('POWER_PRECISION', 4); // Decimals of %

define('OP_RETURN_MAX_SIZE', 220); // Bytes

define('FEE_PER_BYTE', 0.00002); // BCH/KB
