<?php
declare(strict_types=1);
namespace AlderleyPHP;

class Core
{
    public static function checkAuth(): void
    {
        session_start();
        if (empty($_SESSION['auth'])) {
            http_response_code(401);
            exit;
        }
    }

    public static function logIn(): void
    {
        session_start();
        $_SESSION['auth'] = true;
        return;
    }

    public static function logOut(): void
    {
        session_start();
        unset($_SESSION['auth']);
        return;
    }

    public static function generatePassword(int $passwordLength): string
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

    public static function getConfiguration(string $cfgFilePath): array
    {
        return parse_ini_file($cfgFilePath);
    }

    public static function newCSRFToken(): void
    {
        session_start();
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        return;
    }

    public static function getCSRFToken(): string
    {
        session_start();
        return $_SESSION['csrf_token'];
    }

    public static function checkCSRFToken(string $token): boolean
    {
        session_start();
        return hash_equals($_SESSION['csrf_token'], $token);
    }

    public static function getDatabase(string $dbUri, string $dbUser)
    {
        return new \PDO($dbUri, $dbUser);
    }

    public static function resizeImage(string $imageIn, string $imageOut,
        int $cols, int $rows
    ): void {
        $image = new \Imagick($imageIn);
        $image->adaptiveResizeImage($cols, $rows, true);
        $image->writeImage($imageOut);
        $image->destroy();
        return;
    }

    public static function thumbnailImage(string $imageIn, string $imageOut,
        int $cols, int $rows
    ): void {
        $image = new \Imagick($imageIn);
        $image->thumbnailImage($cols, $rows, true);
        $image->writeImage($imageOut);
        $image->destroy();
        return;
    }

    public static function sanitizeInput($i)
    {
        return htmlspecialchars(stripslashes(trim($i)));
    }

    public static function sanitizeString(string $s): string
    {
        return filter_var(self::sanitizeInput($s), FILTER_SANITIZE_STRING);
    }

    public static function sanitizeInteger($i)
    {
        return filter_var(self::sanitizeInput($i), FILTER_SANITIZE_NUMBER_INT);
    }

    public static function sanitizeEmail(string $e): string
    {
        return filter_var(self::sanitizeInput($e), FILTER_SANITIZE_EMAIL);
    }

    public static function getPaginationOffset(int $page, int $limit = 9): int
    {
        return ($page - 1) * $limit;
    }

    public static function redirect(string $uri): void
    {
        header('Location: '.$uri);
        return;
    }

    public static function xAccelRedirect(string $uri): void
    {
        header('X-Accel-Redirect: '.$uri);
        return;
    }

    public static function nginxPushHeader($uri, $as): string
    {
        return "<{$uri}>; rel=preload; as={$as};";
    } 

    public static function nginxPush($header): void
    {
        header("Link: {$header}");
        return;
    }

    public static function nginxPushMany($headers): void
    {
        $result = "";
        foreach ($headers as $h) {
            $result .= $h;
        }
        header("Link: {$result}");
        return;
    }

    public static function createSlug(string $s): string
    {
        return str_replace(
            " ",
            "-",
            strtolower(preg_replace("/[^0-9a-zA-Z ]/", "", $s))
        );
    }

    public static function createRoute(string $method, string $regex, 
        callable $callback
    ): array {
        return array(
            "method" => $method,
            "regex" => $regex,
            "callback" => $callback
        );
    }

    public static function route($routes): void
    {
        $uri = $_SERVER["REQUEST_URI"];
        $method = $_SERVER["REQUEST_METHOD"];
        
        foreach ($routes as $route) {
            if ($route["method"] === $method) {
                if (preg_match($route["regex"], $uri, $params) === 1) {
                    call_user_func($route["callback"], $params);
                    return;
                }
            }
        }
        return;
    }
}
