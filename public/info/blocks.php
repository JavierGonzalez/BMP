<?php # BMP — Javier González González

$__template['title'] = 'Blocks';

echo html_h($__template['title'], 1);


$data = sql("SELECT blockchain, height, hash,
    (SELECT COUNT(*) FROM miners WHERE height = blocks.height) AS miners,
    (SELECT COUNT(*) FROM actions WHERE height = blocks.height) AS actions, 
    pool, tx_count, time, hashpower, power_by
    FROM blocks 
    ORDER BY time DESC, height DESC");


foreach ($data AS $key => $value) {

    if ($value['actions'])
        $data[$key]['actions']  = html_b($value['actions']);

    $data[$key]['tx_count']  = num($value['tx_count']);

    $data[$key]['hashpower'] = hashpower_humans($value['hashpower']);
    $data[$key]['hash']      = substr($value['hash'],0,24);

}


echo html_table($data, array(
        'miners'        => array('align'     => 'right'),
        'actions'       => array('align'     => 'right'),
        'hash'          => array('monospace' => true),
        'tx_count'      => array('align'     => 'right', 'th' => 'TX'),
        'hashpower'     => array('align'     => 'right'),
    ));
