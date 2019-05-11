<?php # simple_framework

$_ = array();

$_['crono_start'] = microtime(true);


include('__simple_framework/config.php');


ob_start(NULL, 1024*1024*10);


foreach (glob('autoload/*.php') AS $_file)
    include($_file);


include('__simple_framework/login.php');


include('__simple_framework/router.php');


if (isset($_['template']))
    include('template/'.key($_['template']).'.php');