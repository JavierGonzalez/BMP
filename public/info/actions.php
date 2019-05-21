<?php # BMP

$_template['title'] = 'Actions';



$data = sql("
SELECT * 
FROM actions  
ORDER BY time DESC
");

foreach ($data AS $key => $value) {
    $data[$key]['op_return_decode'] = hex2bin(substr($value['op_return'], 10));
}




echo html_table($data, array(
        'blocks'    => array('align' => 'right'),
        'power'     => array('align' => 'right'),
        'hashpower' => array('align' => 'right'),
    ));
    
    

