<?php # simple_framework


function revert_bytes($input) {
    $output = str_split($input, 2);
    $output = array_reverse($output);
    $output = implode('', $output);
    return $output;
}