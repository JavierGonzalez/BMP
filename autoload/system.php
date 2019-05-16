<?php



function shell($command) {
	$GLOBALS['shell_output'] = trim(shell_exec($command.' 2>&1'));
	return $GLOBALS['shell_output'];
}



function event_chat($msg, $nick=false) {
	
    sql_insert('chats_msg', array(
            'chat_id'   => 1,
            'nick'      => ($nick?$nick:''),
            'msg'       => $msg,
            'tipo'      => 'e',
        )); // ????

    return true;
}
