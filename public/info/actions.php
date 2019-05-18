<?php # BMP

$_['html']['title'] = 'Actions';


// WHERE op_return LIKE '6a026d01%'
$data = sql("SELECT * 
FROM actions  
ORDER BY time DESC
LIMIT 500"); // 

foreach ($data AS $key => $value) {
    $data[$key]['op_return_bin'] = hex2bin(substr($value['op_return'], 10));
}




echo html_table($data, array(
        'blocks'    => array('align' => 'right'),
        'power'     => array('align' => 'right'),
        'hashpower' => array('align' => 'right'),
    ));
    
    

