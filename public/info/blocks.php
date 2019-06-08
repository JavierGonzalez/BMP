<?php # BMP

$_template['title'] = 'Blocks';


$data = sql("SELECT height, hash,
    (SELECT COUNT(*) FROM miners WHERE height = blocks.height) AS miners,
    (SELECT COUNT(*) FROM actions WHERE height = blocks.height) AS actions, 
    pool, tx_count, time, 1 AS minutes, hashpower
    FROM blocks 
    ORDER BY height DESC");


foreach ($data AS $key => $value) {

    if ($value['actions'])
        $data[$key]['actions']  = html_b($value['actions']);

    if (!$time_last)
        $time_last = date("Y-m-d H:i:s");

    $duration = strtotime($time_last) - strtotime($value['time']);
    $data[$key]['minutes'] = num($duration/60,0);
    $time_last = $value['time'];

    $data[$key]['tx_count']  = num($value['tx_count']);

    $data[$key]['hashpower'] = hashpower_humans($value['hashpower']);
    $data[$key]['hash']      = substr($value['hash'],0,24).'..';

}


echo html_table($data, array(
        'miners'        => array('align'     => 'right'),
        'actions'       => array('align'     => 'right'),
        'hash'          => array('monospace' => true),
        'tx_count'      => array('align'     => 'right', 'th' => 'TX'),
        'minutes'       => array('align'     => 'right'),
    ));
