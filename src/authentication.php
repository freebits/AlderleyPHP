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

function deauthenticate() {
	session_start();
	unset($_SESSION['auth']);
}

function generate_password($password_length) {

	$keyspace = array(
		'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i',
		'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r',
		's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A',
		'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J',
		'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S',
		'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '1', '2', 
		'3', '4', '5', '6', '7', '8', '9', '0', '!', 
		'@', '#', '$', '%', '^', '&', '*', '(', ')');	
		
	$password = '';
	for($i = 0; $i < $password_length; $i++) {
		$password .= $keyspace[random_int(0, count($keyspace) - 1)];
	}	
	return $password;
}
?>
