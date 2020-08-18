<?php # BMP — Javier González González

$maxsim['template']['title'] = 'Delegation create';


$maxsim['template']['css'] .= '#delegation_create td { padding:10px; }';

?>

<h1><?=$maxsim['template']['title']?></h1>

<br />



<table border=0><tr><td valign="top">


<form id="delegation_create">

<table style="border:none;">




<tr>
    <td align=right>Quota</td>

    <td valign="middle">
        <input type="text" id="quota" value="1.0000" size=10 style="text-align:right;" /> % of hashpower
    </td>
</tr>



<tr>
    <td align=right>Address (Legacy)</td>

    <td valign="middle">
        <input type="text" id="address" size=50 maxlength="60" autocomplete="off" class="monospace" focus required /> <b id="address_validity_check"></b>
    </td>
</tr>




<tr>
    <td></td>

    <td>
        <button type="submit" class="executive_action btn btn-success">Hashpower delegation</button>
        <span id="op_return_preview" class="monospace"></span>
    </td>

</tr>


</table>

</form>


</td></tr></table>



