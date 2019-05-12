<?php # BMP


$total = sql("SELECT SUM(share) AS share, SUM(hashpower) AS hashpower FROM addresses")[0];

$data = sql("SELECT address, COUNT(DISTINCT height) AS blocks, SUM(share) AS share, SUM(hashpower) AS hashpower FROM addresses GROUP BY address ORDER BY share DESC");

foreach ($data AS $key => $value) {
    $data[$key]['share'] = num(($value['hashpower']*100)/$total['hashpower'], 10).'%';
    
    $data[$key]['hashpower'] = hashpower_humans($value['hashpower']/2016,6);
}




echo html_table($data, array(
        'blocks'    => array('align' => 'right'),
        'share'     => array('align' => 'right'),
        'hashpower' => array('align' => 'right'),
    ));
    
    
    
    
    
$_['template']['html']['tabs'] = array(
        '/hashpower/blocks'     => _('Blocks'),
        '/hashpower/addresses'  => _('Addresses'),
        '/hashpower/miners'     => _('Miners'),
    );


