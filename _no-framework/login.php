<?php


// LOGIN
if (isset($_COOKIE['teorizauser'])) { 
	session_start();
	
	if (!isset($_SESSION['pol'])) { //NO existe sesion
		foreach (sql("SELECT ID, pass, nick, cargo, nivel, pais, fecha_registro, estado, dnie, voto_confianza FROM users WHERE nick = '".$_COOKIE['teorizauser']."' LIMIT 1") AS $r) {
			if (md5(CLAVE.$r['pass']) == $_COOKIE['teorizapass']) {
				$session_new = true;
				$_SESSION['pol']['nick'] = $r['nick'];
				$_SESSION['pol']['user_ID'] = $r['ID'];
				$_SESSION['pol']['fecha_registro'] = $r['fecha_registro'];
				$_SESSION['pol']['confianza'] = $r['voto_confianza'];
			}
		}  
	}

	$pol['nick'] = $_SESSION['pol']['nick'];
	$pol['user_ID'] = $_SESSION['pol']['user_ID'];

	// Control del tiempo para responder un examen. Puesto aquí para que sirva también para eliminar $_SESION['examen'] si se empieza un examen y no se reciben las respuestas. 
	if (isset($_SESSION['examen'])) {
		if (($_SESSION['examen']['tiempo'] + 10) <= time()) { unset($_SESSION['examen']); } 
	}
}

// USER OK
if (isset($pol['user_ID'])) {

	// LOAD: $pol
	$result = sql("SELECT lang, online, estado, pais, pols, partido_afiliado, bando, fecha_last, fecha_registro, nivel, fecha_init, cargo, cargos, examenes, fecha_legal, dnie, SC, IP, grupos, socio
FROM users WHERE ID = '".$pol['user_ID']."' LIMIT 1");
	while($r = r($result)) {
		$pol['pols'] = $r['pols'];
		$pol['pais'] = $r['pais'];
		$pol['estado'] = $r['estado'];
		$pol['partido'] = $r['partido_afiliado'];
		$pol['bando'] = $r['bando'];
		$pol['fecha_registro'] = $r['fecha_registro'];
		$pol['nivel'] = $r['nivel'];
		$pol['online'] = $r['online'];
		$pol['cargo'] = $r['cargo'];
		$pol['IP'] = $r['IP'];
		$pol['grupos'] = $r['grupos'];
		$fecha_init = $r['fecha_init'];
		$fecha_last = $r['fecha_last'];
		
		if ((isset($r['lang'])) AND ($_SERVER['REQUEST_URI'] != '/accion.php')) { $pol['config']['lang'] = $r['lang']; }

		$_SESSION['pol']['cargo'] = $r['cargo'];
		$_SESSION['pol']['cargos'] = $r['cargos'];
		$_SESSION['pol']['examenes'] = $r['examenes'];
		$_SESSION['pol']['nivel'] = $r['nivel'];
		$_SESSION['pol']['pais'] = $r['pais'];
		$_SESSION['pol']['estado'] = $r['estado'];
		$_SESSION['pol']['socio'] = $r['socio'];
		$_SESSION['pol']['dnie'] = $r['dnie'];
		$_SESSION['pol']['SC'] = $r['SC'];
		$_SESSION['pol']['partido_afiliado'] = $r['partido_afiliado'];
		$_SESSION['pol']['pols'] = $r['pols'];
		$_SESSION['pol']['grupos'] = $r['grupos'];

		if (($r['pais'] != PAIS) AND ($pol['estado'] == 'ciudadano')) { 
			// es extranjero
			$pol['estado'] = 'extranjero';
			if (($pol['cargo'] != 42) AND ($pol['cargo'] != 21)) { $pol['cargo'] = 99; }
			$pol['nivel'] = 0;
			$pol['pols'] = 0;
		}
	}

	// UPDATE
	if ($pol['estado'] != 'expulsado') { // No esta expulsado
		if (isset($session_new)) { // START SESSION
			$update = ", visitas = visitas + 1, nav = '".$_SERVER['HTTP_USER_AGENT']."', fecha_init = '".now()."'";
			if ($fecha_init != '0000-00-00 00:00:00') { $update .= ", online = online + ".(strtotime($fecha_last)-strtotime($fecha_init)); }
			include_once('inc-functions-accion.php');
			$txt .= users_con($pol['user_ID'], '', 'session', true);
		}
		sql("UPDATE LOW_PRIORITY users SET paginas = paginas + 1, fecha_last = '".now()."'".$update." WHERE ID = '".$pol['user_ID']."' LIMIT 1");
	} else { unset($pol); session_unset(); session_destroy(); } // impide el acceso a expulsados


}


// Forzado SSL
if (false AND !$_SERVER['HTTPS'] AND isset($pol['nick'])) { redirect('https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); }


/* i18n
$vp['lang'] = $pol['config']['lang'];
if ((isset($vp['lang'])) AND ($vp['lang'] != 'es_ES')) {
	// Carga internacionalización
	$locale = $vp['lang'];
	putenv("LC_ALL=$locale");
	setlocale(LC_ALL, $locale);
	bindtextdomain('messages', '../locale');
	textdomain('messages');
	bind_textdomain_codeset('messages', 'UTF-8');
}
*/


unset($fecha_init, $fecha_last);


//!!!!!!!!
$pol['nick'] = 'GONZO';
$pol['user_ID'] = 1;

$_SESSION['pol']['nick'] = 'GONZO';
$_SESSION['pol']['user_ID'] = 1;