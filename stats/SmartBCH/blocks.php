<?php


$maxsim['template']['title'] = 'SmartBCH validators: blocks';


$smartbch_block_window      = 2016;
$smartbch_validators_json   = 'stats/SmartBCH/smartbch_validators.json';


$smartbch_validators_raw = json_decode(file_get_contents($smartbch_validators_json), true);


foreach ($smartbch_validators_raw AS $validator) {
    
    $pool = [];
    $r = sql('SELECT pool, pool_link, time FROM blocks WHERE blockchain = "'.BLOCKCHAIN_ACTIONS.'" AND height = "'.$validator['height'].'" LIMIT 1')[0];
    $pool[$r['pool']] = ($r['pool_link']?'<a href="'.$r['pool_link'].'" target="_blank">'.$r['pool'].'</a>':$r['pool']);

    $data[] = [
        'height'        => $validator['height'],
        'time'          => $r['time'],
        'validator'     => $validator['validator_pub_key'],
        'pool'         => implode(', ', $pool),
    ];
}



$config = [
    'validator'        => ['th' => 'Validators (pub key)', 'monospace' => true],
    ];


?>

<h1>BCH blocks with <a href="/stats/SmartBCH">SmartBCH validators</a></h1>

<?=html_table($data, $config)?>
