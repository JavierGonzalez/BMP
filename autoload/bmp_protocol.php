<?php # BMP — Javier González González


$bmp_protocol = array(
    
    'prefix' => '00', // 9d 
    
    'actions' => array(


        '00' => array(
            'status'        => 'implemented',
            'coinbase'      => true,
            'action'        => 'power_by_value',
            'description'   => 'By default, standard, P2Pool style, without OP_RETURN.',
        ),


        '01' => array(
            'status'        => 'implemented',
            'coinbase'      => true,
            'action'        => 'power_by_opreturn',
            'description'   => 'Value-independent HP signaling. Any number, best option.',
            1 => array('size' =>  2, 'name'=>'quota',    'decode'=>'hexdec'),
            2 => array('size' => 34, 'name'=>'address',  'decode'=>'hextobase58'),
        ),


        '02' => array(
            'status'        => 'implemented',
            'action'        => 'chat',
            'description'   => '',
            1 => array('size' =>   5, 'name'=>'time'),
            2 => array('size' =>   1, 'name'=>'channel',  'decode'=>'hexdec', 'options'=>array(0=>'main', 1=>'bmp')),
            3 => array('size' => 200, 'name'=>'msg',      'decode'=>'hex2bin'),
        ),


        '03' => array(
            'status'        => 'implemented',
            'action'        => 'miner_parameter',
            'description'   => '',
            1 => array('size' =>  10, 'name'=>'key',    'decode'=>'hex2bin', 'options'=>array('nick', 'email', 'location')),
            2 => array('size' => 200, 'name'=>'value',  'decode'=>'hex2bin'),
        ),


        '04' => array(
            'status'        => 'implemented',
            'action'        => 'vote',
            'description'   => 'All action can be voted, independent validity voting.',
            1 => array('size' =>  32, 'name'=>'txid'),
            2 => array('size' =>   1, 'name'=>'voting_validity',  'decode'=>'hexdec', 'options'=>array(0=>'not_valid', 1=>'valid')),
            3 => array('size' =>   1, 'name'=>'vote_direction',   'decode'=>'hexdec', 'options'=>array(0=>'neutral', 1=>'positive', 2=>'negative')),
            4 => array('size' => 160, 'name'=>'comment',          'decode'=>'hex2bin'),
        ),


        '05' => array(
            'status'        => 'implemented',
            'action'        => 'voting',
            'description'   => '',
            1 => array('size' =>   1, 'name'=>'type_voting',       'decode'=>'hexdec', 'options'=>array(0=>'default')),
            2 => array('size' =>   1, 'name'=>'type_vote',         'decode'=>'hexdec', 'options'=>array(0=>'one_election',1=>'multiple', 2=>'preferential_3', 3=>'preferential_5', 4=>'preferential_10')),
            3 => array('size' =>   1, 'name'=>'parameters_num',    'decode'=>'hexdec'),
            4 => array('size' =>   3, 'name'=>'blocks_to_finish',  'decode'=>'hexdec'),
            5 => array('size' => 200, 'name'=>'question',          'decode'=>'hex2bin'),
        ),

        
        '06' => array(
            'status'        => 'implemented',
            'action'        => 'voting_parameter',
            'description'   => '',
            1 => array('size' =>  32, 'name'=>'txid'),
            2 => array('size' =>   1, 'name'=>'type',   'decode'=>'hexdec', 'options'=>array(1=>'point', 2=>'option')),
            3 => array('size' =>   1, 'name'=>'order',  'decode'=>'hexdec'),
            4 => array('size' => 160, 'name'=>'text',   'decode'=>'hex2bin'),
        ),

        '07' => array(
            'status'        => 'planned',
            'action'        => 'bmp_parameter',
            1 => array('size' =>  10, 'name'=>'key',    'decode'=>'hex2bin'),
            2 => array('size' => 200, 'name'=>'value',  'decode'=>'hex2bin'),
        ),

        '08' => array(
            'status'        => 'planned',
            'action'        => 'cancel',
        ),

        '09' => array(
            'status'        => 'planned',
            'action'        => 'proposals',
        ),


        '0a' => array(
            'status'        => 'planned',
            'action'        => 'forum',
        ),


        '0b' => array(
            'status'        => 'planned',
            'action'        => 'documents',
        ),


        '0c' => array(
            'status'        => 'planned',
            'action'        => 'projects',
        ),


        '0d' => array(
            'status'        => 'planned',
            'action'        => 'teams',
        ),


    ),
);
