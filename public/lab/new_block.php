<?php # BMP



crono();

if (get_new_block())
    echo '<meta http-equiv="refresh" content="0">';

sql_insert('actions', get_mempool());

sleep(15);

sql_insert('actions', get_mempool());


sleep(15);

sql_insert('actions', get_mempool());


crono();

echo sql_error();

exit;