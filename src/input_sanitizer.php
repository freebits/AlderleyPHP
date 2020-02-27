<?php
function sanitize_input($i)
{
    return htmlspecialchars(stripslashes(trim($i)));
}

function sanitize_string($s)
{
    return filter_var(sanitize_input($s), FILTER_SANITIZE_STRING);
}

function sanitize_integer($i)
{
    return filter_var(sanitize_input($i), FILTER_SANITIZE_NUMBER_INT);
}

function sanitize_email($e)
{
    return filter_var(sanitize_input($e), FILTER_SANITIZE_EMAIL);
}
