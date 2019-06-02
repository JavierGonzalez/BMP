<?php # BMP

$_template['title'] = 'Blocks';


$data = sql("SELECT height, hash, hashpower,
    (SELECT COUNT(*) FROM miners WHERE height = blocks.height) AS miners, 
    pool, tx_count, time 
    FROM blocks 
    ORDER BY height DESC");


foreach ($data AS $key => $value) {
    $data[$key]['hashpower'] = hashpower_humans($value['hashpower']);
    $data[$key]['hash']      = substr($value['hash'],0,24).'..';
    $data[$key]['tx_count']  = num($value['tx_count']);
    
    $duration = strtotime($time_last) - strtotime($value['time']);
    $data[$key]['min'] = ($key!==0?num($duration/60,0):'');
    $time_last = $value['time'];
}


echo html_table($data, array(
        'miners'        => array('align'     => 'right'),
        'hash'          => array('monospace' => true),
        'tx_count'      => array('align'     => 'right', 'th' => 'TX'),
        'min'           => array('align'     => 'right'),
    ));
