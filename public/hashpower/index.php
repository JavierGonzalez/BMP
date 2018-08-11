<?php 


$template = false;



block_update();


echo sql_error();


// echo '<meta http-equiv="refresh" content="2" />';


exit;

/*



CREATE TABLE `blocks` (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `height` int(8) UNSIGNED DEFAULT NULL,
  `date` timestamp DEFAULT NULL,
  `nonce` varchar(32) DEFAULT NULL,
  `hash` varchar(64) DEFAULT NULL,
  `size` num(20,0) DEFAULT NULL,
  `difficulty` varchar(32) DEFAULT NULL,
  `tx_count` varchar(32) DEFAULT NULL,
  `reward_block` varchar(32) DEFAULT NULL,
  `reward_fees` varchar(32) DEFAULT NULL,
  `hashpower` decimal(50,0) DEFAULT NULL,
  `coinbase_text_hex` varchar(512) DEFAULT NULL,
  `coinbase_text` varchar(32) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



CREATE TABLE `addresses` (
  `id` bigint(16) UNSIGNED NOT NULL AUTO_INCREMENT,
  `height` int(8) UNSIGNED DEFAULT NULL,
  `address` varchar(64) DEFAULT NULL,
  `value` int(8) DEFAULT NULL,
  `share` decimal(16,13) DEFAULT NULL,
  `hashpower` decimal(50,0) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



*/



//////////////////////////////////////////


$height = 459871;

$block = block_info_raw($height);
// print_r($block);


$block = block_info($height);
print_r($block);

echo "\n";

$hps = block_hashpower($block);
print_r($hps);

echo "\n";

$output = hashpower_humans($hps);
print_r($output);


