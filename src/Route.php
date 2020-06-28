<?php
declare(strict_types=1);
namespace AlderleyPHP;

class Route
{
    public $method;
    public $regex;
    public $callback;

    public function __construct(string $method, string $regex, callable $callback)
    {
        $this->method = $method;
        $this->regex = $regex;
        $this->callback = $callback;
    }
}
