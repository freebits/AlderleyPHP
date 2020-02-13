<?php
function sanitize_input($i) {
	$i = trim($i);
	$i = stripslashes($i);
	$i = htmlspecialchars($i);
	return $i;
}

function sanitize_string($s) {
	$s = sanitize_input($s);
	$s = filter_var($s, FILTER_SANITIZE_STRING);
	return $s;
}

function sanitize_integer($i) {
	$i = sanitize_input($i);
	$i = filter_var($i, FILTER_SANITIZE_NUMBER_INT);
	return $i;
}

function sanitize_email($e) {
	$e = sanitize_input($e);
	$e = filter_var($e, FILTER_SANITIZE_EMAIL);
}
?>
