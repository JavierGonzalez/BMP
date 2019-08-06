<?php # maximum_simplicity — Javier González González



function ___($echo='', $scroll_down=false) {
	$now = hrtime(true);
    global $_;

    if (!$_['crono'])
        $_['crono'] = $now;

    if ($scroll_down) {
        if (function_exists('apache_setenv'))
            @apache_setenv('no-gzip', 1);

		ob_end_flush();
		echo '<script>function Az1() { window.scrollTo(0,document.body.scrollHeight); }</script>';
	}


    echo '<br />'.++$_['crono_count'].'. &nbsp; '.date('Y-m-d H:i:s').' &nbsp; ';
    echo number_format(($now-$_['crono'])/1000000, 2).' ms &nbsp; ';
    
    if (is_array($echo) OR is_object($echo))
        print_r2($echo);
    else if ($echo!=='')
        var_dump($echo);
    
    if ($scroll_down) {
        echo '<script>Az1();</script>';
        flush();
        ob_flush();
    }

    $_['crono'] = hrtime(true);
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



function ram() {
    return number_format(memory_get_usage(true)/1024).' kb';
}



function redirect($url='/') {
    header('Location: '.$url);
    exit;
}



function shell($command) {
    $GLOBALS['shell_output'] = trim(shell_exec($command.' 2>&1'));
    return $GLOBALS['shell_output'];
}



function num($number, $decimals=0) { 
    return number_format($number, $decimals, '.', ',');
}
