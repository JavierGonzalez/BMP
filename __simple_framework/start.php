<?php # simple_framework


$_['crono_start'] = microtime(true);


include('__simple_framework/config.php');


ob_start(NULL, 1024*1024*10);


foreach (glob('autoload/*.php') AS $load)
    include($load);


include('__simple_framework/login.php');


include('__simple_framework/router.php');


if ($_['template']=='api')
    include('template/api.php');
    
else if ($_['template']!==false)
    include('template/html.php');


