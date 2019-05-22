<?php # simple_framework


function injection_filter($danger_input) {
  $output = trim(strip_tags($danger_input));
  if (get_magic_quotes_gpc())
    $output = stripslashes($output);
  return e($output);
}



function file_filter($file) {
    $file = preg_replace('/[^A-Za-z0-9_.-]/', '', $file);
    $file = filter_var($file, FILTER_SANITIZE_STRING);
    return $file;
}



function print_r2($print, $echo=true) {
	$html = '<xmp style="background:#EEE;padding:4px;">'.print_r($print, true).'</xmp>';
	if ($echo===true)
		echo $html;
	else
		return $html;
}



function crono($text=false) {
    global $crono;
    
    $crono_now = microtime(true);
    
    if ($crono['last'])
        $extra = ' ('.round(($crono_now-$crono['last'])*1000,2).' ms)';
    
    echo "\n".++$crono['count'].'. '.$crono_now.$extra.' '.$text."\n";
    
    $crono['last'] = microtime(true);
}



function redirect($url='/') {
    header('Location: '.$url);
    exit;
}



function shell($command) {
	$GLOBALS['shell_output'] = trim(shell_exec($command.' 2>&1'));
	return $GLOBALS['shell_output'];
}
