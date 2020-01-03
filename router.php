<?php


function index() {
	echo "INDEX";
}

function hello($name) {
	echo "HELLO ".$name[1];
}

$routes = array(
	array('GET', '/^\/$/', 'index'),
	array('GET', '/^\/hello\/([0-9A-Za-z]++)$/', 'hello')
);

foreach($routes as $route) {

	$http_verb = $route[0];
	$regex = $route[1];
	$fn = $route[2];
	
	if(preg_match($regex, $_SERVER["REQUEST_URI"], $params) === 1) {
		call_user_func($fn, $params);
		break;
	}
}
?>
