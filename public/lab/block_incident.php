<?php # BMP


// crono();


$block_hash = '000000000000000000944485965a7172b18962c953da005afd648fe2f6abe650';

$block = $rpc->getblock($block_hash);
print_r($block);



foreach ($block['tx'] AS $tx) {
    $count++;
    if ($count>10000) break;
    
    $transaction_raw = $rpc->getrawtransaction($tx, 1);
    
    if (!is_array($transaction_raw))
        echo $tx."\n";
    
    //print_r($transaction_raw);
}


include('template/api.php');