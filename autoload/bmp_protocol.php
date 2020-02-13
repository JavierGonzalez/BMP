<?php # BMP — Javier González González


define('BMP_PROTOCOL', [

    'prefix'  => (DEV===true?'00':'9d'),

    'actions' => [


        '00' => [
            'action'        => 'power_by_value',
            'coinbase'      => true,
            'status'        => 'implemented',
            'description'   => 'By default, standard, P2Pool style.',
        ],


        '01' => [
            'action'        => 'power_by_opreturn', // To be tested.
            'coinbase'      => true,
            'status'        => 'implemented',
            'description'   => 'Power quota signaling by OP_RETURN. Independent from value. Zero cost.',
            1 => ['size' =>  4, 'name'=>'quota',       'decode'=>'hexdec'],
            2 => ['size' => 34, 'name'=>'address',     'decode'=>'hextobase58'],
        ],


        '02' => [
            'action'        => 'chat',
            'status'        => 'implemented',
            'description'   => '',
            1 => ['size' =>   5, 'name'=>'time'],
            2 => ['size' =>   1, 'name'=>'channel',    'decode'=>'hexdec', 'options'=>[0=>'bmp', /*1=>'main'*/ ]],
            3 => ['size' => 200, 'name'=>'msg',        'decode'=>'hex2bin'],
        ],


        '03' => [
            'action'        => 'miner_parameter',
            'status'        => 'implemented',
            'description'   => '',
            1 => ['size' =>  10, 'name'=>'key',        'decode'=>'hex2bin', 'options'=>['nick'=>'nick', 'email'=>'email']],
            2 => ['size' => 200, 'name'=>'value',      'decode'=>'hex2bin'],
        ],


        '04' => [
            'action'        => 'vote',
            'status'        => 'implemented',
            'description'   => 'All action can be voted, independent validity voting.',
            1 => ['size' =>  32, 'name'=>'txid'],
            2 => ['size' =>   1, 'name'=>'type_vote',        'decode'=>'hexdec', 'options'=>[0=>'action', 1=>'one_election']],
            3 => ['size' =>   1, 'name'=>'voting_validity',  'decode'=>'hexdec', 'options'=>[0=>'not_valid', 1=>'valid']],
            4 => ['size' =>   1, 'name'=>'vote',             'decode'=>'hexdec'],
            5 => ['size' => 160, 'name'=>'comment',          'decode'=>'hex2bin'],
        ],


        '05' => [
            'action'        => 'voting',
            'status'        => 'implemented',
            'description'   => '',
            1 => ['size' =>   1, 'name'=>'type_voting',       'decode'=>'hexdec', 'options'=>[0=>'informative', 1=>'decisive_51', 2=>'decisive_66']],
            2 => ['size' =>   1, 'name'=>'type_vote',         'decode'=>'hexdec', 'options'=>[1=>'one_election', /*2=>'multiple', 3=>'preferential_3', 4=>'preferential_5'*/]],
            3 => ['size' =>   1, 'name'=>'parameters_num',    'decode'=>'hexdec'],
            4 => ['size' =>   3, 'name'=>'blocks_to_finish',  'decode'=>'hexdec', 'min'=>2],
            5 => ['size' => 200, 'name'=>'question',          'decode'=>'hex2bin'],
        ],

        
        '06' => [
            'action'        => 'voting_parameter',
            'status'        => 'implemented',
            'description'   => '',
            1 => ['size' =>  32, 'name'=>'txid'],
            2 => ['size' =>   1, 'name'=>'type',   'decode'=>'hexdec', 'options'=>[0=>'point', 1=>'option']],
            3 => ['size' =>   1, 'name'=>'order',  'decode'=>'hexdec'],
            4 => ['size' => 160, 'name'=>'text',   'decode'=>'hex2bin'],
        ],


        '07' => [
            'action'        => 'bmp_parameter',
            'status'        => 'idea',
            1 => ['size' =>  10, 'name'=>'key',    'decode'=>'hex2bin'],
            2 => ['size' => 200, 'name'=>'value',  'decode'=>'hex2bin'],
        ],



        '08' => [
            'action'        => 'cancel',
            'status'        => 'idea',
            1 => ['size' =>  32, 'name'=>'action'],
        ],


        '09' => [
            'action'        => 'private_msg',
            'status'        => 'idea',
        ],

        '0a' => [
            'action'        => 'forum',
            'status'        => 'idea',
        ],


        '0b' => [
            'action'        => 'documents',
            'status'        => 'idea',
        ],


        '0c' => [
            'action'        => 'teams',
            'status'        => 'idea',
        ],


        '0d' => [
            'action'        => 'projects',
            'status'        => 'idea',
        ],


        '0e' => [
            'action'        => 'funding',
            'status'        => 'idea',
        ],

    ],
]);
