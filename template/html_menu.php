<?php # simple_framework


?>
<ul class="menu vertical">

	<li id="menu-comu"<?=($txt_menu=='comu'?' class="menu-sel"':'')?>><a href="/"><?=_('Chat')?></a>
		<ul>
			<li><a href="/chats"><?=_('Chats')?></a></li>
			<li><a href="/forum"><b><?=_('Forum')?></b></a>
				<ul>
					<li><a href="/forum/last-activity"><?=_('Last activity')?></a>
					<?=(isset($pol['user_ID'])?'<li><a href="/forum/my">'._('For you').'</a></li>':'')?>
				</ul>
			</li>
			<li><a href="/msg"><?=_('Private messages')?></a></li>
			<li><a href="/api">API</a></li>
		</ul>
	</li>

	<li id="menu-info"<?=($txt_menu=='info'?' class="menu-sel"':'')?>><a href="/"><?=_('Information')?></a>
		<ul>
			<li><a href="/info/censo"><?=_('Census')?><span class="md"><?=num($pol['config']['info_censo'])?></span></a></li>
			<li><a href="/doc"><b><?=_('Documents')?></b><span class="md"><?=$pol['config']['info_documentos']?></span></a></li>
			<li><a href="/statistics"><?=_('Statistics')?></a></li>
		</ul>
	</li>

	<li id="menu-demo"<?=($txt_menu=='demo'?' class="menu-sel"':'')?>><a href="/votacion"><?=_('Hashpower')?></a>
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



<div id="menu-next"><br /><br />

Last block: <?=block_height_last()?> <br />
Blocks: <?=sql("SELECT COUNT(*) AS num FROM blocks")[0]['num']?> <br />
Addresses: <?=sql("SELECT COUNT(*) AS num FROM addresses")[0]['num']?> <br />
TX: <?=sql("SELECT COUNT(*) AS num FROM tx")[0]['num']?> <br />

</div>