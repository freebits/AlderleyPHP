<?php

class Alderley {
    public static function authenticationRequired()
    {
        session_start();
        if (empty($_SESSION['auth'])) {
            http_response_code(401);
        }
    }


    public static function authenticate()
    {
        session_start();
        $_SESSION['auth'] = true;
    }


    public static function deauthenticate()
    {
        session_start();
        unset($_SESSION['auth']);
    }


    public static function generatePassword(int $passwordLength)
    {
        $keyspace = array(
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i',
            'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r',
            's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A',
            'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J',
            'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S',
            'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '1', '2',
            '3', '4', '5', '6', '7', '8', '9', '0', '!',
            '@', '#', '$', '%', '^', '&', '*', '(', ')');
                    
        $password = '';
        for ($i = 0; $i < $passwordLength; $i++) {
            $password .= $keyspace[random_int(0, count($keyspace) - 1)];
        }
        return $password;
    }


    public static function getConfiguration(string $cfgFilePath)
    {
        return parse_ini_file($cfgFilePath);
    }


    public static function newCsrfToken()
    {
        session_start();
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }


    public static function getCsrfToken()
    {
        session_start();
        return $_SESSION['csrf_token'];
    }


    public static function CheckCsrfToken(string $token)
    {
        session_start();
        return hash_equals($_SESSION['csrf_token'], $token);
    }


    public static function getDatabase(string $dbUri, string $dbUser)
    {
        return new PDO($dbUri, $dbUser);
    }


    public static function resizeImage(string $imageIn, string $imageOut, int $cols, int $rows)
    {
        $image = new Imagick($imageIn);
        $image->adaptiveResizeImage($cols, $rows, true);
        $image->writeImage($imageOut);
        $image->destroy();
    }


    public static function thumbnailImage(string $imageIn, string $imageOut, int $cols, int $rows)
    {
        $image = new Imagick($imageIn);
        $image->thumbnailImage($cols, $rows, true);
        $image->writeImage($imageOut);
        $image->destroy();
    }


    public static function sanitizeInput($i)
    {
        return htmlspecialchars(stripslashes(trim($i)));
    }


    public static function sanitizeString(string $s)
    {
        return filter_var(sanitizeInput($s), FILTER_SANITIZE_STRING);
    }


    public static function sanitizeInteger(int $i)
    {
        return filter_var(sanitizeInput($i), FILTER_SANITIZE_NUMBER_INT);
    }


    public static function sanitizeEmail(string $e)
    {
        return filter_var(sanitizeInput($e), FILTER_SANITIZE_EMAIL);
    }


    public static function contactMail(string $mailTo, string $mailFrom, string $subject, array $fields)
    {
        $body = '';
        foreach ($fields as $field) {
            list($label, $value) = $field;
            $body .= $label.': '.$value.PHP_EOL;
        }
        $headers = 'From: '.$mailFrom;
        mail($mailTo, $subject, $body, $headers);
    }


    public static function getPaginationOffset(int $page, int $limit = 9)
    {
        return ($page - 1) * $limit;
    }


    public static function redirect(string $uri)
    {
        header('Location: '.$uri);
    }


    public static function xAccelRedirect(string $uri)
    {
        header('X-Accel-Redirect: '.$uri);
    }


    public static function createSlug(string $s)
    {
        return str_replace(" ", "-",
            strtolower(preg_replace("/[^0-9a-zA-Z ]/", "", $s)));
    }
}
