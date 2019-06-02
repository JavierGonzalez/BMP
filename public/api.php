<?php # BMP


$_['template']['output'] = 'api';


if ($_GET[1]=='miner_utxo') {

    foreach ((array)$_POST['utxo'] AS $utxo_id => $utxo) {
        $tx = rpc_get_transaction($utxo['transactionHash']);
        
        $utxo['address'] = $tx['vout'][$utxo['index']]['scriptPubKey']['addresses'][0];

        if (sql("SELECT address AS ECHO FROM miners WHERE address = '".e(address_normalice($utxo['address']))."' LIMIT 1"))
            $echo['miner_utxo'] = $utxo;
    }

}