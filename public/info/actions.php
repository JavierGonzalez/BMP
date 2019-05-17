<?php # BMP

$_['html']['title'] = 'Actions';



$data = sql("SELECT time, NULL, op_return 
FROM actions  
WHERE op_return LIKE '6a026d01%'
ORDER BY RAND()
LIMIT 20"); // 

foreach ($data AS $key => $value) {
    $data[$key]['NULL'] = hex2bin(substr($value['op_return'], 10));
}




echo html_table($data, array(
        'blocks'    => array('align' => 'right'),
        'power'     => array('align' => 'right'),
        'hashpower' => array('align' => 'right'),
    ));
    
    

