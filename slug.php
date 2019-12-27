<?php
function create_slug($s) {
	$s = preg_replace("/[^0-9a-zA-Z ]/", "", $s);
	$s = strtolower($s);
	$s = str_replace(" ", "-", $s);
	return $s;
}
?>
