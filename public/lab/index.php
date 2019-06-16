<?php

crono();


function event($name) {
    global $__events;

    

    return 'OK';
}

crono(event());


exit;

if (get_new_block())
    echo '<meta http-equiv="refresh" content="0">';

crono();

exit;

$txid = '4ac4a547ed5cc7b5eb825819f08c5559de9daadde360de5efccbf90c7f8a5f24';

crono(get_action($txid));
crono();

exit;