<?php # BMP

$_template['title'] = 'Blocks';


$data = sql("SELECT height, hash, hashpower,
    (SELECT COUNT(*) FROM miners WHERE height = blocks.height) AS miners,
    (SELECT COUNT(*) FROM actions WHERE height = blocks.height) AS actions, 
    pool, tx_count, time 
    FROM blocks 
    ORDER BY height DESC");


foreach ($data AS $key => $value) {
    $data[$key]['hashpower'] = hashpower_humans($value['hashpower']);
    $data[$key]['hash']      = substr($value['hash'],0,24).'..';
    $data[$key]['tx_count']  = num($value['tx_count']);
    
    if (!$time_last)
        $time_last = date("Y-m-d H:i:s");

    $duration = strtotime($time_last) - strtotime($value['time']);
    $data[$key]['minutes'] = num($duration/60,0);
    $time_last = $value['time'];
}


echo html_table($data, array(
        'miners'        => array('align'     => 'right'),
        'actions'       => array('align'     => 'right'),
        'hash'          => array('monospace' => true),
        'tx_count'      => array('align'     => 'right', 'th' => 'TX'),
        'minutes'       => array('align'     => 'right'),
    ));
