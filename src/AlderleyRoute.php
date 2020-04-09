<?php

class AlderleyRoute
{
    public string $method;
    public string $regex;
    public callable $callback;

    function __construct($method, $regex, $callback)
    {
        $this->method = $method;
        $this->regex = $regex;
        $this->callback = $callback;
    }
}
