<?php



function html_table($data=false, $config=false) {

    if (!$data)
        return '';

    $html = '<table>';
    
    // Header
    $html .= '<tr>';
    foreach ($data[0] AS $key => $value) {
        $html .= '<th>'.ucfirst($key).'</th>';
    }
    $html .= '</tr>';
    
    
    // Content
    foreach ($data AS $row) {
        $html .= '<tr>';
        foreach ($row AS $name => $column) {
            
            $td_extra = '';
            if ($config[$name]['align'])
                $td_extra .= ' align="'.$config[$name]['align'].'"';
            
            $html .= '<td'.$td_extra.' nowrap>'.$column.'</td>';
        }
        $html .= '</tr>';
    }
    
    
    
    $html .= '</table>';
    
    
    return $html;
}