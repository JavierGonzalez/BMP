<?php # BMP — Javier González González


$bmp_protocol = array(
        
        'prefix' => '00', // 9d
        
        'actions' => array(


            ' ' => array(
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
                2 => array('size' =>   1, 'name'=>'channel',  'decode'=>'hexdec'),
                3 => array('size' => 200, 'name'=>'msg',      'decode'=>'hex2bin'),
            ),


            '03' => array(
                'status'        => 'implemented',
                'action'        => 'miner_parameter',
                'description'   => '',
                1 => array('size' =>  10, 'name'=>'key',    'decode'=>'hex2bin'),
                2 => array('size' => 200, 'name'=>'value',  'decode'=>'hex2bin'),
            ),


            '04' => array(
                'status'        => 'developing',
                'action'        => 'vote',
                'description'   => 'All action can be voted, validity parallel voting independly.',
                1 => array('size' =>  32, 'name'=>'txid'),
                2 => array('size' =>   1, 'name'=>'direction',  'decode'=>'hexdec'),
                3 => array('size' =>   1, 'name'=>'validity',   'decode'=>'hexdec'),
                4 => array('size' => 160, 'name'=>'comment',    'decode'=>'hex2bin'),
            ),


            '05' => array(
                'status'        => 'developing',
                'action'        => 'voting',
                'description'   => '',
                1 => array('size' =>   1, 'name'=>'type_voting',       'decode'=>'hexdec'),
                2 => array('size' =>   1, 'name'=>'type_vote',         'decode'=>'hexdec'),
                3 => array('size' =>   1, 'name'=>'parameters_num',    'decode'=>'hexdec'),
                4 => array('size' =>   3, 'name'=>'blocks_to_finish',  'decode'=>'hexdec'),
                5 => array('size' => 200, 'name'=>'question',          'decode'=>'hex2bin'),
            ),

            
            '06' => array(
                'status'        => 'developing',
                'action'        => 'voting_parameter',
                'description'   => '',
                1 => array('size' =>  32, 'name'=>'txid'),
                2 => array('size' =>   1, 'name'=>'type',   'decode'=>'hexdec'),
                3 => array('size' =>   1, 'name'=>'order',  'decode'=>'hexdec'),
                4 => array('size' => 160, 'name'=>'text',   'decode'=>'hex2bin'),
            ),


            '07' => array(
                'status'        => 'planned',
                'action'        => 'bmp_parameter',
                'description'   => '',
                1 => array('size' =>  10, 'name'=>'key',    'decode'=>'hex2bin'),
                2 => array('size' => 200, 'name'=>'value',  'decode'=>'hex2bin'),
            ),


        ),
    );
