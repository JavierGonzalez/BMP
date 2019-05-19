<?php # simple_framework

$_ = array();

$_['crono_start'] = microtime(true);


include('__simple_framework/config.php');


ob_start(NULL, 1024*1024*10);


foreach (glob('autoload/*.php') AS $_file)
    include($_file);


include('__simple_framework/login.php');


include('__simple_framework/router.php');


$_['output_html_content'] = ob_get_contents();
ob_end_clean();
include('template/index.php');

exit;