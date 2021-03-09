<?php # BMP — Javier González González

$maxsim['template']['title'] = 'Miners';

echo html_h($maxsim['template']['title'], 1);


$data = sql("SELECT COUNT(DISTINCT height) AS blocks, 
    address AS miner, 
    SUM(power) AS power, 
    SUM(hashpower) AS hashpower,
    0 AS pools,
    (SELECT COUNT(*) FROM actions WHERE address = miners.address) AS actions,
    (SELECT time FROM actions WHERE address = miners.address ORDER BY time DESC LIMIT 1) AS last
    FROM miners 
    GROUP BY address 
    ORDER BY power DESC");

foreach ($data AS $key => $value) {

    if (!$value['actions'])
        $data[$key]['actions'] = '';

    $data[$key]['miner'] = html_a('/info/miner/'.$value['miner'], $value['miner']);

    if ($value['actions'] > 0)
        $data[$key]['miner'] = html_b($data[$key]['miner']);

    $data[$key]['power']     = '<span title="'.$value['power'].'%">'.num($value['power'], POWER_PRECISION).'%</span>';
    $data[$key]['hashpower'] = hashpower_humans($value['hashpower']);


    $pools_miner = [];
    $pools = sql("SELECT SUM(power) AS power,
    (SELECT pool FROM blocks WHERE height = miners.height) AS pool,
    (SELECT pool_link FROM blocks WHERE height = miners.height) AS pool_link
    FROM miners 
    WHERE address = '".$value['miner']."'
    GROUP BY pool
    ORDER BY power DESC");

    foreach ($pools AS $key2 => $value2) {
        if (!$value2['pool'])
            continue;

        if ($value2['pool_link'])
            $value2['pool'] = '<a href="'.$value2['pool'].'" target="_blank">'.$value2['pool'].'</a>';
        $pools_miner[] = '<span title="'.num($value2['power'], POWER_PRECISION).'%">'.$value2['pool'].'</span>';
    }

    $data[$key]['pools'] = implode(', ', $pools_miner);

}


echo html_table($data, [
    0           => ['align' => 'right',  'th' => '&nbsp;'],
    'miner'     => ['monospace' => true],
    'blocks'    => ['align' => 'right'],
    'power'     => ['align' => 'right', 'monospace' => true],
    'hashpower' => ['align' => 'right'],
    'actions'   => ['align' => 'right'],
    ]);
