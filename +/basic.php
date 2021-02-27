<?php



function injection_filter($danger_input) {
    $output = trim(stripslashes(strip_tags($danger_input)));
    return $output;
}



function file_filter($file) {
    $file = preg_replace('/[^A-Za-z0-9_.-]/', '', $file);
    $file = filter_var($file, FILTER_SANITIZE_STRING);
    return $file;
}



function every($seconds=60, $id=0) {
    global $every_last;

    if (time() >= $every_last[$id]+$seconds)
        return $every_last[$id] = time();

    return false;
}



function redirect($url='/') {
    header('Location: '.$url);
    exit;
}



function shell($command) {
    return trim(shell_exec($command.' 2>&1'));
}



function num($number, $decimals=0) { 

    if (!is_numeric($number))
        return '';

    return number_format((float)$number, $decimals, '.', ',');
}
