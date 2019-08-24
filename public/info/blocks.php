<?php # BMP — Javier González González

$__template['title'] = 'Blocks';

echo html_h($__template['title'], 1);


$data = sql("SELECT blockchain, height, hash,
    (SELECT COUNT(*) FROM miners  WHERE height = blocks.height) AS miners,
    (SELECT COUNT(*) FROM actions WHERE height = blocks.height) AS actions, 
    pool, tx_count, time, hashpower, power_by
    FROM blocks 
    ORDER BY time DESC, height DESC");


foreach ($data AS $key => $value) {
    
    if ($value['actions'])
        $data[$key]['actions']  = html_b($value['actions']);

    $data[$key]['tx_count']  = num($value['tx_count']);

    $data[$key]['hashpower'] = hashpower_humans($value['hashpower']);
    $data[$key]['hash']      = substr($value['hash'],0,26);

}

foreach (BLOCKCHAINS AS $blockchain => $value)
    $blockchain_colors[$blockchain] = $value['background_color'];

echo html_table($data, [
    'blockchain'    => ['tr_background_color' => $blockchain_colors],
    'miners'        => ['align'     => 'right'],
    'actions'       => ['align'     => 'right'],
    'hash'          => ['monospace' => true],
    'tx_count'      => ['align'     => 'right', 'th' => 'TX'],
    'hashpower'     => ['align'     => 'right'],
    ]);
