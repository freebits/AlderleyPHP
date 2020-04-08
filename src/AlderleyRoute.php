<?php

class AlderleyRoute {
    public string $method;
    public string $regex;
    public callable $callback; 

    function __construct($httpVerb, $regex, $callback) {
        $this->httpVerb = $httpVerb;
        $this->regex = $regex;
        $this->callback = $callback;
    }
}
