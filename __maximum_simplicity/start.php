<?php # maximum_simplicity


define('MAXIMUM_SIMPLICITY_VERSION', '2019-08');

ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', 1);

$__['crono'] = hrtime(true);
$__['crono_start'] = $__['crono'];

ob_start(NULL, 10485760);

include('__maximum_simplicity/functions.php');

foreach (glob('autoload/*.php') AS $__file)
    include($__file);

include('__maximum_simplicity/router.php');

if (is_array($echo)) {
    header('Content-type:application/json;charset=utf-8');
    echo json_encode($echo, JSON_PRETTY_PRINT);
    exit;
}

header('Content-Type: text/html; charset=utf-8');

$__output_html = ob_get_contents();
ob_end_clean();

include('template/index.php');

exit;