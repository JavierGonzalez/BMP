<?php # BMP

$_['html']['title'] = 'Blocks';

$data = sql("SELECT blockchain, height, hash, hashpower FROM blocks ORDER BY height DESC");


foreach ($data AS $key => $value) {
    $data[$key]['hashpower'] = hashpower_humans($value['hashpower']);
}


echo html_table($data);

