<?php # BMP



$data = sql("SELECT height, address, share, hashpower FROM addresses ORDER BY height DESC, share DESC");

foreach ($data AS $key => $value) {
    $data[$key]['share'] = num($value['share'], 4).'%';
    $data[$key]['hashpower'] = hashpower_humans($value['hashpower']);
}


echo html_table($data);
