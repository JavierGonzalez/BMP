<?php # BMP

$_template['title'] = 'Actions';



$data = sql("SELECT height, txid, time, address, action, p1, p2, p3, p4, p5, p6, power, hashpower
    FROM actions  
    ORDER BY time DESC");


foreach ($data AS $key => $value) {
    $data[$key]['txid']    = substr($value['txid'],0,10).'..';
    $data[$key]['address'] = '..'.substr($value['address'],-10,10);
}


echo html_table($data, array(
        'txid'      => array('monospace' => true),
        'blocks'    => array('align' => 'right'),
        'address'   => array('monospace' => true, 'th' => 'Miner'),
        'power'     => array('align' => 'right'),
        'hashpower' => array('align' => 'right'),
    ));
    
