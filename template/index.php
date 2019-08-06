<?php # BMP — Javier González González

header('Content-Type: text/html; charset=utf-8');


if ($_template['title'])
	$_template['title'] = 'BMP | '.$_template['title'];
else
	$_template['title'] = 'BMP';



$_template['lib_css'][] = '/lib/bootstrap-4.3.1/css/bootstrap.min.css';
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

<link rel="stylesheet" href="/lib/bootstrap-4.3.1/css/bootstrap.min.css">
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


<div id="content_left">
	
    <?php include('template/menu.php'); ?>
	
</div>



<div id="content_right">

    <div id="top_right">
        <?=$_template['top_right']?> 
        <span id="print_login"></span>
    </div>

	<div id="content">
	    <?=$_output_html_content?>
	</div>

	<div id="footer" style="color:#777;">
		<?php include('template/footer.php'); ?>
	</div>

</div>



<script type="text/javascript" src="/lib/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="/lib/bootstrap-4.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/public/bmp.js"></script>
<script type="text/javascript" src="/lib/trezor-connect-7.js"></script>

<?php
foreach ((array)$_template['lib_js'] AS $file)
	echo '<script type="text/javascript" src="'.$file.'"></script>'."\n";
?>

<script type="text/javascript">
<?=$_template['js']?>
</script>

</body>
</html>