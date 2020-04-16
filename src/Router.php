<?php
declare(strict_types=1);
namespace Alderley;

class Router
{
    private $routes = array();

    public function route(): void
    {
        $uri = $_SERVER["REQUEST_URI"];
        $method = $_SERVER["REQUEST_METHOD"];
        
        foreach ($this->routes as $route) {
            if ($route->method === $method) {
                if (preg_match($route->regex, $uri, $params) === 1) {
                    call_user_func($route->callback, $params);
                    return;
                }
            }
        }
    }

    public function addRoute(string $method, string $regex, callable $callback): void
    {
        array_push($routes, AlderleyRoute($method, $regex, $callback));
        return;
    }
}
