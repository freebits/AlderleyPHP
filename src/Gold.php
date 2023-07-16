<?php

namespace Gold;

use Exception;
use GearmanClient;
use PDO;
use PDOException;

class Gold
{
    public static function getDatabase(string $dsn): PDO
    {
        $connection = null;
        try {
            $connection = new PDO($dsn);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            exit();
        }
        return $connection;
    }

    /**
     * @throws Exception
     */
    public static function generatePassword(int $password_length): string
    {
        $alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $alphabet_len = strlen($alphabet) - 1;
        $password = array();
        for ($i = 0; $i < $password_length; $i++) {
            $r = random_int(0, $alphabet_len);
            $random_letter = $alphabet[$r];
            $password[] = $random_letter;
        }
        return implode($password);
    }

    public static function sendMail(string $to, string $from, string $subject, string $message): void
    {
        $g = new GearmanClient();
        $g->addServer('127.0.0.1');
        $data = array(
            'to' => $to,
            'from' => $from,
            'subject' => $subject,
            'message' => $message
        );
        $json_data = json_encode($data);
        $g->doBackground("send_email", $json_data);
    }

   public static function authCheck(): void
   {
       session_start();
       if(!array_key_exists('account_id', $_SESSION)) {
           http_response_code(401);
           exit();
       }
       else if(!$_SESSION['account_id']) {
           http_response_code(401);
           exit();
       }
   }
}
