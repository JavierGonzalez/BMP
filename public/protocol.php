<?php # BMP — Javier González González


$__template['title'] = 'Protocol';

foreach (BMP_PROTOCOL['actions'] AS $action_id => $action) {

    $td = array(
            'status'        => $action['status'],
            'coinbase'      => ($action['coinbase']?html_b('x'):''),
            
            'BTC'           => ($action['coinbase']?html_b('x'):''),
            'BCH'           => ($action['status']=='implemented'?html_b('x'):''),
            'BSV'           => ($action['coinbase']?html_b('x'):''),
            
            'action'        => $action['action'],

            'BMP'           => BMP_PROTOCOL['prefix'],
            'ID'            => $action_id,
        );

    
    for ($i=1;$i<=5;$i++)
        $td['p'.$i] = ($action[$i]?$action[$i]['name'].'['.$action[$i]['size'].']':'');
    
    
    if ($txid_action_random = sql("SELECT txid AS ECHO FROM actions WHERE action = '".$action['action']."' ORDER BY RAND() LIMIT 1")) {
        $actions_num = sql("SELECT COUNT(*) AS ECHO FROM actions WHERE action = '".$action['action']."'");
        $td['example'] = html_a('/info/action/'.$txid_action_random, 'Example ('.$actions_num.')');
    }
    
    $table[] = $td;
}

$table[0]['ID']  = '';
$table[0]['BMP'] = '';


$config = array(
        'th_background-color' => '#FFFFDD',
        'num'       => array('align' => 'right'),
        'status'    => array('capital' => true, 'monospace' => true),
        'coinbase'  => array('align' => 'center'),
    );

foreach (BLOCKCHAINS AS $blockchain)
    $config[$blockchain] = array('align' => 'center');


?>

<h1>Protocol</h1>

<ul>
    <li>Power percentage is calculated with all Bitcoin SHA-256 hashpower in last 2016 blocks.</li>
    <li>Miners power is calculated proportionally with coinbase output addresses.</li>
    <li>Actions -transactions- without hashpower are ignored.</li>
    <li>Miners power changes with each block.</li>
    <li>Actions power never changes.</li>
    <li>Code obeys hashpower.</li>
</ul>


<?=html_table($table, $config)?>


<br /><br />

<em>* In BETA development. Changes will occur.</em><br />
<em>* More specs in code <a href="https://github.com/JavierGonzalez/BMP/blob/master/autoload/bmp_protocol.php" target="_blank"><b>here</b></a>.</em>

<br /><br />
