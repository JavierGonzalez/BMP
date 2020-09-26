<?php # BMP — Javier González González


if ($_GET[1]=='README') {

	$maxsim['template']['autoload']['js'][] = 'lib/showdown-2.0.0.min.js';

	$maxsim['template']['js'] .= '
		$(document).ready(function() {
			var converter = new showdown.Converter();
			var html = converter.makeHtml($("#readme_md").html());			
			$("#readme_md").html(html).show();
		});
		';

	$maxsim['template']['css'] .= '
		#readme_md {
			display:none;
			margin-top:20px;
			margin-left:20px;
			max-width:800px;
			text-align: justify;
		}
		#readme_md h1 { font-size:28px; }
		
		#readme_md code {
			color:#7b0d40;
			padding: .2em .4em;
			margin: 0;
			font-size: 85%;
			background-color: #1b1f230d;
			border-radius: 6px;
		}
		
		';

	echo '<div id="readme_md">';
	echo file_get_contents('README'.($_GET[2]=='CN'?'_CN':'').'.md');
	echo '</div>';

} else if (!$_GET[1]) {
	include('chat/index.php'); 
}