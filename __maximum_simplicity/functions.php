<?php # maximum_simplicity



function __profiler($hrtime=false) {
    global $__, $__sql, $__rpc;

    if (!$hrtime)
        $hrtime = $__['crono'];

    $output[] = num((hrtime(true)-$hrtime)/1000/1000).' ms';
    
    if (is_numeric($__sql['count']))
        $output[] = num($__sql['count']).' sql';
    
    if (is_numeric($__rpc['count']))
        $output[] = num($__rpc['count']).' rpc';

    $output[] = num(memory_get_usage(false)/1024).' kb';
    
    return $output;
}



// For debug or benchmark.
function ___($echo='', $scroll_down=false) {
	global $__;

    $hrtime = $__['crono'];

    echo '<br />'."\n";
    echo ++$__['___'].'. &nbsp; '.date('Y-m-d H:i:s').' &nbsp; '.implode(' &nbsp; ', __profiler($hrtime)).' &nbsp; ';


    if (is_string($echo))
        echo $echo;
    else if (is_array($echo) OR is_object($echo))
        print_r2($echo);
    else
        var_dump($echo);
    

    if ($scroll_down) {
        if ($__['___']==1) {
            if (function_exists('apache_setenv')) {
                @apache_setenv('no-gzip', 1);
            }

            ob_end_flush();
            echo '<script>function __sd() { window.scrollTo(0,document.body.scrollHeight); }</script>';
        }

        echo '<script>__sd();</script>';
        flush();
        ob_flush();
    }

    $__['crono'] = hrtime(true);
}



function print_r2($print, $echo=true) {
    $html = '<xmp style="background:#EEE;padding:4px;">'.print_r($print, true).'</xmp>';
    if ($echo===true)
        echo $html;
    else
        return $html;
}



function injection_filter($danger_input) {
    $output = trim(strip_tags($danger_input));
    if (get_magic_quotes_gpc())
        $output = stripslashes($output);
    return $output;
}



function file_filter($file) {
    $file = preg_replace('/[^A-Za-z0-9_.-]/', '', $file);
    $file = filter_var($file, FILTER_SANITIZE_STRING);
    return $file;
}



function every($seconds=60, $id=0) {
    global $every_last;

    if (time() >= $every_last[$id]+$seconds)
        return $every_last[$id] = time();

    return false;
}



function redirect($url='/') {
    header('Location: '.$url);
    exit;
}



function shell($command) {
    return trim(shell_exec($command.' 2>&1'));
}



function num($number, $decimals=0) { 

    if (!is_numeric($number))
        return '';

    return number_format((float)$number, $decimals, '.', ',');
}
