<?php


$maxsim['template']['title'] = 'Stats: SmartBCH validators';


$smartbch_block_window      = 2016;
$smartbch_validators_json   = 'stats/SmartBCH/smartbch_validators.json';


$smartbch_validators_raw = json_decode(file_get_contents($smartbch_validators_json), true);


foreach ($smartbch_validators_raw AS $value)
    $smartbch_validators_count[$value['validator_pub_key']]++;

krsort($smartbch_validators_count);

$votes_total = 0;
foreach ($smartbch_validators_count AS $validator => $votes)
    $votes_total += $votes;

foreach ($smartbch_validators_count AS $validator => $votes) {
    
    $pool = '';
    foreach ($smartbch_validators_raw AS $value) {
        if ($validator === $value['validator_pub_key']) {
            $r = sql('SELECT pool, pool_link FROM blocks WHERE blockchain = "'.BLOCKCHAIN_ACTIONS.'" AND height = "'.$value['height'].'" LIMIT 1')[0];
            $pool = ($r['pool_link']?'<a href="'.$r['pool_link'].'" target="_blank">'.$r['pool'].'</a>':$r['pool']);
            break;
        }
    }
    
    $data[] = [
        'validators'        => $validator,
        'blocks'            => num($votes),
        'share_absolute'    => num(($votes*100)/$smartbch_block_window,2).'%',
        'share'             => num(($votes*100)/$votes_total,2).'%',
        'pool'              => $pool,
    ];
}


$votes_unknown = $smartbch_block_window - $votes_total;
$data[] = [
    'validators'        => 'Non-participants',
    'blocks'            => num($votes_unknown),
    'share_absolute'    => num(($votes_unknown*100)/$smartbch_block_window,2).'%',
];


$config = [
    'validators'        => ['th' => 'Validators (pub key)', 'monospace' => true],
    'blocks'            => ['align' => 'right'],
    'share_absolute'    => ['th' => 'Share (absolute)', 'align' => 'right'],
    'share'             => ['align' => 'right'],
    ];


?>

<h1>SmartBCH validators</h1>

<?=html_table($data, $config)?>

<br /><br />

<ul>
<li>SmartBCH is not part of the BMP protocol.</li>
<li>This information is for aditional info and research purposes only.</li>
<li>SmartBCH block window is the last <?=$smartbch_block_window?> blocks.</li>
<li>More info in: <a href="https://smartbch.org/" target="_blank"><b>SmartBCH.org</b></a></li>
</ul>

<br />