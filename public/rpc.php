<?php


require_once('lib/easybitcoin.php');

$bitcoin = new Bitcoin('username','password','localhost','8332');


echo $bitcoin->getinfo();