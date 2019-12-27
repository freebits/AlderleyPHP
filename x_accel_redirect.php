<?php
function x_accel_redirect($uri) {
	header("X-Accel-Redirect: ".$uri);
}
?>
