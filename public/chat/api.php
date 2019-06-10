<?php # BMP


$_['template']['output'] = 'api';

if ($_GET[2]=='refresh' AND $_GET['last'])
	$echo['msg'] = sql("SELECT id, txid, height, time, address, nick, action, p1, p2, p3,
        ROUND(power, ".POWER_PRECISION.") AS power 
        FROM actions 
        WHERE action IN ('chat', 'miner_parameter') AND time > '".e($_GET['last'])."'
        ORDER BY time ASC, id ASC");
