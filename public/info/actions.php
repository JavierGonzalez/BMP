<?php # BMP

$_template['title'] = 'Actions';

echo html_h($_template['title'], 2);


$blocks_num = sql("SELECT COUNT(*) AS ECHO FROM blocks");

$data = sql("SELECT id, height, txid, time, address, action, action_id AS aid, p1, p2, p3, p4, power, hashpower
    FROM actions  
    ORDER BY time DESC");


foreach ($data AS $key => $value) {
    $data[$key]['txid']      = html_a('/info/action/'.$value['txid'],   substr($value['txid'],0,10).'..');
    $data[$key]['address']   = html_a('/info/miner/'.$value['address'], substr($value['address'],-10,10));
    
    $data[$key]['power']     = num($value['power'], POWER_PRECISION).'%';
    $data[$key]['hashpower'] = hashpower_humans($value['hashpower']/$blocks_num);
}


echo html_table($data, array(
        'txid'      => array('monospace' => true),
        'blocks'    => array('align' => 'right'),
        'address'   => array('monospace' => true, 'th' => 'Miner'),
        'power'     => array('align' => 'right'),
        'hashpower' => array('align' => 'right'),
    ));
    
