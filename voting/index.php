<?php # BMP — Javier González González


if (strlen($_GET[1])==64)
    include('voting/vote.php');
else
    include('voting/list.php');