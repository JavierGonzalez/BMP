

// VARIABLES
pnick = '';
whois_cache = new Array();
chat_msg_ID = new Array();
p_st = '';

// ON LOAD
$(document).ready(function(){
	
	// Reemplazo de emoticonos, etc.
	$(".rich").each(function (i) { $(this).html(enriquecer($(this).html(), true)); });

	// Botones HTML de votos +1 -1
	$(".votar").each(function (i) {
		var tipo = $(this).attr("type");
		var item_ID = $(this).attr("name");
		var voto = parseInt($(this).val());
		if (voto == 1) { var c_mas = " checked=\"checked\""; }
		if (voto == -1) { var c_menos = " checked=\"checked\""; }
		var radio_ID = tipo + item_ID;
		$(this).html("+<input type=\"radio\" class=\"radio_" + radio_ID + "\" name=\"radio_" + radio_ID + "\" onclick=\"votar(1, '" + tipo + "', '" + item_ID + "');\"" + c_mas + " /><input type=\"radio\" class=\"radio_" + radio_ID + "\" name=\"radio_" + radio_ID + "\" onclick=\"votar(-1, '" + tipo + "', '" + item_ID + "');\"" + c_menos + " />&#8211;"); 
	});

	search_timers();
	setInterval("search_timers()", 60000); // Actualiza temporizadores, cada 1 minuto.

	// Efecto scroll horizontal de Notificaciones.
	if (p_scroll == true) { 
		p_r = false;
		pl = 0;
		if (Math.floor(Math.random()*2) == 1) { p_r = true; } // Deslizado izquierda/derecha aleatorio.
		var p_st = setInterval("pscr()", 95); // Inicia deslizado cada 95ms (10 veces por segundo)
		var p_st_close = setTimeout("pscr_close()", 180000); // Detiene deslizado tras 3 min.
	}

	// Popup de info de ciudadanos.
	$(".nick").mouseover(function(){
		var wnick = $(this).text();
		if (!whois_cache[wnick]) { pnick = setTimeout(function(){ $.post("/ajax.php", { a: "whois", nick: wnick }, function(data){ $("#pnick").css("display","none"); whois_cache[wnick] = data; print_whois(data, wnick); }); }, 500);
		} else { print_whois(whois_cache[wnick], wnick); }
	}).mouseout(function(){ clearTimeout(pnick); pnick = ""; $("#pnick").css("display","none"); });
	$(document).mousemove(function(e){ $("#pnick").css({top: e.pageY + "px", left: e.pageX + 15 + "px"}); });

	// Mensajes emergentes de ayuda.
	$(".ayuda").hover(
		function () {
			var txt = $(this).val();
			$(this).append('<span class="ayudap">' + txt + '</span>');
		}, 
		function () { $(".ayudap").remove(); }
	);

	setInterval("actualizar_noti()", 180000); // Actualiza notificaciones cada 3 min.
});



/*** FUNCIONES ***/


function pscr() {
	// Esta funcion es critica, debe optimizarse al máximo. Se ejecuta 10 veces por segundo.
	if (p_scroll == true) {
		if (p_r == true) { pl++; } else { pl--; }
		document.getElementById('menu-noti').style.backgroundPosition = pl + 'px 0';
	} else { if (p_st) { clearInterval(p_st); } }
}
function pscr_close() { p_scroll = false; }

function actualizar_noti() { 
	$('#notif').load('/ajax.php?a=noti');
	if (p_scroll == false) { clearInterval(p_st); }
	search_timers();
}

function votar(voto, tipo, item_ID) {
	var radio_ID = tipo + item_ID;
	$(".radio_" + radio_ID).blur();
	var voto_pre = parseInt($("#data_" + radio_ID).val());
	if (voto_pre == voto) { voto = 0; $(".radio_" + radio_ID).removeAttr("checked"); }
	$.get("/accion.php", { a: "voto", tipo: tipo, item_ID: item_ID, voto: voto }, function(data){
		if (data) {
			if (data == "false") {
				$(".radio_" + radio_ID).removeAttr("checked");
				alert("El voto no se ha podido realizar.");
			} else if (data == "limite") {
				$(".radio_" + radio_ID).removeAttr("checked");
				alert("Has llegado al limite de votos emitibles.");
			} else {
				if (tipo != "confianza") { $("#" + radio_ID).html(print_votonum(data)); }
				$("#data_" + radio_ID).attr("value", voto);
			}
		}
	});
}
function print_votonum(num) {
	var num = parseInt(num);
	if (num >= 10) { return "<span class=\"vcc\">+" + num + "</span>"; }
	else if (num >= 0) { return "<span class=\"vc\">+" + num + "</span>"; } 
	else if (num > -10) { return "<span class=\"vcn\">" + num + "</span>"; }
	else { return "<span class=\"vcnn\">" + num + "</span>"; }
}



function print_whois(whois, wnick) {
	var w = whois.split(":"); print_votonum(w[13])
	if (!whois) { $("#pnick").html("&dagger;"); } else {
	if (w[6] == 1) { var wa = "<img src=\"" + IMG + "a/" + w[0] + ".jpg\" style=\"float:right;margin:0 -6px 0 0;\" />"; } else { var wa = ""; }
	if (w[11] != 0) { var wc = "<img src=\"" + IMG + "cargos/" + w[11] + ".gif\" width=\"16\" /> "; } else { var wc = ""; }
	if (w[9] == "expulsado") { var exp = "<br /><b style=\"color:red;\">" + w[12] + "</b>"; } else { var exp = ""; }
		
		$("#pnick").html("<legend>" + wc + "<b style=\"color:grey;\"><span style=\"color:#555;\">" + wnick + "</span> (<span class=\"" + w[9] + "\">" + w[9].substr(0,1).toUpperCase() + w[9].substr(1,w[9].length) + "</span> de " + w[10] + ")</b>" + exp + "</legend>" + wa + "Confianza: " + print_votonum(w[13]) + "<br /><!--Afil: <b>" + w[7] + "</b><br />-->Foro: <b>" + w[8] + "</b><br /><br />Online: <b>" + w[5] + "</b><br />Ultimo acceso: <b>" + w[2] + "</b><br />Registrado: <b>" + w[1] + "</b>").css("display","inline");
	}
}


function search_timers() {
	var ts = Math.round((new Date()).getTime() / 1000);
	$(".timer").each(function (i) {
		var cuando = $(this).val();
		$(this).text(hace(cuando, ts, 1, false));
	});
}

function hace(cuando, ts, num, pre) {
	tiempo = (cuando - ts);
	if (pre) { if (tiempo >= 0) { pre = _["En"]; } else { pre = _["Hace"]; } }
	tiempo = Math.abs(tiempo);
	
	var periods_sec = new Array(2419200, 86400, 3600, 60, 1);
	var periods_txt = new Array(_["meses"], _["días"], _["horas"], _["min"], _["seg"]);

	if (pre) { var duracion = pre + " "; } else { var duracion = ""; }

	tiempo_cont = tiempo;
	nm = 0;
	for (n in periods_sec) {
		sec = periods_sec[n];
		if ((nm < num) && ((tiempo_cont >= (sec*2)) || (n == 4))) {
			period = Math.floor(tiempo_cont / sec);
			if (n == 4) { 
				duracion += _["Segundos"];
			} else {
				duracion += period + " " + periods_txt[n];
			}
			if ((num != 1) && (n != 4)) { if (n != 3) { duracion += ", "; } else { duracion += " y "; } }
			tiempo_cont = tiempo_cont - (period * sec);
			nm++;
		}
	}
	return duracion;
}





function enriquecer(m, bbcode) {

	// Emoticonos
	m = m.replace(/(\s|^):\)/gi,			' <img src="'+IMG+'smiley/sonrie.gif" border="0" alt=":)" title=":)" width="15" height="15" />');
	m = m.replace(/(\s|^):\(/gi,			' <img src="'+IMG+'smiley/disgustado.gif" border="0" alt=":(" title=":(" width="15" height="15" />');
	m = m.replace(/(\s|^):\|/gi,			' <img src="'+IMG+'smiley/desconcertado.gif" border="0" alt=":|" title=":|" width="15" height="15" />');
	m = m.replace(/(\s|^):D/gi,				' <img src="'+IMG+'smiley/xd.gif" alt=":D" border="0" title=":D" width="15" height="15" />');
	m = m.replace(/(\s|^):\*/gi,			' <img src="'+IMG+'smiley/muacks.gif" alt=":*" border="0" title=":*" width="15" height="15" />');
	m = m.replace(/(\s|^);\)/gi,			' <img src="'+IMG+'smiley/guino.gif" alt=";)" border="0" title=";)" width="15" height="15" />');
	m = m.replace(/(\s|^):O/gi,				' <img src="'+IMG+'smiley/bocaabierta.gif" alt=":O" border="0" title=":O" width="15" height="15" />');
	m = m.replace(/:(tarta|roto2|palm|moneda):/gi,	' <img src="'+IMG+'smiley/$1.gif" alt=":$1:" border="0" title=":$1:" width="16" height="16" />');
	m = m.replace(/(\s|^)(:troll:)/gi,			' <img src="'+IMG+'smiley/troll.gif" alt=":troll:" border="0" title=":troll:" width="15" height="15" />');
	m = m.replace(/(\s|^)(:falso:)/gi,			' <img src="'+IMG+'smiley/sonrie.gif" border="0" alt=":falso:" title=":falso:" width="15" height="15" onMouseOver="$(this).attr(\'src\', \''+IMG+'smiley/troll.gif\');" />');


	// URLs
	m = m.replace(/(\s|^|>)(\/[-A-Z0-9\/_]{3,})/ig, ' <a href="$2" target="_blank">$2</a>'); // /url
	m = m.replace(/(\s|^|>)@([-A-Z0-9_]{2,20})/ig, ' <a href="/perfil/$2" class="nick">@<b>$2</b></a>'); // @nick
	m = m.replace(/(\s|^|>)(\b(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig, ' <a href="$2" target="_blank">$2</a>');

	// BBCODE
	if (bbcode) {
		m = m.replace(/\[(b|i|em|s)\](.*?)\[\/\1\]/gi, '<$1>$2</$1>'); 
		m = m.replace(/\[img\](.*?)\[\/img\]/gi, '<img src="$1" alt="img" style="max-width:800px;" />');
		m = m.replace(/\[youtube\]http\:\/\/www\.youtube\.com\/watch\?v=(.*?)\[\/youtube\]/gi, '<iframe width="520" height="390" src="http://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>');
		m = m.replace(/\[quote\]/gi, '<blockquote><div class="quote">');
		m = m.replace(/\[quote=(.*?)\]/gi, '<blockquote><div class="quote"><cite>$1 escribió:</cite>');
		m = m.replace(/\[\/quote\]/gi, '</div></blockquote>');
	}

	return m;
}

function html_instant(nom, width) {
	return '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" title=":' + nom + ':" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" height="' + width + '" width="' + width + '"><param name="quality" value="high" /><param name="wmode" value="transparent" /><param name="movie" value="' + IMG + 'instant/' + nom + '.swf" /><embed style="margin:0 0 -3px 0;" height="' + width + '" pluginspage="http://www.macromedia.com/go/getflashplayer" quality="high" src="' + IMG + 'instant/' + nom + '.swf" type="application/x-shockwave-flash" width="' + width + '" wmode="transparent"></embed></object>';
}