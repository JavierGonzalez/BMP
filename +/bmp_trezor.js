// BMP — Javier González González


$(document).ready(function() {
    print_login();

    window.TrezorConnect.on('DEVICE_EVENT', (event) => {
        if (event.type === 'device-connect') {
            print_login();
        } else if (event.type === 'device-disconnect') {
            miner_logout();
        }
    });

});


async function get_miner_utxo(confirmation=false) {

    if (confirmation == true) {
        var c = confirm("REQUIREMENTS TO PARTICIPATE:\n\n1. Your address in coinbase in the last 4,032 blocks of BCH.\n\n2. Trezor Model T hardware-wallet (recommended).\n\n3. Do not block pop-up windows in the browser.");
        if (c != true)
            return false;
    }

    
    TrezorConnect = window.TrezorConnect;

    TrezorConnect.manifest({
        email: 'gonzo@virtualpol.com',
        appUrl: 'https://bmp.virtualpol.com'
    });



    result_utxo = await TrezorConnect.getAccountInfo({
        coin: 'bch',
    });


    if (result_utxo.payload.utxo) {
        console.log(result_utxo.payload);
        await $.post('/api/miner_utxo', { utxo: result_utxo.payload.utxo },
            async function(data){

                if (data['miner_utxo']['address']) {
                    console.log('BMP MINER UTXO FOUND! ' + data['miner_utxo']['address'] + ' ' + data['miner_utxo']['transactionHash']);
                    miner_utxo(data['miner_utxo']);
                } else {
                    sessionStorage.clear();
                    console.log('BMP MINER UTXO: not found!');
                    alert("Coinbase UTXO not found.");
                }

            }
        );
    }

    print_login();
}


async function blockchain_send_tx(op_return) {

    if (op_return == '' || !op_return)
        return false;

    if (!miner_utxo())
        await get_miner_utxo();


    var value_output = String(miner_utxo()['value'] - ((op_return.length * 2) + 1000));

    var TrezorConnect = window.TrezorConnect;

    TrezorConnect.manifest({
        email: 'gonzo@virtualpol.com',
        appUrl: 'https://bmp.virtualpol.com'
    });

    result_tx = await TrezorConnect.signTransaction({
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
                    address: miner_utxo()['address_cash'],
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


    if (result_tx.payload.error) {
        console.log('ERROR: ' + result_tx.payload.error);
        alert('ERROR: ' + result_tx.payload.error);
        // sessionStorage.clear();
        
    } else {
        var data = miner_utxo();
        data['index'] = 0;
        data['value'] = value_output;
        data['transactionHash'] = result_tx.payload.txid;
        miner_utxo(data);

        console.log('BMP ACTION:  ' + result_tx.payload.txid + ' ' + op_return);

        return result_tx.payload;
    }
    
}

async function blockchain_send_tx_debug(op_return) {
    console.log(op_return);
}

