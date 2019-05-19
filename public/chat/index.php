<?php # BMP


$_template['lib_js']  = '/public/chat/chat.js';
$_template['lib_css'] = '/public/chat/chat.css';
$_template['title'] = 'Chat';



echo '
<div id="vp_c">


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

<td width="46" align="right" valign="middle"><img id="vpc_actividad" onclick="actualizar_ahora();" src="/public/chat/img/point_grey.png" width="16" height="16" title="Actualizar chat" style="margin-top:4px;" /></td>

<td valign="middle">
<input type="text" id="vpc_msg" name="msg" onKeyUp="msgkeyup(event,this);" onKeyDown="msgkeydown(event,this);" tabindex="1" autocomplete="off" size="65" maxlength="250" style="margin-left:0;width:98%;" autofocus="autofocus" value="" required />
</td>

<td nowrap="nowrap" valign="middle" title="Marcar para ocultar eventos del chat">&nbsp;&nbsp; <input id="cfilter" name="cfilter" value="1" type="checkbox" OnClick="chat_filtro_change(chat_filtro);" /> <label for="cfilter" class="inline">'._('Hide events').'</label></td>

<td align="right">BOTON_ENVIAR</td>

</tr>
</table>

</form>

</div>';



/*
// css & js
$_template['header'] .= '
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


*/