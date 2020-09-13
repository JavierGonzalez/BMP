<?php # BMP — Javier González González

unset($maxsim['output']);


$beat_last = sql_key_value('beat_last');

__('beat_last: '.$beat_last);

if ($beat_last AND $beat_last >= time()-(60*4))
    exit;
    


set_time_limit(60*60*24);

for ($i=0;$i<=10000;$i++) {
    beat();
    sleep(3);
}


function beat() {
    $beat_start = microtime(true);
    sql_key_value('beat_last', time());
    
    beat_payload();

    $ms = round((microtime(true)-$beat_start)*1000,2);
    sql_key_value('beat_last_ms', $ms);
}


function beat_payload() {

    if (get_new_blocks())
        return beat();
    else
        sql_insert('actions', get_mempool());

}

