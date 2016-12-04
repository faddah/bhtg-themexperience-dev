<?php
ob_start();

$swarmcdn = dirname(__FILE__)."/swarmcdn.php";
$root = dirname(dirname(dirname(dirname(__FILE__))));

if(file_exists($root.'/wp-load.php')) {
     require_once($root.'/wp-load.php');
} else {
     require_once($root.'/wp-config.php');
}

require_once($swarmcdn);
ob_end_clean();

$currenturl = parse_url(curPageURL());
$queryParts = explode("&", $currenturl["query"]);
$params = array();

foreach($queryParts as $part) {
     $keyval = explode("=", $part);
     $params[$keyval[0]] = $keyval[1];
}

if(isset($params["url"])) {
	header("Content-type: text/html");
	echo("
		<!doctype html>
		<html>
		<head>
			<style>
				body, html {margin: 0px; padding: 0px; height: 100%; min-height: 100%;};
				.video-js-box {
					width: 100% !important;
					min-width: 100% !important;
					min-height: 100% !important;
					position: relative;
					background: #eeeeee;
					position:absolute;
					overflow: hidden;
					top:0;
					left:0;
					height:100% !important;
					z-index:998;
				}
				.video-js {
					height:auto;
					width:100% !important;
					min-width: 100% !important;
					min-height: 100% !important;
					top:0;
					left:0;
					right: 0;
					bottom: 0;
					margin: 0 auto;
					display: block;
				}
			</style>
		</head>
		<body>"
			.SwarmCDN::inject_content("
			  <swarmvideo id='swarmvideo_".time()."' src='".$params["url"]."' preload='none' controls></swarmvideo>
			")."
		</body>
		</html>
	");
} else {
     echo("Please pass a URL via the querystring.");
}

function curPageURL() {
     $pageURL = 'http';

     if ($_SERVER["HTTPS"] == "on") {
          $pageURL .= "s";
     }

     $pageURL .= "://";

     if ($_SERVER["SERVER_PORT"] != "80") {
          $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
     } else {
          $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
     }

     return $pageURL;
}
?>
