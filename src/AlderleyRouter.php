<?php

class AlderleyRouter {

    private $routes = array();

    public function route()
    {
        $requestUri = $_SERVER["REQUEST_URI"];
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        
        foreach ($this->routes as $route) {
            list($httpVerb, $regex, $callback) = $route;
            
            if ($method === $requestMethod &&
                preg_match($regex, $requestUri, $params) === 1) {
                call_user_func($callback, $params);
                break;
            }
        }
    }

    public function addRoute(string $httpVerb, string $regex, string $callback)
    {
        $route = array(
            0 => $httpVerb,
            1 => $regex,
            2 => $callback
        );
        array_push($routes, $route);
    }
}
