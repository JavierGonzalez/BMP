// BMP — Javier González González


function miner_utxo(data=null) {

    if (data) {
        sessionStorage['miner_utxo'] = JSON.stringify(data);
    }

    if (sessionStorage['miner_utxo'])
        return JSON.parse(sessionStorage['miner_utxo']);
    else
        return false;
}



function get_miner_utxo() {

    var TrezorConnect = window.TrezorConnect;

	TrezorConnect.manifest({
        email: 'gonzo@virtualpol.com',
        appUrl: 'https://bmp.virtualpol.com'
    });


    trezor_request = TrezorConnect.getAccountInfo({
        coin: 'bch',
    });



    trezor_request.then(function(result) {
        
        console.log(result.payload);

        $.post('/api/miner_utxo', { utxo: result.payload.utxo },
            function(data){
                if (data['miner_utxo']['transactionHash']) {
                    console.log('miner_utxo found! ' + data['miner_utxo']['transactionHash']);
                    console.log(data['miner_utxo']);
                    miner_utxo(data['miner_utxo']);
                } else {
                    sessionStorage.clear();
                    console.log('miner_utxo not found!');
                }
            }
        );

    }, function(error) {
        sessionStorage.clear();
        console.log('ERROR: ' + error);
    });


}


function blockchain_send_tx(op_return) {


    if (!miner_utxo()) {
        get_miner_utxo();

    } else {

        var value_output = String(miner_utxo()['value'] - ((op_return.length * 2) + 1000));

        var TrezorConnect = window.TrezorConnect;

        TrezorConnect.manifest({
            email: 'gonzo@virtualpol.com',
            appUrl: 'https://bmp.virtualpol.com'
        });

        trezor_request = TrezorConnect.signTransaction({
                inputs: [
                    {
                        address_n: [(44 | 0x80000000) >>> 0, (145 | 0x80000000) >>> 0, (0 | 0x80000000) >>> 0, miner_utxo()['addressPath'][0], miner_utxo()['addressPath'][1]],
                        prev_index: parseInt(miner_utxo()['index']),
                        prev_hash: miner_utxo()['transactionHash'],
                        amount: String(miner_utxo()['value']),
                        script_type: 'SPENDADDRESS',
                    }
                ],
                outputs: [
                    {
                        address: miner_utxo()['address'],
                        amount: value_output,
                        script_type: 'PAYTOADDRESS',
                    },
                    { 
                        op_return_data: op_return, 
                        amount: '0',
                        script_type: 'PAYTOOPRETURN', 
                    },
                ],
                coin: 'bch',
                push: true
            });

        trezor_request.then(function(result) {
            
            console.log(result.payload);

            if (result.payload.error)
                console.log('ERROR: ' + result.payload.error);
            
            if (result.payload.txid) {
                var data = miner_utxo();
                data['index'] = 0;
                data['value'] = value_output;
                data['transactionHash'] = result.payload.txid;
                miner_utxo(data);
                console.log('BMP TX:  ' + op_return + '  ' + data['address'] + '  ' + result.payload.txid);
            } else {
                sessionStorage.clear();
            }

        }, function(error) {
            sessionStorage.clear();
            console.log('ERROR: ' + error);
        });
    }
    
}





function bin2hex(s) {
    var i, l, o = '', n;
    s += '';
    for (i = 0, l = s.length; i < l; i++) {
        n = s.charCodeAt(i).toString(16)
        o += n.length < 2 ? '0' + n : n;
    }
    return o;
}
