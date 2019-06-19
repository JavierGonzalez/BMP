<?php # BMP



if (strlen($_GET[1])==64)
    include('public/voting/view.php');
else
    include('public/voting/list.php');