<?php # BMP — Javier González González

// $__template['title'] = 'Chat';


$__template['lib_css'][] = '/public/chat/chat.css';

$__template['lib_js'][]  = '/public/chat/chat.js';
$__template['lib_js'][]  = '/lib/date.format.js';


$__template['tabs'] = [
    '/info/blocks'   => _('Blocks'),
    '/info/miners'   => _('Miners'),
    '/info/actions'  => _('Actions'),
    ];


?>

<div id="vp_c">


<!--
<div id="vpc_u">
	<ul id="chat_list"></ul>
</div>
-->


<div id="vpc_fondo">
<div id="vpc">
<div style="margin-top:600px;color:#666;">

<table id="chat_msg">
<tr>
    <th>Height</th>
    <th>Time</th>
    <th>Miner</th>
    <th></th>
    <th>Power</th>
    <th>Hashpower</th>
</tr>


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
<img id="vpc_actividad" src="/public/chat/img/point_grey.png" width=16 height=16 style="margin-top:4px;" />
</td>

<td valign="middle">
	<input type="text" id="chat_input_msg" name="msg" value="" tabindex="1" autocomplete="off" size="65" maxlength="70" style="margin-left:0;width:98%;" autofocus required />
</td>

<td>
	<input type="submit" style="width:100px;" class="executive_action btn btn-success btn-sm" value="Execute" />
</td>


</tr>

<tr>

<td></td>
<td colspan=2>
<span id="op_return_preview" class="monospace" style="font-size:13px;"></span>
</td>

</tr>


</table>

</form>



</div>

