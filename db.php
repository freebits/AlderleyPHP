<?php
function get_db() {
  $dbh = new PDO("pgsql:dbname=termitesruncorn.com.au", 'trader');
  return $dbh;
}
?>
