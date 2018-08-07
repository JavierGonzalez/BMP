<?php

/* no-framework router

    URL                             CODE
    /                               public/index.php
    /example/more/abc?param=true    public/example/more.php
    /example?param=true             public/example.php             
    /example/abc                    public/example.php
    /example/abc                    public/example/index.php

*/


$url = explode('?', $_SERVER['REQUEST_URI'])[0];

$depth = array_filter(explode('/', $url));

$_GET = array_merge($depth, $_GET);


if (!$_GET[0])
    $_GET[0] = 'index';


$public = array(
        'public/'.filter_var($_GET[0], FILTER_SANITIZE_STRING).'/'.filter_var($_GET[1], FILTER_SANITIZE_STRING).'.php',
        'public/'.filter_var($_GET[0], FILTER_SANITIZE_STRING).'.php',
        'public/'.filter_var($_GET[0], FILTER_SANITIZE_STRING).'/index.php',
    );


if (!isset($_GET[1]))
    unset($public[0]);


foreach ($public AS $module) {
    if (file_exists($module)) {
        include($module);
        $module_found = true;
        break;
    }
}


if (!$module_found) {
    header("HTTP/1.0 404 Not Found");
    redirect();
}