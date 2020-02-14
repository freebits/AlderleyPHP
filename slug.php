<?php
function create_slug($s) {
	return 
		str_replace(" ", "-",
			strtolower(
				preg_replace("/[^0-9a-zA-Z ]/", "", $s)
			)
		);
}
?>
