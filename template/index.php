<?php # BMP — Javier González González


$__template['title'] = 'BMP'.($__template['title']?' | '.$__template['title']:'');


$__template['lib_css'][] = '/lib/bootstrap-4.3.1/css/bootstrap.min.css';
$__template['lib_css'][] = '/template/style.css';

$__template['js'] .= "\n".'bmp_protocol_prefix = "'.BMP_PROTOCOL['prefix'].'";'."\n";

$__template['lib_js'] = array_merge([
    '/lib/jquery-3.4.1.min.js',
    '/lib/bootstrap-4.3.1/js/bootstrap.min.js',
    '/public/bmp.js',
    '/lib/trezor-connect-7.js',
    ], (array)$__template['lib_js']);


?><!DOCTYPE html>
<html lang="en">
<head>

<title><?=$__template['title']?></title>

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<meta name="description" content="<?=$__template['title']?>" />
<meta name="author" content="Javier González González — gonzo@virtualpol.com" />

<link rel="shortcut icon" href="/template/favicon.ico" />

<link rel="stylesheet" enctype="text/css" href="/lib/bootstrap-4.3.1/css/bootstrap.min.css">
<?php

foreach ((array)$__template['lib_css'] AS $file)
	echo '<link rel="stylesheet" enctype="text/css" href="'.$file.'" media="all" />'."\n";

echo '
    <style type="text/css">
    '.$__template['css'].'
    </style>';

?>

</head>


<body style="overflow-y:scroll;">


<div id="content_left">
	
    <?php include('template/menu.php'); ?>
	
</div>



<div id="content_right">


    <div id="top_right">
        
        <?=$__template['top_right']?> 
        
        <span id="print_login"></span>

    </div>


	<div id="content">

        <div style="font-size:20px;color:red;font-weight:bold;"></div>
    
	    <?=$__output_html?>

	</div>


	<div id="footer" style="color:#777;">

		<?php include('template/footer.php'); ?>

	</div>

</div>




<?php
foreach ($__template['lib_js'] AS $file)
	echo '<script type="text/javascript" enctype="application/javascript" src="'.$file.'"></script>'."\n";
?>

<script type="text/javascript">
<?=$__template['js']?>
</script>

</body>
</html>