<?php


foreach (glob('_no-framework/functions*.php') AS $load)
    include($load);


include('_no-framework/config.php');


include('_no-framework/router.php');


if ($template!==false)
    include('templates/index.php');


