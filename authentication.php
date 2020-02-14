<?php
function check_signed_in() {
	session_start();
	if(empty($_SESSION['auth'])) {
		header('location: /sign_in.php');
	}
}
?>
