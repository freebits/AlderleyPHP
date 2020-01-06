<?php

function route($routes) {
	$request_uri = $_SERVER["REQUEST_URI"];
	$request_method = $_SERVER["REQUEST_METHOD"];
	
	foreach($routes as $route) {
		
		list($method, $regex, $handler) = $route;

		if($method === $request_method &&
			preg_match($regex, $request_uri, $params) === 1) {

			call_user_func($handler, $params);
			break;
		}

	}
}

$routes = array(
	array('GET', '/^\/$/', 'index'),
	array('GET', '/^\/hello\/(?<s>[0-9A-Za-z]++)$/', 'hello')
);

route($routes);

?>
