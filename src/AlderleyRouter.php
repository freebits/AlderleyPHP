<?php

class AlderleyRouter {

    private $routes = array();

    public function route()
    {
        $request_uri = $_SERVER["REQUEST_URI"];
        $request_method = $_SERVER["REQUEST_METHOD"];
        
        foreach ($this->routes as $route) {
            list($method, $regex, $callback) = $route;
            
            if ($method === $request_method &&
                preg_match($regex, $request_uri, $params) === 1) {
                call_user_func($callback, $params);
                break;
            }
        }
    }

    public function addRoute(string $httpVerb, string $regex, string $callback)
    {
        $route = array(
            0 => $http_verb,
            1 => $regex,
            2 => $callback
        );
        array_push($routes, $route);
    }
}
