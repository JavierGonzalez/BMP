<?php # maximum_simplicity

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









<table id="main_grid" border=1 width="100%" height="100%" style="margin:0;">

<tr>
<td rowspan=2 valign=top width="180" style="padding:0;">

<a href="/" style="font-size:50px;margin-left:35px;">BMP</a>

<?php include('template/menu.php'); ?>

</td>
<td valign=top>

<?=$_['output_html_content']?>

</td>
</tr>

<tr>
<td valign=top height="100" style="padding:10px;">

<?php include('template/footer.php'); ?>

</td>
</tr>


</table>




<script type="text/javascript" src="/lib/jquery-3.4.1.min.js"></script>
<script src="/lib/popper-1.15.0.min.js"></script>
<script src="/lib/bootstrap-4.3.1/js/bootstrap.min.js"></script>

<?php
foreach ((array)$_template['lib_js'] AS $file)
	echo '<script type="text/javascript" src="'.$file.'"></script>'."\n";
?>

<script type="text/javascript">
<?=$_template['js']?>
</script>

</body>
</html>


