<?php

/* no-framework router

    URL                             CODE
    /                               modules/index.php
    /example/more/abc?param=true    modules/example/more.php
    /example?param=true             modules/example.php             
    /example/abc                    modules/example.php
    /example/abc                    modules/example/index.php

*/


$url = explode('?', $_SERVER['REQUEST_URI'])[0];

$depth = array_filter(explode('/', $url));

$_GET = array_merge($depth, $_GET);


if (!$_GET[0])
    $_GET[0] = 'index';


$modules = array(
        'modules/'.filter_var($_GET[0], FILTER_SANITIZE_STRING).'/'.filter_var($_GET[1], FILTER_SANITIZE_STRING).'.php',
        'modules/'.filter_var($_GET[0], FILTER_SANITIZE_STRING).'.php',
        'modules/'.filter_var($_GET[0], FILTER_SANITIZE_STRING).'/index.php',
    );


if (!isset($_GET[1]))
    unset($modules[0]);


foreach ($modules AS $module) {
    if (file_exists($module)) {
        include($module);
        $module_found = true;
        break;
    }
}

if (!$module_found)
    redirect();