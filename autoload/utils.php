<?php


function redirect($url='/') {
    header('Location: '.$url);
    exit;
}


function num($number, $decimals=0) { 
    return number_format($number, $decimals, '.', ','); // i18n!
}


function crono($text=false) {
    global $crono;
    
    $crono_now = microtime(true);
    
    if ($crono['last'])
        $extra = ' ('.round(($crono_now-$crono['last'])*1000,2).' ms)';
    
    echo "\n".++$crono['count'].'. '.$crono_now.$extra.' '.$text."\n";
    
    $crono['last'] = microtime(true);
}


function escape($xss_danger_input, $html=true) {
	
	$a = $xss_danger_input;
	$a = nl2br($a);
	$a = str_replace("'", '&#39;', $a);
	$a = str_replace('"', '&quot;', $a);
	$a = str_replace(array("\x00", "\x1a"), '', $a);

	if ($html) 
		$a = strip_tags($a);
	
	$js_filter = 'video|javascript|vbscript|expression|applet|xml|blink|script|embed|object|iframe|frame|frameset|ilayer|bgsound|onabort|onactivate|onafterprint|onafterupdate|onbeforeactivate|onbeforecopy|onbeforecut|onbeforedeactivate|onbeforeeditfocus|onbeforepaste|onbeforeprint|onbeforeunload|onbeforeupdate|onblur|onbounce|oncellchange|onchange|onclick|oncontextmenu|oncontrolselect|oncopy|oncut|ondataavailable|ondatasetchanged|ondatasetcomplete|ondblclick|ondeactivate|ondrag|ondragend|ondragenter|ondragleave|ondragover|ondragstart|ondrop|onerror|onerrorupdate|onfilterchange|onfinish|onfocus|onfocusin|onfocusout|onhelp|onkeydown|onkeypress|onkeyup|onlayoutcomplete|onload|onlosecapture|onmousedown|onmouseenter|onmouseleave|onmousemove|onmouseout|onmouseover|onmouseup|onmousewheel|onmove|onmoveend|onmovestart|onpaste|onpropertychange|onreadystatechange|onreset|onresize|onresizeend|onresizestart|onrowenter|onrowexit|onrowsdelete|onrowsinserted|onscroll|onselect|onselectionchange|onselectstart|onstart|onstop|onsubmit|onunload';
	$a = preg_replace('/(<|&lt;|&#60;|&#x3C;|&nbsp;)('.$js_filter.')/', 'nojs', $a);
	
	return $a;
}



function now($days=0, $format='Y-m-d H:i:s', $type='past') {
	if ($days==0) {
		$timestamp = time();
	} else if ($type=='past') {
		$timestamp = time()-(86400*round($days));
	} else {
		$timestamp = time()+(86400*round($days));
	}
	return date($format, $timestamp);
}

function error_and_exit($print) {
	echo '<span style="color:red;">'.$print.'</span>';
	sql_close();
	exit;
}

function print_r2($print, $a=false) {
	$html = '<xmp style="background:#EEE;padding:4px;">'.print_r($print, true).'</xmp>';
	if ($a===true)
		return $html;
	else
		echo $html;
}