<?php # BMP — Javier González González


$txid = $_GET[1];


if ($txid_option = sql("SELECT p1 AS ECHO FROM actions WHERE action = 'voting_parameter' AND p2 = 2 AND txid = '".$txid."' LIMIT 1"))
    redirect('/voting/'.$txid_option);


$voting = get_voting($txid);


function get_voting($txid) {

    $voting = sql("SELECT * FROM actions WHERE txid = '".e($txid)."' AND action = 'voting'  LIMIT 1")[0];
    
    $voting['p'] = action_parameters_pretty($voting);
    
    $voting['points']  = sql("SELECT * FROM actions WHERE action = 'voting_parameter' AND p1 = '".e($txid)."' AND p2 = 1 ORDER BY p3 ASC");
    $voting['options'] = sql("SELECT * FROM actions WHERE action = 'voting_parameter' AND p1 = '".e($txid)."' AND p2 = 2 ORDER BY p3 ASC");


    if ((count($voting['points']) + count($voting['options'])) != $voting['p3'])
        return false;

    $voting['options'] = array_merge(array(array('txid'=>$txid, 'p4'=>'NULL')), $voting['options']);

    return $voting;
}


$_template['lib_js'][]  = '/public/voting/voting.js';
$_template['lib_js'][]  = '/public/bmp.js';
$_template['lib_js'][]  = '/lib/trezor-connect-7.js';


?>


<div style="width:700px;">


<h1>Voting</h1>


<fieldset>
<legend style="font-size:22px;font-weight:bold;"><?=$voting['p']['question']?></legend>

<ol>
<?php
foreach ($voting['points'] AS $r)
    echo '<li>'.html_h($r['p4'], 3).'</li>';
?>
</ol>

</fieldset>







<fieldset>
<legend>Vote</legend>


<form id="voting_vote">

<p>
<select id="voting_option" style="font-size:22px;white-space:normal;max-width:400px;">
    <option value="<?=$txid?>" selected>NULL</option>

<?php
foreach ($voting['options'] AS $r)
    echo '<option value="'.$r['txid'].'">'.$r['p4'].'</option>';
?>

</select> 
</p>

<br />

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

<ul>
<?php

$options_votes[] = $txid; // NULL
foreach ($voting['options'] AS $r)
    $options_votes[] = $r['txid'];


$result = sql("SELECT address, p1
                FROM actions 
                WHERE action = 'vote' AND p1 IN ('".implode("','", $options_votes)."')
                ORDER BY time ASC");

// One vote per miner, last prevails.
foreach ($result AS $r)
    $voting_votes_txid[$r['address']] = $r['p1'];

foreach ($voting_votes_txid AS $miner => $vote_txid)
    $voting_result[$vote_txid]++; 

foreach ($voting['options'] AS $r)
    echo '<li>'.$r['p4'].' ('.($voting_result[$r['txid']]?$voting_result[$r['txid']]:0).')</li>';
?>
</ul>



</fieldset>




</div>