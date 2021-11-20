<?php

echo 'Check:<br />';

echo 'Tables: <b>'.implode(' ', (array)sql_get_tables()).'</b><br />';

echo 'Count blocks: <b>'.sql("SELECT COUNT(*) AS num FROM blocks")[0]['num'].'</b><br />';

echo 'Select config "test": <b>'.sql("SELECT value FROM key_value WHERE name = 'test' LIMIT 1")[0]['value'].'</b><br />';

sql_key_value('test', time().'.'.rand(1,10000));


echo sql_error();


___(rpc_get_block(1));

___(rpc_get_transaction('0e3e2357e806b6cdb1f70b54c3a3a17b6714ee1f0e68bebb44a74b1efd512098'));

___(sql_link());


exit;