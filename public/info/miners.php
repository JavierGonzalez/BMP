<?php # BMP

$_['html']['title'] = 'Miners';

$total = sql("SELECT SUM(power) AS power, SUM(hashpower) AS hashpower FROM miners")[0];

$total_blocks = sql("SELECT COUNT(*) AS num FROM blocks")[0]['num'];

$data = sql("SELECT address, COUNT(DISTINCT height) AS blocks, SUM(power) AS power, SUM(hashpower) AS hashpower FROM miners GROUP BY address ORDER BY power DESC");

foreach ($data AS $key => $value) {
    $data[$key]['power'] = num(($value['hashpower']*100)/$total['hashpower'], 10).'%';
    
    $data[$key]['hashpower'] = hashpower_humans($value['hashpower']/$total_blocks);
}




echo html_table($data, array(
        'blocks'    => array('align' => 'right'),
        'power'     => array('align' => 'right'),
        'hashpower' => array('align' => 'right'),
    ));
    
    
    
    
    
$_['html']['tabs'] = array(
        '/info/blocks'     => _('Blocks'),
        '/info/miners'     => _('Miners'),
        '/info/actions'    => _('Actions'),
    );


