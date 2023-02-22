<?php

namespace Gold;

use GearmanClient;
use Memcached;
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
            error_log($e);
        }
        return $connection;
    }

    /**
     * @throws \Exception
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
        $g->addServer();
        $data = array(
            't0' => $to,
            'from' => $from,
            'subject' => $subject,
            'message' => $message
        );
        $g->doBackground("send_email", json_encode($data));
    }

}
