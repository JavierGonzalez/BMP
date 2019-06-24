<?php # BMP — Javier González González

$_template['title'] = 'Voting';
$_template['top_right'] .= '<a href="/voting/create" class="btn btn-primary">Create new voting</a>';



$votings = sql("SELECT txid FROM actions WHERE action = 'voting' ORDER BY height DESC, time DESC");

foreach ($votings AS $r)
    if ($voting = action_voting_info($r['txid']))
        $table[] = array(
                'time'          => date('Y-m-d', strtotime($voting['time'])),
                //'height'        => $voting['height'],
                'height_finish' => $voting['height_finish'],
                'voting'        => html_a('/voting/'.$voting['txid'], html_b($voting['question'])),
                'votes'         => $voting['votes_num'],
                'power'         => $voting['power'],
            );


$config = array(
        'votes'    => array('align' => 'right', 'num' => 0),
        'power'    => array('align' => 'right', 'num' => POWER_PRECISION, 'after' => '%'),
    );


?>

<h1>Voting</h1>


<div style="font-size:18px;line-height:30px;">

<?=html_table($table, $config)?>

</div>