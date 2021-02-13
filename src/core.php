<?php
declare(strict_types=1);
namespace alderley_php;

class core {

    public static function check_auth(): void {
        session_start();
        if (empty($_SESSION['auth'])) {
            http_response_code(401);
            return;
        }
    }

    public static function log_in(): void {
        session_start();
        $_SESSION['auth'] = true;
        return;
    }

    public static function log_out(): void {
        session_start();
        unset($_SESSION['auth']);
        return;
    }

    public static function generate_password(int $password_length): string {
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
        for ($i = 0; $i < $password_length; $i++) {
            $password .= $keyspace[random_int(0, count($keyspace) - 1)];
        }
        return $password;
    }

    public static function get_configuration(string $cfg_file_path): array {
        return parse_ini_file($cfg_file_path);
    }

    public static function new_csrf_token(): void {
        session_start();
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        return;
    }

    public static function get_csrf_token(): string {
        session_start();
        return $_SESSION['csrf_token'];
    }

    public static function check_csrf_token(string $token): boolean {
        session_start();
        return hash_equals($_SESSION['csrf_token'], $token);
    }

    public static function get_database(string $db_uri, string $db_user) {
        return new \PDO($db_uri, $db_user);
    }

    public static function resize_image(string $image_in, string $image_out, int $cols, int $rows): void {
        $image = new \Imagick($image_in);
        $image->adaptiveResizeImage($cols, $rows, true);
        $image->writeImage($image_out);
        $image->destroy();
        return;
    }

    public static function thumbnail_image(string $image_in, string $image_out, int $cols, int $rows): void {
        $image = new \Imagick($image_in);
        $image->thumbnailImage($cols, $rows, true);
        $image->writeImage($image_out);
        $image->destroy();
        return;
    }

    public static function sanitize_input($i) {
        return htmlspecialchars(stripslashes(trim($i)));
    }

    public static function sanitize_string(string $s): string {
        return filter_var(self::sanitize_input($s), FILTER_SANITIZE_STRING);
    }

    public static function sanitize_integer($i) {
        return filter_var(self::sanitize_input($i), FILTER_SANITIZE_NUMBER_INT);
    }

    public static function sanitize_email(string $e): string {
        return filter_var(self::sanitize_input($e), FILTER_SANITIZE_EMAIL);
    }

    public static function get_pagination_offset(int $page, int $limit = 9): int {
        return ($page - 1) * $limit;
    }

    public static function redirect(string $uri): void {
        header('Location: '.$uri);
        return;
    }

    public static function x_accel_redirect(string $uri): void {
        header('X-Accel-Redirect: '.$uri);
        return;
    }

    public static function nginx_push_header($uri, $as): string {
        return "<{$uri}>; rel=preload; as={$as};";
    } 

    public static function nginx_push($header): void {
        header("Link: {$header}");
        return;
    }

    public static function nginx_push_many($headers): void {
        $result = "";
        foreach ($headers as $h) {
            $result .= $h;
        }
        header("Link: {$result}");
        return;
    }

    public static function create_slug(string $s): string {
        return str_replace(
            " ",
            "-",
            strtolower(preg_replace("/[^0-9a-zA-Z ]/", "", $s))
        );
    }

    public static function create_route(string $method, string $regex, callable $callback): array {
        return array(
            "method" => $method,
            "regex" => $regex,
            "callback" => $callback
        );
    }

    public static function route($routes): void {
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
