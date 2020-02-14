<?php
function check_signed_in() {
	session_start();
	if(empty($_SESSION['auth'])) {
		header('location: /sign_in.php');
	}
}

function generate_key($length = 32) {
	$keyspace = 
		'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ`1234567890-=~!@#$%^&*()_+[]{};:,.<>/?';
	$keyspace_size = strlen($keyspace);
	$key = '';
	for(i = 0; i < $keyspace_size; i++) {
		$key .= random_int(0, $keyspace_size);
	}	
	return $key;
}

?>
