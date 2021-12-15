<?php # BMP — Javier González González

$maxsim['template']['title'] = 'Blocks';

echo html_h($maxsim['template']['title'], 1);


if ($_GET['coinbase_hex'])
    $sql_where[] = "coinbase LIKE '%".e($_GET['coinbase_hex'])."%'";

if ($_GET['blockchain'])
    $sql_where[] = "blockchain = '".e($_GET['blockchain'])."'";

if ($_GET['pool'])
    $sql_where[] = "pool = '".e($_GET['pool'])."'";

if ($_GET['unknown'])
    $sql_where[] = "pool IS NULL";

if ($_GET['address'] AND $_GET['address']!='true')
    $sql_where[] = "1=1 HAVING address = '".e($_GET['address'])."'";


$data = sql("SELECT blockchain, height, LEFT(hash, 26) AS hash, pool, pool_link, tx_count, time, power_by, 0 AS miners,
    (SELECT COUNT(*) FROM actions WHERE blockchain = blocks.blockchain AND height = blocks.height) AS actions 
    ".($_GET['address']?", (SELECT address FROM miners WHERE blockchain = blocks.blockchain AND height = blocks.height ORDER BY hashpower DESC LIMIT 1) AS address":"")
    .($_GET['coinbase']?", coinbase":"")."
    FROM blocks ".($sql_where?"WHERE ".implode(" AND ", $sql_where):"")."
    ORDER BY height DESC");


foreach ($data AS $key => $value) {
    
    $data[$key]['miners'] = sql("SELECT COUNT(*) AS num FROM miners WHERE blockchain = '".$value['blockchain']."' AND height = '".$value['height']."'")[0]['num'];

    if ($value['actions'])
        $data[$key]['actions']  = html_b($value['actions']);

    $data[$key]['tx_count']  = num($value['tx_count']);

    if ($value['pool_link'])
        $data[$key]['pool'] = '<a href="'.$value['pool_link'].'" target="_blank">'.$value['pool'].'</a>';
    unset($data[$key]['pool_link']);

    if ($_GET['coinbase'])
        $data[$key]['coinbase']  = hex2bin_print($value['coinbase']);

    unset($data[$key]['blockchain']);
}

foreach (BLOCKCHAINS AS $blockchain => $value)
    $blockchain_colors[$blockchain] = $value['background_color'];

echo html_table($data, [
    'miners'        => ['align'     => 'right'],
    'actions'       => ['align'     => 'right'],
    'hash'          => ['monospace' => true],
    'tx_count'      => ['align'     => 'right', 'th' => 'TX'],
    ]);

