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



async function get_miner_utxo() {

   TrezorConnect = window.TrezorConnect;

   TrezorConnect.manifest({
       email: 'gonzo@virtualpol.com',
       appUrl: 'https://bmp.virtualpol.com'
   });



   result_utxo = await TrezorConnect.getAccountInfo({
       coin: 'bch',
   });


    console.log(result_utxo.payload);
    
    if (result_utxo.payload.utxo) {
        await $.post('/api/miner_utxo', { utxo: result_utxo.payload.utxo },
            async function(data){
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
    }

}


async function blockchain_send_tx(op_return) {
console.log('A');
    if (!miner_utxo())
        await get_miner_utxo();

console.log('B');
    var value_output = String(miner_utxo()['value'] - ((op_return.length * 2) + 1000));

    var TrezorConnect = window.TrezorConnect;

    TrezorConnect.manifest({
        email: 'gonzo@virtualpol.com',
        appUrl: 'https://bmp.virtualpol.com'
    });
console.log('C');
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
console.log('D');

    if (result_tx.payload.error) {
        console.log('ERROR: ' + result_tx.payload.error);
        sessionStorage.clear();
console.log('EEE');

    } else {
console.log('E');
        var data = miner_utxo();
        data['index'] = 0;
        data['value'] = value_output;
        data['transactionHash'] = result_tx.payload.txid;
console.log('F');
        miner_utxo(data);

        console.log('BMP ACTION:  ' + op_return + '  ' + data['address'] + '  ' + result_tx.payload.txid);
console.log('G');
        return result_tx.payload;
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



function dechex(dec) {
    return parseInt(dec).toString(16);
}


function hexdec(hex) {
    return parseInt(hex, 16);
}

function blockchain_send_tx_debug(op_return) {
    console.log(op_return);
}

function fill_hex(hex, bytes) {
    return hex.padStart(bytes*2, '0').substr(0, bytes*2);
}

