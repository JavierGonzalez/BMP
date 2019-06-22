
<?php


function menu_active($url) {
    if (strpos($_SERVER['REQUEST_URI'], $url) !== false)
        return ' style="background:#FFFFBB;"';
}



?>


<a href="/" style="font-size:40px;margin-left:45px;">BMP</a>


<ul class="menu vertical">

    <li<?=menu_active('/chat')?>>
        <a href="/chat">Chat</a>
    </li>

    <li<?=menu_active('/voting')?>>
        <a href="/voting">Voting</a>
    </li>

</ul>


<ul class="menu vertical" style="background:#F7F7F7;">

	<li<?=menu_active('/info/blocks')?>>
        <a href="/info/blocks">Blocks
        <span class="md"><?=num(sql("SELECT height AS ECHO FROM blocks ORDER BY height DESC LIMIT 1"))?></span>
        </a>
    </li>
	
    <li<?=menu_active('/info/miners')?>>
        <a href="/info/miners">Miners
        <span class="md"><?=num(sql("SELECT COUNT(DISTINCT address) AS ECHO FROM miners"))?></span>
        </a>
    </li>
    
    <li<?=menu_active('/info/actions')?>>
        <a href="/info/actions">Actions
        <span class="md"><?=num(sql("SELECT COUNT(*) AS ECHO FROM actions"))?></span>
        </a>
    </li>

</ul>




<div id="menu-next">

<p>
    <a<?=menu_active('/protocol')?> href="/protocol">Protocol</a><br />
    <a href="https://github.com/JavierGonzalez/BMP#the-bitcoin-mining-parliament" target="_blank">README</a><br />
    <a href="https://github.com/JavierGonzalez/BMP" target="_blank">Code</a><br />
</p>

<br /><br />

<?php

if (DEBUG) {

	$blocks = sql("SELECT COUNT(*) AS num, SUM(hashpower) AS hashpower FROM blocks")[0];
	if ($blocks['num']>0)
        echo hashpower_humans(($blocks['hashpower'] / $blocks['num']), 0).'<br />';
/*
    echo round(100-sql("SELECT ROUND(SUM(miners.power), ".POWER_PRECISION.") AS ECHO FROM miners 
        LEFT JOIN actions ON actions.address = miners.address WHERE actions.id IS NULL"), POWER_PRECISION).'% HP';
*/
    
	echo num(memory_get_usage()/1000).' kb &nbsp;'.num((microtime(true)-$_['crono_start'])*1000).' ms<br />';

    
}

echo '</div>';