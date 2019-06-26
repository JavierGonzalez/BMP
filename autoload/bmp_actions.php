<?php # BMP — Javier González González



function update_actions() {

    // miner_parameter nick
    foreach (sql("SELECT address, p2 AS nick FROM actions WHERE action = 'miner_parameter' AND p1 = 'nick' ORDER BY time ASC") AS $r)
        sql_update('miners', array('nick' => $r['nick']), "address = '".$r['address']."'");

}


function action_voting_info($txid) { // Refact

    $voting = sql("SELECT txid, height, time, address, 
    p1 AS type_voting, p2 AS type_vote, p3 AS parameters_num, p4 AS blocks_to_finish, p5 AS question 
    FROM actions WHERE txid = '".e($txid)."' AND action = 'voting' LIMIT 1")[0];

    $voting['height_finish'] = $voting['height'] + $voting['blocks_to_finish'];
    
    $last_height = sql("SELECT height FROM blocks ORDER BY height DESC LIMIT 1")[0]['height'];
    
    $voting['status'] = ($voting['height_finish']>=$last_height?'open':'close');
    
    if ($voting['status']=='open')
        $voting['close_in'] = $voting['height_finish']-$last_height;

    $voting['points'] = array();

    $voting['options'][] = array(
            'txid'      => $txid,
            'vote'      => '0',
            'option'    => 'NULL',
            'votes'     => 0,
            'power'     => 0,
            'hashpower' => 0,
        );
    
    $voting['votes_num'] = 0;
    $voting['power'] = 0;
    $voting['hashpower'] = 0;

    $voting['validity'] = array(
            'valid'     => 0,
            'not_valid' => 0,    
        );

    foreach (sql("SELECT txid, p2 AS type, p3, p4 AS text 
        FROM actions WHERE action = 'voting_parameter' AND p1 = '".e($txid)."' 
        ORDER BY p2 ASC, p3 ASC") AS $r) {
        
        $parameters_num++;

        if ($r['type']==0)
            $voting['points'][] = $r['text'];

        if ($r['type']==1)
            $voting['options'][$r['p3']] = array(
                    'txid'      => $r['txid'],
                    'vote'      => $r['p3'],
                    'option'    => $r['text'],
                    'votes'     => 0,
                    'power'     => 0,
                    'hashpower' => 0,
                );
        
        if ($r['type']==2)
            return false;
    }


    if ($parameters_num != $voting['parameters_num'])
        return false;

    
    $blocks_num = sql("SELECT COUNT(*) AS ECHO FROM blocks");

    $result = sql("SELECT txid, address, p2 AS type_vote, p3 AS voting_validity, p4 AS vote,
                    (SELECT SUM(power) FROM miners WHERE address = actions.address) AS power,
                    (SELECT SUM(hashpower) FROM miners WHERE address = actions.address) AS hashpower
                    FROM actions 
                    WHERE action = 'vote' 
                    AND p1 = '".e($txid)."'
                    AND (height <= ".$voting['height_finish'].($voting['status']=='open'?' OR height IS NULL':'').")
                    ORDER BY ".($voting['status']=='close'?'height ASC, ':'')."time ASC");


    // One vote per miner, replace by last.
    foreach ($result AS $r)
        $voting['votes'][$r['address']] = $r;


    foreach ((array)$voting['votes'] AS $miner => $vote) {
        $voting['votes_num']++;
        $voting['power']        += $vote['power'];
        $voting['hashpower']    += $vote['hashpower'];

        $voting['validity'][($vote['voting_validity']==='1'?'valid':'not_valid')] += $vote['power'];

        $voting['options'][$vote['vote']]['votes']++;
        $voting['options'][$vote['vote']]['power']      += $vote['power'];
        $voting['options'][$vote['vote']]['hashpower']  += $vote['hashpower']/$blocks_num;
    }


    return $voting;
}


function action_parameters_pretty($action) {
    global $bmp_protocol;

    foreach ((array)$bmp_protocol['actions'][$action['action_id']] AS $key => $value)
        if (is_numeric($key))
            if (isset($action['p'.$key]))
                $parameters[$value['name']] = $action['p'.$key];
    
    return $parameters;
}
