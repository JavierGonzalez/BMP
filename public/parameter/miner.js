// BMP — Javier González González



function bmp_op_return_parameter_nick() {

    var action  = '03'; // miner_parameter
    var key     = fill_hex(bin2hex('nick'), 10);
    var value   = bin2hex($('#miner_parameter_nick_value').val().trim());

    return bmp_protocol_prefix + action + key + value;
}


$('#miner_parameter_nick_value').keyup(function() {
    $('#op_return_preview').text(bmp_op_return_parameter_nick());
});


$('#miner_parameter_nick').submit(function() {
    
    result = blockchain_send_tx(bmp_op_return_parameter_nick());

    $('#miner_parameter_nick_value').val('');
    $('#miner_parameter_nick_preview').text('');
    
    return false;
});





function formatted_string(pad, user_str, pad_pos) {
    
    if (typeof user_str === 'undefined') 
        return pad;

    if (pad_pos == 'l')
        return (pad + user_str).slice(-pad.length);
    else
        return (user_str + pad).substring(0, pad.length);
}
