<?php # BMP — Javier González González

$maxsim['output'] = 'json';

if ($_GET[1]=='check_address') {
    $address = address_normalice($_GET['address']);
    if (address_validate($address))
        echo $address;
    exit;
}
