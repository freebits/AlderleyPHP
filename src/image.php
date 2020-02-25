<?php
function convert_image($image_in, $image_out) {
	exec("convert {$image_in} -strip -quality %85 -resize 1280X720 {$image_out}");

}

function create_thumbnail($image_in, $image_out) {
	exec("convert {$image_in} -resize 197X150 -gravity north -crop 197X150+0+0 {$image_out}");
}
?>
