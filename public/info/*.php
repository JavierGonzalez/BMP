<?php # BMP



foreach (array('blocks', 'miners', 'actions') AS $value)
    $_template['top_right'] .= ' '.html_button('/info/'.$value, ucfirst($value), ($_GET[1]==$value?'outline-':'').'primary');