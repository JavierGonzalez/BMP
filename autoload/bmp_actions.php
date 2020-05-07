<?php # BMP — Javier González González



function update_actions($blockchain, $height) {

    foreach (sql("SELECT blockchain, txid FROM actions WHERE action = 'voting' AND json IS NULL AND blockchain = '".$blockchain."' ORDER BY time ASC") AS $r)
        action_voting_info($r['txid'], $r['blockchain']);

    // Cache miner_parameter nick
    foreach (sql("SELECT address, p2 AS nick FROM actions WHERE action = 'miner_parameter' AND p1 = 'nick' AND blockchain = '".$blockchain."' AND height = '".$height."' ORDER BY time ASC") AS $r)
        sql_update('miners', ['nick' => $r['nick']], "address = '".$r['address']."'");

    // Cache menu
    $hashpower_total = sql("SELECT SUM(hashpower) AS ECHO FROM blocks");
    if (is_numeric($hashpower_total))
        sql_key_value('cache_blocks_num',  round($hashpower_total/BLOCK_WINDOW));
    sql_key_value('cache_miners_num',  sql("SELECT COUNT(DISTINCT address) AS ECHO FROM miners"));
    sql_key_value('cache_actions_num', sql("SELECT COUNT(*) AS ECHO FROM actions"));
    sql_key_value('cache_chat_num', sql("SELECT COUNT(DISTINCT address) AS ECHO FROM actions WHERE action = 'chat'"));

}


function action_voting_info($txid, $blockchain=false) { // Refact

    $voting = sql("SELECT blockchain, txid, height, time, address, json,
        p1 AS type_voting, 
        p2 AS type_vote, 
        p3 AS parameters_num, 
        p4 AS blocks_to_finish, 
        p5 AS question 
        FROM actions WHERE action = 'voting' AND txid = '".e($txid)."' LIMIT 1")[0];

    if (!$voting)
        return false;

    if ($voting['json']) {
        $cached = true;
        $voting = json_decode($voting['json'], true);

    } else {
        unset($voting['json']);

        $voting['height_finish'] = $voting['height'] + $voting['blocks_to_finish'];
        
        $last_height = sql("SELECT height FROM blocks WHERE blockchain = '".$voting['blockchain']."' ORDER BY height DESC LIMIT 1")[0]['height'];
        
        $voting['status'] = ($voting['height_finish']>=$last_height || !$voting['height']?'open':'close');
        
        if ($voting['status']=='open')
            $voting['close_in'] = $voting['height_finish']-$last_height;

        $voting['points'] = [];

        $voting['options'][] = [
            'blockchain'=> $voting['blockchain'],
            'txid'      => $txid,
            'vote'      => '0',
            'option'    => 'NULL',
            'votes'     => 0,
            'power'     => 0,
            'hashpower' => 0,
            ];
        


        foreach (sql("SELECT blockchain, (SUM(hashpower)/".BLOCK_WINDOW.") AS hashpower FROM miners GROUP BY 1 ORDER BY 2 DESC") AS $r)
            $voting['hashpower_blockchain'][$r['blockchain']] = $r['hashpower'];


        foreach (sql("SELECT blockchain, txid, p2 AS type, p3, p4 AS text 
            FROM actions WHERE action = 'voting_parameter' AND p1 = '".e($txid)."' 
            ORDER BY p2 ASC, p3 ASC") AS $r) {
            
            $parameters_num++;

            if ($r['type']==0)
                $voting['points'][] = $r;

            if ($r['type']==1)
                $voting['options'][$r['p3']] = [
                    'blockchain' => $r['blockchain'],
                    'txid'       => $r['txid'],
                    'vote'       => $r['p3'],
                    'option'     => $r['text'],
                    'votes'      => 0,
                    'power'      => 0,
                    'hashpower'  => 0,
                    ];
            
            if ($r['type']==2)
                return false;
        }


        if ($parameters_num != $voting['parameters_num'])
            return false;


        $result = sql("SELECT blockchain, height, txid, time, address, p2 AS type_vote, p3 AS voting_validity, p4 AS vote,
                        ((SELECT SUM(hashpower) FROM miners WHERE address = actions.address)/".BLOCK_WINDOW.") AS hashpower
                        FROM actions 
                        WHERE action = 'vote' 
                        AND p1 = '".e($txid)."'
                        AND (height <= ".$voting['height_finish'].($voting['status']=='open'?' OR height IS NULL':'').")
                        ORDER BY ".($voting['status']=='close'?'height ASC, ':'')."time ASC");

        // One vote per miner, replace by last height. // FIX ambiguity when last TX is in the same block.
        foreach ($result AS $r)
            $voting['votes'][$r['address']] = $r;


        if ($voting['status']=='close')
            sql_update('actions', ['json' => json_encode($voting)], "json IS NULL AND txid = '".$txid."' LIMIT 1");
    }



    ///////////////////////////////////////////////////////////////////////////
    // Calculated on-the-fly

    // Counters and percentages (total or by blockchain)
    $voting['votes_num'] = 0;
    $voting['votes_power'] = 0;
    $voting['votes_hashpower'] = 0;
    $voting['validity'] = [
        'valid'     => 0,
        'not_valid' => 0,    
        ];

    if ($blockchain)
        $total_hashpower = $voting['hashpower_blockchain'][$blockchain];
    else
        foreach (BLOCKCHAINS AS $blockchain_ticker => $value)
            $total_hashpower += $voting['hashpower_blockchain'][$blockchain_ticker];
    

    foreach ($voting['votes'] AS $miner => $vote)
        $voting['votes'][$miner]['power'] = round(($voting['votes'][$miner]['hashpower']/BLOCK_WINDOW*100)/$total_hashpower, POWER_PRECISION);


    foreach ((array)$voting['votes'] AS $miner => $vote) {
        if (!$blockchain OR $blockchain==$vote['blockchain']) {
            $voting['votes_num']++;

            $voting['validity'][($vote['voting_validity']==='1'?'valid':'not_valid')] += $vote['power'];

            $voting['options'][$vote['vote']]['votes']++;
            $voting['options'][$vote['vote']]['power']      += round($vote['power'], POWER_PRECISION);
            $voting['options'][$vote['vote']]['hashpower']  += $vote['hashpower']/BLOCK_WINDOW;

            $voting['votes_power']        += $vote['power'];
            $voting['votes_hashpower']    += $vote['hashpower'];
        }
    }



    return $voting;
}




function action_parameters_pretty($action) {

    foreach (BMP_PROTOCOL['actions'][$action['action_id']] AS $key => $value)
        if (is_numeric($key))
            if (isset($action['p'.$key]))
                $parameters[$value['name']] = $action['p'.$key];
    
    return $parameters;
}
