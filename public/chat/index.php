<?php # BMP

$_template['title'] = 'Chat';

$_template['lib_js'][]  = '/public/chat/chat.js';
$_template['lib_css'][] = '/public/chat/chat.css';

$_template['lib_js'][] = 'https://connect.trezor.io/7/trezor-connect.js';


$_template['tabs'] = array(
        '/info/blocks'     => _('Blocks'),
        '/info/miners'     => _('Miners'),
        '/info/actions'    => _('Actions'),
    );

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
<br />';

foreach (sql("SELECT address, p1, p2, p3 FROM actions WHERE action = 'chat' AND p2 = '000001' ORDER BY p1 ASC") AS $r)
	echo date("Y-m-d H:i:s", $r['p1']).' &nbsp; '.substr($r['address'],0,10).' &nbsp; '.$r['p3'].'<br />';



echo '




<hr />

</li>
</ul>
</div>
</div>


</div>

<div id="chatform">

<form id="chat_form_msg">

<table width="100%" style="border:none;">
<tr>

<td width="46" align="right" valign="middle">
<img id="vpc_actividad" onclick="actualizar_ahora();" src="/public/chat/img/point_grey.png" width=16 height=16 style="margin-top:4px;" />
</td>

<td valign="middle">
	<input type="text" id="chat_input_msg" name="msg" value="" tabindex="1" autocomplete="off" size="65" maxlength="100" style="margin-left:0;width:98%;" autofocus required />
</td>

<td>
	<button type="button" id="chat_button_send" style="width:100px;">Enviar</button>
</td>


<!--
<td align="right" nowrap="nowrap" valign="middle" title="Marcar para ocultar eventos del chat">
	<input id="cfilter" name="cfilter" value="1" type="checkbox" OnClick="chat_filtro_change(chat_filtro);" /> <label for="cfilter" class="inline">'._('Hide events').'</label>
</td>
-->

</tr>


<tr>

<td></td>
<td colspan=2>
<span id="op_return_preview" style="font-family:monospace, monospace;font-size:13px;"></span>
</td>

</tr>


</table>

</form>



</div>';



$_template['js'] .= '


ajax_refresh = true;
refresh = "";


chat_delay = 4000;
chat_delay_close = "";
chat_scroll = 0;


window.onload = function(){
	scroll_down();

	refresh = setTimeout(chat_query_ajax, 6000); 
	chat_query_ajax();
}



$("#chat_input_msg").keyup(function() {
	$("#op_return_preview").text(bin2hex($(this).val()));
});



$("#chat_form_msg").submit(function() {

	var msg = $("#chat_input_msg").val();
	$("#chat_input_msg").val("");

	var timestamp = Math.round(new Date().getTime()/1000);	

	var channel = "000001";

	var op_return = "'.$bmp_protocol['prefix'].'" + "02" + bin2hex(timestamp) + channel + bin2hex(msg);

	result = blockchain_send_tx(op_return);

	console.log(result);
	
	return false;
});



function blockchain_send_tx(op_return) {

	var TrezorConnect = window.TrezorConnect;

	TrezorConnect.manifest({
		email: "gonzo@virtualpol.com",
		appUrl: "https://bmp.virtualpol.com"
	});

	result = TrezorConnect.composeTransaction({
		outputs: [
			{ type: "opreturn", dataHex: op_return }
		],
		coin: "bch",
		push: true
	});

	return result;
}



function bin2hex(s) {
  var i, l, o = "", n;
  s += "";
  for (i = 0, l = s.length; i < l; i++) {
    n = s.charCodeAt(i).toString(16)
    o += n.length < 2 ? "0" + n : n;
  }
  return o;
}


';
