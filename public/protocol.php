<?php # BMP — Javier González González

$_template['title'] = 'Protocol';


foreach ($bmp_protocol['actions'] AS $action_id => $action) {

    $td = array(
            'status'        => $action['status'],
            'coinbase'      => ($action['coinbase']?html_b('x'):''),
            'action'        => $action['action'],

            'BMP'           => $bmp_protocol['prefix'],
            'ID'            => $action_id,
        );

    
    for ($i=1;$i<=5;$i++)
        $td['p'.$i] = ($action[$i]?$action[$i]['name'].'['.$action[$i]['size'].']':'');
            
    if ($txid_action_random = sql("SELECT txid AS ECHO FROM actions WHERE action = '".$action['action']."' ORDER BY RAND() LIMIT 1"))
        $td['example'] = html_a('/info/action/'.$txid_action_random, 'Example');
    

    $table[] = $td;
}

$table[0]['ID']  = '';
$table[0]['BMP'] = '';


$config = array(
        'th_background-color' => '#FFFFDD',
        
        'status'    => array('capital' => true, 'monospace' => true),
        'coinbase'  => array('align' => 'center'),
    );


?>

<h1>Protocol</h1>

<ul>
    <li>Power percentage is calculated with SHA-256 hashpower with last <?=num(BLOCK_WINDOW)?> BCH blocks.</li>
    <li>Miners power is calculated proportionally with coinbase output addresses.</li>
    <li>Actions -transactions- without hashpower are ignored.</li>
    <li>Miners power changes with each block.</li>
    <li>Actions power never changes.</li>
    <li>Code obeys hashpower.</li>
</ul>


<?=html_table($table, $config)?>


<br /><br />

<em>* In ALPHA development. Changes will occur.</em><br />
<em>* Code specs in <a href="https://github.com/JavierGonzalez/BMP/blob/master/autoload/bmp_protocol.php" target="_blank">code here</a>.</em>

