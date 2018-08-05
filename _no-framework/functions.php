<?php


function redirect($url='/') {
    header('Location: '.$url);
    exit;
}


function crono($text=false) {
    global $crono;
    
    $crono_now = microtime(true);
    
    if ($crono['last'])
        $extra = ' ('.round(($crono_now-$crono['last'])*1000,2).' ms)';
    
    echo "\n".++$crono['count'].'. '.$crono_now.$extra.' '.$text."\n";
    
    $crono['last'] = microtime(true);
}