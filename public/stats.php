<?php # BMP — Javier González González

$__template['title'] = 'Stats';

echo html_h($__template['title'], 1);



foreach (BLOCKCHAINS AS $blockchain) {

    $last_block = sql("SELECT * FROM blocks WHERE blockchain = '".$blockchain."' ORDER BY height DESC LIMIT 1")[0];

    $last_height = rpc_get_best_height($blockchain);

    $miners = sql("SELECT COUNT(DISTINCT address) AS miners, SUM(power) AS power, SUM(hashpower) AS hashpower
            FROM miners WHERE blockchain = '".$blockchain."'")[0];

    $blocks_ahead = $last_height-$last_block['height'];

    $data[] = array(
            'blockchain'    => $blockchain,
            'sync'          => ($blocks_ahead?num($blocks_ahead):'✔'),
            'height BMP'    => $last_block['height'],
            'height RPC'    => $last_height,
            'time'          => $last_block['time'],
            'miners'        => $miners['miners'],
            'power'         => '<span title="'.$miners['power'].'%">'.num($miners['power'], POWER_PRECISION).'%</span>',
            'hashpower'     => hashpower_humans($miners['hashpower']/BLOCK_WINDOW),
        );

    $total_miners += $miners['miners'];
    $total_hashpower += $miners['hashpower'];
}

$data[] = array(
            'blockchain'    => '',
            'sync'          => '',
            'height BMP'    => '',
            'height RPC'    => '',
            'time'          => '',
            'miners'        => '<b>'.$total_miners.'</b>',
            'power'         => '<b>100%</b>',
            'hashpower'     => '<b>'.hashpower_humans($total_hashpower/BLOCK_WINDOW).'</b>',
        );



$config = array(
        ''          => array('align' => 'right',  'th' => '&nbsp;'),
        'sync'      => array('align' => 'right'),
        'miners'    => array('align' => 'right'),
        'power'     => array('align' => 'right', 'monospace' => true),
        'hashpower' => array('align' => 'right'),
    );


echo html_table($data, $config);






foreach (BLOCKCHAINS AS $blockchain)
    $select_artisan[] = "0 AS power_".$blockchain.", (SUM(IF(blockchain='".$blockchain."',hashpower,0))/".BLOCK_WINDOW.") AS hashpower_".$blockchain;

$data = sql("SELECT pool, 0 AS power, (SUM(hashpower)/".BLOCK_WINDOW.") AS hashpower, ".implode(',', $select_artisan)." FROM blocks GROUP BY pool ORDER BY hashpower DESC");


foreach ($data AS $r)
    foreach ($r AS $key => $value)
        if (substr($key,0,9)=='hashpower')
            $total[$key] += $value;

foreach ($data AS $id => $r)
    foreach ($r AS $key => $value)
        if (substr($key,0,5)=='power' AND $key_hashpower = str_replace('power', 'hashpower', $key))
            $data[$id][$key] = ($data[$id][$key_hashpower]>0?num(($data[$id][$key_hashpower]*100)/$total[$key_hashpower],2).'%':'');



$config = array(
        'tr_th_extra' => '<tr><th></th><th colspan=2 style="text-align:center;">Bitcoin</th><th colspan=2 style="text-align:center;">'.implode('</th><th colspan=2 style="text-align:center;">', BLOCKCHAINS).'</th></tr>',
        'power'     => array('align' => 'right'),
        'hashpower' => array('align' => 'right', 'function' => 'hashpower_humans_phs', 'th' => 'Hashpower'),
    );

foreach (BLOCKCHAINS AS $blockchain) {
    $config[    'power_'.$blockchain] = array('th' => 'Power', 'align' => 'right');
    $config['hashpower_'.$blockchain] = array('th' => 'Hashpower', 'align' => 'right', 'function' => 'hashpower_humans_phs');
}

echo html_table($data, $config);
