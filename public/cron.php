<?php # BMP

$_['template'] = 'api';


if ($_GET[1]=='new_block') {
    echo 'New Block! '. $_GET['hash'];
    file_put_contents('static/bmp.log', "\n".date('Y-m-d H:i:s').' '.$_SERVER['REQUEST_URI'], FILE_APPEND | LOCK_EX);
}
