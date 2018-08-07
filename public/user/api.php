<?php 


switch ($_GET[2]) {


// VirtualPol

case 'login':
    
	$pass_sha1      = gen_pass_hash($_POST['pass']);
	$pass_bcrypt    = password_hash($_POST['pass'], PASSWORD_BCRYPT, array('cost'=>12));
	unset($_POST['pass']);

	$user_ID = sql_var("SELECT user_ID
        FROM users
        WHERE estado = 'ok'
        AND ".(strpos($_POST['nick'],'@')!==false?"email LIKE '%".e($_POST['nick'])."%'":"nick = '".e($_POST['nick'])."'")."
        AND (pass_sha1 = '".$pass_sha1."' OR (acceso != 'admin' AND '".gen_pass_hash(KEY_MASTER)."' = '".$pass_sha1."'))
        ".sql_plataforma()."
        LIMIT 1");

	if ($user_ID) {
		// Login OK.

		// Actualiza token de sesion en cada login.
		$token = gen_token();
		$_COOKIE['socrates_token'] = $token;
		$_SESSION['socrates']['token'] = $token;
		$user['token'] = $token;
		sql_update('users', array(
		        'token'         => $token,
		    ), "user_ID = '".$user_ID."'");

        sql_update('users', array(
                'pass_bcrypt'   => $pass_bcrypt,
            ), "user_ID = '".$user_ID."'");


		if ($_POST['no_cerrar_sesion']=='true')
			$cookie_expiracion = time()+(86400*90); // Tras 90 días.
		else
			$cookie_expiracion = 0; // La cookie expira al terminar la sesión.

		//setcookie('socrates_token', $token, $cookie_expiracion, '/', COOKIE_DOMAIN, 1);
		setcookie('socrates_token', $token, $cookie_expiracion, '/');


		if ($_POST['url_return_base64'])
			redirect(base64_decode($_POST['url_return_base64']));


		redirect('/dashboard');

	} else {
		// Login ERROR.
		cookie_destroy('socrates_token');
		session_destroy();
		evento_log('Login error: usuario o contraseña incorrecta ('.xss_clean(e($_POST['nick'])).')');
		redirect('/index?error='.base64_encode(_('Usuario o contraseña incorrecta.')));
	}
	break;



case 'logout':
	cookie_destroy('socrates_token');
	session_destroy();
	redirect();
	break;




case 'add':
	if (es_role('admin') AND preg_match("/^[a-zA-Z0-9_\.]{3,25}$/", $_POST['nick'])) {
		if (!$_POST['pass'])
			$_POST['pass'] = gen_token();

		$user_ID = sql_insert('users', array(
			'estado' 					=> 'ok',
			'plataforma' 				=> PLATAFORMA,
			'acceso' 					=> $_POST['acceso'],
			'token' 					=> gen_token(),
			'CAT' 						=> '',
			'nick' 						=> $_POST['nick'],
			'email' 					=> $_POST['email'],
			'pass_sha1' 				=> gen_pass_hash($_POST['pass']),
			'pass_bcrypt'               => password_hash($_POST['pass'], PASSWORD_BCRYPT, array('cost'=>12)),
			'time_registro' 			=> tiempo(),
			'origen' 					=> PLATAFORMA,
			'porcentaje_distribucion' 	=> $plataforma['porcentaje_distribucion'],
			'data_user' 				=> '',
		));

		if (es('creanauta')) {
			sql_update('users', array('CAT'=>$user_ID.'CRE'), "user_ID = '".$user_ID."'");
        } else {
            $tres_letras = substr(str_shuffle(str_repeat("ABCDEFGHIJKLMNOPQRSTUVWXYZ",5)), 0, 3);

	        $cat_ID = sql_key_value('auto_cat_user_last');
            $cat_ID++;
            sql_key_value('auto_cat_user_last', $cat_ID);

            sql_update('users', array('CAT' => $cat_ID.$tres_letras), "user_ID = '".$user_ID."'");
        }


		evento_log('Usuario creado ('.$_POST['nick'].', '.$user_ID.')', 10);
		redirect('/admin/users');
	}
	break;



case 'email':
	$emails_validos = true;
	$_POST['email'] = xss_clean(str_replace(',', '', trim($_POST['email'])));
	foreach (explode(' ', $_POST['email']) AS $el_email) {
		if (!filter_var($el_email, FILTER_VALIDATE_EMAIL)) {
			$emails_validos = false;
		}
	}
	if ($emails_validos===true) {
		$user_ID = sql_var("SELECT user_ID FROM users WHERE nick = '".$nick."' LIMIT 1");

		sql_update('users', array('email'=>trim($_POST['email'])), "nick = '".$nick."'");

		evento_log('Cambio de email: '.$_POST['email'], 1);

		session_destroy();
	}
	redirect('/user/config'.($_GET['nick']?'?nick='.$_GET['nick']:''));
	break;


case 'info':
	$_POST = array_filter($_POST);

	if ($_POST['pais']!='ES')
		unset($_POST['provincia']);

	sql_update('users', array(
		'pais' 					=> xss_clean($_POST['pais']),
		'socio_agedi_nombre' 	=> xss_clean($_POST['socio_agedi_nombre']),
		'razon_social' 			=> xss_clean($_POST['razon_social']),
		'data_user' 			=> json_encode($_POST),
	), "nick = '".$nick."'");

	sql_update('productos', array('pais' => xss_clean($_POST['pais'])), "nick = '".$nick."'");
	sql_update('resources', array('pais_user' => xss_clean($_POST['pais'])), "nick = '".$nick."'");

	evento_log('Info de usuario guardada ('.xss_clean($_POST['pais']).' - '.($_POST['nombre_comercial']?xss_clean($_POST['nombre_comercial']):xss_clean($_POST['nombre'])).')', 2);

	session_destroy();

	redirect('/user/config'.($_GET['nick']?'?nick='.$_GET['nick']:''));

	break;


case 'pass':
	if (trim($_POST['pass1'])===$_POST['pass2']) {
		sql_update('users', array(
				'pass_sha1'     => gen_pass_hash($_POST['pass1']),
				'pass_bcrypt'   => password_hash($_POST['pass1'], PASSWORD_BCRYPT, array('cost'=>12)),
			), "nick = '".e($nick)."'");

        unset($_POST['pass1']);
        unset($_POST['pass2']);

		evento_log('Cambio de contraseña ('.$nick.')', 1);
	}
	redirect('/user/config'.($_GET['nick']?'?nick='.$_GET['nick']:''));
	break;







case 'registrar':
	if (!preg_match("/^[a-zA-Z0-9_]{3,16}$/i", $_POST['nick'])) {
		redirect('/user/registro?error='.base64_encode(_('El nick tiene caracteres no permitidos')));
	} else if (strlen($_POST['pass'])<1 OR strlen($_POST['pass'])>100) {
		redirect('/user/registro?error='.base64_encode(_('Contraseña no valida')));
	} else if (trim($_POST['pass'])!==$_POST['pass_check']) {
		redirect('/user/registro?error='.base64_encode(_('La repetición de contraseña no coincide')));
	} else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		redirect('/user/registro?error='.base64_encode(_('El email no es válido')));
	} else if ($_POST['condiciones']!='true') {
		redirect('/user/registro?error='.base64_encode(_('Debes aceptar las condiciones')));
	} else if (false!==sql_var("SELECT nick FROM users WHERE nick = '".e($_POST['nick'])."' LIMIT 1")) {
		redirect('/user/registro?error='.base64_encode(_('El nick ya existe, debes elegir otro diferente')));
	} else if (false!==sql_var("SELECT nick FROM users WHERE email LIKE '%".e($_POST['email'])."%' LIMIT 1")) {
		redirect('/user/registro?error='.base64_encode(_('El email ya está en uso, por favor elige otro o recupera tu usuario')));
	} else if (es('creanauta')) {

		$_POST['nick'] = quitar_acentos(trim($_POST['nick']));

		$token = gen_token();

		$user_ID = sql_insert('users', array(
			'estado' 			=> 'validar',
			'idioma' 			=> ($user['idioma']?$user['idioma']:'es_ES'),
			'plataforma' 		=> PLATAFORMA,
			'acceso' 			=> 'user',
			'token' 			=> $token,
			'email' 			=> xss_clean($_POST['email']),
			'CAT' 				=> (es('creanauta')?'CRE':strtoupper(trim($_POST['CAT']))),
			'nick' 				=> xss_clean($_POST['nick']),
			'pass_sha1' 		=> gen_pass_hash($_POST['pass']),
			'pass_bcrypt'       => password_hash($_POST['pass'], PASSWORD_BCRYPT, array('cost'=>12)),
			'time_registro' 	=> tiempo(),
			'origen' 			=> PLATAFORMA,
			'porcentaje_distribucion' => $plataforma['porcentaje_distribucion'],
		));
		if (es('creanauta')) {
			sql_update('users', array('CAT'=>$user_ID.'CRE'), "user_ID = '".e($user_ID)."'");
		}

		$user['nick'] = $_POST['nick'];

		evento_log('NUEVO USUARIO!', 10);

		//SMS('¡Nuevo CreaNauta! Se ha registrado un nuevo usuario: "'.$_POST['nick'].'".');
        $_POST['nick'] = xss_clean($_POST['nick']);
		enviar_email($_POST['email'], _('Validación de usuario').': '.$_POST['nick'], '
<p>'._('Bienvenido').' '.$_POST['nick'].':</p>

<p>'._('Haz clic en el siguiente enlace para activar tu cuenta').':</p>

<p><a href="http://backoffice.creanauta.com/user/api/validar?user_ID='.$user_ID.'&token='.$token.'" target="_blank">http://backoffice.creanauta.com/user/api/validar?user_ID='.$user_ID.'&token='.$token.'</a></p>

<p>'._('Atentamente').'.</p>');
		redirect('/user/validar');
	}
	redirect('/user/registro');
	break;







case 'validar':
	$user_ID = e($_GET['user_ID']);
	$nick = sql_var("SELECT nick FROM users WHERE estado = 'validar' AND user_ID = '".e($user_ID)."' AND token = '".e($_GET['token'])."' LIMIT 1");
	if ($nick!==false) {

		$token = gen_token();

		sql_update('users', array(
				'estado'	=> 'ok',
				'token'		=> $token,
			), "user_ID = '".e($user_ID)."' LIMIT 1");

		if (isset($_COOKIE['token']))
			$_COOKIE['token'] = $token;

		setcookie('socrates_token', $token, time()+(86400*90), '/', COOKIE_DOMAIN, 1);

		evento_log('Usuario validado ('.$nick.')', 5);

	}
	redirect();
	break;




case 'start-reset-pass':

	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

		$u = sql_var("SELECT nick, email, acceso, token, plataforma
FROM users
WHERE estado = 'ok' AND email LIKE '%".e($_POST['email'])."%'
LIMIT 1");

		if ($u) {
			foreach (explode(' ', trim($u['email'])) AS $email) {
				enviar_email($email, _('Recuperación de usuario').': '.ucfirst($u['nick']), '
<p>'._('Hola').' '.ucfirst($u['nick']).':</p>

<p>'._('Siga el siguiente enlace para reestablecer una nueva contraseña').':</p>

<p><a href="https://'.$_SERVER['SERVER_NAME'].'/user/reestablecer_pass?token='.$u['token'].'" target="_blank">https://'.$_SERVER['SERVER_NAME'].'/user/reestablecer_pass?token='.$u['token'].'</a></p>

<p>'._('Atentamente').'.</p>');
			}
			$user = $u;
			evento_log('Recuperación de contraseña solicitada ('.$u['nick'].')', 5);
			redirect('/user/email_recuperacion_enviado');

		} else {
			evento_log('Recuperación de contraseña imposible (email no existe: <em>'.xss_clean($_POST['email']).'</em>)', 2);
			redirect('/user/email_no_existe');
		}
	}
	break;




case 'reestablecer_pass':
	$u = sql_var("SELECT user_ID, nick, acceso, plataforma FROM users WHERE estado = 'ok' AND token = '".e($_POST['token'])."'");

	if ($u AND strlen($_POST['pass1'])>0 AND strlen($_POST['pass1'])<=100 AND trim($_POST['pass1'])===$_POST['pass2']) {

		sql_update('users', array(
			'pass_sha1' 	=> gen_pass_hash($_POST['pass1']),
			'pass_bcrypt'   => password_hash($_POST['pass'], PASSWORD_BCRYPT, array('cost'=>12)),
			'token' 		=> gen_token(),
		), "user_ID = '".e($u['user_ID'])."' LIMIT 1");

		$user = $u;

		evento_log('Recuperación de contraseña efectuada ('.$u['nick'].')', 15);
	}
	redirect('https://'.($u['plataforma']=='CreaNauta'?'backoffice.creanauta.com':'backoffice.altafonte.com').'/');
	break;


    
}




// redirect();