<?php # BMP — Javier González González


if ($_GET[1]=='README') {

	$file_md = 'README'.($_GET[2]=='CN'?'_CN':'').'.md';

	$maxsim['template']['css'] .= '
		#content {
			background:white;
			margin-top:-10px;
			padding:20px;
			padding-left:40px;
		}
		';



	include('lib/Parsedown.php');
	$Parsedown = new Parsedown();


	echo '<div id="markdown_text">';
	echo $Parsedown->text(file_get_contents($file_md));
	echo '</div>';


} else if (!$_GET[1]) {
	$maxsim['redirect'] = '/chat'; 
}