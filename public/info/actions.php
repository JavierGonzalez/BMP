<?php # BMP

$_template['title'] = 'Actions';



$data = sql("
    SELECT txid, height, time, address, action, p1, p2, p3, p4, p5, p6, op_return
    FROM actions  
    ORDER BY time DESC");

foreach ($data AS $key => $value) {
    $data[$key]['txid']    = substr($value['txid'],0,10).'..';
    $data[$key]['address'] = substr($value['address'],0,10).'..';
}




echo html_table($data, array(
        'blocks'    => array('align' => 'right'),
        'power'     => array('align' => 'right'),
        'hashpower' => array('align' => 'right'),
    ));
    
    

