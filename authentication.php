<?php
function check_signed_in() {
	session_start();
	if(empty($_SESSION['auth'])) {
		header('Location: /sign_in.php');
	}
}
?>
