


<ul class="menu vertical">

	<li id="menu-comu"<?=($txt_menu=='comu'?' class="menu-sel"':'')?>><a href="/chat"><?=_('Communication')?></a>
		<ul>
			<li><a href="/chats"><?=_('Chats')?></a></li>
			<li><a href="/forum"><b><?=_('Forum')?></b></a>
				<ul>
					<li><a href="/forum/last-activity"><?=_('Last activity')?></a>
				</ul>
			</li>
			<li><a href="/msg"><?=_('Private messages')?></a></li>
			<li><a href="/api">API</a></li>
		</ul>
	</li>


	<li id="menu-info"<?=($txt_menu=='info'?' class="menu-sel"':'')?>><a href="/info/miners"><?=_('Information')?></a>
		<ul>
			<li><a href="/info/censo"><?=_('Census')?><span class="md"><?=num($pol['config']['info_censo'])?></span></a></li>
			<li><a href="/doc"><b><?=_('Documents')?></b><span class="md"><?=$pol['config']['info_documentos']?></span></a></li>
			<li><a href="/statistics"><?=_('Statistics')?></a></li>
		</ul>
	</li>


	<li id="menu-demo"<?=($txt_menu=='demo'?' class="menu-sel"':'')?>><a href="/votacion"><?=_('Hashcracy')?></a>
		<ul>
			<li><a href="/votacion"><b><?=_('Voting')?></b><span class="md"><?=$pol['config']['info_consultas']?></span></a></li>
			<li><a href="/jobs"><?=_('Jobs')?></a>
				<ul>
					<li><a href="/teams"><?=_('Teams')?></a></li>
					<li><a href="/examinations"><?=_('Examinations')?></a></li>
				</ul>
			</li>
			<li><a href="/control/panel"><?=_('Panel')?></a>
				<ul>
					<li><a href="/control/panel/config"><?=_('Config')?></a></li>
					<li><a href="/control/panel/notify"><?=_('Notifications')?></a></li>
					<li><a href="/control/panel/forum"><?=_('Forum config')?></a></li>
				</ul>
			</li>
		</ul>
	</li>


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