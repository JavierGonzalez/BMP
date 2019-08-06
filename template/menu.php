
<?php


function menu_active($url) {
    if (strpos($_SERVER['REQUEST_URI'], $url) !== false)
        return ' style="background:#FFFFBB;"';
}



?>


<a href="/" style="font-size:40px;margin-left:45px;">BMP</a>


<ul class="menu vertical">

    <li<?=menu_active('/chat')?>>
        <a href="/">Chat</a>
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
    <a href="https://github.com/JavierGonzalez/BMP#the-bitcoin-mining-parliament" target="_blank">README</a><br />
    <a<?=menu_active('/protocol')?> href="/protocol">Protocol</a><br />
    <a href="https://github.com/JavierGonzalez/BMP" target="_blank">Code</a><br />
</p>

<br /><br />

<?php


if ($blocks_num = sql("SELECT COUNT(*) AS ECHO FROM blocks"))
    if ($blocks_num!=BLOCK_WINDOW)
        echo 'Updating...<div class="progress">
            <div class="progress-bar" role="progressbar" style="width: '.round(($blocks_num*100)/BLOCK_WINDOW,2).'%" aria-valuenow="'.round(($blocks_num*100)/BLOCK_WINDOW,2).'" aria-valuemin="0" aria-valuemax="100"></div>
            </div>'.num($blocks_num).'&nbsp;blocks of '.BLOCK_WINDOW.'<br /><br />';



echo '<div style="position:absolute;bottom:16px;">'.num((hrtime(true)-$_['crono'])/100000).' ms &nbsp; '.ram().'</div>';

echo '</div>';