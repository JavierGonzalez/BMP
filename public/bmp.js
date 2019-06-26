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



function print_login() {

    if (miner_utxo()) {
        $('#print_login').html('<a href="/parameter/miner">' + miner_utxo()['address'].substr(-10, 10) + '</a> <button class="btn btn-warning" onclick="miner_logout()">Logout</button>');
        $('.executive_action').prop('disabled', false);
    } else {
        $('#print_login').html('<button class="btn btn-warning" onclick="get_miner_utxo(true)">Login</button>');
        $('.executive_action').prop('disabled', true);
    }

}


function miner_utxo(data=null) {

    if (data) {
        sessionStorage['miner_utxo'] = JSON.stringify(data);
    }

    if (sessionStorage['miner_utxo'])
        return JSON.parse(sessionStorage['miner_utxo']);
    else
        return false;
}



async function get_miner_utxo(confirmation=false) {

    if (confirmation == true) {
        var c = confirm("\n *** REQUIREMENTS TO PARTICIPATE ***\n\n1. Your address in a coinbase in the last 2,016 BCH blocks.\n\n2. Trezor hardware wallet.\n\n3. Do not block external browser popup or adblocks.");
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


function miner_logout() {
    sessionStorage.clear();
    print_login();
}


async function blockchain_send_tx(op_return) {

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


function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
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



function dechex(dec) {
    return parseInt(dec).toString(16);
}


function hexdec(hex) {
    return parseInt(hex, 16);
}


function fill_hex(hex, bytes) {
    return hex.padStart(bytes*2, '0').substr(0, bytes*2);
}

