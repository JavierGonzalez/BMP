<?php

echo 'Hello Bitcoin Miners!<br />';


foreach (sql_query("SELECT user FROM users ORDER BY user ASC") AS $r)
    echo $r['user'].'<br />';


    
var_dump(sql_query("SELECT * FROM users ORDER BY user ASC"));

var_dump(sql_query("SELECT COUNT(*) AS num FROM users")[0]['num']);