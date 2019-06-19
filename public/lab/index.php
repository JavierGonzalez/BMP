<?php

crono();
require_once('lib/spyc.php');
crono();
$bmp_protocol_yaml = spyc_load_file('bmp_protocol.yaml');

crono($bmp_protocol_yaml);

crono($bmp_protocol);


crono();


exit;

if (get_new_block())
    echo '<meta http-equiv="refresh" content="0">';

crono();

exit;

$txid = '4ac4a547ed5cc7b5eb825819f08c5559de9daadde360de5efccbf90c7f8a5f24';

crono(get_action($txid));
crono();

exit;