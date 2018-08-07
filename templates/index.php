<?php



if ($template=='api')
    include('templates/api.php');
    
else if ($template!==false)
    include('templates/html.php');