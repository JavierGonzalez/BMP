// BMP — Javier González González


last = '2009-01-03 18:15:00';
ajax_refresh = true;
refresh = '';
chat_delay = 2000;
chat_scroll = 0;


window.onload = function(){
	scroll_down();
	refresh = setTimeout(chat_query_ajax, chat_delay); 
	chat_query_ajax();
}



function bmp_op_return_chat() {

	var action      = '02';
    var timestamp   = Math.round(new Date().getTime()/1000);
	var channel     = fill_hex('00',1);
    var msg         = bin2hex($('#chat_input_msg').val().trim());

    return bmp_protocol_prefix + action + timestamp + channel + msg;
}



$('#chat_input_msg').keyup(function() {
	$('#op_return_preview').text(bmp_op_return_chat());
});


$('#chat_form_msg').submit(async function(e) {
    e.preventDefault();

	result = await blockchain_send_tx(bmp_op_return_chat());

	$('#chat_input_msg').val('');
	$('#op_return_preview').text('');
});



function chat_query_ajax() {

	if (ajax_refresh) {
		ajax_refresh = false;
        
        clearTimeout(refresh);
        var start = new Date().getTime();
		$('#vpc_actividad').attr('src', '/public/chat/img/point_blue.png');

		$.post('/chat/api/refresh?last=' + last, function(data) {

            if (data) {
                $('#vpc_actividad').attr('src', '/public/chat/img/point_green.png');
                print_msg(data);
                scroll_down();
            }

            var elapsed = new Date().getTime() - start;
            $('#vpc_actividad').attr('title', elapsed + ' ms latency');
            $('#vpc_actividad').attr('src', '/public/chat/img/point_grey.png');

            refresh = setTimeout(chat_query_ajax, chat_delay);

            ajax_refresh = true;
        });
		
	}
}



function print_msg(data) {
	var html = '';

    if (!data['msg'])
        return false;

	data['msg'].forEach(function(value, key, array) {
        var tr_show = true;
        
        if (value['height'] == null)
            value['height'] = '';
        
        var date = new Date(Date.parse(value['time']));
        

        if (value['nick'] !== null)
            var nick = value['nick'].substr(0, 20);
        else
            var nick = value['address'].substr(-10, 10);

        var td = '';
        td += '<td style="color:#888;">' + value['height'] + '</td>';
        td += '<td title="' + date.format('Y-m-d H:i:s') + ' UTC">' + date.format('H:i') + '</td>';
        td += '<td align=right class="monospace"><a href="/info/miner/' + value['address'] + '" class="bmp_power">' + nick + '</a></td>';
        
        if (value['action']=='chat') {
            td += '<td width="100%" style="color:#222;">' + value['p3'] + '</td>';

        }


        if (value['action']=='miner_parameter') {

            td += '<td style="color:#00469A;"><b>[' + value['p1'].toUpperCase() + ']</b>&nbsp; ';
            if (value['p1']=='nick') {
                td += 'set nick: <i>' + value['p2'] + '</i>';    
            }
            td += '</td>';

        }


        if (value['action']=='vote') {

            td += '<td style="color:#00469A;"><b>[VOTE]</b>&nbsp; ';
            td += value['question'];
            td += '</td>';

            if (!value['question'])
                tr_show = false;
        }


        td += '<td align=right nowrap><a href="/info/action/' + value['txid'] + '" class="bmp_power">' + value['power'] + '%</a></td>';
        td += '<td align=right nowrap>' + value['hashpower'] + '</td>';
        
        
        if (tr_show)
            html += '<tr>' + td + '</tr>\n';

		last = value['time'];
	});
	
	$('#chat_msg').append(html);
}


function scroll_down() {
	if (chat_scroll <= document.getElementById('vpc').scrollTop) {
		document.getElementById('vpc').scrollTop = 100000000;
		chat_scroll = document.getElementById('vpc').scrollTop;
	}
}
