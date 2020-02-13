// BMP — Javier González González



$('#type_voting, #type_vote').change(function() {
	bmp_preview_voting_update();
});

$('#blocks_to_finish, #question, .parameter').keyup(function() {
	bmp_preview_voting_update();
});

function bmp_preview_voting_update() {
    op_return_preview = bmp_preview_voting();
    $('#op_return_preview').html(op_return_preview.join('<br />'));
    $('#op_return_preview_tx_count').html('<b>' + op_return_preview.length + '</b> transactions.');
}


function bmp_preview_voting() {
    output_array = [bmp_op_return_voting()];
    output_array = output_array.concat(bmp_op_return_voting_parameter('[first_txid]'));
    return output_array;
}


function bmp_op_return_voting() {

    var parameters_num = 0;
    $('.parameter').each(async function(index) {
            if ($(this).val())
                parameters_num++;
        });

    var op_return = bmp_protocol_prefix;
    op_return += '05';                                              // action: voting
    op_return += fill_hex($('#type_voting').val(),1);               // type_voting    
    op_return += fill_hex($('#type_vote').val(),1);                 // type_vote
    op_return += fill_hex(dechex(parameters_num),1);                // parameters_num
    op_return += fill_hex(dechex($('#blocks_to_finish').val()),3);  // blocks_to_finish
    op_return += bin2hex($('#question').val().trim());              // question

    return op_return;
}



function bmp_op_return_voting_parameter(voting_txid) {

    var order = [0,0];
    var op_return_array = [];

    $('.parameter').each(function(index) {
            if ($(this).val()) {

                if ($(this).hasClass('voting_point'))
                    var type = 0;

                if ($(this).hasClass('voting_option'))
                    var type = 1;
                
                order[type]++;

                var op_return = bmp_protocol_prefix;
                op_return += '06';                                  // action: voting_parameter
                op_return += voting_txid;                           // txid
                op_return += fill_hex(dechex(type),1);              // type
                op_return += fill_hex(dechex(order[type]),1);       // order
                op_return += bin2hex($(this).val().trim());         // text
                
                op_return_array.push(op_return);

            }
        });

    return op_return_array;
}


$('#voting_create').submit(async function(e) {
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


    result_tx1 = await blockchain_send_tx(bmp_op_return_voting());

    if (!result_tx1)
        return false;

    var parameters_tx = bmp_op_return_voting_parameter(result_tx1.txid)

    for (const op_return of parameters_tx)
        await blockchain_send_tx(op_return);
    
});



function voting_add_point() {
    $('#voting_points').append('<li><input class="parameter voting_point" size=24 maxlength=200 onkeyup="bmp_preview_voting_update()" /></li>');
    return false;
}


function voting_add_option() {
    $('#voting_options').append('<br /><input class="parameter voting_option" size=20 maxlength=200 value="" onkeyup="bmp_preview_voting_update()" />');
    return false;
}
