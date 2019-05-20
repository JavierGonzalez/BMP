



function send_msg() {
	
	var text = $("#chat_input_msg").val();

	var boton_envia_estado = $("#botonenviar").attr("disabled");
	$("#vpc_actividad").attr("src", "/public/chat/img/point_red.png");

	if ((text) && (boton_envia_estado != "disabled")) {

 		ajax_refresh = false;
		clearTimeout(refresh);
		$("#botonenviar").attr("disabled","disabled");
		$("#chat_input_msg").val("").css("background", "none").css("color", "black");
		$.post("/chat/ajax/send", { chat_ID: chat_ID, n: msg_ID, msg: text }, 
			function(data){ 
				ajax_refresh = true;
				if (data) { chat_sin_leer = -1; print_msg(data); }
				setTimeout(function(){ $("#botonenviar").removeAttr("disabled"); }, 1600);
				chat_delay = 4000;
				refresh = setTimeout(chat_query_ajax, chat_delay);
				//delays();
				$("#vpc_actividad").attr("src", "/public/chat/img/point_grey.png");
			});
	}
	return false;
}


function scroll_down() {
	if (chat_scroll <= document.getElementById("vpc").scrollTop) {
		document.getElementById("vpc").scrollTop = 90000000;
		chat_scroll = document.getElementById("vpc").scrollTop;
	}
}



function chat_query_ajax() {
	if (ajax_refresh) {
		ajax_refresh = false;
		clearTimeout(refresh);
		var start = new Date().getTime();
		$("#vpc_actividad").attr("src", "/public/chat/img/point_blue.png");
		$.post("/chat/ajax/refresh", { n: "___" },
			function(data){
				ajax_refresh = true;
				if (data) { print_msg(data); }
				refresh = setTimeout(chat_query_ajax, chat_delay);
				var elapsed = new Date().getTime() - start;
				$("#vpc_actividad").attr("src", "/public/chat/img/point_grey.png").attr("title", "Chat actualizado (" + (chat_delay/1000) + " segundos, " + elapsed + "ms)");
			}
		);
		if (ajax_refresh == true) { merge_list(); }
	}
}





/*

function actualizar_ahora() {
	chat_delay = 4000;
	refresh = setTimeout(chat_query_ajax, chat_delay);
	delays();
	chat_query_ajax();
	scroll_down();
	$("#chat_input_msg").focus();
}



function siControlPulsado(event, nick){
	if (event.ctrlKey==1) { toggle_ignorados(nick); return false; }
}

function toggle_ignorados(nick) {
	var idx = $.inArray(nick, array_ignorados);
	if (idx != -1) {
		array_ignorados.splice(idx, 1);
		$("."+nick).show();
		scroll_down();
	} else {
		array_ignorados.push(nick); 
		$("."+nick).hide();
	}
	merge_list();
	chat_scroll = 0;
	scroll_down();
}

function cf_cambiarnick() {
	nick_anonimo = $("#cf_nick").val();
	nick_anonimo = nick_anonimo.replace(/[^A-Za-z0-9_-]/g, "");
	if ((nick_anonimo) && (nick_anonimo.length >= 3) && (nick_anonimo.length <= 14)) {
		elnick = "-" + nick_anonimo.replace(" ", "_"); 
		anonimo = elnick;
		$("#cf").hide();
		$("#chatform").show();
	} else { $("#cf_nick").val(""); }
}

function chat_filtro_change() {
	if (chat_filtro == "normal") {
		chat_filtro = "solochat";
		$(".cf_c, .cf_e").hide();
	} else {
		chat_filtro = "normal";
		$(".cf_c, .cf_e").show();	
	}
	chat_scroll = 0;
	scroll_down();
	$("#chat_input_msg").focus();
}

function msgkeyup(evt, elem) {
	if ($(elem).val().substr(0,1) == "/") {
		$(elem).css("background", "#FF7777").css("color", "#952500");
	} else {
		$(elem).css("background", "none").css("color", "black");
	}
}

function msgkeydown(evt, elem) {
	obj = elem;
	var keyCode;
	if ("which" in evt) { keyCode=evt.which; }
	else if ("keyCode" in evt) { keyCode=evt.keyCode; }
	else if ("keyCode" in window.event) { keyCode=window.event.keyCode; }
	else if ("which" in window.event) { keyCode=evt.which; }
	if (keyCode == 9) {
		var elmsg = $(elem).val();
		var array_elmsg = elmsg.split(" ");
		var elmsg_num = array_elmsg.length;
		var palabras = "";
		for (i=0;i<elmsg_num;i++) {
			if (i == (elmsg_num - 1)) { var ultima_palabra = array_elmsg[i].toLowerCase(); } else { palabras += array_elmsg[i] + " "; }
		}
		if (ultima_palabra) {
			var len_ultima_palabra = ultima_palabra.length;
			for (elnick in al) {
				var elmnick = elnick.toLowerCase();
				if (ultima_palabra == elmnick.substr(0, len_ultima_palabra)) {
					if (palabras) { obj.value = palabras + elnick + " "; } else { obj.value = elnick + " "; }
				}
			}
		}
		setTimeout("obj.focus()", 10);
	}
}


function refresh_sin_leer() { document.title = chat_sin_leer_yo + chat_sin_leer + " - " + titulo_html; }

function print_msg(data) {
	if (ajax_refresh) {
		var chat_sin_leer_antes = chat_sin_leer;
		var escondidos = new Array();
		var arraydata = data.split("\n");
		var msg_num = arraydata.length - 1;
		var list = "";
		for (i=0;i<msg_num;i++) {
			var mli = arraydata[i].split(" ");
			var txt = ""; var ml = mli.length; for (var e=4; e<ml; e++) { txt += mli[e] + " "; }

			var m_ID = mli[0];
			var m_tipo = mli[1];
			var m_time = mli[2];
			var m_nick = mli[3];

			if (!chat_msg_ID[m_ID]) {
				
				chat_msg_ID[m_ID] = true;

				if (chat_time == m_time) { m_time = "<span style=\"color:#eee;\">" + m_time + "</span>"; } else { chat_time = m_time; }

				switch(m_tipo) {
					case "c":
					case "e":
						list += "<li id=\"" + m_ID + "\" class=\"cf_" + m_tipo + "\">" + m_time + " <span class=\"vpc_accion\">" + txt + "</span></li>\n";
						m_tipo = "0";
						break;

					case "p":
						if ((m_nick == minick) && (mli[4] == "<b>Nuevo")) { } else {
							var nick_solo = m_nick.split("&rarr;");
							var nick_s = nick_solo[0];
							if (minick == nick_s) {
								list += "<li id=\"" + m_ID + "\" class=\"" + nick_s + "\">" + m_time + " <span class=\"vpc_priv\" style=\"color:#004FC6\" ;OnClick=\"auto_priv(\'" + nick_s + "\');\"><b>[PRIV] " + m_nick + "</b>: " + txt + "</span></li>\n";
							} else {
								list += "<li id=\"" + m_ID + "\" class=\"" + nick_s + "\">" + m_time + " <span class=\"vpc_priv\" OnClick=\"auto_priv(\'" + nick_s + "\');\"><b>[PRIV] " + m_nick + "</b>: " + txt + "</span></li>\n";
								chat_sin_leer_yo = chat_sin_leer_yo + "+";
							}
						}
						var nick_p = m_nick.split("&rarr"); m_nick = nick_p[0]; m_tipo = "0";
						break;

					default:
						if (minick != "") { 
							var txt = " " + txt;
							var regexp = eval("/ "+minick+"/gi");
							var txt = txt.replace(regexp, " <b style=\"color:orange;\">" + minick + "</b>"); 
							if (txt.search(regexp) != -1) { chat_sin_leer_yo = chat_sin_leer_yo + "+"; } 
						}

						var vpc_yo = "";
						if (minick == m_nick) { var vpc_yo = " class=\"vpc_yo\""; }
						if (m_tipo && m_tipo.substr(0,3) == "98_") { var cargo_ID = 98; } else { var cargo_ID = m_tipo; }
						list += "<li id=\"" + m_ID + "\" class=\"" + m_nick + "\">" + m_time + " <img src=\""+IMG+"cargos/" + cargo_ID + ".gif\" width=\"16\" height=\"16\" title=\"" + array_cargos[cargo_ID] + "\" /> <b" + vpc_yo + " OnClick=\"auto_priv(\'" + m_nick + "\');\">" + m_nick + "</b>: " + txt + "</li>\n";
				}

				if (((msg_num - 1) == i) && (msg_num != "n") && (m_nick != "&nbsp;")) { msg_ID = m_ID; }
				if ((m_tipo != "c") && (m_nick != "_") && (m_nick != "")) { 
					al[m_nick] = parseInt(new Date().getTime().toString().substring(0, 10));
					if ((al_cargo[m_nick] == "0") || (!al_cargo[m_nick])) { al_cargo[m_nick] = m_tipo; }
				}

				var idx = $.inArray(m_nick, array_ignorados);
				if (idx != -1) { escondidos.push(m_ID); } else { chat_sin_leer++; }
			}
		}

		$("#vpc_ul").append(enriquecer(list, false));
		merge_list();
		if ((chat_sin_leer > 0) || (chat_sin_leer_antes == -1)) {
			refresh_sin_leer();
			print_delay();
		}
		for (var i=0;i<escondidos.length;i++) { $("#"+escondidos[i]).hide(); }
	}
}

function merge_list() {
	var unix_timestamp = parseInt(new Date().getTime().toString().substring(0, 10));
	var times_exp = parseInt(unix_timestamp - 1500); //25min
	
	array_list = new Array();
	for (elnick in al) {
		if (al[elnick] < times_exp) {
			al[elnick] = null;
			al_cargo[elnick] = null;
		} else {
			var cargo_ID = al_cargo[elnick];

			if (cargo_ID.substr(0,3) == "98_") { var kick_nick  = "ip-" + cargo_ID.substr(3); } 
			else { var kick_nick  = elnick; }

			var idx = $.inArray(elnick, array_ignorados);
			if (idx != -1) { nick_tachado = "<strike>" + elnick + "</strike>"; } else { nick_tachado = elnick; }
			
			if (array_list[cargo_ID] === undefined) { array_list[cargo_ID] = ""; }

			if (hace_kick) {
				js_kick = "<a href=\"/control/kick/" + kick_nick  + "/" + chat_ID  + "\" target=\"_blank\"><img src=\"" + IMG + "varios/kick.gif\" title=\"Kickear\" alt=\"Kickear\" border=\"0\" /></a>";
			} else {
				js_kick = "";
			}

			array_list[cargo_ID] += "<li>" + js_kick + " <span style=\"\">0.00%</span> <img src=\""+IMG+"cargos/" + cargo_ID + ".gif\" title=\"" + array_cargos[cargo_ID] + "\" /> <a href=\"/perfil/" + elnick  + "\" class=\"nick\" onClick=\"siControlPulsado(event,\'"+ elnick +"\');\" target=\"_blank\">" + nick_tachado + "</a></li>\n";
		}
	}

	var list = "";

	for (cargo_ID in array_cargos) {
		if ((array_list[cargo_ID] !== undefined) && (cargo_ID > 0)) { list += array_list[cargo_ID]; }
	}
	for (cargo_ID in array_cargos) {
		if ((array_list[cargo_ID] !== undefined) && (cargo_ID == 0)) { list += array_list[cargo_ID]; }
	}

	$("#chat_list").html(list);
}



function print_delay() {
	if (chat_filtro == "solochat") { $(".cf_c, .cf_e").hide(); }
	$("#chat_input_msg").focus();
	scroll_down();
}




function change_delay(delay) { chat_delay = parseInt(delay) * parseInt(1000); }

function delays() {
	if (chat_delay1) { clearTimeout(chat_delay1); } chat_delay1 = setTimeout("change_delay(6)", 25000);
	if (chat_delay2) { clearTimeout(chat_delay2); } chat_delay2 = setTimeout("change_delay(10)", 60000);
	if (chat_delay3) { clearTimeout(chat_delay3); } chat_delay3 = setTimeout("change_delay(15)", 120000);
	if (chat_delay4) { clearTimeout(chat_delay4); } chat_delay4 = setTimeout("change_delay(60)", 300000);
	if (chat_delay_close) { clearTimeout(chat_delay_close); } chat_delay_close = setTimeout("chat_close()", 7200000); // 2h
}

function chat_close() {
	clearTimeout(refresh);
	$("body").before("<div id=\"chat_alert\" style=\"position:absolute;top:40%;left:40%;\"><button onclick=\"chat_enabled();\" style=\"font-weight:bold;font-size:28px;color:#888;z-index:20px;\">Volver al chat...</button></div>");
}

function chat_enabled() {
	$("#chat_alert").remove();
	chat_query_ajax();
	chat_delay = 4500;
	refresh = setTimeout(chat_query_ajax, chat_delay);
	delays();
	$("#chat_input_msg").focus();
	scroll_down();
}

function auto_priv(nick) { $("#chat_input_msg").attr("value","/msg " + nick + " ").css("background", "#FF7777").css("color", "#952500").focus(); }

*/