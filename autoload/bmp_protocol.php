<?php # BMP


$bmp_protocol = array(
        
        'prefix' => '6d', // 9d = BMP
        
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
                2 => array('size' =>   5, 'name'=>'channel'),
                3 => array('size' =>   5, 'name'=>'command'),
                4 => array('size' => 150, 'name'=>'msg'),
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




function op_return_decode($op_return) {
    global $bmp_protocol;

    if (substr($op_return,0,2)!=='6a') // OP_RETURN
        return false;

    if (substr($op_return,4,2)!==$bmp_protocol['prefix']) // BMP Protocol
        return false;

    $action_id  = substr($op_return,6,2);

    if (!$bmp_protocol['actions'][$action_id]) // Protocol action
        return false;

    $output = array(
            'action'    => $bmp_protocol['actions'][$action_id]['action'],
            'action_id' => $action_id,
        );

    $counter = 4;
    foreach ($bmp_protocol['actions'][$action_id] AS $p => $v) {
        if (is_numeric($p)) {
            $parameter = substr($op_return, $counter*2, $v['size']*2);
            if ($parameter) {
                
                if ($v['hex'])
                    $parmeter = $parameter;

                if ($v['date'] AND strlen(hex2bin($parameter))==10)
                    $parmeter = date("Y-m-d H:i:s", hex2bin($parameter));

                $output['p'.$p] = hex2bin($parameter);

                $counter += $v['size'];
            }
        }
    }

    $output['json'] = null;

    return $output;
}
