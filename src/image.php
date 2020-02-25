<?php
function resize_image($image_in, $image_out, $cols, $rows) {
	$image = new Imagick($image_in);
	$image->adaptiveResizeImage($cols, $rows, TRUE);
	$image->writeImage($image_out);
	$image->destroy();
}

function thumbnail_image($image_in, $image_out, $cols, $rows) {
	$image = new Imagick($image_in);
	$image->thumbnailImage($cols, $rows, TRUE);
	$image->writeImage($image_out);
	$image->destroy();
}
?>
