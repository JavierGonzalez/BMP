<?php # BMP — Javier González González

$__template['title'] = 'Voting';



$votings = sql("SELECT txid FROM actions WHERE action = 'voting' ORDER BY height DESC, time DESC");

foreach ($votings AS $r)
    if ($voting = action_voting($r['txid'], $_GET['blockchain']))
        $table[$voting['status']][] = [
            'status'        => ucfirst($voting['status']),
            'voting'        => html_a('/voting/'.$voting['txid'], html_b($voting['question'])),
            'power'         => $voting['votes_power'],
            'hashpower'     => $voting['votes_hashpower'],
            'valid?'        => '<span title="'.num($voting['validity'], POWER_PRECISION).'%">'.($voting['validity']>50?'Yes!':'No').'</span>',
            'votes'         => $voting['votes_num'],
            'time'          => date('Y-m-d', strtotime($voting['time'])),
            'height_closed' => $voting['height_closed'],
            ];


$config = [
    'votes'     => ['num' => 0],
    'power'     => ['align' => 'right', 'num' => POWER_PRECISION, 'after' => '%'],
    'hashpower' => ['align' => 'right', 'function' => 'hashpower_humans'],
    ];


?>

<h1>Voting</h1>


<div style="font-size:20px;line-height:30px;">

<?php
echo html_table($table['open'],  $config);
echo html_table($table['closed'], $config);
?>

</div>

<br /><br /><br />

<a href="/voting/create" class="btn btn-primary">Create new voting</a>