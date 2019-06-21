<?php # BMP — Javier González González



function update_actions() {

    // miner_parameter nick
    foreach (sql("SELECT address, p2 AS nick FROM actions WHERE action = 'miner_parameter' AND p1 = 'nick' ORDER BY time ASC") AS $r)
        sql_update('miners', array('nick' => $r['nick']), "address = '".$r['address']."'");

}


function action_parameters_pretty($action) {
    global $bmp_protocol;

    foreach ((array)$bmp_protocol['actions'][$action['action_id']] AS $key => $value)
        if (is_numeric($key))
            if (isset($action['p'.$key]))
                $parameters[$value['name']] = $action['p'.$key];
    
    return $parameters;
}











