<?php # BMP — Javier González González


if (!$maxsim['template']['title'])
    $maxsim['template']['title'] = 'The Bitcoin Mining Parliament';

$maxsim['template']['title'] .= ' | BMP';

$maxsim['autoload'][] = 'lib/bootstrap-4.3.1/css/bootstrap.min.css';
$maxsim['autoload'][] = 'template/style.css';

$maxsim['autoload'] = array_merge([
    'lib/jquery-3.4.1.min.js',
    'lib/bootstrap-4.3.1/js/bootstrap.min.js',
    'lib/trezor-connect-6.js',
    ], (array)$maxsim['autoload']);
    

$maxsim['template']['js'] .= "\n".'bmp_protocol_prefix = "'.BMP_PROTOCOL['prefix'].'";'."\n".
    'url_explorer_tx = "'.URL_EXPLORER_TX.'";'."\n";


?><!DOCTYPE html>
<html lang="en">
<head>

<title><?=$maxsim['template']['title']?></title>

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<meta name="description" content="The Bitcoin Mining Parliament (BMP). A hashpower voting system. Blockchain, on-chain vote, decentralized, open-source. Bitcoin Cash, BCH." />
<meta name="author" content="Javier González González — gonzo@virtualpol.com" />

<link rel="shortcut icon" href="/template/favicon.ico" type="image/x-icon" />

<?php

foreach ((array)$maxsim['autoload'] AS $file)
    if (substr($file,-4)==='.css')
	    echo '<link rel="stylesheet" enctype="text/css" href="/'.$file.'" media="all" />'."\n";

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
foreach ((array)$maxsim['autoload'] AS $file)
    if (substr($file,-3)==='.js')
	    echo '<script type="text/javascript" enctype="application/javascript" type=module src="/'.$file.'"></script>'."\n";
?>

<script type="text/javascript">
<?=$maxsim['template']['js']?>
</script>

</body>
</html>