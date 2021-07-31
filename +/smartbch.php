<?php




function smartbch_update_validators() {

    $blockchain             = 'BCH';
    $smartbch_block_window  = 2016;
    $smartbch_prefix        = '7342434800';
    $cache_validators_json  = 'stats/SmartBCH/smartbch_validators.json';



    $last_block_sql = sql("SELECT height FROM blocks WHERE blockchain = '".$blockchain."' ORDER BY height DESC LIMIT 1")[0]['height'];
    $last_block_rpc = rpc_get_best_height($blockchain);

    if (!is_numeric($last_block_sql) OR $last_block_sql != $last_block_rpc)
        return false;


    $height = $last_block_rpc;

    while ($height >= ($last_block_rpc - $smartbch_block_window)) {

        $block = rpc_get_block($height, $blockchain);

        $coinbase = rpc_get_transaction($block['tx'][0], $blockchain);

        foreach ($coinbase['vout'] AS $vout) {
            if ($vout['scriptPubKey']['asm']) {
                $op_return_hex = str_replace('OP_RETURN ', '', $vout['scriptPubKey']['asm']);
                
                if (substr($op_return_hex, 0, 10) == $smartbch_prefix)
                    $smartbch_validators[] = [
                        'height'            => $height,
                        'block_hash'        => $block['hash'],
                        'tx_hash'           => $block['tx'][0],
                        'op_return_hex'     => $op_return_hex,
                        'validator_pub_key' => substr($op_return_hex, strlen($smartbch_prefix)),
                    ];
            }
        }
        
        $height--;
    }

    file_put_contents($cache_validators_json, json_encode($smartbch_validators, JSON_PRETTY_PRINT));

}