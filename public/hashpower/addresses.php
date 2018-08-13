<?php


$share_total = sql("SELECT SUM(share) AS share FROM addresses")[0]['share'];

$data = sql("SELECT address, COUNT(DISTINCT height) AS blocks, SUM(share) AS share, SUM(hashpower) AS hashpower FROM addresses GROUP BY address ORDER BY share DESC");

foreach ($data AS $key => $value) {
    $data[$key]['share'] = num(($value['share']*100)/$share_total, 4).'%';
    $data[$key]['hashpower'] = hashpower_humans($value['hashpower']);
}





echo html_table($data, array(
        'blocks'    => array('align' => 'right'),
        'share'     => array('align' => 'right'),
        'hashpower' => array('align' => 'right'),
    ));
    
    
    
    
    
$template['tabs'] = array(
        '/hashpower/blocks'     => _('Blocks'),
        '/hashpower/addresses'  => _('Addresses'),
        '/hashpower/miners'     => _('Miners'),
    );
