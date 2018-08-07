<?php



foreach (glob('_no-framework/functions*.php') AS $load)
    include($load);

include('_no-framework/config.php');

include('_no-framework/router.php');


//////////////////////////////////////////


foreach (glob('functions/*.php') AS $load)
    include($load);

include('templates/index.php');


