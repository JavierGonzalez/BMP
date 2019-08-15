// BMP — Javier González González



$('#voting_vote, #rv_1, #rv_0').change(function() {
	$('#op_return_preview').text(bmp_op_return_vote());
});

$('#voting_comment').keyup(function() {
	$('#op_return_preview').text(bmp_op_return_vote());
});


function bmp_op_return_vote() {

    var action          = '04'; // vote
    var txid            = $("#voting_txid").val();
    var type_vote       = fill_hex(dechex($("#voting_type_vote").val()),1);
    var voting_validity = fill_hex(dechex($("#voting_vote input[name='voting_validity']:checked").val()),1);
    var vote            = fill_hex(dechex($("#voting_option").val()),1);
    var comment         = bin2hex($('#voting_comment').val());

    if (!$("#voting_vote input[name='voting_validity']:checked").val())
        return '';

    return bmp_protocol_prefix + action + txid + type_vote + voting_validity + vote + comment;
}



$('#voting_vote').submit(async function(e) {
    e.preventDefault();

    result_tx1 = await blockchain_send_tx(bmp_op_return_vote());
});



///////


function bmp_op_return_voting() {
    // IN DEVELOPMENT...

    var parameters_num = 0;
    $(".parameter").each(async function(index) {
            if ($(this).val())
                parameters_num++;
        });


    return false;
}



$('#voting_create').submit(async function(e) {
    e.preventDefault();

    var parameters_num = 0;
    $(".parameter").each(async function(index) {
            if ($(this).val())
                parameters_num++;
        });

    var c = confirm("\nThis action requires " + (1 + parameters_num) + " consecutive transactions.");
    if (c != true)
        return false;

    $('.executive_action').prop('disabled', true);


    var op_return = bmp_protocol_prefix;
    op_return += '05';                                              // action: voting
    op_return += '00';                                              // type_voting    
    op_return += fill_hex($('#type_vote').val(),1);                 // type_vote
    op_return += fill_hex(dechex(parameters_num),1);                // parameters_num
    op_return += fill_hex(dechex($('#blocks_to_finish').val()),3);  // blocks_to_finish
    op_return += bin2hex($('#question').val().trim());              // question
    result_tx1 = await blockchain_send_tx(op_return);

    if (!result_tx1)
        return false;

    var order = [];
    order[0] = 0;
    order[1] = 0;
    
    var parameters_tx = [];
    $(".parameter").each(function(index) {
            if ($(this).val()) {

                if ($(this).hasClass('voting_point'))
                    var type = 0;

                if ($(this).hasClass('voting_option'))
                    var type = 1;
                
                order[type]++;

                var op_return = bmp_protocol_prefix;
                op_return += '06';                                  // action: voting_parameter
                op_return += result_tx1.txid;                       // txid
                op_return += fill_hex(dechex(type),1);              // type
                op_return += fill_hex(dechex(order[type]),1);       // order
                op_return += bin2hex($(this).val().trim());         // text
                parameters_tx.push(op_return);

            }
        });

    for (const op_return of parameters_tx)
        await blockchain_send_tx(op_return);
    
});






function voting_add_point() {
    $('#voting_points').append('<li><input class="parameter voting_point" size=40 maxlength="42" /></li>');
    return false;
}


function voting_add_option() {
    $('#voting_options').append('<br /><input class="parameter voting_option" size=20 maxlength="42" value="" />');
    return false;
}
