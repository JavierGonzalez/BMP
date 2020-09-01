<?php # BMP — Javier González González


if ($maxsim['template']['title'])
    $maxsim['template']['title'] = $maxsim['template']['title'].' | BMP';
else
    $maxsim['template']['title'] = 'The Bitcoin Mining Parliament (BMP)';


$maxsim['template']['autoload']['css'][] = '/lib/bootstrap-4.3.1/css/bootstrap.min.css';
$maxsim['template']['autoload']['css'][] = '/template/style.css';

$maxsim['template']['js'] .= "\n".'bmp_protocol_prefix = "'.BMP_PROTOCOL['prefix'].'";'."\n".
    'url_explorer_tx = "'.URL_EXPLORER_TX.'";'."\n";

$maxsim['template']['autoload']['js'] = array_merge([
    '/lib/jquery-3.4.1.min.js',
    '/lib/bootstrap-4.3.1/js/bootstrap.min.js',
    '/bmp.js',
    '/bmp_trezor.js',
    '/lib/trezor-connect-7.js',
    ], (array)$maxsim['template']['autoload']['js']);

?><!DOCTYPE html>
<html lang="en">
<head>

<title><?=$maxsim['template']['title']?></title>

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<meta name="description" content="BMP. The Bitcoin Mining Parliament. A hashpower voting system. Blockchain, on-chain vote, decentralized, open-source. Bitcoin Cash." />
<meta name="author" content="Javier González González — gonzo@virtualpol.com" />

<link rel="stylesheet" enctype="text/css" href="/lib/bootstrap-4.3.1/css/bootstrap.min.css" />
<?php

foreach ((array)$maxsim['template']['autoload']['css'] AS $file)
	echo '<link rel="stylesheet" enctype="text/css" href="'.$file.'" media="all" />'."\n";

echo '
    <style type="text/css">
    '.$maxsim['template']['css'].'
    </style>';

?>

<script type="text/javascript">
<?php
foreach ((array)$maxsim['template']['js_array'] AS $key => $value)
    echo $key.' = "'.str_replace('"', '\"', $value).'";'."\n";
?>
</script>

</head>


<body style="overflow-y:scroll;">


<div id="content_left">
	
    <?php include('menu.php'); ?>
	
</div>



<div id="content_right">


    <div id="top_right">
        
        <?=$maxsim['template']['top_right']?> 
        
        <span id="print_login"></span>

    </div>


	<div id="content">

        <div style="font-size:20px;color:red;font-weight:bold;"></div>
    
	    <?=$echo?>

	</div>


	<div id="footer" style="color:#777;">

		<?php include('footer.php'); ?>

	</div>

</div>




<?php
foreach ($maxsim['template']['autoload']['js'] AS $file)
	echo '<script type="text/javascript" enctype="application/javascript" src="'.$file.'"></script>'."\n";
?>

<script type="text/javascript">
<?=$maxsim['template']['js']?>
</script>

</body>
</html>