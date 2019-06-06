<?php # BMP


crono();

if (get_new_block())
    echo '<meta http-equiv="refresh" content="0">';
else
    sql_insert('actions', get_mempool());

crono();


exit;