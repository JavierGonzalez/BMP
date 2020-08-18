<?php # BMP — Javier González González

$maxsim['template']['title'] = 'Voting create';


$maxsim['template']['css'] .= '#voting_create td { padding:10px; }';

$maxsim['template']['autoload']['js'][]  = '/voting/create.js';

?>

<h1><?=$maxsim['template']['title']?></h1>

<br />



<table border=0><tr><td valign="top">


<form id="voting_create">

<table style="border:none;">

<tr>

    <td align=right nowrap>Type of voting</td>

    <td valign="middle">

        <select id="type_voting" required>
            <option value="00">Explorative</option>
            <option value="01">Decisive in BMP</option>
            <option value="02">Decisive 51%</option>
            <option value="03">Decisive 66%</option>
        </select>

    </td>

</tr>



<tr>

    <td align=right>Type of vote</td>

    <td valign="middle">
        <select id="type_vote" required>
            <option value="01">One option</option>
            <option value="02" disabled>Multiple approval</option>
            <option value="03" disabled>Preferential with 3 votes</option>
            <option value="04" disabled>Preferential with 5 votes</option>
            <option value="05" disabled>Parameter config</option>
        </select>
    </td>

</tr>



<tr>
    <td align=right>Voting finish</td>

    <td valign="middle">
        Closed in <input type="text" id="blocks_to_finish" value="<?=BLOCK_WINDOW?>" size=5 style="text-align:right;" /> blocks.
    </td>
</tr>



<tr>
    <td align=right>Question</td>

    <td valign="middle">
        <input type="text" id="question" size=30 maxlength="200" autocomplete="off" focus required style="font-weight:bold;" />
    </td>
</tr>



<tr>
    <td align=right valign=top>Points</td>

    <td valign="middle" nowrap>
        <ol id="voting_points">
            <li><input class="parameter voting_point" size=24 maxlength="200" /> 
            <a href="#" style="font-size:18px;" onclick="voting_add_point();"><b>+</b></a></li>
        </ol>
    </td>
</tr>



<tr>
    <td align=right valign=top>Options</td>

    <td id="voting_options">
        <input size=20 value="NEUTRAL" disabled /><br />
        <input class="parameter voting_option" size=20 maxlength="200" value="Yes" required /><br />
        <input class="parameter voting_option" size=20 maxlength="200" value="No"  required /> 
        <a href="#" style="font-size:18px;" onclick="voting_add_option();"><b>+</b></a>
    </td>
</tr>



<tr>
    <td></td>

    <td>
        <button type="submit" class="executive_action btn btn-success">Create voting</button>
        &nbsp; <span id="op_return_preview_tx_count"></span>
    </td>
</tr>


</table>

</form>


</td><td valign="top">
    OP_RETURN preview:
    <div id="op_return_preview" class="monospace"></div>
</td></tr>

</table>