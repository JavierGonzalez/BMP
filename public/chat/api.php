<?php # BMP — Javier González González


$_['template']['output'] = 'api';


if ($_GET[2]=='refresh' AND $_GET['last']) {

	$echo['msg'] = sql("SELECT id, txid, height, time, address, nick, action, p1, p2, p3,
        ROUND(power, ".POWER_PRECISION.") AS power, hashpower
        FROM actions 
        WHERE action IN ('chat', 'miner_parameter', 'vote') AND time > '".e($_GET['last'])."'
        ORDER BY time ASC, id ASC
        LIMIT 1000");


    foreach ($echo['msg'] AS $key => $value) {
        $echo['msg'][$key]['hashpower'] = hashpower_humans($value['hashpower']/BLOCK_WINDOW);


        if ($value['action']=='vote')
            if ($question = sql("SELECT p5 AS ECHO FROM actions WHERE action = 'voting' AND txid = '".$value['p1']."' LIMIT 1"))
                $echo['msg'][$key]['question'] = $question;


    }









}