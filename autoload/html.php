<?php # BMP — Javier González González


function html_table($data, $config=false) {

    if (!is_array($data))
        return '';
    
    // Header
    $html .= '<tr style="'.($config['th_background-color']?'background-color:'.$config['th_background-color'].';':'').'">';
    foreach ((array)$data[key($data)] AS $key => $value) {

        if (isset($config[$key]['th']))
            $key = $config[$key]['th'];

        $html .= '<th>'.ucfirst($key).'</th>';
    }
    $html .= '</tr>';
    
    
    // Rows
    foreach ($data AS $row) {
        $html .= '<tr>';
        foreach ($row AS $key => $column) {
            $td_extra = '';
            
            if (is_array($column))
                $column = implode(', ', $column);
                
            if ($config[$key]['align'])
                $td_extra .= ' align="'.$config[$key]['align'].'"';

            if ($config[$key]['monospace'])
                $td_extra .= ' class="monospace"';

            if ($config[$key]['function'])
                $column = call_user_func($config[$key]['function'], $column);

            if (is_numeric($config[$key]['num']))
                $column = num($column,$config[$key]['num']);

            if ($config[$key]['ucfirst'])
                $column = ucfirst($column);

            if ($config[$key]['capital'])
                $column = strtoupper($column);

            if ($config[$key]['before'])
                $column = $config[$key]['before'].$column;

            if ($config[$key]['after'])
                $column = $column.$config[$key]['after'];

            if ($config[$key]['bold'])
                $column = '<b>'.$column.'</b>';

            $html .= '<td'.$td_extra.' nowrap>'.$column.'</td>';
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


function html_h($text, $num=1) {
    return '<h'.$num.'>'.$text.'</h'.$num.'>';
}


function html_button($url=false, $text='', $style='primary', $extra=false) {
    if ($url)
        return '<a href="'.$url.'" class="btn btn-'.$style.'">'.$text.'</a>';
    else
        return '<button type="button" class="btn btn-'.$style.'">'.$text.'</button>';
}
