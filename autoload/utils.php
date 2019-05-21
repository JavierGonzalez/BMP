<?php # BMP





function event_chat($msg, $nick=false) {
	
    sql_insert('chats_msg', array(
            'chat_id'   => 1,
            'nick'      => ($nick?$nick:''),
            'msg'       => $msg,
            'tipo'      => 'e',
        )); // ????

    return true;
}



function num($number, $decimals=0) { 
    return number_format($number, $decimals, '.', ','); // i18n!
}



function now($days=0, $format='Y-m-d H:i:s', $type='past') {
	if ($days==0) {
		$timestamp = time();
	} else if ($type=='past') {
		$timestamp = time()-(86400*round($days));
	} else {
		$timestamp = time()+(86400*round($days));
	}
	return date($format, $timestamp);
}

function error_and_exit($print) {
	echo '<span style="color:red;">'.$print.'</span>';
	sql_close();
	exit;
}
