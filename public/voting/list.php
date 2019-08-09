<?php # BMP — Javier González González

$__template['title'] = 'Voting';



$votings = sql("SELECT txid FROM actions WHERE action = 'voting' ORDER BY height DESC, time DESC");

foreach ($votings AS $r)
    if ($voting = action_voting_info($r['txid']))
        $table[$voting['status']][] = array(
                'status'        => ucfirst($voting['status']),
                
                'time'          => date('Y-m-d', strtotime($voting['time'])),
                'height_finish' => $voting['height_finish'],
                'voting'        => html_a('/voting/'.$voting['txid'], html_b($voting['question'])),
                'votes'         => $voting['votes_num'],
                'power'         => $voting['power'],
                'validity'      => $voting['validity']['valid'],
            );


$config = array(
        'votes'    => array('align' => 'right', 'num' => 0),
        'power'    => array('align' => 'right', 'num' => POWER_PRECISION, 'after' => '%'),
        'validity' => array('align' => 'right', 'num' => POWER_PRECISION, 'after' => '%'),
    );


?>

<h1>Voting</h1>


<div style="font-size:20px;line-height:30px;">

<?=html_table($table['open'], $config)?>

<?=html_table($table['close'], $config)?>

</div>

<br /><br /><br />

<a href="/voting/create" class="btn btn-primary">Create new voting</a>