<?php



function event_chat($msg, $nick=false) {
	
    sql_insert('chats_msg', array(
            'chat_id'   => 1,
            'nick'      => ($nick?$nick:''),
            'msg'       => $msg,
            'tipo'      => 'e',
        ));

    return true;
}
