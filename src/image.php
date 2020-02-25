<?php

function convert_image($image_in, $image_out) {
	$image = new Imagick($image_in);
	$image->adaptiveResizeImage(1280, 720, TRUE);
	$image->writeImageFile($image_out);
	$image->destroy();

}

function create_thumbnail($image_in, $image_out) {
	$image = new Imagick($image_in);
	$image->thumbnailImage(197, 150, TRUE);
	$image->writeImageFile($image_out);
	$image->destroy();
}
?>
