<?php # BMP — Javier González González


$bmp_protocol = array(
    
    'prefix' => '00', // 9d 
    
    'actions' => array(


        '00' => array(
            'action'        => 'power_by_value',
            'coinbase'      => true,
            'status'        => 'implemented',
            'description'   => 'By default, standard, P2Pool style, without OP_RETURN.',
        ),


        '01' => array(
            'action'        => 'power_by_opreturn',
            'coinbase'      => true,
            'status'        => 'implemented',
            'description'   => 'Value-independent HP signaling. Any number, best option.',
            1 => array('size' =>  2, 'name'=>'quota',       'decode'=>'hexdec'),
            2 => array('size' => 34, 'name'=>'address',     'decode'=>'hextobase58'),
        ),


        '02' => array(
            'action'        => 'chat',
            'status'        => 'implemented',
            'description'   => '',
            1 => array('size' =>   5, 'name'=>'time'),
            2 => array('size' =>   1, 'name'=>'channel',    'decode'=>'hexdec', 'options'=>array(0=>'bmp', /*1=>'main'*/)),
            3 => array('size' => 200, 'name'=>'msg',        'decode'=>'hex2bin'),
        ),


        '03' => array(
            'action'        => 'miner_parameter',
            'status'        => 'implemented',
            'description'   => '',
            1 => array('size' =>  10, 'name'=>'key',        'decode'=>'hex2bin', 'options'=>array('nick', 'email')),
            2 => array('size' => 200, 'name'=>'value',      'decode'=>'hex2bin'),
        ),


        '04' => array(
            'action'        => 'vote',
            'status'        => 'implemented',
            'description'   => 'All action can be voted, independent validity voting.',
            1 => array('size' =>  32, 'name'=>'txid'),
            2 => array('size' =>   1, 'name'=>'type_vote',        'decode'=>'hexdec', 'options'=>array(0=>'action', 1=>'one_election', /*2=>'multiple', 3=>'preferential_3', 4=>'preferential_5', 5=>'preferential_10'*/)),
            3 => array('size' =>   1, 'name'=>'voting_validity',  'decode'=>'hexdec', 'options'=>array(0=>'not_valid', 1=>'valid')),
            4 => array('size' =>   1, 'name'=>'vote',             'decode'=>'hexdec'),
            5 => array('size' => 160, 'name'=>'comment',          'decode'=>'hex2bin'),
        ),


        '05' => array(
            'action'        => 'voting',
            'status'        => 'implemented',
            'description'   => '',
            1 => array('size' =>   1, 'name'=>'type_voting',       'decode'=>'hexdec', 'options'=>array(0=>'default')),
            2 => array('size' =>   1, 'name'=>'type_vote',         'decode'=>'hexdec', 'options'=>array(1=>'one_election', /*2=>'multiple', 3=>'preferential_3', 4=>'preferential_5', 5=>'preferential_10'*/)),
            3 => array('size' =>   1, 'name'=>'parameters_num',    'decode'=>'hexdec'),
            4 => array('size' =>   3, 'name'=>'blocks_to_finish',  'decode'=>'hexdec', 'min'=>144),
            5 => array('size' => 200, 'name'=>'question',          'decode'=>'hex2bin'),
        ),

        
        '06' => array(
            'action'        => 'voting_parameter',
            'status'        => 'implemented',
            'description'   => '',
            1 => array('size' =>  32, 'name'=>'txid'),
            2 => array('size' =>   1, 'name'=>'type',   'decode'=>'hexdec', 'options'=>array(0=>'point', 1=>'option')),
            3 => array('size' =>   1, 'name'=>'order',  'decode'=>'hexdec'),
            4 => array('size' => 160, 'name'=>'text',   'decode'=>'hex2bin'),
        ),




        '07' => array(
            'action'        => 'bmp_parameter',
            'status'        => 'planned',
            1 => array('size' =>  10, 'name'=>'key',    'decode'=>'hex2bin'),
            2 => array('size' => 200, 'name'=>'value',  'decode'=>'hex2bin'),
        ),




        '08' => array(
            'action'        => 'cancel',
            'status'        => 'idea',
            1 => array('size' =>  32, 'name'=>'action'),
        ),


        '09' => array(
            'action'        => 'private_msg',
            'status'        => 'idea',
        ),

        '0a' => array(
            'action'        => 'forum',
            'status'        => 'idea',
        ),


        '0b' => array(
            'action'        => 'documents',
            'status'        => 'idea',
        ),


        '0c' => array(
            'action'        => 'teams',
            'status'        => 'idea',
        ),


        '0d' => array(
            'action'        => 'projects',
            'status'        => 'idea',
        ),


        '0e' => array(
            'action'        => 'funding',
            'status'        => 'idea',
        ),

    ),
);
