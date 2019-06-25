<?php # BMP — Javier González González

$_template['title'] = 'Voting create';


$_template['css'] .= '#voting_create td { padding:10px; }';

$_template['lib_js'][]  = '/public/voting/voting.js';

?>

<h1><?=$_template['title']?></h1>

<br />

<form id="voting_create">

<table style="border:none;">



<tr>

    <td align=right>Type of vote</td>

    <td valign="middle">
        <select id="type_vote" required>
            <option value="00">One election</option>
            <option value="01" disabled>Multiple approval</option>
            <option value="02" disabled>Preferential with 3 votes</option>
            <option value="03" disabled>Preferential with 5 votes</option>
        </select>
    </td>

</tr>





<tr>

    <td align=right>Voting finish</td>

    <td valign="middle">
        In <input type="text" id="blocks_to_finish" value="<?=BLOCK_WINDOW?>" size=5 style="text-align:right;" /> blocks
    </td>

</tr>



<tr>

    <td align=right>Question</td>

    <td valign="middle">
        <input type="text" id="question" size=40 maxlength="70" focus required style="font-weight:bold;" />
    </td>

</tr>



<tr>

    <td align=right valign=top>Points</td>

    <td valign="middle">
        <input class="parameter voting_point" size=40 maxlength="42" /> +
    </td>

</tr>




<tr>

    <td align=right valign=top>Options</td>

    <td>
        <input class="parameter voting_option" size=20 maxlength="42" value="Yes" required /><br />
        <input class="parameter voting_option" size=20 maxlength="42" value="No" required /> +
    </td>

</tr>






<tr>

<td></td>

<td>
<button type="submit" class="executive_action btn btn-success">Execute</button>
</td>


</tr>


</table>

<br />

</form>
