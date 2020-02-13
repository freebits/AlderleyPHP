<?php
function get_db() {
  $dbh = new PDO("pgsql:dbname=test.com.au", 'dbuser');
  return $dbh;
}
?>
