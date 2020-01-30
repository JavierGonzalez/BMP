<?php # BMP — Javier González González


function menu_active($url) {
    if (strpos($_SERVER['REQUEST_URI'], $url) !== false OR ($url=='/chat' AND $_SERVER['REQUEST_URI']=='/'))
        return ' style="background:#FFFFBB;"';
}

?>


<a href="/" style="font-size:40px;margin-left:45px;">BMP</a>


<ul class="menu vertical">

    <li<?=menu_active('/chat')?>>
        <a href="/">Chat
        <span class="md"><?=num(sql_key_value('cache_chat_num'))?></span>
        </a>
    </li>

    <li<?=menu_active('/voting')?>>
        <a href="/voting">Voting</a>
    </li>
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

<span style="float:left;writing-mode:vertical-lr;-webkit-transform:rotate(180deg);color:red;font-size:20px;">
<?=(DEV?'DEVELOPMENT':'')?>
</span>

<p>
    <a<?=menu_active('/stats')?> href="/stats">Stats</a></br >
    <a<?=menu_active('/protocol')?> href="/protocol">Protocol</a><br />
    <a href="https://github.com/JavierGonzalez/BMP" target="_blank" class="external">Code</a></br >
    <a href="https://github.com/JavierGonzalez/BMP#the-bitcoin-mining-parliament" target="_blank" class="external">README</a><br />
</p>


<div style="position:fixed;bottom:20px;">
    <?=implode('<br />', __profiler($__['crono_start']))?>
</div>

</div>

