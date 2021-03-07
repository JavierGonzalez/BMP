<?php # BMP — Javier González González


function menu_active($url) {
    if (strpos($_SERVER['REQUEST_URI'], $url) !== false OR ($url=='/chat' AND $_SERVER['REQUEST_URI']=='/'))
        return ' style="background:#FFFFBB;"';
}

?>

<div style="background:#eee;">
    <a href="/" title="BMP - The Bitcoin Mining Parliament">
        <img src="/static/logos/main_200.png" width="200" height="200" alt="BMP - The Bitcoin Mining Parliament" style="margin:5px;" />
    </a>
</div>


<ul class="menu vertical">

    <li<?=menu_active('/chat')?>>
        <a href="/">Chat
        <span class="md"><?=num(sql_key_value('cache_chat_num'))?></span>
        </a>
    </li>

    <li<?=menu_active('/voting')?>>
        <a href="/voting">Voting</a>
    </li>

    <!--
    <li<?=menu_active('/delegation')?>>
        <a href="/delegation">Delegation</a>
    </li>
    -->
    
</ul>


<ul class="menu vertical" style="background:#F7F7F7;">

	<li<?=menu_active('/info/blocks')?>>
        <a href="/info/blocks">Blocks
        <span class="md"><?=hashpower_humans(sql_key_value('cache_blocks_num'), 'E')?></span>
        </a>
    </li>
	
    <li<?=menu_active('/info/miners')?>>
        <a href="/info/miners">Miners
        <span class="md"><?=num(sql_key_value('cache_miners_num'))?></span>
        </a>
    </li>
    
    <li<?=menu_active('/info/actions')?>>
        <a href="/info/actions">Actions
        <span class="md"><?=num(sql_key_value('cache_actions_num'))?></span>
        </a>
    </li>

</ul>




<div id="menu-next">

    <?=(passwords['dev']?'<span style="float:left;writing-mode:vertical-lr;-webkit-transform:rotate(180deg);color:red;font-size:30px;">DEVELOPMENT</span>':'')?>

    <p>
        <a<?=menu_active('/protocol')?> href="/protocol">Protocol</a><br />
        <a<?=menu_active('/stats')?> href="/stats">Stats</a></br >
        <br />
        <a<?=($_SERVER['REQUEST_URI']=='/README'?' style="background:#FFFFBB;"':'')?> href="/README">How it works?</a><br />
        <a<?=menu_active('/README/CN')?> href="/README/CN">它是如何工作的?</a><br />
    </p>

</div>


