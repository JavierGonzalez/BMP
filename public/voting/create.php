<?php # BMP

$_template['title'] = 'Voting create';


$_template['top_right'] .= '<a href="/voting" class="btn btn-outline-primary">Voting</a>';

echo html_h($_template['title'], 1);

$_template['css'] .= '#voting_create td { padding:10px; }';

?>

<br />

<form id="voting_create">

<table style="border:none;">


<tr>

    <td>Type of voting</td>

    <td valign="middle">
        <select id="type_voting" required>
            <option value="00">Survey</option>
            <option value="01">Executive</option>
        </select>
    </td>


</tr>



<tr>

    <td>Type of vote</td>

    <td valign="middle">
        <select id="type_vote" required>
            <option value="00">One election</option>
            <option value="01" disabled>Multiple election</option>
            <option value="02" disabled>Preferential with 3 votes</option>
            <option value="03" disabled>Preferential with 5 votes</option>
            <option value="04" disabled>Preferential with 10 votes</option>
        </select>
    </td>

</tr>





<tr>

    <td>Voting time</td>

    <td valign="middle">
        <select id="type_vote" required>
            <option value="2016">2016 blocks</option>
        </select>
    </td>

</tr>



<tr>

    <td>Quorum</td>

    <td valign="middle">
        <select id="type_vote" required>
            <option value="2016">51%</option>
        </select>
    </td>

</tr>





<tr>

    <td>Question</td>

    <td valign="middle">
        <input size=40 focus required />
    </td>

</tr>

<tr>

<td></td>

<td>
<button type="button" id="chat_button_send" class="btn btn-success">Execute</button>
</td>


</tr>


</table>

<br />

</form>
