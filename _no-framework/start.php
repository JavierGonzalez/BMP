<?php



define('CRONO_START', microtime(true));


$_ = array();


foreach (glob('_no-framework/functions*.php') AS $load)
    include($load);


include('_no-framework/config.php');


foreach (glob('functions/*.php') AS $load)
    include($load);


include('_no-framework/login.php');


include('_no-framework/router.php');


include('templates/index.php');


