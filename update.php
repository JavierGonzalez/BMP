<?php # BMP — Javier González González


$beat_last = sql_key_value('beat_last');

___('beat_last: '.$beat_last);

if ($beat_last AND $beat_last >= time()-(60*4))
    exit;

set_time_limit(60*60*24);
ini_set('memory_limit', '15G');

pool_identify();

if (function_exists('smartbch_update_validators'))
    smartbch_update_validators();


for ($i=0;$i<=1000;$i++) {
    beat();
    sleep(5);
}


function beat() {
    $beat_start = microtime(true);
    sql_key_value('beat_last', time());
    
    beat_payload();

    $ms = round((microtime(true)-$beat_start)*1000,2);
    sql_key_value('beat_last_ms', $ms);
}


function beat_payload() {

    if (get_new_blocks()) {
        return beat();
    } else
        sql_insert('actions', get_mempool());

}

exit;