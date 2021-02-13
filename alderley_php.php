<?php
function check_auth() {
    session_start();
    if (empty($_SESSION['auth'])) {
        http_response_code(401);
        return;
    }
}

function log_in() {
    session_start();
    $_SESSION['auth'] = true;
    return;
}

function log_out() {
    session_start();
    unset($_SESSION['auth']);
    return;
}

function generate_password(int $password_length) {
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

function get_configuration(string $cfg_file_path) {
    return parse_ini_file($cfg_file_path);
}

function new_csrf_token() {
    session_start();
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    return;
}

function get_csrf_token() {
    session_start();
    return $_SESSION['csrf_token'];
}

function check_csrf_token(string $token) {
    session_start();
    return hash_equals($_SESSION['csrf_token'], $token);
}

function get_database(string $db_uri, string $db_user) {
    return new \PDO($db_uri, $db_user);
}

function resize_image(string $image_in, string $image_out, int $cols, int $rows) {
    $image = new \Imagick($image_in);
    $image->adaptiveResizeImage($cols, $rows, true);
    $image->writeImage($image_out);
    $image->destroy();
    return;
}

function thumbnail_image(string $image_in, string $image_out, int $cols, int $rows) {
    $image = new \Imagick($image_in);
    $image->thumbnailImage($cols, $rows, true);
    $image->writeImage($image_out);
    $image->destroy();
    return;
}

function sanitize_input($i) {
    return htmlspecialchars(stripslashes(trim($i)));
}

function sanitize_string(string $s) {
    return filter_var(self::sanitize_input($s), FILTER_SANITIZE_STRING);
}

function sanitize_integer($i) {
    return filter_var(self::sanitize_input($i), FILTER_SANITIZE_NUMBER_INT);
}

function sanitize_email(string $e) {
    return filter_var(self::sanitize_input($e), FILTER_SANITIZE_EMAIL);
}

function get_pagination_offset(int $page, int $limit = 9) {
    return ($page - 1) * $limit;
}

function redirect(string $uri) {
    header('Location: '.$uri);
    return;
}

function x_accel_redirect(string $uri) {
    header('X-Accel-Redirect: '.$uri);
    return;
}

function nginx_push_header($uri, $as) {
    return "<{$uri}>; rel=preload; as={$as};";
} 

function nginx_push($header) {
    header("Link: {$header}");
    return;
}

function nginx_push_many($headers) {
    $result = "";
    foreach ($headers as $h) {
        $result .= $h;
    }
    header("Link: {$result}");
    return;
}

function create_slug(string $s) {
    return str_replace(
        " ",
        "-",
        strtolower(preg_replace("/[^0-9a-zA-Z ]/", "", $s))
    );
}

function create_route(string $method, string $regex, callable $callback) {
    return array(
        "method" => $method,
        "regex" => $regex,
        "callback" => $callback
    );
}

function route($routes) {
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
