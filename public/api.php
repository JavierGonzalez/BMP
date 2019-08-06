<?php # BMP — Javier González González


$_['template']['output'] = 'api';


function miner_utxo_find($utxo) {
    $tx = rpc_get_transaction($utxo['transactionHash']);
            
    $utxo['address'] = address_normalice($tx['vout'][$utxo['index']]['scriptPubKey']['addresses'][0]);
    $utxo['address_cash'] = $tx['vout'][$utxo['index']]['scriptPubKey']['addresses'][0];

    if ($tx AND $utxo['address'])
        if (sql("SELECT address FROM miners WHERE address = '".e($utxo['address'])."' LIMIT 1"))
            return $utxo;

    return false;
}


if ($_GET[1]=='miner_utxo') {

    $utxos = array_reverse((array)$_POST['utxo']);

    foreach ($utxos AS $utxo)
        if ($utxo['coinbase']=='false')
            $echo['miner_utxo'] = miner_utxo_find($utxo);


    if (!$echo['miner_utxo'])
        foreach ($utxos AS $utxo)
            if ($utxo['coinbase']=='true')
                $echo['miner_utxo'] = miner_utxo_find($utxo);

    
    unset($_POST['utxo']);
    unset($utxos);

}
