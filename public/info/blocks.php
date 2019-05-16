<?php # BMP

$_['html']['title'] = 'Blocks';

$data = sql("SELECT height, address, power, hashpower FROM miners ORDER BY height DESC, power DESC");

foreach ($data AS $key => $value) {
    $data[$key]['power'] = num($value['power'], 4).'%';
    $data[$key]['hashpower'] = hashpower_humans($value['hashpower']);
}


echo html_table($data);
