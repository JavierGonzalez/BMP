<?php # BMP — Javier González González

$maxsim['output'] = 'json';


$echo = [
    'version' => [
        'apache' => $_SERVER['SERVER_SOFTWARE'],
        'php' => phpversion(),
        'sql' => sql("SELECT VERSION()")[0]['VERSION()'],
        'maxsim' => $maxsim['version'],
        'bmp' => BMP_VERSION,
    ],
    'config' => [
        'block_window' => BLOCK_WINDOW,
        'blockchain_actions' => BLOCKCHAIN_ACTIONS,
        'power_precision' => POWER_PRECISION,
        'op_return_max_size' => OP_RETURN_MAX_SIZE,
        'fee_per_byte' => FEE_PER_BYTE,
        'php_error_reporting' => error_reporting(),
        'time_zone' => date_default_timezone_get(),
    ],
    'state' => [
        'num_blockchain' => sql("SELECT COUNT(DISTINCT blockchain) AS num FROM blocks GROUP BY blockchain")[0]['num'],
        'num_blocks' => sql("SELECT COUNT(*) AS num FROM blocks")[0]['num'],
        'num_miners' => sql("SELECT COUNT(*) AS num FROM miners")[0]['num'],
        'num_actions' => sql("SELECT COUNT(*) AS num FROM actions")[0]['num'],
        'last_height' => sql("SELECT height FROM blocks ORDER BY height DESC LIMIT 1")[0]['height'],
        'last_hash' => sql("SELECT hash FROM blocks ORDER BY height DESC LIMIT 1")[0]['hash'],
        'first_height' => sql("SELECT height FROM blocks ORDER BY height ASC LIMIT 1")[0]['height'],
        'first_hash' => sql("SELECT hash FROM blocks ORDER BY height ASC LIMIT 1")[0]['hash'],
        'height_sum_blocks' => sql("SELECT SUM(height) AS num FROM blocks")[0]['num'],
        'height_sum_miners' => sql("SELECT SUM(height) AS num FROM miners")[0]['num'],
        'height_sum_actions' => sql("SELECT SUM(height) AS num FROM actions")[0]['num'],
        'difficulty_sum_blocks' => sql("SELECT SUM(difficulty) AS num FROM blocks")[0]['num'],
        'hashpower_sum_miners' => sql("SELECT SUM(hashpower) AS num FROM miners")[0]['num'],
    ],
    'metrics' => [
        'beat_last_ms' => sql_key_value('beat_last_ms'),
        'beat_last' => date('Y-m-d H:m:s', sql_key_value('beat_last')),
        'cache_blocks_num' => sql_key_value('cache_blocks_num'),
        'cache_miners_num' => sql_key_value('cache_miners_num'),
        'cache_actions_num' => sql_key_value('cache_actions_num'),
        'cache_chat_num' => sql_key_value('cache_chat_num'),
        'maxsim_timing' => $maxsim['debug']['timing'],
    ],
];