<?php # BMP — Javier González González


$txid = $_GET[1];

// Redirect url option to voting.
if ($txid_option = sql("SELECT p1 AS ECHO FROM actions WHERE action = 'voting_parameter' AND p2 = 2 AND txid = '".e($txid)."' LIMIT 1"))
    redirect('/voting/'.$txid_option);


$voting = action_voting_info($txid);


$_template['lib_js'][]  = '/public/voting/voting.js';
$_template['lib_js'][]  = '/public/bmp.js';
$_template['lib_js'][]  = '/lib/trezor-connect-7.js';

?>


<div style="width:700px;">


<h1>Voting</h1>


<fieldset>
<legend style="font-size:22px;font-weight:bold;"><?=$voting['question']?></legend>

<ol>
<?php
foreach ($voting['points'] AS $text)
    echo '<li>'.html_h($text, 3).'</li>';
?>
</ol>

</fieldset>







<fieldset>
<legend>Vote</legend>


<form id="voting_vote">

<p>
<select id="voting_option" style="font-size:22px;white-space:normal;max-width:400px;">

<?php
foreach ($voting['options'] AS $option_txid => $r)
    echo '<option value="'.$option_txid.'">'.$r['option'].'</option>';
?>

</select> 
</p>


<table border=0>

<tr>
<td>

<input type="submit" value="Vote" class="btn btn-success" />

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


<p><input type="text" id="voting_comment" maxlength="60" value="" style="width:100%;padding:4px;" placeholder="Comment..." /></p>


</form>



</fieldset>






<fieldset>
<legend>Result</legend>

<?php

$config = array(
        'votes'    => array('align' => 'right', 'num' => 0),
        'power'    => array('align' => 'right', 'num' => POWER_PRECISION, 'after' => '%'),
    );

echo html_table($voting['options'], $config);

?>

<br />

</fieldset>




</div>