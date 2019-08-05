<?php # maximum_simplicity — Javier González González



function ___($echo='') {
    global $crono;
	
	$crono_now = microtime(true);
	
    if (!isset($crono['last'])) {
		ob_end_flush();
		// ini_set('memory_limit', '15G');
		// set_time_limit(24*60*60);
		// apache_setenv('no-gzip', '1');
		
		$crono['last'] = $crono_now;

		echo '<script>function Sc() { window.scrollTo(0,document.body.scrollHeight); }</script>';
	}


    echo '<br />'.++$crono['count'].'. &nbsp; '.date("Y-m-d H:i:s").' &nbsp; ';
    echo number_format(($crono_now-$crono['last'])*1000, 1).' ms &nbsp; '; 
    
    if (is_array($echo) OR is_object($echo))
        print_r2($echo);
    else if ($echo!=='')
        var_dump($echo);

    echo '<script>Sc();</script>';

	$crono['last'] = microtime(true);
	
	flush();
	ob_flush();
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
    return round(memory_get_usage(true)/1024/1024).' MB';
}



function redirect($url='/') {
    header('Location: '.$url);
    exit;
}



function shell($command) {
    $GLOBALS['shell_output'] = trim(shell_exec($command.' 2>&1'));
    return $GLOBALS['shell_output'];
}
