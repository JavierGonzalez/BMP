<?php # BMP — Javier González González

$maxsim['template']['title'] = 'Stats';

$maxsim['template']['css'] .= '#hashpower_stats tr:hover td { background-color: #00FF00 !important; }';


echo html_h($maxsim['template']['title'], 1);


if ($_GET['coinbase_hex'])
    $sql_where[] = "coinbase LIKE '%".e($_GET['coinbase_hex'])."%'";

if ($_GET['time'])
    $sql_where[] = "time >= '".e($_GET['time'])."'";

if (is_numeric($_GET['days']))
    $sql_where[] = "time >= '".date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s').' - '.e($_GET['days']).' days'))."'";


foreach (BLOCKCHAINS AS $blockchain => $config) {

    $last_block = sql("SELECT * FROM blocks WHERE blockchain = '".$blockchain."' ORDER BY height DESC LIMIT 1")[0];

    $last_height = rpc_get_best_height($blockchain);

    $blocks_ahead = $last_height-$last_block['height'];

    $blocks_num = sql("SELECT COUNT(*) AS num FROM blocks WHERE blockchain = '".$blockchain."'")[0]['num'];

    $data[] = [
        'blockchain'    => $blockchain,
        'sync'          => ($blocks_ahead?$blocks_ahead.' ✖':'✔'),
        'SQL'           => $last_block['height'],
        'RPC'           => ($last_height?$last_height:'✖'),
        'time'          => $last_block['time'],
        'blocks'        => $blocks_num.' '.($blocks_num != BLOCK_WINDOW?'✖':'✔'),
        'mempool'       => rpc_get_mempool_info($blockchain)['size'],
        'peers'         => count((array)rpc_get_peer_info($blockchain)),
        'uptime'        => num(rpc_uptime($blockchain)/60/60).' h',
        'version'       => rpc_get_network_info($blockchain)['subversion'],
        ];


    $miners = sql("SELECT COUNT(DISTINCT address) AS miners, SUM(power) AS power, SUM(hashpower) AS hashpower
            FROM miners WHERE blockchain = '".$blockchain."'")[0];

    $blockchain_hp[$blockchain] = [
        'power'         => '<span title="'.$miners['power'].'%">'.num($miners['power'], 2).'%</span>',
        'hashpower'     => hashpower_humans_phs($miners['hashpower']),
        ];

    $total_hashpower += $miners['hashpower'];
    $blockchain_colors[$blockchain] = $config['background_color'];
}
    

$config = [
    'blockchain'    => ['th' => '', 'tr_background_color' => $blockchain_colors],
    ''              => ['align' => 'right',  'th' => '&nbsp;'],
    'sync'          => ['align' => 'right'],
    'blocks'        => ['align' => 'right'],
    'mempool'       => ['align' => 'right', 'function' => 'num'],
    'peers'         => ['align' => 'right', 'function' => 'num'],
    'uptime'        => ['align' => 'right'],
    'time'          => ['th' => 'Block time'],
    ];


echo html_table($data, $config);






foreach (BLOCKCHAINS AS $blockchain => $config)
    $select_artisan[] = "0 AS power_".$blockchain.", SUM(IF(blockchain='".$blockchain."',hashpower/".BLOCK_WINDOW.",0)) AS hashpower_".$blockchain;

$data2 = sql("SELECT pool, pool_link, ".implode(',', $select_artisan)." 
    FROM blocks".($sql_where?" WHERE ".implode(" AND ", $sql_where):"")." 
    GROUP BY pool 
    ORDER BY hashpower_BCH DESC");


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
    $th_extra_total[] = '<th style="text-align:right;font-weight:normal;border-bottom:none;background-color:'.$blockchain_colors[$blockchain].';">'.$value['power'].'</th>
        <th style="text-align:right;font-weight:normal;border-bottom:none;background-color:'.$blockchain_colors[$blockchain].';">'.$value['hashpower'].'</th>';
}


$config = [
    'id' => 'hashpower_stats',
    'tr_th_extra' => '
        <tr><th></th>'.implode('', $th_extra_name).'</tr>
        <tr>
            <th style="border-bottom:none;font-weight:normal;">'.date('Y-m-d', strtotime($last_block['time'])).'</th>
            '.implode('', $th_extra_total).'
        </tr>
        ',
    'power'     => ['align' => 'right'],
    'hashpower' => ['align' => 'right', 'function' => 'hashpower_humans_phs', 'th' => 'Hashpower'],
    ];

foreach (BLOCKCHAINS AS $blockchain => $value) {
    $config[    'power_'.$blockchain] = ['th' => 'Power', 'align' => 'right', 'background_color' => $value['background_color'] ];
    $config['hashpower_'.$blockchain] = ['th' => 'Hashpower', 'align' => 'right', 'function' => 'hashpower_humans_phs', 'background_color' => $value['background_color'] ];
}

?>

<br />

<?=html_table($data2, $config)?>

<br /><br />

<ul>
<li>BMP protocol is not based on "<a href="/stats/pools.json">pools.json</a>" or "coinbase text" to calculate the miners hashpower.</li>
<li>This information is for aditional info and research purposes only.</li>
<li>BMP block window is the last <?=BLOCK_WINDOW?> blocks.</li>
</ul>

<br />