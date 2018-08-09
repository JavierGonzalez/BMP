<?php



$template = false;

header('connection: close');
header('Content-Type: text/plain');





function acceso_check($chat_ID, $ac=null) {
	global $link;
	if (isset($ac)) { $check = array($ac); } else { $check = array('leer','escribir','escribir_ex'); }
	
	foreach (sql("SELECT acceso_leer, acceso_escribir, acceso_escribir_ex, acceso_cfg_leer, acceso_cfg_escribir, acceso_cfg_escribir_ex, pais FROM chats WHERE chat_ID = ".$chat_ID." LIMIT 1") AS $r) {
		foreach ($check AS $a) { $acceso[$a] = nucleo_acceso($r['acceso_'.$a], $r['acceso_cfg_'.$a]); }
	}
	if (isset($ac)) { return $acceso[$ac]; } else { return $acceso; }
}

/* ID CARGO 00:00 NICK MSG
m0 - m normal
p - m privado
e - evento
c - print comando
*/
function chat_refresh($chat_ID, $msg_ID=0) {
	global $_SESSION;
	$t = '';

	if (acceso_check($chat_ID, 'leer') === true) { // Permite leer  
		
		foreach (sql("SELECT * FROM chats_msg 
WHERE chat_ID = ".$chat_ID." AND 
msg_ID > ".$msg_ID."".(isset($_SESSION['pol']['user_ID'])?" AND (user_ID = '0' OR user_ID = ".$_SESSION['pol']['user_ID']." OR (tipo = 'p' AND nick LIKE '".$_SESSION['pol']['nick']."&rarr;%'))":" AND tipo != 'p'")." 
ORDER BY msg_ID DESC LIMIT 50") AS $r) {
			$t = $r['msg_ID'].' '.($r['tipo']!='m'?$r['tipo']:$r['cargo']).' '.substr($r['time'], 11, 5).' '.$r['nick'].' '.$r['msg']."\n".$t; 
		}
		return $t;
	}
}


// Prevención de inyección
foreach (array('GET', 'POST', 'REQUEST', 'COOKIE') AS $_) {
	foreach (${'_'.$_} AS $key=>$value) {
		if (get_magic_quotes_gpc()) { $value = stripslashes($value); }
		$value = str_replace(
			array("\r\n",   "\n",     '\'',    '"',     '\\'   ), 
			array('<br />', '<br />', '&#39;', '&#34;', '&#92;'),
		$value);
		${'_'.$_}[$key] = e($value); 
	}
}


if ($_GET[2] == 'refresh' AND (is_numeric($_POST['chat_ID'])) AND (is_numeric($_POST['n']))) {

	echo chat_refresh($_POST['chat_ID'], $_POST['n']);

} elseif (($_GET[2] == 'send') AND (is_numeric($_POST['chat_ID']))) {

	$date = date('Y-m-d H:i:s');
	$chat_ID = $_POST['chat_ID'];

	// CHECK MSG
	$msg_len = strlen($_POST['msg']);
	if (($msg_len > 0) AND ($msg_len < 400) AND (!isset($expulsado)) AND (acceso_check($chat_ID, 'escribir'))) {
		

		// limpia MSG
		$msg = $_POST['msg'];
		if (isset($borrar_msg)) { $msg = ''; }

		$msg = str_replace(array("\n", "\r", "ส็็็็็็็็", "ส็็็็็็็็็็็็็็็็็็็็็็็็็"), "", str_replace("'", "''", trim($msg)));
		
		$target_ID = 0;
		$tipo = 'c';

		if (substr($msg, 0, 1) == '/') {
			// ES COMANDO
			$msg_array = explode(" ", $msg);
			$msg_key = substr($msg_array[0], 1);
			$msg_rest = substr($msg, (strlen($msg_key) + 2));
			$user_ID_priv = '0';

			switch ($msg_key) {

				case 'dado':
					$param = $msg_array[1]; // parametro despues de /dado
					if ((is_numeric($param)) AND ($param > 1)) {
						$result_rand = mt_rand(1, $param);
						$result_type = ' de '.$param.' n&uacute;meros';
					} elseif ($param == '%') {
						$result_rand = mt_rand(00, 99).'%';
						$result_type = ' de porcentaje';
					} else { // dado normal
						$result_rand = mt_rand(1, 6);
						$result_type = '';
					}
					$elmsg = '<b>[$]</b> <em>' . $_SESSION['pol']['nick'] . '</em> tira el <b>dado'.$result_type.': <span style="font-size:16px;">'.$result_rand.'</span></b>';
					break;

				case 'calc': 
					if (ereg("^[0-9\+-\/\*\(\)\.]{1,100}$", strtolower($msg_rest))) { 
						@eval("\$result=" . $msg_rest . ";");
						if (substr($result, 0, 8) == 'Resource') { $result = 'calc error'; }
						$elmsg = '<b>[$] ' . $_SESSION['pol']['nick'] . '</b> calc: <b style="color:blue">' . $msg_rest . '</b> <b style="color:grey;">=</b> <b style="color:red">' . $result . '</b>';
					}
					break;

				case 'aleatorio': $elmsg = '<b>[$] ' . $_SESSION['pol']['nick'] . '</b> aleatorio: <b>' . mt_rand(00000,99999) . '</b>'; break;
				

				case 'me': $elmsg = '<b style="margin-left:20px;">' . $_SESSION['pol']['nick'] . '</b> ' . $msg_rest; break;
				case 'exit': $elmsg = '<span style="margin-left:20px;color:#66004C;"><b>' . $_SESSION['pol']['nick'] . '</b> se marcha, ¡hasta pronto!</span>'; break;


				case 'msg':
					if (isset($_SESSION['pol']['user_ID'])) {
						$nick_receptor = trim($msg_array[1]);
						$result = sql("SELECT HIGH_PRIORITY ID, nick FROM users WHERE nick = '" . $nick_receptor . "' LIMIT 1");
						while($r = r($result)){ 
							$elmsg = substr($msg_rest, (strlen($r['nick'])));
							$target_ID = $r['ID'];
							$tipo = 'p';
							$elnick = $_SESSION['pol']['nick'].'&rarr;'.$r['nick'];
						}
					}
					break;
			}
			unset($msg); if (isset($elmsg)) { $msg = $elmsg; }
			
		} else { $tipo = 'm'; }

		// insert MSG
		if (isset($msg)) {
			if (!isset($elnick)) { $elnick = $_SESSION['pol']['nick']; }
			if ($_SESSION['pol']['estado'] == 'anonimo') { $sql_ip = 'inet_aton("'.$_SERVER['REMOTE_ADDR'].'")'; } else { $sql_ip = 'NULL'; }

			$elcargo = $_SESSION['pol']['cargo'];
			if (($_SESSION['pol']['pais'] != PAIS) AND ($_SESSION['pol']['estado'] == 'ciudadano')) { $elcargo = 99; } // Extrangero

			sql("INSERT DELAYED INTO chats_msg (chat_ID, nick, msg, cargo, user_ID, tipo, IP) VALUES ('".$chat_ID."', '".$elnick."', '".$msg."', '".$elcargo."', '".$target_ID."', '".$tipo."', ".$sql_ip.")");

			sql("
UPDATE users SET fecha_last = '".$date."' WHERE ID = '".$_SESSION['pol']['user_ID']."' LIMIT 1;
UPDATE chats SET stats_msgs = stats_msgs + 1 WHERE chat_ID = '".$chat_ID."' LIMIT 1;
");
		}

		// print refresh
		if (isset($_POST['n'])) { echo chat_refresh($chat_ID, $_POST['n']); }
	} else { echo 'n 0 &nbsp; &nbsp; <b style="color:#FF0000;">No tienes permiso de escritura.</b>'."\n"; }

}