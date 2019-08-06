<?php # maximum_simplicity — Javier González González


$_['crono'] = hrtime(true);


ob_start(NULL, 1024*1024*10);


include('__maximum_simplicity/config.php');


include('__maximum_simplicity/functions.php');


foreach (glob('autoload/*.php') AS $_file)
    include($_file);


include('__maximum_simplicity/router.php');


if (isset($_['template']['output']))
    include('template/'.$_['template']['output'].'.php');    


$_output_html_content = ob_get_contents();
ob_end_clean();
include('template/index.php');

exit;