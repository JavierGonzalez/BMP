<?php # BMP

$_template['title'] = 'Voting';

$_template['top_right'] .= '<a href="/voting/create" class="btn btn-primary">Create new voting</a>';


echo html_h($_template['title'], 1);




$blocks_num = sql("SELECT COUNT(*) AS ECHO FROM blocks");


$data = sql("SELECT txid, p5,
    (SELECT COUNT(*) FROM actions WHERE action = 'vote' AND p1 = a.txid) AS votes,
    (SELECT COUNT(*) FROM actions WHERE action = 'voting_parameter' AND p2 = 2 AND  p1 = a.txid) AS options
    FROM actions AS a
    WHERE action = 'voting' AND p5 != ''
    ORDER BY time DESC");


foreach ($data AS $key => $value) {

    $table[] = array(
            'voting'  => html_a('/voting/'.$value['txid'], html_b($value['p5'])),
            'options' => $value['options'],
            'votes'   => $value['votes'],
        );
}


echo html_table($table, array(
        'votes'   => array('align' => 'right'),
        'options'   => array('align' => 'right'),
        'power'     => array('align' => 'right', 'monospace' => true),
        'hashpower' => array('align' => 'right'),
    ));
