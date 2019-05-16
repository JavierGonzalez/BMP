<?php # simple_framework



header('Content-type:application/json;charset=utf-8');

if ($output)
    echo json_encode($output, JSON_PRETTY_PRINT);

exit;