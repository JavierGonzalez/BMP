<?php

/* no-framework router

/                               modules/index.php
/example/more/abc?param=true    modules/example/more.php
/example?param=true             modules/example.php             
/example/abc                    modules/example.php
/example/abc                    modules/example/index.php

*/


$url = explode('?', $_SERVER['REQUEST_URI'])[0];

$depth = array_filter(explode('/', $url));

$_GET = array_merge($depth, $_GET);


if (!$_GET[0]) {
    include('modules/index.php');
    exit;
}


$modules = array(
        'modules/'.filter_var($_GET[0], FILTER_SANITIZE_STRING).'/'.filter_var($_GET[1], FILTER_SANITIZE_STRING).'.php',
        'modules/'.filter_var($_GET[0], FILTER_SANITIZE_STRING).'.php',
        'modules/'.filter_var($_GET[0], FILTER_SANITIZE_STRING).'/index.php',
    );

foreach ($modules AS $module) {
    if (file_exists($module)) {
        include($module);
        exit;
    }
}


redirect(); // 404