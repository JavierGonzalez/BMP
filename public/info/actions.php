<?php # BMP — Javier González González

$__template['title'] = 'Actions';

echo html_h($__template['title'], 1);


$data = sql("SELECT blockchain, height, txid, time, address, power, hashpower, action, action_id AS aid, p1, p2, p3, p4, p5
    FROM actions  
    ORDER BY time DESC");


foreach ($data AS $key => $value) {
    $data[$key]['txid']      = html_a('/info/action/'.$value['txid'],   substr($value['txid'],0,10));
    $data[$key]['address']   = html_a('/info/miner/'.$value['address'], substr($value['address'],-10,10));
    
    $data[$key]['power']     = num($value['power'], POWER_PRECISION).'%';
    $data[$key]['hashpower'] = hashpower_humans($value['hashpower']);
}


echo html_table($data, [
    'txid'      => ['monospace' => true],
    'blocks'    => ['align' => 'right'],
    'address'   => ['monospace' => true, 'th' => 'Miner'],
    'power'     => ['align' => 'right'],
    'hashpower' => ['align' => 'right'],
    ]);
    
