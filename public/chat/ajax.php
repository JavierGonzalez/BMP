<?php # BMP


$_['template']['output'] = 'api';


if ($_GET[2]=='refresh' AND is_numeric($_GET['id_last']))
	$echo['msg'] = sql("SELECT id, txid, address, p1, p3 
        FROM actions 
        WHERE action = 'chat' AND p2 = '000001' AND id > ".e($_GET['id_last'])." 
        ORDER BY p1 ASC");
