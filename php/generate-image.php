<?php
// header( "Content-type: image/png" );
require __DIR__ . '/vendor/autoload.php';


function generateImage($severity,$string, $id/*,$reportedTime,$clearTime*/){
	$imageWidth = 880;
	$imageHeight = 440;
	$xMiddle = $imageWidth/2;
	$yMiddle = $imageHeight/2;

	// $my_img = @imagecreatetruecolor( $imageWidth,$imageHeight )
	// or die('Cannot Initialize new GD image stream');

	$lines = explode('|', wordwrap($string, 28, '|'));

	// Starting X and Y position
	$y = $yMiddle - 70;
	$x = $xMiddle - 80;

	$font = __DIR__ . "/assets/open-sans/OpenSansExtraBold.ttf";
	$fontSize = 24;


	switch ($severity) {
		case 3:
			$my_img = imagecreatefrompng ( __DIR__ .  "/assets/images/base/high-impact.png");
			$text_color = imagecolorallocate( $my_img, 255,186,37);
			break;
		case 4:
			$my_img = imagecreatefrompng ( __DIR__ . "/assets/images/base/severe-impact.png");
			$text_color = imagecolorallocate( $my_img, 139,0,0);
			break;
		default:
			$my_img = imagecreatefrompng ( __DIR__ . "/assets/images/base/moderate-impact.png");
			$text_color = imagecolorallocate( $my_img, 255,255,255);
			break;
	}


	// Loop through the lines and place them on the image
	foreach ($lines as $line) {

		imagettftext($my_img, $fontSize, 0, $x, $y, $text_color, $font, $line);
		$y += 38;
		}
	$filePath = __DIR__ . "/assets/images/_" . $id . "_img.png";
	// /php/assets/images/_11972673_img.png
	imagepng( $my_img, $filePath);
	imagedestroy( $my_img );

	//function returns path to file
	return $filePath;
	}

	generateImage(4,"This is a test image generated by the traffic twitter, used to test whether the image generation is actually working.", 12345678);

?>