<?php # BMP — Javier González González


$bmp_protocol = array(
        
        'prefix' => '00', // 9d
        
        'actions' => array(

            ' ' => array(
                'status'        => 'implemented',
                'coinbase'      => true,
                'action'        => 'power_by_value',
                'name'          => 'Power signalling by value',
                'description'   => 'By default, standard, P2Pool style',
            ),

            '01' => array(
                'status'        => 'planned',
                'coinbase'      => true,
                'action'        => 'power_by_opreturn',
                'name'          => 'Power signalling by OP_RETURN',
                'description'   => 'Value independent signaling. Any number, best option.',
                1 => array('size' => 32, 'name'=>'miner'),
                2 => array('size' => 3, 'name'=>'number',  'hex'=>true),
            ),

            '02' => array(
                'status'        => 'implemented',
                'action'        => 'chat',
                'name'          => 'Chat',
                'description'   => 'IRC-like on-chain chat',
                1 => array('size' =>  10, 'name'=>'time'),
                2 => array('size' =>   2, 'name'=>'channel',  'hex'=>true),
                3 => array('size' => 150, 'name'=>'msg'),
            ),

            '03' => array(
                'status'        => 'implemented',
                'action'        => 'miner_parameter',
                'name'          => 'Set parameter miner',
                'description'   => '',
                1 => array('size' =>  10, 'name'=>'key'),
                2 => array('size' => 200, 'name'=>'value'),
            ),

            '04' => array(
                'status'        => 'planned',
                'action'        => 'bmp_parameter',
                'name'          => 'Set parameter BMP',
                'description'   => '',
                1 => array('size' =>  10, 'name'=>'key'),
                2 => array('size' => 200, 'name'=>'value'),
            ),

            '05' => array(
                'status'        => 'planned',
                'action'        => 'vote',
                'name'          => 'Vote',
                'description'   => 'All action can be voted, validity parallel voting independly.',
                1 => array('size' =>  32, 'name'=>'txid',      'hex'=>true),
                2 => array('size' =>   1, 'name'=>'direction', 'hex'=>true),
                3 => array('size' =>   1, 'name'=>'validity',  'hex'=>true),
                4 => array('size' => 160, 'name'=>'comment'),
            ),

            '06' => array(
                'status'        => 'developing',
                'action'        => 'voting',
                'name'          => 'Voting create',
                'description'   => '',
                1 => array('size' =>   1, 'name'=>'vote_type', 'hex'=>true),
                2 => array('size' =>   1, 'name'=>'random', 'hex'=>true),
                3 => array('size' => 200, 'name'=>'question'),
            ),

            '07' => array(
                'status'        => 'developing',
                'action'        => 'voting_parameter',
                'name'          => 'Voting parameter',
                'description'   => '',
                1 => array('size' =>  32, 'name'=>'txid',      'hex'=>true),
                2 => array('size' =>   2, 'name'=>'key'),
                3 => array('size' => 160, 'name'=>'value'),
            ),


        ),
    );
