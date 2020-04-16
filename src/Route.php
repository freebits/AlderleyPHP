<?php
declare(strict_types=1);
namespace AlderleyPHP;

class Route
{
    public string $method;
    public string $regex;
    public callable $callback;

    public function __construct($method, $regex, $callback)
    {
        $this->method = $method;
        $this->regex = $regex;
        $this->callback = $callback;
    }
}
