<?php
function convert_image($image) {
	$filename_md = "{$image}_md";
	$dir = dirname(__DIR__, 2);
	$image_command = "convert {$dir}/admin/{$image} -strip -quality %85 -resize 1280X720 {$dir}/admin/{$filename_md}";
	exec($image_command);
}

function create_thumbnail($image) {
	$filename_thumb = "{$image}_thumb";
	$dir = dirname(__DIR__, 2);
	$crop_resize = "convert {$dir}/admin/{$image}_md -resize 197X150 -gravity north -crop 197X150+0+0 {$dir}/admin/{$filename_thumb}";
	exec($crop_resize);
}
?>
