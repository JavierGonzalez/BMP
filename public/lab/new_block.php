<?php # BMP


crono();

$num = 1;
$refresh = 1;


for ($h=1;$h<=$num;$h++)
    $result = get_new_block();

crono();

if ($result AND $refresh)
    echo '<meta http-equiv="refresh" content="0">';


exit;