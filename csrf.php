<?php
session_start();
function new_csrf_token() {
	$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function get_csrf_token() {
	return $_SESSION['csrf_token'];
}

function check_csrf_token($token) {
	return hash_equals($_SESSION['csrf_token'], $token);
}

?>
