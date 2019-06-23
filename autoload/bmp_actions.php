<?php # BMP — Javier González González



function update_actions() {

    // miner_parameter nick
    foreach (sql("SELECT address, p2 AS nick FROM actions WHERE action = 'miner_parameter' AND p1 = 'nick' ORDER BY time ASC") AS $r)
        sql_update('miners', array('nick' => $r['nick']), "address = '".$r['address']."'");

}


function action_parameters_pretty($action) {
    global $bmp_protocol;

    foreach ((array)$bmp_protocol['actions'][$action['action_id']] AS $key => $value)
        if (is_numeric($key))
            if (isset($action['p'.$key]))
                $parameters[$value['name']] = $action['p'.$key];
    
    return $parameters;
}






function action_voting_info($txid) {

    $voting = sql("SELECT txid, height, time, address, 
    p1 AS type_voting, p2 AS type_vote, p3 AS parameters_num, p4 AS blocks_to_finish, p5 AS question 
    FROM actions WHERE txid = '".e($txid)."' AND action = 'voting' LIMIT 1")[0];

    $voting['height_finish'] = $voting['height'] + $voting['blocks_to_finish'];

    $voting['points'] = array();

    $voting['options'][$txid] = array(
            'option'    => 'NULL',
            'votes'     => 0,
            'power'     => 0,
            'hashpower'     => 0,
        );
    
    $voting['votes_num'] = 0;
    $voting['power'] = 0;
    $voting['hashpower'] = 0;

    $voting['validity'] = array(
            'valid'     => 0,
            'not_valid' => 0,    
        );

    foreach (sql("SELECT txid, p2 AS type, p4 AS text FROM actions 
        WHERE action = 'voting_parameter' AND p1 = '".e($txid)."' ORDER BY height ASC, p3 ASC, time ASC") AS $r) {
        $parameters_num++;

        if ($r['type']==1)
            $voting['points'][] = $r['text'];

        if ($r['type']==2)
            $voting['options'][$r['txid']] = array(
                    'option'    => $r['text'],
                    'votes'     => 0,
                    'power'     => 0,
                    'hashpower' => 0,
                );
        
    }


    if ($parameters_num != $voting['parameters_num'])
        return false;



    foreach ($voting['options'] AS $option_txid => $r)
        $options_votes[] = $option_txid;

    
    $blocks_num = sql("SELECT COUNT(*) AS ECHO FROM blocks");

    $result = sql("SELECT txid, address, p1 AS option_txid, p2 AS voting_validity, 
                    (SELECT SUM(power) FROM miners WHERE address = actions.address) AS power,
                    (SELECT SUM(hashpower) FROM miners WHERE address = actions.address) AS hashpower
                    FROM actions 
                    WHERE action = 'vote' 
                    AND p1 IN ('".implode("','", $options_votes)."')
                    AND height IS NOT NULL
                    AND height <= ".$voting['height_finish']."
                    ORDER BY height ASC, time ASC");

    // One vote per miner, replace by last.
    foreach ($result AS $r)
        $voting['votes'][$r['address']] = $r;

    foreach ($voting['votes'] AS $miner => $vote) {
        $voting['votes_num']++;
        $voting['power'] += $vote['power'];
        $voting['hashpower'] += $vote['hashpower'];

        $voting['validity'][($vote['voting_validity']==='1'?'valid':'not_valid')]++;

        $voting['options'][$vote['option_txid']]['votes']++;
        $voting['options'][$vote['option_txid']]['power'] += $vote['power'];
        $voting['options'][$vote['option_txid']]['hashpower'] += $vote['hashpower']/$blocks_num;
    }


    return $voting;
}








