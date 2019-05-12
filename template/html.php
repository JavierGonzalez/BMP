<?php # simple_framework



header('Content-Type: text/html; charset=utf-8');


$output_content = ob_get_contents();
ob_end_clean();


?><!DOCTYPE html>
<html lang="en">
<head>
<title><?=$_['template']['html']['title']?></title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta name="description" content="<?=$_['template']['html']['title']?>" />


<link rel="stylesheet" type="text/css" href="/static/img/style_all.css" media="all" />
<link rel="stylesheet" type="text/css" href="/static/img/style2.css" media="all" />
<style type="text/css">
#header { background:#FFF <?=$body_bg?> repeat scroll top left; }
</style>


<script type="text/javascript" src="/static/img/lib/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/static/img/scripts2.js"></script>
<?php
foreach ((array)$_['template']['html']['lib']['js'] AS $file)
	echo '<script type="text/javascript" src="'.$file.'"></script>';
?>
<script type="text/javascript">
IMG = '/static/img/';
ACCION_URL = "/";
p_scroll = false;
</script>


<!--<link rel="shortcut icon" href="/static/img/favicon.ico" />-->

<?=$_['template']['html']['header']?>


</head>


<body>

<div id="content-left">
	
	<a href="/" style="font-size:50px;margin-left:50px;">BMP</a>
	
    <?php include('template/html_menu.php'); ?>

	<div id="menu-next"></div>
</div>




<div id="content-right">

	<div id="header">

		<div id="header-logo">
			<span class="htxt" id="header-logo-p"><?=$pol['config']['pais_des']?></span>
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
			<ul class="ttabs right">
				<?php 
				foreach ((array)$_['template']['html']['tabs'] AS $u => $a) { 
					echo '<li'.(!is_numeric($u)&&$_SERVER['REQUEST_URI']==$u?' class="current"':'').'><a href="'.(!is_numeric($u)?$u:'#').'">'.$a.'</a></li>'; 
					
				}
				// if (isset($txt_help)) { echo '<li onclick="$(\'#txt_help\').slideToggle(\'fast\');"><a href="#"><img src="/img/varios/help.gif" alt="ayuda" width="22" height="22" style="margin:-5px -9px;" /></a></li>'; }
				?>
			</ul>
		</div>

	</div>



	<div id="content">
	    <?php echo $output_content; ?>
	</div>



	<div id="footer">

		<div id="footer-right" style="text-align:center;">
			
			<p></p>
			
			<p>
				Bitcoin Mining Parliament
				<br />
			    <a target="_blank" href="/papers"><?=_('Papers')?></a> | <a target="_blank" href="/about"><?=_('About')?></a>
    			<br />
    			2017-2018
    		</p>
    		
    		<p style="color:#999;">
    			<?php echo num((microtime(true)-$_['crono_start'])*1000, 2).'ms '.num(memory_get_usage()/1000).'kb'; ?>
			</p>
		</div>
		
		<div id="footer-left">

		</div>
	</div>
</div>

<fieldset id="pnick" style="display:none;"></fieldset>


</body>
</html>