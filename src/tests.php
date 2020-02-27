<?php
require_once('authentication.php');

function test_generate_password()
{

    $password = generate_password();

    echo 'Password test 1: '.$password.PHP_EOL;
    echo 'Length: '.strlen($password).PHP_EOL;
    
    $password = generate_password(64);
    
    echo 'Password test 2: '.$password.PHP_EOL;
    echo 'Length: '.strlen($password).PHP_EOL;

    try {
        $password = generate_password('STRING');
    } catch (Exception $e) {
        echo 'Correctly caught wrong param exception', $e->getMessage(), PHP_EOL;
    }
}


test_generate_password();
