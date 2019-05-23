<?php # BMP


$bmp_protocol = array(
        
        'prefix' => '00', // 9d
        
        'actions' => array(

            '01' => array(
                'coinbase'      => true,
                'action'        => 'hashpower_quota',
                'name'          => 'Hashpower signaling by quota',
                'description'   => 'Not by coinbase value. Any number, best option.',
                1 => array('size' => 10, 'name'=>'number',  'hex'=>true),
            ),

            '02' => array(
                'action'        => 'chat',
                'name'          => 'Chat',
                'description'   => 'IRC-like on-chain chat',
                1 => array('size' =>  10, 'name'=>'timestamp'),
                2 => array('size' =>   3, 'name'=>'channel',  'hex'=>true),
                3 => array('size' => 150, 'name'=>'msg'),
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
                2 => array('size' =>  10, 'name'=>'parameter', 'hex'=>true),
                3 => array('size' => 180, 'name'=>'value'),
            ),

            '06' => array(
                'action'        => 'parameter_bmp',
                'name'          => 'Set parameter BMP',
                'description'   => '',
                1 => array('size' =>  10, 'name'=>'key',  'hex'=>true),
                2 => array('size' => 200, 'name'=>'value'),
            ),

            '07' => array(
                'action'        => 'parameter_miner',
                'name'          => 'Set parameter miner',
                'description'   => '',
                1 => array('size' =>  10, 'name'=>'key',  'hex'=>true),
                2 => array('size' => 200, 'name'=>'value'),
            ),

        ),
    );
