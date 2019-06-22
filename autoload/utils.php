<?php # BMP — Javier González González



function num($number, $decimals=0) { 
    return number_format($number, $decimals, '.', ',');
}


function error_and_exit($print) {
	echo '<span style="color:red;">'.$print.'</span>';
	sql_close();
	exit;
}
