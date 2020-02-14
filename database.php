<?php
require_once('configuration.php');
function get_database() {
	$configuration = get_configuration();
	$dbh = 
		new PDO($configuration['DATABASE_URI'], $configuration['DATABASE_USER']);
  return $dbh;
}
?>
