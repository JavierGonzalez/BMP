<?php


$danger_input = 'Testing. ¿? ¡! [] {} () \|/ @$%&#~ " \' ` <script>alert("XSS")</script>';

$output = injection_filter($danger_input);

// $output = $danger_input;

echo $output;