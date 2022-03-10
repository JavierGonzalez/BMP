// BMP — Javier González González


function print_login() {

    if (miner_utxo()) {
        $('#print_login').html('<a href="/parameter">' + miner_utxo()['address'].substr(-10, 10) + '</a> <button class="btn btn-warning" onclick="miner_logout()">Logout</button>');
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



function miner_logout() {
    sessionStorage.clear();
    print_login();
}




function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}


function bin2hex(s) {
    var i, l, o = '', n;
    s += '';
    for (i = 0, l = s.length; i < l; i++) {
        n = s.charCodeAt(i).toString(16);
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


function command_print(op_return) {
    if (!op_return)
        return '';
    
    var data = dechex(op_return.length / 2) + op_return;

    return '<div style="width:100%;padding:5px;background-color:#FFF;border:1px solid #000;cursor:text;" contenteditable>createrawtransaction "[{\\"txid\\": \\"&lt;tx hash containing mined coinbase&gt;\\", \\"vout\\":&lt;vout mined address&gt;}]" "[{\\"bitcoincash:&lt;mined address in coinbase&gt;\\":&lt;coinbase output amount&gt;, \\"data\\":\\"' + data + '\\"}]"</div>';
}