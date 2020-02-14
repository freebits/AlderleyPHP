<?php
function authentication_required() {
	session_start();
	if(empty($_SESSION['auth'])) {
		http_response_code(401);
	}
}

function authenticate() {
	session_start();
	$_SESSION['auth'] = TRUE;
}

function unauthenticate() {
	session_start();
	unset($_SESSION['auth']);
}

function generate_password($password_length = 32) {
	$keyspace = 
		'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ`1234567890-=~!@#$%^&*()_+[]{};:,.<>/?';
	$keyspace_size = strlen($keyspace);
	$password = '';
	for(i = 0; i < $password_length; i++) {
		$password .= $keyspace[random_int(0, $keyspace_size)];
	}	
	return $password;
}
?>
