<?php
include_once('configuration.php');

function convert_image($image) {
	$configuration = get_configuration();
	$uploads = $configuration['UPLOADS'];
	exec("convert {$uploads}{$image} -strip -quality %85 -resize 1280X720 {$uploads}{$image}_md";

}

function create_thumbnail($image) {
	$configuration = get_configuration();
	$uploads = $configuration['UPLOADS'];
	exec("convert {$uploads}{$image}_md -resize 197X150 -gravity north -crop 197X150+0+0 {$uploads}{$image}_thumb";
}
?>
