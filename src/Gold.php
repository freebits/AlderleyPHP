<?php

namespace Gold;

use GearmanClient;
use Memcached;
use PDO;
use PDOException;

class Gold
{
    private array $configuration;

    /**
     * @throws ConfigurationError
     */
    public function __construct(string $configurationFilePath)
    {
        $configuration = parse_ini_file($configurationFilePath);
        if (false === $configuration) {
            throw new ConfigurationError();
        } else {
            $this->setConfiguration($configuration);
        }
    }

    public function getConfiguration(): array
    {
        return $this->configuration;
    }

    public function setConfiguration(array $configuration): void
    {
        $this->configuration = $configuration;
    }

    public function getDatabase(): PDO
    {
        $connection = null;
        try {
            $configuration = $this->getConfiguration();
            $connection = new PDO($configuration["DATABASE_CONNECTION_STRING"]);
        } catch (PDOException $e) {
            error_log($e);
        }
        return $connection;
    }

    /**
     * @throws \Exception
     */
    public function generatePassword(int $password_length): string
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

    public function sendMail(string $to, string $from, string $subject, string $message): void
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
