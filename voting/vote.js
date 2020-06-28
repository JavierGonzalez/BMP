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

