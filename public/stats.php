<?php # BMP — Javier González González

$__template['title'] = 'Stats';

$__template['css'] .= '#hashpower_stats tr:hover td { background-color: #00FF00 !important; }';


echo html_h($__template['title'], 1);


if ($_GET['coinbase_hex'])
    $sql_where[] = "coinbase LIKE '%".e($_GET['coinbase_hex'])."%'";


foreach (BLOCKCHAINS AS $blockchain => $config) {

    $last_block = sql("SELECT * FROM blocks WHERE blockchain = '".$blockchain."' ORDER BY height DESC LIMIT 1")[0];

    $last_height = rpc_get_best_height($blockchain);

    $blocks_ahead = $last_height-$last_block['height'];

    $data[] = [
        'blockchain'    => $blockchain,
        'sync'          => ($blocks_ahead?num($blocks_ahead):'✔'),
        'SQL'           => $last_block['height'],
        'RPC'           => $last_height,
        'time'          => $last_block['time'],
        'mempool'       => rpc_get_mempool_info($blockchain)['size'],
        'peers'         => count((array)rpc_get_peer_info($blockchain)),
        'uptime'        => num(rpc_uptime($blockchain)/60/60).' h',
        'version'    => rpc_get_network_info($blockchain)['subversion'],
        ];


    $miners = sql("SELECT COUNT(DISTINCT address) AS miners, SUM(power) AS power, SUM(hashpower) AS hashpower
            FROM miners WHERE blockchain = '".$blockchain."'")[0];

    $blockchain_hp[$blockchain] = [
        'power'         => '<span title="'.$miners['power'].'%">'.num($miners['power'], 2).'%</span>',
        'hashpower'     => hashpower_humans_phs($miners['hashpower']/BLOCK_WINDOW),
        ];

    $total_hashpower += $miners['hashpower'];
    $blockchain_colors[$blockchain] = $config['background_color'];
}
    

$config = [
    'blockchain'    => ['th' => '', 'tr_background_color' => $blockchain_colors],
    ''              => ['align' => 'right',  'th' => '&nbsp;'],
    'sync'          => ['align' => 'right'],
    'mempool'       => ['align' => 'right', 'function' => 'num'],
    'peers'         => ['align' => 'right', 'function' => 'num'],
    'uptime'        => ['align' => 'right'],
    'time'          => ['th' => 'Block time'],
    ];


echo html_table($data, $config);






foreach (BLOCKCHAINS AS $blockchain => $config)
    $select_artisan[] = "0 AS power_".$blockchain.", (SUM(IF(blockchain='".$blockchain."',hashpower,0))/".BLOCK_WINDOW.") AS hashpower_".$blockchain;

$data2 = sql("SELECT pool, pool_link, 0 AS power, 
    (SUM(hashpower)/".BLOCK_WINDOW.") AS hashpower, ".implode(',', $select_artisan)." 
    FROM blocks ".($sql_where?"WHERE ".implode(" AND ", $sql_where):"")." 
    GROUP BY pool 
    ORDER BY hashpower DESC");


foreach ($data2 AS $id => $r) {

    if (!$r['pool'])
        $data2[$id]['pool'] = '<em>Unknown</em>';

    if ($r['pool_link'])
        $data2[$id]['pool'] = '<a href="'.$r['pool_link'].'" target="_blank">'.$r['pool'].'</a>';
    unset($data2[$id]['pool_link']);

    foreach ($r AS $key => $value)
        if (substr($key,0,9)=='hashpower')
            $total[$key] += $value;

}


foreach ($data2 AS $id => $r)
    foreach ($r AS $key => $value)
        if (substr($key,0,5)=='power' AND $key_hashpower = str_replace('power', 'hashpower', $key))
            $data2[$id][$key] = ($data2[$id][$key_hashpower]>0?num(($data2[$id][$key_hashpower]*100)/$total[$key_hashpower],2).'%':'');



foreach ($blockchain_hp AS $blockchain => $value) {
    $th_extra_name[]  = '<th colspan=2 style="text-align:center;background-color:'.$blockchain_colors[$blockchain].';">'.$blockchain.'</th>';
    $th_extra_total[] = '<th style="text-align:right;font-weight:normal;border-bottom:none;background-color:'.$blockchain_colors[$blockchain].';">'.$value['power'].'</th><th style="text-align:right;font-weight:normal;border-bottom:none;background-color:'.$blockchain_colors[$blockchain].';">'.$value['hashpower'].'</th>';
}


$config = [
    'id' => 'hashpower_stats',
    'tr_th_extra' => '
        <tr><th></th><th colspan=2 style="text-align:center;">Bitcoin</th>'.implode('', $th_extra_name).'</tr>
        <tr><th style="border-bottom:none;font-weight:normal;">'.date('Y-m-d').'</th><th style="text-align:right;font-weight:normal;border-bottom:none;">100.00%</th><th style="text-align:right;font-weight:normal;border-bottom:none;">'.hashpower_humans_phs($total_hashpower/BLOCK_WINDOW).'</th>'.implode('', $th_extra_total).'</tr>
        ',
    'power'     => ['align' => 'right'],
    'hashpower' => ['align' => 'right', 'function' => 'hashpower_humans_phs', 'th' => 'Hashpower'],
    ];

foreach (BLOCKCHAINS AS $blockchain => $value) {
    $config[    'power_'.$blockchain] = ['th' => 'Power', 'align' => 'right', 'background_color' => $value['background_color'] ];
    $config['hashpower_'.$blockchain] = ['th' => 'Hashpower', 'align' => 'right', 'function' => 'hashpower_humans_phs', 'background_color' => $value['background_color'] ];
}



echo '<br />';

echo html_table($data2, $config);

echo '<br /><br />';