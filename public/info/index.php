<?php # BMP

$_['html']['title'] = 'Info';

if ($_GET[1]=='crawler') {
    block_update();
    echo sql_error();
    echo '<meta http-equiv="refresh" content="60" />';
    exit;
}








print_r(block_info_raw(543263));



