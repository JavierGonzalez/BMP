<?php # BMP — Javier González González


define('BMP_PROTOCOL', [

    'prefix'  => (passwords['dev']===true?'00':'9d'),

    'actions' => [


        '' => [
            'action'        => 'power_by_value',
            'coinbase'      => true,
            'status'        => 'implemented',
            'tested'        => true,
            'description'   => 'By default, by value, standard block, P2Pool style.',
        ],


        '00' => [
            'action'        => 'power_by_opreturn',
            'coinbase'      => true,
            'status'        => 'implemented',
            'tested'        => false,
            'description'   => 'Power quota signaling by OP_RETURN. Independent from value.',
            1 => ['size' =>  3, 'name'=>'quota',       'decode'=>'hexdec'],
            2 => ['size' => 40, 'name'=>'address',     'decode'=>'hex2bin', 'validate'=>'address'],
        ],


        '01' => [
            'action'        => 'power_by_action',
            'coinbase'      => false,
            'status'        => 'idea',
            'tested'        => false,
            'description'   => 'Power quota delegation in to arbitrary address by action. Independent from value. Non-recursive.',
            1 => ['size' =>  3, 'name'=>'quota',       'decode'=>'hexdec'],
            2 => ['size' => 40, 'name'=>'address',     'decode'=>'hex2bin', 'is'=>'address'],
        ],


        '02' => [
            'action'        => 'chat',
            'status'        => 'implemented',
            'tested'        => true,
            'description'   => '',
            1 => ['size' =>   5, 'name'=>'time'],
            2 => ['size' =>   1, 'name'=>'channel',    'decode'=>'hexdec', 'options'=>[0=>'bmp', /*1=>'main'*/ ]],
            3 => ['size' => 200, 'name'=>'msg',        'decode'=>'hex2bin'],
        ],


        '03' => [
            'action'        => 'miner_parameter',
            'status'        => 'implemented',
            'tested'        => true,
            'description'   => '',
            1 => ['size' =>  10, 'name'=>'key',        'decode'=>'hex2bin', 'options'=>['nick'=>'nick', 'email'=>'email']],
            2 => ['size' => 200, 'name'=>'value',      'decode'=>'hex2bin'],
        ],


        '04' => [
            'action'        => 'vote',
            'status'        => 'implemented',
            'tested'        => true,
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
            'tested'        => true,
            'description'   => '',
            1 => ['size' =>   1, 'name'=>'type_voting',       'decode'=>'hexdec', 'options'=>[0=>'explorative', 1=>'decisive_bmp', 2=>'decisive_51', 3=>'decisive_66']],
            2 => ['size' =>   1, 'name'=>'type_vote',         'decode'=>'hexdec', 'options'=>[1=>'one_option', /*2=>'multiple', 3=>'preferential_3', 4=>'preferential_5'*/]],
            3 => ['size' =>   1, 'name'=>'parameters_num',    'decode'=>'hexdec'],
            4 => ['size' =>   3, 'name'=>'blocks_to_closed',  'decode'=>'hexdec', 'min'=>2],
            5 => ['size' => 200, 'name'=>'question',          'decode'=>'hex2bin'],
        ],

        
        '06' => [
            'action'        => 'voting_parameter',
            'status'        => 'implemented',
            'tested'        => true,
            'description'   => '',
            1 => ['size' =>  32, 'name'=>'txid'],
            2 => ['size' =>   1, 'name'=>'type',   'decode'=>'hexdec', 'options'=>[0=>'point', 1=>'option']],
            3 => ['size' =>   1, 'name'=>'order',  'decode'=>'hexdec'],
            4 => ['size' => 160, 'name'=>'text',   'decode'=>'hex2bin'],
        ],


        '08' => [
            'action'        => 'bmp_parameter',
            'status'        => 'idea',
            1 => ['size' =>  10, 'name'=>'key',    'decode'=>'hex2bin'],
            2 => ['size' => 200, 'name'=>'value',  'decode'=>'hex2bin'],
        ],



        '09' => [
            'action'        => 'cancel',
            'status'        => 'idea',
            1 => ['size' =>  32, 'name'=>'action'],
        ],


        '0a' => [
            'action'        => 'private_msg',
            'status'        => 'idea',
        ],

        '0b' => [
            'action'        => 'forum',
            'status'        => 'idea',
        ],


        '0c' => [
            'action'        => 'documents',
            'status'        => 'idea',
        ],


        '0d' => [
            'action'        => 'teams',
            'status'        => 'idea',
        ],


        '0e' => [
            'action'        => 'projects',
            'status'        => 'idea',
        ],


        '0f' => [
            'action'        => 'funding',
            'status'        => 'idea',
        ],

        '10' => [
            'action'        => 'scrum_board',
            'status'        => 'idea',
        ],

    ],
]);
