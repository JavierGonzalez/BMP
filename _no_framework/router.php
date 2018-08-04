<?php


$url = explode('?', $_SERVER['REQUEST_URI'])[0];

$depth = array_filter(explode('/', $url));

$_GET = array_merge($depth, $_GET);


if (!$_GET[0])
    $_GET[0] = 'index';


$_GET[0] = filter_var($_GET[0], FILTER_SANITIZE_STRING);


if (!file_exists('modules/'.$_GET[0].'.php'))
    redirect();

include('modules/'.$_GET[0].'.php');

exit;