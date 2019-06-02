<?php # BMP

$_template['title'] = 'Evidence action: '.$_GET[2];

$evidence['action'] = sql("SELECT * FROM actions WHERE txid = '".e($_GET[2])."'")[0];

$evidence['miner']  = sql("SELECT * FROM miner WHERE address = '".$evidence['action']['address']."'");

print_r2($evidence);
