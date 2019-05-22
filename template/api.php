<?php # simple_framework


header('Content-type:application/json;charset=utf-8');

echo json_encode((array)$echo, JSON_PRETTY_PRINT);

exit;