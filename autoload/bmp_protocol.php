<?php # BMP


$bmp_protocol = array(
        
        'prefix' => '00', // 9d
        
        'actions' => array(

            '01' => array(
                'coinbase'      => true,
                'action'        => 'hashpower_quota',
                'name'          => 'Hashpower signaling by quota',
                'description'   => 'Any number, hashpower block quota, ignore value, best option.',
                1 => array('size' => 10, 'name'=>'number'),
            ),

            '02' => array(
                'action'        => 'chat',
                'name'          => 'Chat',
                'description'   => 'IRC-like chat commands:',
                1 => array('size' =>  10, 'name'=>'timestamp', 'date'=>true),
                2 => array('size' =>   2, 'name'=>'channel'),
                3 => array('size' => 150, 'name'=>'command'),
            ),

            '03' => array(
                'action'        => 'vote',
                'name'          => 'Vote',
                'description'   => 'All action can be voted, validity parallel voting independly.',
                1 => array('size' =>  30, 'name'=>'txid',      'hex'=>true),
                2 => array('size' =>   1, 'name'=>'direction', 'hex'=>true),
                3 => array('size' =>   1, 'name'=>'validity',  'hex'=>true),
                4 => array('size' => 170, 'name'=>'comment'),
            ),

            '04' => array(
                'action'        => 'voting',
                'name'          => 'Voting create',
                'description'   => '',
                1 => array('size' =>   4, 'name'=>'type', 'hex'=>true),
                2 => array('size' => 200, 'name'=>'title'),
            ),

            '05' => array(
                'action'        => 'voting_parameter',
                'name'          => 'Voting parameter',
                'description'   => '',
                1 => array('size' =>  30, 'name'=>'txid', 'hex'=>true),
                2 => array('size' =>   6, 'name'=>'parmeter'),
                3 => array('size' => 180, 'name'=>'value'),
            ),

            '06' => array(
                'action'        => 'parameter_bmp',
                'name'          => 'Set parameter BMP',
                'description'   => '',
                1 => array('size' =>  10, 'name'=>'key'),
                2 => array('size' => 200, 'name'=>'value'),
            ),

            '07' => array(
                'action'        => 'parameter_miner',
                'name'          => 'Set parameter miner',
                'description'   => '',
                1 => array('size' =>  10, 'name'=>'key'),
                2 => array('size' => 200, 'name'=>'value'),
            ),

        ),
    );


// Specification
///////////////////////////////////////////////////////////////////////////////////
// Code


function op_return_decode($op_return) {
    global $bmp_protocol;

    if (!ctype_xdigit($op_return))
        return false;

    if (substr($op_return,0,2)!=='6a')
        return false;

    if (substr($op_return,4,2)!==$bmp_protocol['prefix'])
        return false;

    $action_id  = substr($op_return,6,2);

    if (!$bmp_protocol['actions'][$action_id])
        return false;

    $output = array(
            'action'    => $bmp_protocol['actions'][$action_id]['action'],
            'action_id' => $action_id,
        );

    $counter = 6;
    foreach ($bmp_protocol['actions'][$action_id] AS $p => $v) {
        if (is_numeric($p)) {
            $parameter = substr($op_return, $counter*2, $v['size']*2);
            if ($parameter) {
                
                if ($v['date'] AND is_numeric(hex2bin($parameter)))
                    $parameter = date("Y-m-d H:i:s", inyection_filter(hex2bin($parameter)));
                    
                else if (!$v['hex'])
                    $parameter = inyection_filter(hex2bin($parameter));

                $output['p'.$p] = $parameter;

                $counter += $v['size'];
            }
        }
    }

    $output['json'] = null;

    return $output;
}
