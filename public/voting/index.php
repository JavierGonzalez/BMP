<?php # BMP — Javier González González



if (strlen($_GET[1])==64)
    include('public/voting/vote.php');
else
    include('public/voting/list.php');