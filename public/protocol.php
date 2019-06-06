<?php # BMP

$_template['title'] = 'Protocol';

echo html_h('BMP Protocol', 2);

foreach ($bmp_protocol['actions'] AS $action_id => $action) {

    $table[] = array(
            'status'        => $action['status'],
            'coinbase'      => ($action['coinbase']?html_b('x'):''),
            'action'        => $action['action'],
            'name'          => $action['name'],
            'description'   => $action['description'],

            'BMP'           => $bmp_protocol['prefix'],
            'ACTION'        => $action_id,
        );

    $table[0]['BMP']    = '';
    $table[0]['ACTION'] = '';
    
    $params = array();

}


$config = array(
        'coinbase'    => array('align' => 'center'),
    );

echo html_table($table, $config);

print_r2($bmp_protocol);
