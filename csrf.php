<?php
function new_csrf_token() {
	session_start();
	$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function get_csrf_token() {
	session_start();
	return $_SESSION['csrf_token'];
}

function check_csrf_token($token) {
	session_start();
	return hash_equals($_SESSION['csrf_token'], $token);
}
?>
