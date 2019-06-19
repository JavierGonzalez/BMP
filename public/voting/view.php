<?php # BMP — Javier González González


$txid = $_GET[1];


$voting = sql("SELECT * FROM actions WHERE txid = '".e($txid)."' AND action = 'voting'  LIMIT 1")[0];
$voting['p'] = action_parameters_pretty($voting);



?>


<div style="width:700px;">


<h1>Voting</h1>


<fieldset>
<legend style="font-size:22px;font-weight:bold;"><?=$voting['p']['question']?></legend>

<ol>
<?php
foreach (sql("SELECT p4 FROM actions WHERE p1 = '".e($txid)."' AND action = 'voting_parameter' AND p2 = 1 ORDER BY p3 ASC") AS $r)
    echo '<li>'.html_h($r['p4'], 3).'</li>';
?>
</ol>

</fieldset>







<fieldset>
<legend>Vote</legend>


<form>
<p>
<select name="voto" style="font-size:20px;white-space:normal;max-width:400px;">
    <option value="0" selected="selected">NULL</option>
    <option value="1">Yes</option>
    <option value="2">No</option>
</select> 
</p>

<p>
<input id="validez_true" type="radio" name="validez" value="true" class="radio"> 
<label for="validez_true">Voting valid.</label><br />

<input id="validez_false" type="radio" name="validez" value="false" class="radio"> 
<label for="validez_false">Voting not valid.</label>
</p>



<p><button class="btn btn-primary disabled">Vote</button></p> 

<p><input type="text" name="mensaje" value="" size="60" maxlength="60" placeholder="Optional comment..."></p>

</form>



</fieldset>






<fieldset>
<legend>Result</legend>

<ul>
<?php
foreach (sql("SELECT p4 FROM actions WHERE p1 = '".e($txid)."' AND action = 'voting_parameter' AND p2 = 2 ORDER BY p3 ASC") AS $r)
    echo '<li>'.$r['p4'].'</li>';
?>
</ul>



</fieldset>




</div>