<?php # BMP

$_template['title'] = 'Chat';


$_template['lib_css'][] = '/public/chat/chat.css';

$_template['lib_js'][]  = '/public/chat/chat.js';
$_template['lib_js'][]  = '/public/bmp.js';
$_template['lib_js'][]  = '/lib/trezor-connect-7.js';
$_template['lib_js'][]  = '/lib/date.format.js';


$_template['tabs'] = array(
        '/info/blocks'   => _('Blocks'),
        '/info/miners'   => _('Miners'),
        '/info/actions'  => _('Actions'),
    );


?>

<div id="vp_c">


<div id="vpc_u">
	<ul id="chat_list">
	</ul>
</div>


<div id="vpc_fondo">
<div id="vpc">
<div style="margin-top:600px;color:#666;">

<table id="chat_msg">
</table>


</div>
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
	<input type="text" id="chat_input_msg" name="msg" value="" tabindex="1" autocomplete="off" size="65" maxlength="64" style="margin-left:0;width:98%;" autofocus required />
</td>

<td>
	<button type="button" id="chat_button_send" style="width:100px;" class="btn btn-success btn-sm">Execute</button>
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



</div>

