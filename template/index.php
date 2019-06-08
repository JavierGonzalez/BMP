<?php # maximum_simplicity

header('Content-Type: text/html; charset=utf-8');


if ($_template['title'])
	$_template['title'] = 'BMP | '.$_template['title'];
else
	$_template['title'] = 'BMP';


$_template['lib_css'][] = '/template/style.css';


$_template['js'] .= '
        bmp_protocol_prefix = "'.$bmp_protocol['prefix'].'";
    ';


?><!DOCTYPE html>
<html lang="en">
<head>

<title><?=$_template['title']?></title>

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta name="description" content="<?=$_template['title']?>" />


<!--<link rel="shortcut icon" href="/template/favicon.ico" />-->


<?php

foreach ((array)$_template['lib_css'] AS $file)
	echo '<link rel="stylesheet" type="text/css" href="'.$file.'" media="all" />'."\n";


echo '
<style type="text/css">
'.$_template['css'].'
</style>';


?>

</head>


<body style="overflow-y:scroll;">

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
			
		</div>



		<div id="header-tab">
			<ul class="ttabs left">
				<?php 
				foreach ((array)$_template['tabs'] AS $u => $a)
					echo '<li'.($_SERVER['REQUEST_URI']===$u?' class="current"':'').'><a href="'.(!is_numeric($u)?$u:'#').'">'.$a.'</a></li>';
				
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


<script type="text/javascript" src="/lib/jquery-3.4.1.min.js"></script>
<?php
foreach ((array)$_template['lib_js'] AS $file)
	echo '<script type="text/javascript" src="'.$file.'"></script>'."\n";
?>
<script type="text/javascript">
<?=$_template['js']?>
</script>

</body>
</html>