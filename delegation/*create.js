// BMP — Javier González González



$('#quota, #address').keyup(function() {
	bmp_preview_delegation_update();
});

$('#address').keyup(function() {
	$.get('/delegation/api/check_address', { address: $('#address').val() }).done(function(data) {
        if (data) {
            $('#address').val(data);
            $('#address_validity_check').html('✔');
        } else {
            $('#address_validity_check').html('Not valid');
        }
    });
});

function bmp_preview_delegation_update() {
    op_return_preview = bmp_op_return_delegation();
    $('#op_return_preview').html(op_return_preview);
}


function bmp_op_return_delegation() {

    var op_return = bmp_protocol_prefix;
    op_return += '01';                                         // action: power_by_action
    op_return += fill_hex(dechex($('#quota').val()*10000),3);  // quota
    op_return += bin2hex($('#address').val().trim());          // address

    return op_return;
}


$('#delegation_create').submit(async function(e) {
    e.preventDefault();

    var parameters_num = 0;
    $('.parameter').each(async function(index) {
            if ($(this).val())
                parameters_num++;
        });

    var c = confirm("\nThis action requires " + (1 + parameters_num) + " consecutive transactions.");
    if (c != true)
        return false;

    $('.executive_action').prop('disabled', true);


    result_tx1 = await blockchain_send_tx(bmp_op_return_delegation());

    if (!result_tx1)
        return false;

    // var parameters_tx = bmp_op_return_delegation_parameter(result_tx1.txid)

    //for (const op_return of parameters_tx)
    //    await blockchain_send_tx(op_return);
    
});
