<?php # simple_framework


$_ = array();
$_['crono_start'] = microtime(true);


ob_start(NULL, 1024*1024*10);


include('__simple_framework/config.php');


include('__simple_framework/functions.php');


foreach (glob('autoload/*.php') AS $_file)
    include($_file);


include('__simple_framework/router.php');


if (isset($_['template']['output']))
    include('template/'.$_['template']['output'].'.php');    


$_['output_html_content'] = ob_get_contents();
ob_end_clean();
include('template/index.php');


exit;