<?php


$template['lib']['js'] = '/public/chat/chat.js';



if ($_GET[2] == 'e') { $externo = true; } else { $externo = false; }

if ((!$pol['nick']) AND ($_SESSION['pol']['nick'])) { $pol['nick'] = $_SESSION['pol']['nick']; }

foreach (sql("SELECT * FROM chats WHERE estado = 'activo' AND url = '".$_GET[1]."' LIMIT 1") AS $r) {

	$chat_ID = $r['chat_ID'];
	$titulo = $r['titulo'];

	foreach (array('leer','escribir') AS $a) {
		$acceso[$a] = nucleo_acceso($r['acceso_'.$a], $r['acceso_cfg_'.$a]);
	}

	$acceso_leer = $r['acceso_leer'];
	$acceso_cfg_leer = $r['acceso_cfg_leer'];

	$acceso_escribir = $r['acceso_escribir'];
	$acceso_cfg_escribir = $r['acceso_cfg_escribir'];

	$acceso_escribir_ex = $r['acceso_escribir_ex'];
	$acceso_cfg_escribir_ex = $r['acceso_cfg_escribir_ex'];
}

// genera array js, nombres cargos
foreach (sql("SELECT cargo_ID, nombre FROM cargos ORDER BY nivel DESC") AS $r) {
	if ($array_cargos) { $array_cargos .= ', '; } 
	$array_cargos .= $r['cargo_ID'].':"'.$r['nombre'].'"';
}



echo '
<div id="vp_c">

<h1 style="margin:0 0 18px 0;">';

if ($externo) {
	if ($_SESSION['pol']['user_ID']) {
		echo '<span style="float:right;"><a href="http://www.'.DOMAIN.'">'._('Volver a VirtualPol').'</a></span>'.$titulo;
	} else {
		echo '<span style="float:right;"><a href="'.REGISTRAR.'?='.PAIS.'">'._('Crear ciudadano').'</a></span>'.$titulo;
	}
} else {
	echo '<span class="quitar"><span style="float:right;">[<a href="/chats/'.$_GET[1].'/opciones">'._('Opciones').'</a>] [<a href="/chats/'.$_GET[1].'/log">'._('Log').'</a>]</span><a href="/chats/">'._('Chat').'</a>: '.$titulo.'</span>';
}

$a_leer = nucleo_acceso($acceso_leer, $acceso_cfg_leer);
$a_escribir = nucleo_acceso($acceso_escribir, $acceso_cfg_escribir);
$a_escribir_ex = nucleo_acceso($acceso_escribir_ex, $acceso_cfg_escribir_ex);

echo '</h1>

<div id="vpc_u">
<ul id="chat_list">
</ul>
</div>

<div id="vpc_fondo">
<div id="vpc">
<ul id="vpc_ul">
<li style="margin-top:600px;color:#666;">
BMP
<br />
'.now().'
<br />
<br />
<!--<table>
<tr>
<td align="right">'._('Acceso leer').':</td>
<td><b style="color:'.($a_leer?'blue;">'._('SI'):'red;">'._('NO')).'</b>. '.ucfirst('').'</td>
</tr>

<tr>
<td align="right">'._('Acceso escribir').':</td>
'.($pol['estado']=='extranjero'?'<td><b style="color:'.($a_escribir_ex?'blue;">'._('SI'):'red;">'._('NO')).'</b>. '.ucfirst('').'</td>':'<td><b style="color:'.($a_escribir?'blue;">'._('SI'):'red;">'._('NO')).'</b>. '.ucfirst('').'</td>').'
</tr>

</table>-->

<hr />

</li>
</ul>
</div>
</div>


</div>

<div id="chatform">
<form method="POST" onSubmit="return enviarmsg();">

<table width="100%">
<tr>

<td width="46" align="right" valign="middle"><img id="vpc_actividad" onclick="actualizar_ahora();" src="/img/ico/punto_gris.png" width="16" height="16" title="Actualizar chat" style="margin-top:4px;" /></td>

<td valign="middle">
'.(isset($pol['user_ID'])?'
<input type="text" id="vpc_msg" name="msg" onKeyUp="msgkeyup(event,this);" onKeyDown="msgkeydown(event,this);" tabindex="1" autocomplete="off" size="65" maxlength="250" style="margin-left:0;width:98%;" autofocus="autofocus" value="" required />':_('¡Regístrate para participar!')).'
</td>

<td nowrap="nowrap" valign="middle" title="Marcar para ocultar eventos del chat">&nbsp;&nbsp; <input id="cfilter" name="cfilter" value="1" type="checkbox" OnClick="chat_filtro_change(chat_filtro);" /> <label for="cfilter" class="inline">'._('Hide events').'</label></td>

<td align="right">'.boton(_('Enviar'), 'submit', false, '', '', ' id="botonenviar"').'</td>

</tr>
</table>

</form>

</div>';




// css & js
$template['header'] .= '
<script type="text/javascript"> 
msg_ID = -1;
elnick = "'.$_SESSION['pol']['nick'].'";
minick = elnick;
chat_ID = "'.$chat_ID.'";

ajax_refresh = true;
refresh = "";
anonimo = false;

hace_kick = '.($js_kick==''?'false':'true').';
kick_nick = "___";
js_kick = "'.$js_kick.'";

chat_delay = 4000;
chat_delay1 = "";
chat_delay2 = "";
chat_delay3 = "";
chat_delay4 = "";
chat_sin_leer = 0;
chat_sin_leer_yo = "";
mouse_position = "";
titulo_html = document.title;
chat_delay_close = "";
chat_scroll = 0;

chat_filtro = "normal";
chat_time = "";
acceso_leer = '.($acceso['leer']?'true':'false').';
acceso_escribir = '.($acceso['escribir']?'true':'false').';

al = new Array();
al_cargo = new Array();
array_cargos = new Array();
array_cargos = { 0:"", 98:"Turista", 99:"Extranjero" }; // '.$array_cargos.',

array_ignorados = new Array();

window.onload = function(){
	scroll_abajo();
	merge_list();
	$("#vpc_msg").focus();
	if ((!elnick) && ("'.$acceso_escribir.'" == "anonimos")) {
		$("#chatform").hide().after("<div id=\"cf\"><b>Nick:</b> <input type=\"input\" id=\"cf_nick\" size=\"10\" maxlength=\"14\" /> <button onclick=\"cf_cambiarnick();\" style=\"font-weight:bold;color:green;font-size:16px;\">Entrar al chat</button></div>");
	}
	'.($acceso['leer']?'refresh = setTimeout(chat_query_ajax, 6000); chat_query_ajax();':'').'

	$("body").click(function() {
	  chat_sin_leer = 0; 
	  chat_sin_leer_yo = "";
	  refresh_sin_leer();
	});
	delays();
	$("#vp_c a").attr("target", "_blank");
}


</script>';
