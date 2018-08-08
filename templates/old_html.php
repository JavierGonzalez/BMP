<?php



header('Content-Type: text/html; charset=utf-8');


$template['content'] = ob_get_contents();
ob_end_clean();


?><!DOCTYPE html>
<html>
    
<head>
<meta charset="UTF-8" />

<?php if (is_numeric($template['refresh'])) echo '<meta http-equiv="refresh" content="'.$template['refresh'].'" />'; ?>

<title><?=$template['title']?></title>

<script type='text/javascript'>
<?php echo $template['js_head']; ?>
</script>



<?php
foreach (array_unique((array)$template['lib']['css']) AS $url)
    echo '<link rel="stylesheet" href="'.$url.'" />'."\n";
?>


<style type="text/css">
<?php echo $template['css']; ?>
</style>



<?php echo $template['head']; ?>

</head>
<body>

<table border=1 width=100% height=100% cellpadding=6 cellspacing=0>
    <tr>
        <td colspan=2>
            <div style="float:right;"><a href="/user/login">LOGIN</a></div>
            <a href="/">Bitcoin Mining Parliament</a> <sup>0.1</sup>
        </td>
    </tr>
    
    <tr>
        <td valign=top><?php include('templates/old_html_menu.php'); ?></td>
        <td valign=top><?php echo $template['content']; ?></td>
    </tr>
    
    <tr>
        <td colspan=2>
            <div style="float:right;">
                <a href="/about">About</a><br />
                BMP 2017-2018
            </div>
            
            Footer...
            </td>
    </tr>

</table>




<?php
foreach (array_unique((array)$template['lib']['js']) AS $url)
    echo '<script src="'.$url.'"></script>'."\n";
?>

<script type="text/javascript">
    <?php echo $theme['js']; ?>
</script>


    
</body>
</html>