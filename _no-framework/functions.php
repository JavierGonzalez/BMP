<?php


function redirect($url='/') {
    header('Location: '.$url);
    exit;
}


function crono() {
    global $crono_last;
    
    $crono = microtime(true);
    
    if ($crono_last)
        $extra = ' ('.round(($crono-$crono_last)*1000,2).' ms)';
    
    echo "\n".$crono.$extra."\n";
    
    $crono_last = $crono;
}