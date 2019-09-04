<?php # BMP — Javier González González

$__template['title'] = 'Miners';

echo html_h($__template['title'], 1);


$data = sql("SELECT COUNT(DISTINCT height) AS blocks, 
    address AS miner, 
    nick, 
    SUM(power) AS power, 
    SUM(hashpower) AS hashpower,
    (SELECT COUNT(*) FROM actions WHERE address = miners.address) AS actions,
    (SELECT time FROM actions WHERE address = miners.address ORDER BY time DESC LIMIT 1) AS last_action
    FROM miners 
    GROUP BY address 
    ORDER BY power DESC");
    // (SELECT pool FROM blocks WHERE blockchain = miners.blockchain AND height = miners.height) AS pools

foreach ($data AS $key => $value) {

    $data[$key]['miner'] = html_a('/info/miner/'.$value['miner'], ($value['nick']?$value['nick']:$value['miner']));
    unset($data[$key]['nick']);

    if ($value['actions'] > 0)
        $data[$key]['miner'] = html_b($data[$key]['miner']);

    $data[$key]['power']     = '<span title="'.$value['power'].'%">'.num($value['power'], POWER_PRECISION).'%</span>';
    $data[$key]['hashpower'] = hashpower_humans($value['hashpower']/BLOCK_WINDOW);
}


echo html_table($data, [
    0           => ['align' => 'right',  'th' => '&nbsp;'],
    'miner'     => ['monospace' => true],
    'blocks'    => ['align' => 'right'],
    'power'     => ['align' => 'right', 'monospace' => true],
    'hashpower' => ['align' => 'right'],
    'actions'   => ['align' => 'right'],
    ]);
