<?php



/*
foreach (sql("SELECT height FROM blocks WHERE height >= 583551") AS $r)
    block_delete($r['height']);
*/

// print_r2(rpc_get_block(583551));

print_r2(get_block_info(583551));


exit;