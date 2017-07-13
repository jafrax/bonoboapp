<?php
set_time_limit(9999999999);
ob_clean();

function LoadFile($file,$quality){
		
	list($width, $height, $image_type) = @getimagesize($file);
	
	switch ($image_type){
		case 1: $im = @imagecreatefromgif($file) or die("Cannot Initialize new GD image stream"); break;
		case 2: $im = @imagecreatefromjpeg($file) or die("Cannot Initialize new GD image stream");  break;
		case 3: $im = @imagecreatefrompng($file) or die("Cannot Initialize new GD image stream"); break;
		default: $im = '';  break;
	}

	if(!$im){
		$im  = imagecreatetruecolor(150, 30);
		$bgc = imagecolorallocate($im, 0, 0, 0);
		$tc  = imagecolorallocate($im, 0, 0, 0);

		imagefilledrectangle($im, 0, 0, 150, 30, $bgc);
		imagestring($im, 1, 5, 5, 'Error loading ' . $file, $tc);
	}
	
	switch ($image_type){
		case 1: 
			header('Content-Type: image/gif');
			imagegif($im, null, $quality);
		break;
		
		case 2: 
			header('Content-Type: image/jpeg');
			imagejpeg($im, null, $quality);
		break;
		
		case 3: 
			header('Content-Type: image/png');
			//imagepng($im, null, $quality);
			imagepng($im, null, null);
		break;
		
		default: 
			header('Content-Type: image/jpeg');
			imagejpeg($im, null, $quality);
		break;
	}
	
	imagedestroy($im);
}





$quality = 50;
$file = "http://192.168.0.253/visione/bonobo/assets/image/img_default_photo.jpg";


if(!empty($_GET["q"])){
	$quality = $_GET["q"];
}

if(!empty($_GET["f"])){
	if(@getimagesize($_GET["f"])){
		$file = $_GET["f"];
	}
}elseif(!empty($_GET["fe"])){
	if(@getimagesize(base64_decode($_GET["fe"]))){
		$file = base64_decode($_GET["fe"]);
	}
}
	
LoadFile($file,$quality);

?>