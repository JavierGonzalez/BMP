// BMP



$('#voting_create').submit(async function(e) {
    e.preventDefault();
console.log(1);
    var parameters_num = 0;
    $(".parameter").each(async function(index) {
            parameters_num++;
        });

console.log(2);
    var op_return = bmp_protocol_prefix;
    op_return += '05';                                              // action
    op_return += '00';                                              // type_voting    
    op_return += fill_hex($('#type_vote').val(),1);                 // type_vote
    op_return += fill_hex(dechex(parameters_num),1);                // parameters_num
    op_return += fill_hex(dechex($('#blocks_to_finish').val()),3);  // blocks_to_finish
    op_return += bin2hex($('#question').val());                     // question
    result_tx1 = await blockchain_send_tx(op_return);
console.log(3);
    if (!result_tx1)
        return false;

    var order = 0;
    $(".parameter").each(async function(index) {
            

            if ($(this).val()) {
                order++;
console.log(4);
                
                if ($(this).hasClass('voting_point')) {
                    var type = 1;
                }

                if ($(this).hasClass('voting_option')) {
                    var type = 2;
                }

                var op_return = bmp_protocol_prefix;
                op_return += '06';                                      // action
                op_return += result_tx1.txid;                           // txid
                op_return += fill_hex(dechex(type),1);                  // type
                op_return += fill_hex(dechex(order),1);                 // order
                op_return += bin2hex($(this).val());                    // text
                await blockchain_send_tx(op_return);
            }
        });
console.log(5);
});



$('#chat_input_msg').keyup(function() {
	$('#op_return_preview').text(bin2hex($(this).val()));
});
