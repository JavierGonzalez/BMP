<?php

echo 'Check:<br />';

echo 'Tables: <b>'.implode(' ', (array)sql_get_tables()).'</b><br />';

echo 'Count blocks: <b>'.sql("SELECT COUNT(*) AS num FROM blocks")[0]['num'].'</b><br />';

echo 'Select config "test": <b>'.sql("SELECT value FROM key_value WHERE name = 'test' LIMIT 1")[0]['value'].'</b><br />';

sql_key_value('test', time().'.'.rand(1,10000));



echo sql_error();

___(sql_link());

exit;