<?php


function redirect($url='/') {
    header('Location: '.$url);
    exit;
}


function num($number, $decimals=0) { 
    return number_format($number, $decimals, '.', ','); // i18n 
}


function crono($text=false) {
    global $crono;
    
    $crono_now = microtime(true);
    
    if ($crono['last'])
        $extra = ' ('.round(($crono_now-$crono['last'])*1000,2).' ms)';
    
    echo "\n".++$crono['count'].'. '.$crono_now.$extra.' '.$text."\n";
    
    $crono['last'] = microtime(true);
}



// ### NUCLEO ACCESO 3.1 from VirtualPol
function nucleo_acceso($tipo, $valor='', $pais=false) {
	return true;
	/*
	global $_SESSION;
	$valor = trim($valor);
	$rt = false;
	if ($pais == false) { $pais = PAIS; }
	if (is_array($tipo)) { $valor = $tipo[1]; $tipo = $tipo[0]; }
	elseif (stristr($tipo, '|')) { $valor = explodear('|', $tipo, 1); $tipo = explodear('|', $tipo, 0); }
	switch ($tipo) {
		case 'internet': case 'anonimos': $rt = true; break;
		case 'ciudadanos_global': if ((isset($_SESSION['pol']['user_ID'])) AND ($_SESSION['pol']['estado'] == 'ciudadano')) { $rt = true; } break;
		case 'ciudadanos': if (($_SESSION['pol']['estado'] == 'ciudadano') && (($_SESSION['pol']['pais'] == $pais) || (in_array(strtolower($_SESSION['pol']['pais']), explode(' ', strtolower($valor)))))) { $rt = true; } break;
		case 'excluir': if ((isset($_SESSION['pol']['nick'])) AND (!in_array(strtolower($_SESSION['pol']['nick']), explode(' ', strtolower($valor))))) { $rt = true; } break;
		case 'privado': if ((isset($_SESSION['pol']['nick'])) AND (in_array(strtolower($_SESSION['pol']['nick']), explode(' ', strtolower($valor))))) { $rt = true; } break;
		case 'afiliado': if (($_SESSION['pol']['pais'] == $pais) AND ($_SESSION['pol']['partido_afiliado'] == $valor)) { $rt = true; } break;
		case 'confianza': if (($_SESSION['pol']['confianza'] >= $valor)) { $rt = true; } break;
		case 'nivel': if (($_SESSION['pol']['pais'] == $pais) AND ($_SESSION['pol']['nivel'] >= $valor)) { $rt = true; } break;
		case 'cargo': if (($_SESSION['pol']['pais'] == $pais) AND (count(array_intersect(explode(' ', $_SESSION['pol']['cargos']), explode(' ', $valor))) > 0)) { $rt = true; } break;
		case 'grupos': if (($_SESSION['pol']['pais'] == $pais) AND (count(array_intersect(explode(' ', $_SESSION['pol']['grupos']), explode(' ', $valor))) > 0)) { $rt = true; } break;
		case 'examenes': if (($_SESSION['pol']['pais'] == $pais) AND (count(array_intersect(explode(' ', $_SESSION['pol']['examenes']), explode(' ', $valor))) > 0)) { $rt = true; } break;
		case 'monedas': if ($_SESSION['pol']['pols'] >= $valor) { $rt = true; } break;
		case 'supervisores_censo': if ($_SESSION['pol']['SC'] == 'true') { $rt = true; } break;
		case 'antiguedad': if ((isset($_SESSION['pol']['fecha_registro'])) AND (strtotime($_SESSION['pol']['fecha_registro']) < (time() - ($valor*86400)))) { $rt = true; } break;
		case 'print': 
			return array('privado'=>'Nick ...', 'excluir'=>'Nick ...', 'afiliado'=>'partido_ID', 'confianza'=>'0', 'cargo'=>'cargo_ID ...', 'grupos'=>'grupo_ID ...', 'nivel'=>'1', 'antiguedad'=>'365', 'monedas'=>'0', 'socios'=>'', 'autentificados'=>'', 'supervisores_censo'=>'', 'ciudadanos'=>'', 'ciudadanos_global'=>'', 'anonimos'=>'');
			exit;
	}
	if (in_array($_SESSION['pol']['estado'], array('kickeado', 'expulsado'))) { $rt = false; }
	return $rt;
	*/
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


function boton($texto, $url=false, $confirm=false, $size=false, $pols='', $html_extra=false) {
	if (($pols=='') OR (ECONOMIA == false)) {
		return '<button'.($url==false?' disabled="disabled"':' onClick="'.($confirm!=false?'if(!confirm(\''.$confirm.'\')){return false;}':'').($url!='submit'?'window.location.href=\''.$url.'\';return false;':'').'"').($size!=false?' class="'.$size.'"':'').($html_extra!=false?$html_extra:'').'>'.$texto.'</button>';
	} else {
		global $pol;
		return '<span class="amarillo"><input type="submit" value="'.$texto.'"'.($pol['pols']<$pols?' disabled="disabled"':' onClick="'.($confirm!=false?'if(!confirm(\''.$confirm.'\')){return false;}':'').'window.location.href=\''.$url.'\';"').' class="large blue" />'.(ECONOMIA?' &nbsp; '.pols($pols).' '.MONEDA.'':'').($html_extra!=false?$html_extra:'').'</span>';
	}
}