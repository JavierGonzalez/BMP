<?php # simple_framework


if ($_['template']=='api')
    include('template/api.php');
    
else if ($_['template']!==false)
    include('template/html.php');