<?php # BMP — Javier González González


$maxsim['template']['title'] = 'Protocol';

foreach (BMP_PROTOCOL['actions'] AS $action_id => $action) {

    $td = [
        'status'        => $action['status'],
        //'tested'        => $action['tested']?html_b('x'):'',
        'coinbase'      => $action['coinbase']?html_b('x'):'',
        'action'        => $action['action'],
        'bmp'           => BMP_PROTOCOL['prefix'],
        'id'            => $action_id,
        ];

    
    for ($i=1;$i<=5;$i++)
        $td['p'.$i] = ($action[$i]?$action[$i]['name'].'['.$action[$i]['size'].']':'');
    
    
    if ($txid_action_random = sql("SELECT txid AS ECHO FROM actions WHERE action = '".$action['action']."' ORDER BY RAND() LIMIT 1")) {
        $actions_num = sql("SELECT COUNT(*) AS ECHO FROM actions WHERE action = '".$action['action']."'");
        $td['example'] = html_a('/info/action/'.$txid_action_random, 'Example ('.$actions_num.')');
    }
    
    $table[] = $td;
}

$table[0]['id']  = '';
$table[0]['bmp'] = '';


$config = [
    'th_background_color' => '#FFFFDD',
    'num'       => ['align' => 'right'],
    'status'    => ['capital' => true, 'monospace' => true, 'tr_background_color' => ['implemented' => '#ffeead']],
    'tested'    => ['align' => 'center'],
    'coinbase'  => ['align' => 'center'],
    'bmp'       => ['th' => 'BMP'],
    'id'        => ['th' => 'ID'],
    ];

foreach (BLOCKCHAINS AS $blockchain => $value)
    $config[$blockchain] = ['align' => 'center'];

?>

<h1>BMP Protocol</h1>

<ul>
    <li>Power percentage is calculated with the last <?=num(BLOCK_WINDOW)?> blocks of BTC, BCH and BSV.</li>
    <li>Miners power is calculated proportionally with coinbase output addresses.</li>
    <li>Actions (transactions) without hashpower are ignored.</li>
    <li>Miners power changes with each block.</li>
    <li>Actions power never changes.</li>
    <li>BMP code obeys hashpower.</li>
</ul>


<?=html_table($table, $config)?>


<br /><br />

<ul>
    <li>More detailed specification <a href="https://github.com/JavierGonzalez/BMP/blob/master/*bmp/bmp_protocol.php" target="_blank"><b>in code</b></a>.</li>
    <li>In development... Changes will occur.</li>
    <li>BMP <?=BMP_VERSION?></li>
</ul>
