// BMP




$('#voting_vote').submit(async function(e) {
    e.preventDefault();

    var op_return = bmp_protocol_prefix;
    op_return += '04';                                              // action: vote
    op_return += $("#voting_option").val();                         // txid   
    op_return += fill_hex(dechex($("#voting_vote input[name='voting_validity']:checked").val()),1);   // voting_validity
    op_return += fill_hex(dechex(1),1);                             // vote_direction (positive)
    op_return += bin2hex($('#voting_comment').val());               // comment
    result_tx1 = await blockchain_send_tx(op_return);
    
});



$('#voting_create').submit(async function(e) {
    e.preventDefault();

    var parameters_num = 0;
    $(".parameter").each(async function(index) {
            parameters_num++;
        });

    var op_return = bmp_protocol_prefix;
    op_return += '05';                                              // action: voting
    op_return += '00';                                              // type_voting    
    op_return += fill_hex($('#type_vote').val(),1);                 // type_vote
    op_return += fill_hex(dechex(parameters_num),1);                // parameters_num
    op_return += fill_hex(dechex($('#blocks_to_finish').val()),3);  // blocks_to_finish
    op_return += bin2hex($('#question').val());                     // question
    result_tx1 = await blockchain_send_tx(op_return);

    if (!result_tx1)
        return false;

    var order = 0;
    
    var parameters_tx = [];
    $(".parameter").each(function(index) {
            if ($(this).val()) {
                order++;

                if ($(this).hasClass('voting_point'))
                    var type = 1;

                if ($(this).hasClass('voting_option'))
                    var type = 2;

                var op_return = bmp_protocol_prefix;
                op_return += '06';                                      // action: voting_parameter
                op_return += result_tx1.txid;                           // txid
                op_return += fill_hex(dechex(type),1);                  // type
                op_return += fill_hex(dechex(order),1);                 // order
                op_return += bin2hex($(this).val());                    // text
                parameters_tx.push(op_return);

            }
        });

    for (const op_return of parameters_tx)
        await blockchain_send_tx(op_return);
    
});



$('#chat_input_msg').keyup(function() {
	$('#op_return_preview').text(bin2hex($(this).val()));
});
