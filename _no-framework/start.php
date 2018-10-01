<?php


$_ = array('crono_start' => microtime(true));


ob_start(NULL, 1024*1024*10);


foreach (glob('autoload/*.php') AS $load)
    include($load);


include('_no-framework/login.php');


include('_no-framework/router.php');


include('templates/index.php');


