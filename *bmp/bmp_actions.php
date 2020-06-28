<?php # BMP — Javier González González



function update_actions($blockchain=false, $height=false) {

    foreach (sql("SELECT txid FROM actions WHERE action = 'voting' AND json IS NULL") AS $r)
        action_voting_data($r['txid']);

    // Cache miner_parameter nick
    if ($blockchain AND $height)
        foreach (sql("SELECT address, p2 FROM actions WHERE action = 'miner_parameter' AND p1 = 'nick' AND blockchain = '".$blockchain."' AND height = '".$height."' ORDER BY time ASC") AS $r)
            sql_update('miners', ['nick' => $r['p2']], "address = '".$r['address']."'");

    // Cache menu
    $hashpower_total = sql("SELECT SUM(hashpower) AS ECHO FROM blocks");
    if (is_numeric($hashpower_total))
        sql_key_value('cache_blocks_num',  round($hashpower_total/BLOCK_WINDOW));
    sql_key_value('cache_miners_num',  sql("SELECT COUNT(DISTINCT address) AS ECHO FROM miners"));
    sql_key_value('cache_actions_num', sql("SELECT COUNT(*) AS ECHO FROM actions"));
    sql_key_value('cache_chat_num',    sql("SELECT COUNT(DISTINCT address) AS ECHO FROM actions WHERE action = 'chat'"));

}



function action_voting($txid, $blockchain=false) {

    $voting = action_voting_data($txid); // Inmutable when voting status is closed.


    if (array_key_exists((string)$blockchain, BLOCKCHAINS)) {
        $total_hashpower = $voting['hashpower_blockchain'][$blockchain];
        $voting['filter_by_blockchain'] = $blockchain;
    } else {
        $blockchain = false;
        foreach (BLOCKCHAINS AS $key => $value)
            $total_hashpower += $voting['hashpower_blockchain'][$key];
    }

    $voting['votes_num'] = count((array)$voting['votes']);
    $voting['votes_power'] = 0;
    $voting['votes_hashpower'] = 0;
    $voting['validity'] = 0;


    foreach ((array)$voting['miners'] AS $miner)
        if (!$blockchain OR $blockchain==$miner['blockchain'])
            $voting['votes'][$miner['address']]['hashpower'] += $miner['hashpower'];


    foreach ((array)$voting['votes'] AS $miner => $vote) {
        if (!$blockchain OR $blockchain==$vote['blockchain']) {
            $voting['options'][$vote['vote']]['votes']++;
            
            if ($vote['voting_validity']==='1')
                $voting['validity_hashpower'] += $vote['hashpower'];
            
            $voting['options'][$vote['vote']]['power']      += round(($vote['hashpower']*100)/$total_hashpower, POWER_PRECISION);
            $voting['options'][$vote['vote']]['hashpower']  += $vote['hashpower'];

            $voting['votes_hashpower']    += $vote['hashpower'];
        }
    }

    $voting['votes_power'] = @round(($voting['votes_hashpower']*100)/$total_hashpower, POWER_PRECISION);
    $voting['validity'] = @round(($voting['validity_hashpower']*100)/$total_hashpower, POWER_PRECISION);

    return $voting;
}



function action_voting_data($txid) { // Refact

    $voting = sql("SELECT blockchain, txid, height, time, address, json,
        p1 AS type_voting, 
        p2 AS type_vote, 
        p3 AS parameters_num, 
        p4 AS blocks_to_closed, 
        p5 AS question 
        FROM actions WHERE action = 'voting' AND txid = '".e($txid)."' LIMIT 1")[0];

    if (!$voting)
        return false;

    if ($voting['json'])
        return json_decode($voting['json'], true);


    unset($voting['json']);

    $voting['height_closed'] = $voting['height'] + $voting['blocks_to_closed'];
    
    $last_block = sql("SELECT height, time FROM blocks WHERE blockchain = '".$voting['blockchain']."' ORDER BY height DESC LIMIT 1")[0];
    
    $voting['status'] = ($voting['height_closed']>=$last_block['height'] || !$voting['height']?'open':'closed');
    
    if ($voting['status']=='open')
        $voting['closed_in'] = $voting['height_closed']-$last_block['height'];

    if ($voting['status']=='closed')
        $voting['time_closed'] = $last_block['time'];

    $voting['points'] = [];

    // Votes pointing to the txid voting are NULL/void. Option always available.
    $voting['options'][] = [
        'blockchain'=> $voting['blockchain'],
        'txid'      => $txid,
        'vote'      => '0',
        'option'    => 'NULL',
        'votes'     => 0,
        'power'     => 0,
        'hashpower' => 0,
        ];



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


    // One vote per miner, vote can be change when is open, replace by last height.
    $result = sql("SELECT blockchain, height, txid, time, address, 
                p2 AS type_vote, 
                p3 AS voting_validity, 
                p4 AS vote
                FROM actions 
                WHERE action = 'vote' 
                AND p1 = '".e($txid)."'
                AND (height <= ".$voting['height_closed'].($voting['status']=='open'?' OR height IS NULL':'').")
                ORDER BY ".($voting['status']=='closed'?'height ASC, ':'')."time ASC"); // Refact
    foreach ($result AS $r)
        $voting['votes'][$r['address']] = $r;



    foreach (sql("SELECT blockchain, SUM(hashpower) AS hashpower FROM miners GROUP BY 1 ORDER BY 2 DESC") AS $r)
        $voting['hashpower_blockchain'][$r['blockchain']] = $r['hashpower'];

    foreach (sql("SELECT blockchain, height, address, hashpower FROM miners ORDER BY id ASC") AS $r)
        if (isset($voting['votes'][$r['address']]))
            $voting['miners'][] = $r;



    if ($voting['status']=='closed')
        sql_update('actions', ['json' => json_encode($voting)], "json IS NULL AND txid = '".$txid."' LIMIT 1");
    

    return $voting;
}


function action_parameters_pretty($action) {

    foreach (BMP_PROTOCOL['actions'][$action['action_id']] AS $key => $value)
        if (is_numeric($key))
            if (isset($action['p'.$key]))
                $parameters[$value['name']] = $action['p'.$key];
    
    return $parameters;
}
