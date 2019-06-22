<?php # BMP — Javier González González

$_template['title'] = 'Miner parameter';


$_template['lib_js'][]  = '/public/parameter/miner.js';
$_template['lib_js'][]  = '/public/bmp.js';
$_template['lib_js'][]  = 'https://connect.trezor.io/7/trezor-connect.js';


$_template['tabs'] = array(
        '/info/blocks'   => _('Blocks'),
        '/info/miners'   => _('Miners'),
        '/info/actions'  => _('Actions'),
    );


?>

<h2>Miner parameter:</h2>


<form id="miner_parameter_nick">

<table style="border:none;">

<tr>

<td nowrap>Set nick: </td>

<td>
	<input type="text" id="miner_parameter_nick_value" name="msg" value="" tabindex="1" autocomplete="off" size="20" maxlength="20" />
</td>

<td>
	<button type="button" style="width:100px;">Execute</button>
</td>


</tr>

<tr>

<td></td>
<td colspan=2>
<span id="miner_parameter_nick_preview" style="font-family:monospace, monospace;font-size:13px;"></span>
</td>

</tr>

</table>


</form>
