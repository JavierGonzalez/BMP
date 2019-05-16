<?php # BMP


crono();

$num = 10;
for ($h=1;$h<=$num;$h++)
    $result = block_update();

crono();

if ($result)
    echo '<meta http-equiv="refresh" content="0">';

exit;