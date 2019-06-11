<?php # BMP

$_template['title'] = 'Protocol';


$bmp_protocol['prefix'] = '9d';


foreach ($bmp_protocol['actions'] AS $action_id => $action) {

    $td = array(
            'status'        => $action['status'],
            'coinbase'      => ($action['coinbase']?html_b('x'):''),
            'action'        => $action['action'],
            //'name'        => $action['name'],

            'BMP'           => $bmp_protocol['prefix'],
            'ID'            => $action_id,
        );

    
    for ($i=1;$i<=4;$i++)
        $td['p'.$i] = ($action[$i]?$action[$i]['name'].'['.$action[$i]['size'].']':'');
            
    if ($txid_action_random = sql("SELECT txid AS ECHO FROM actions WHERE action = '".$action['action']."' ORDER BY RAND() LIMIT 1"))
        $td['example'] = html_a('/info/action/'.$txid_action_random, 'Example');

    $table[] = $td;
}

$table[0]['BMP'] = '';



$config = array(
        'th_background-color' => '#FFFF99',

        'status'    => array('capital' => true),
        'coinbase'  => array('align' => 'center'),
    );



?>

<br />

<h2>BMP Protocol</h2>

<ul>
    <li>Power percentage is calculated with SHA-256 hashpower with last <?=num(BLOCK_WINDOW)?> BCH blocks.</li>
    <li>Miners power is calculated proportionally with coinbase output addresses.</li>
    <li>Transactions (actions) without hashpower are ignored.</li>
    <li>Miners power changes with each block.</li>
    <li>Actions power never changes.</li>
    <li>Code obeys hashpower.</li>
</ul>

<?=html_table($table, $config)?>
