<?php # BMP

$_template['title'] = 'Evidence miner: '.$_GET[2];

$evidence['miner'] = sql("SELECT * FROM miner WHERE address = '".e($_GET[2])."'");


print_r2($evidence);
