<?php



function sql_connect($sql_server=false) {
    global $sql;

    if (!$sql_server)
        $sql_server = SQL_SERVER;

	$p = parse_url($sql_server);
	
	if (!isset($p['port']))
	    $p['port'] = 3306;


	$sql_link = @mysqli_connect($p['host'], $p['user'], $p['pass'], str_replace('/', '', $p['path']), $p['port']);
    
    $sql['link'][] = $sql_link;
    
	if (!$sql_link) {
		echo '<span title="'.sql_error().'">ERROR: Database connect error.</span>';
		return false;
	}

	mysqli_query($sql_link, "SET NAMES 'utf8'");

    @register_shutdown_function('sql_close');

	return $sql_link;
}




function sql_link() {
	global $sql;

	if (!$sql['link'])
        sql_connect();

	return $sql['link'][0];
}



function sql_close() {
	global $sql;

	foreach ((array)$sql['link'] AS $link)
    	@mysqli_close($link);

    unset($sql['link']);
    
}



function sql_error() {
	$msg = @mysqli_error(sql_link());
	return ($msg?$msg:'');
}



function e($danger) {
	return mysqli_real_escape_string(sql_link(), $danger);
}



function sql_query($query) {

	$result = mysqli_query(sql_link(), $query);
    
    while ($r = mysqli_fetch_array($result, MYSQLI_ASSOC))
        $output[] = $r;
    
    return $output;
}

