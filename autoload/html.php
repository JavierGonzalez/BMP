<?php # BMP


function html_table($data=false, $config=false) {

    if (!is_array($data))
        return '';

    // Header
    $html .= '<tr>';
    foreach ((array)$data[0] AS $key => $value) {

        if (isset($config[$key]['th']))
            $key = $config[$key]['th'];

        $html .= '<th>'.ucfirst($key).'</th>';
    }
    $html .= '</tr>';
    
    
    // Content
    foreach ($data AS $row) {
        $html .= '<tr>';
        foreach ($row AS $key => $column) {
            $td_extra = '';
            
            if ($config[$key]['align'])
                $td_extra .= ' align="'.$config[$key]['align'].'"';

                $monospace = false;
                if ($config[$key]['monospace'])
                    $monospace = ' class="monospace"';

            $html .= '<td'.$td_extra.$monospace.' nowrap>'.$column.'</td>';
        }
        $html .= '</tr>';
    }
    

    return '<table>'.$html.'</table>';
}


function html_a($url, $text, $blank=false) {
    return '<a href="'.$url.'"'.($blank?' target="_blank"':'').'>'.$text.'</a>';
}


function html_b($text) {
    return '<b>'.$text.'</b>';
}