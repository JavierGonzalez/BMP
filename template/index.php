<?php

header('Content-Type: text/html; charset=utf-8');


$_template['title'] = 'BMP · '.$_template['title'];


?><!DOCTYPE html>
<html lang="en">
<head>
<title><?=$_template['title']?></title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta name="description" content="<?=$_template['title']?>" />




<link rel="stylesheet" type="text/css" href="/template/style_all.css" media="all" />
<link rel="stylesheet" type="text/css" href="/template/style2.css" media="all" />
<?php
foreach ((array)$_template['lib_css'] AS $file)
	echo '<link rel="stylesheet" type="text/css" href="'.$file.'" media="all" />';
?>
<style type="text/css">
#header { background:#FFF <?=$body_bg?> repeat scroll top left; }
</style>


<script type="text/javascript" src="/template/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/template/scripts2.js"></script>
<?php
/*
foreach ((array)$_template['lib_js'] AS $file)
	echo '<script type="text/javascript" src="'.$file.'"></script>';
*/
?>
<script type="text/javascript">
IMG = '/public/static/old/img/';
ACCION_URL = "/";
p_scroll = false;
</script>


<!--<link rel="shortcut icon" href="/template/favicon.ico" />-->

<?=$_template['header']?>


</head>


<body>

<div id="content-left">
	
	<a href="/" style="font-size:50px;margin-left:50px;">BMP</a>
	
    <?php include('template/menu.php'); ?>
	
</div>




<div id="content-right">

	<div id="header">

		<div id="header-logo">
			<span class="htxt" id="header-logo-p"></span>
		</div>

		<div id="header-right">
			<?php
			/*
			unset($txt_header);
			if (isset($pol['user_ID'])) {
				echo '<span class="htxt">'.($pol['estado']=='extranjero'||$pol['estado']=='turista'?'<span style="margin-left:-10px;">'.boton(_('Solicitar ciudadanía'), REGISTRAR, false, 'small red').'</span>':'').' <a href="/perfil/'.$pol['nick'].'"><b>'.$pol['nick'].'</b>'.($pol['cargo']!=0&&$pol['cargo']!=99?' <img src="/img/cargos/'.$pol['cargo'].'.gif" width="16" height="16" alt="cargo" />':'').'</a>'.($pol['estado']!='ciudadano'?' (<b class="'.$pol['estado'].'">'.ucfirst($pol['estado']).'</b>)':'').(nucleo_acceso('supervisores_censo')?' | <a href="/sc">SC</a>':'').($pol['estado']=='extranjero'?'':' | <a href="/msg" title="'._('Mensajes privados').'"><span class="icon medium" data-icon="@"></span></a> ').(ECONOMIA&&$pol['estado']=='ciudadano'?' | <a href="/pols"><b>'.pols($pol['pols']).'</b> '.MONEDA.'</a>':'').' | <a href="'.REGISTRAR.'login.php?a=panel" title="'._('Opciones').'"><span class="icon medium" data-icon="z"></span></a> | <a href="'.accion_url().'a=logout"><b>'._('Salir').'</b></a></span>';
			} else {
				echo boton(_('Crear ciudadano'), REGISTRAR.'?p='.PAIS, false, 'large green').' '.boton(_('Iniciar sesión'), REGISTRAR.'login.php?r='.base64_encode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']), false, 'large blue');
			}
			*/
			?>
		</div>



		<div id="header-tab">
			<ul class="ttabs left">
				<?php 
				foreach ((array)$_template['tabs'] AS $u => $a) { 
					echo '<li'.(!is_numeric($u)&&$_SERVER['REQUEST_URI']==$u?' class="current"':'').'><a href="'.(!is_numeric($u)?$u:'#').'">'.$a.'</a></li>';
				}
				// if (isset($txt_help)) { echo '<li onclick="$(\'#txt_help\').slideToggle(\'fast\');"><a href="#"><img src="/img/varios/help.gif" alt="ayuda" width="22" height="22" style="margin:-5px -9px;" /></a></li>'; }
				?>
			</ul>
		</div>

	</div>



	<div id="content">
	    <?=$_['output_html_content']?>
	</div>



	<div id="footer">
		<?php include('template/footer.php'); ?>
	</div>
</div>

<fieldset id="pnick" style="display:none;"></fieldset>


</body>
</html>