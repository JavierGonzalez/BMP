<?php # BMP — Javier González González

$txid = e($_GET[1]);

$voting = action_voting($txid, $_GET['blockchain']);

if (!$voting)
    redirect('/');


$maxsim['template']['title'] = 'Voting: '.$voting['question'];

$maxsim['autoload'][]  = 'voting/vote.js';



?>

<h1>Voting</h1>


<table border=0 width="100%"><tr><td valign="top" style="min-width:600px;">


<fieldset>
<legend style="font-size:20px;font-weight:bold;"><?=$voting['question']?></legend>


<ol>
<?php
foreach ((array)$voting['points'] AS $point)
    echo '<li style="font-size:16px;margin-bottom:5px;">'.html_link_to_a($point['text']).'</li>';
?>
</ol>

<legend style="float:right;font-size:14px;margin-bottom:-14px;" title="<?=$voting['time'].' OPEN&#013;'.$voting['time_closed'].' CLOSED'?>"><?=ucfirst($voting['status'])?></legend>

</fieldset>



<br />


<fieldset>
<legend>Result</legend>

<!--<span style="float:right;margin-top:-44px;">


<select onchange="window.location.replace('/voting/<?=$txid?>' + (this.options[this.selectedIndex].text!='All'?'?blockchain=' + this.options[this.selectedIndex].text:''));">
    <option>All</option>
<?php
foreach (BLOCKCHAINS AS $blockchain => $value)
    echo '<option'.($_GET['blockchain']==$blockchain?' selected':'').'>'.$blockchain.'</option>';
?>
</select>

</span>-->


<?php

$config = [
    'votes'     => ['align' => 'right', 'num' => 0],
    'power'     => ['align' => 'right', 'num' => POWER_PRECISION, 'after' => '%', 'bold' => true],
    'hashpower' => ['align' => 'right', 'function' => 'hashpower_humans'],
    ];

foreach ((array)$voting['options'] AS $option)
    $print_options[] = [
        'option'    => $option['option'],
        'votes'     => $option['votes'],
        'power'     => $option['power'],
        'hashpower' => $option['hashpower'],
        ];

echo html_table($print_options, $config).'<br />';


if ($voting['status']=='closed' AND $voting['validity']>50) { // Refact
    echo '<legend title="Validity: '.num($voting['validity'],POWER_PRECISION).'%" style="float:right;font-size:14px;margin-bottom:-14px;">';
    echo 'This voting is VALID';
    echo '</legend>';
}

?>

</fieldset>


<?php if ($voting['status']=='open') { ?>

<fieldset>
<legend>Vote</legend>


<form id="voting_vote">

<input type="hidden" id="voting_txid" value="<?=$voting['txid']?>" />
<input type="hidden" id="voting_type_vote" value="1" />

<p>
<select id="voting_option" style="font-size:22px;white-space:normal;max-width:400px;">

<?php
foreach ($voting['options'] AS $option_txid => $r)
    echo '<option value="'.$r['vote'].'">'.$r['option'].'</option>';
?>

</select> 
</p>


<table border=0>

<tr>
<td>

<input type="submit" value="Vote" class="executive_action btn btn-success" />

</td>
<td style="padding-top:8px;">

<input id="rv_1" type="radio" name="voting_validity" value="1" class="radio" required /> 
<label for="rv_1">This voting is valid.</label>
<br />
<input id="rv_0" type="radio" name="voting_validity" value="0" class="radio" required /> 
<label for="rv_0">This voting is not valid.</label>

</td>
</tr>


</table>


<p><input type="text" id="voting_comment" maxlength="41" value="" autocomplete="off" style="width:100%;padding:4px;" placeholder="Comment..." /></p>

<span id="op_return_preview" class="monospace" style="font-size:12px;"></span>

</form>



<legend style="float:right;font-size:14px;margin-bottom:-14px;">Closed in <?=$voting['closed_in']?> blocks</legend>

</fieldset>


<?php } ?>





</td><td valign="top">

<pre>
<?=replace_hash_to_link(json_encode($voting, JSON_PRETTY_PRINT))?>
</pre>

</td></tr></table>