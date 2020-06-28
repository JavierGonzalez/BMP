<?php # BMP — Javier González González


if (strlen($_GET[0])==64)
    include('voting/vote.php');
else
    include('voting/list.php');
