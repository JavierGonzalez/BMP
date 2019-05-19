<?php # BMP

$_template['title'] = 'Miners';

$total = sql("SELECT SUM(power) AS power, SUM(hashpower) AS hashpower FROM miners")[0];

$total_blocks = sql("SELECT COUNT(*) AS ECHO FROM blocks");


$data = sql("SELECT 0, '' AS name, address, COUNT(DISTINCT height) AS blocks, SUM(power) AS power, SUM(hashpower) AS hashpower,
(SELECT COUNT(*) FROM actions WHERE address = miners.address) AS actions,
(SELECT time FROM actions WHERE address = miners.address ORDER BY time DESC LIMIT 1) AS last_action 
FROM miners 
GROUP BY address 
ORDER BY power DESC");

foreach ($data AS $key => $value) {
    $data[$key][0] = ++$count;
    
    $data[$key]['power'] = num(($value['hashpower']*100)/$total['hashpower'], 8).'%';
    
    $data[$key]['hashpower'] = hashpower_humans($value['hashpower']/$total_blocks,6);
}

echo sql_error();




echo html_table($data, array(
        0           => array('align' => 'right', 'th' => ''),
        'address'   => array('monospace' => true, 'th'=>'Miner'),
        'blocks'    => array('align' => 'right'),
        'power'     => array('align' => 'right'),
        'hashpower' => array('align' => 'right'),
        'actions'   => array('align' => 'right'),
    ));