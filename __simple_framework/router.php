<?php # simple_framework

#  URL                             ROUTE                        PARAMS
#  /                               public/index.php             
#  /example/more/abc?param=true    public/example/more.php      $_GET[1] = 'abc';  $_GET['param'] = true;
#  /example?param=true             public/example.php           $_GET['param'] = true;
#  /example/abc                    public/example.php           $_GET[1] = 'abc';
#  /example/abc                    public/example/index.php     $_GET[1] = 'abc';


$url = explode('?', $_SERVER['REQUEST_URI'])[0];

$depth = array_filter(explode('/', $url));

$_GET = array_merge($depth, $_GET);


if (!$_GET[0])
    $_GET[0] = 'index';


$public = array(
        'public/'.file_filter($_GET[0]).'/'.file_filter($_GET[1]).'.php',
        'public/'.file_filter($_GET[0]).'.php',
        'public/'.file_filter($_GET[0]).'/index.php',
    );


if (!isset($_GET[1]))
    unset($public[0]);


foreach ($public AS $_module) {
    if (file_exists($_module)) {
        
        // Sub-autoload
        if (file_exists(dirname($_module).'/*.php'))
            include(dirname($_module).'/*.php');

        include($_module);
        $module_found = true;
        break;
    }
}


if (!$module_found) {
    header("HTTP/1.0 404 Not Found");
    redirect();
}