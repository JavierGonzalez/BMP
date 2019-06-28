// BMP — Javier González González


$('#miner_parameter_nick').submit(function() {

    var action  = '03'; // miner_parameter

    var key = 'nick';

    var parameter = $('#miner_parameter_nick_value').val().trim();

    var op_return = bmp_protocol_prefix + action + bin2hex(formatted_string('          ', key)) + bin2hex(parameter);

    result = blockchain_send_tx(op_return);

    $('#miner_parameter_nick_value').val('');
    $('#miner_parameter_nick_preview').text('');
    
    return false;
});


$('#miner_parameter_nick_value').keyup(function() {
    $('#miner_parameter_nick_preview').text(bin2hex($(this).val()));
});



function formatted_string(pad, user_str, pad_pos) {
    
    if (typeof user_str === 'undefined') 
        return pad;

    if (pad_pos == 'l')
        return (pad + user_str).slice(-pad.length);
    else
        return (user_str + pad).substring(0, pad.length);
}
