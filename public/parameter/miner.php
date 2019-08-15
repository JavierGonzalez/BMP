<?php # BMP — Javier González González

$__template['title'] = 'Miner parameter';


$__template['lib_js'][]  = '/public/parameter/miner.js';


$__template['tabs'] = array(
        '/info/blocks'   => _('Blocks'),
        '/info/miners'   => _('Miners'),
        '/info/actions'  => _('Actions'),
    );


?>

<h1>Miner</h1>

<h2>Parameter</h2>

<form id="miner_parameter_nick">

<table style="border:none;">

<tr>

<td nowrap>Set nick: </td>

<td>
	<input type="text" id="miner_parameter_nick_value" name="msg" value="" tabindex="1" autocomplete="off" size="20" maxlength="20" />
</td>

<td>
	<input type="submit" class="executive_action btn btn-success btn-sm" value="Execute" />
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
