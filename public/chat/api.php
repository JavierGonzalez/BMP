<?php # BMP — Javier González González


if ($_GET[2]=='refresh' AND $_GET['last']) {

	$echo['msg'] = sql("SELECT id, txid, height, time, address, nick, action, 
        p1, p2, p3, p4, ROUND(power, ".POWER_PRECISION.") AS power, hashpower
        FROM actions 
        WHERE action IN ('chat', 'miner_parameter', 'vote') AND time > '".e($_GET['last'])."'
        ORDER BY time ASC, id ASC
        LIMIT 1000");

    foreach ($echo['msg'] AS $key => $value) {
        $echo['msg'][$key]['hashpower'] = hashpower_humans($value['hashpower']/BLOCK_WINDOW);

        if ($value['action']=='vote')
            if ($voting = action_voting_info($value['p1']))
                if ($voting['question'])
                    $echo['msg'][$key]['question'] = '<a href="/voting/'.$voting['txid'].'">'.$voting['question'].'</a> ('.$voting['options'][$value['p4']]['option'].')';

    }

}
