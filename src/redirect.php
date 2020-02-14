<?php
function redirect($uri) {
	header('Location: '.$uri);	
}

function x_accel_redirect($uri) {
	header('X-Accel-Redirect: '.$uri);
}
?>
