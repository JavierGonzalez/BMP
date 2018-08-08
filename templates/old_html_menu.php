<?php


$elements = array(
        '/'             => 'Communications',
        '/hashpower'    => 'Hashpower',
        '' => '',
        '/collective-conversation' => 'CC</sup>',
    );


echo '<ul>';
foreach ($elements AS $url => $text)
    echo '<li><a href="'.$url.'">'.$text.'</a></li>';
echo '</ul>';