<?php # BMP

$_template['title'] = 'Miners';


$blocks_num = sql("SELECT COUNT(*) AS ECHO FROM blocks");


$data = sql("SELECT 0, 
    COUNT(DISTINCT height) AS blocks, 
    address AS miner, 
    '' AS name, 
    SUM(power) AS power, 
    SUM(hashpower) AS hashpower,
    (SELECT COUNT(*) FROM actions WHERE address = miners.address) AS actions,
    (SELECT time FROM actions WHERE address = miners.address ORDER BY time DESC LIMIT 1) AS last_action,
    txid
    FROM miners 
    GROUP BY address 
    ORDER BY power DESC");


foreach ($data AS $key => $value) {
    $data[$key][0] = ++$count;
    $data[$key]['power']     = num($value['power'], POWER_PRECISION).'%';
    $data[$key]['hashpower'] = hashpower_humans($value['hashpower']/$blocks_num, 6);

    $data[$key]['evidence'] = html_a('/evidence/miner/'.$value['txid'], 'Evidence');
    unset($data[$key]['txid']);
}


echo html_table($data, array(
        0           => array('align' => 'right',  'th' => '&nbsp;'),
        'miner'     => array('monospace' => true),
        'blocks'    => array('align' => 'right'),
        'power'     => array('align' => 'right', 'monospace' => true),
        'hashpower' => array('align' => 'right', 'monospace' => true),
        'actions'   => array('align' => 'right'),
    ));
