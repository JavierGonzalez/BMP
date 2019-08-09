<?php # maximum_simplicity — Javier González González


$__['crono'] = hrtime(true);
$__['crono_start'] = $__['crono'];

ob_start(NULL, 10485760);


include('__maximum_simplicity/config.php');

include('__maximum_simplicity/functions.php');

foreach (glob('autoload/*.php') AS $__file)
    include($__file);

include('__maximum_simplicity/router.php');


if (isset($__['template']['output']))
    include('template/'.$__['template']['output'].'.php');    
else
    include('template/index.php');

exit;