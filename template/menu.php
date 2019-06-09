


<ul class="menu vertical">

	<li id="menu-communications"><a href="/chat">Chat</a></li>

	<li id="menu-info"><a href="/info/miners">Miners</a></li>
    
    <li id="menu-info"><a href="/info/actions">Actions</a></li>
	
    <li id="menu-hashcracy"><a href="/voting">Voting</a></li>

	<li id="menu-hashcracy"><a href="/protocol">Protocol</a></li>

</ul>



<div id="menu-next" style="color:#999;padding-top:60px;">

<?php

if (DEBUG) {

	echo 'Height: '.sql("SELECT height AS ECHO FROM blocks ORDER BY height DESC LIMIT 1");
    echo '<br />';

	$blocks = sql("SELECT COUNT(*) AS num, SUM(hashpower) AS hashpower FROM blocks")[0];
	if ($blocks['num']>0)
        echo hashpower_humans(($blocks['hashpower'] / $blocks['num'])).'<br />';
        
    echo sql("SELECT ROUND(SUM(power), ".POWER_PRECISION.") AS ECHO FROM miners").'%<br />';

    echo sql("SELECT ROUND(SUM(miners.power), ".POWER_PRECISION.") AS ECHO FROM miners 
            LEFT OUTER JOIN actions ON actions.address = miners.address WHERE actions.id IS NOT NULL GROUP BY miners.address").'%<br />';
	
	echo '<br />';

	echo 'Blocks:  '.sql("SELECT COUNT(*) AS ECHO FROM blocks").'<br />';
	echo 'Miners:  '.sql("SELECT COUNT(DISTINCT address) AS ECHO FROM miners").'<br />';
	echo 'Actions: '.sql("SELECT COUNT(*) AS ECHO FROM actions").'<br />';
	
	echo '<br />';
	
	echo num((microtime(true)-$_['crono_start'])*1000).' ms &nbsp; ';
    echo num(memory_get_usage()/1000).' kb<br />';
}

?>

<span id="msg_error" style="color:red;font-size:10px;"></span>

</div>