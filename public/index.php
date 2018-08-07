<?php

echo 'Hello Bitcoin Miners!<br />';



sql_insert('users', array(
        'user'      => 'test'.round(microtime(true)),
        'status'    => 'ok',
    ));
    
    
foreach (sql("SELECT user FROM users WHERE status = 'ok' ORDER BY user ASC") AS $r)
    echo $r['user'].'<br />';


// var_dump(sql("SELECT * FROM users WHERE status = 'ok' ORDER BY user ASC"));