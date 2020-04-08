<?php

class AlderleyRouter {

    private $routes = array();

    public function route(): void
    {
        $uri = $_SERVER["REQUEST_URI"];
        $method = $_SERVER["REQUEST_METHOD"];
        
        foreach ($this->routes as $route) {
            if ($route->method === $method) {
                if(preg_match($route->regex, $uri, $params) === 1) {
                    call_user_func($route->callback, $params);
                    break;
                }
            }
        }
    }

    public function addRoute(string $method, string $regex, callable $callback): void
    {
        $route = AlderleyRoute($method, $regex, $callback);
        array_push($routes, $route);
    }
}
