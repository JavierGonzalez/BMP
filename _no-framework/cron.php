<?php

$template = false;

file_put_contents('temp/cron_test.txt', date('Y-m-d H:i:s')."\n", FILE_APPEND | LOCK_EX);

echo 'OKKKKKKKKK';
