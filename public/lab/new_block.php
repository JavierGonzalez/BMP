<?php # BMP



crono();

if (get_new_block())
    echo '<meta http-equiv="refresh" content="0">';

crono(sql_insert('actions', get_mempool()));
sleep(5);
crono(sql_insert('actions', get_mempool()));
sleep(5);
crono(sql_insert('actions', get_mempool()));
sleep(5);
crono(sql_insert('actions', get_mempool()));
sleep(5);
crono(sql_insert('actions', get_mempool()));
sleep(5);
crono(sql_insert('actions', get_mempool()));
sleep(5);
crono(sql_insert('actions', get_mempool()));
sleep(5);
crono(sql_insert('actions', get_mempool()));

exit;