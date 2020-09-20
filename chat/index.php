<?php # BMP — Javier González González

// $maxsim['template']['title'] = 'Chat';


$maxsim['template']['autoload']['css'][] = '/chat/chat.css';

$maxsim['template']['autoload']['js'][]  = '/chat/chat.js';
$maxsim['template']['autoload']['js'][]  = '/lib/date.format.js';


$maxsim['template']['tabs'] = [
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


<div id="vpc_f">
<div id="vpc">
<div style="margin-top:600px;color:#666;font-size:16px;">

<table id="chat_msg" style="display:none;">
<tr>
    <th>Height</th>
    <th>Time</th>
    <th>Miner</th>
    <th></th>
    <th>Power</th>
    <th>Hashpower</th>
    <th></th>
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

<td width="46" align="right" valign="top">
    <img id="vpc_actividad" src="/chat/img/point_grey.png" width=16 height=16 style="margin-top:4px;" />
</td>

<td valign="top">
	<input type="text" id="chat_input_msg" name="msg" value="" tabindex="1" autocomplete="off" size="65" maxlength="300" style="margin-left:0;width:98%;" autofocus required />
</td>

<td valign="top">
	<input type="submit" style="width:100px;" class="executive_action btn btn-success btn-sm" value="Send" />
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

