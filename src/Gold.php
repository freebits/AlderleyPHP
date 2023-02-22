<?php

namespace Secret;

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
            $this->SetConfiguration($configuration);
        }
    }

    public function GetConfiguration(): array
    {
        return $this->configuration;
    }

    public function SetConfiguration(array $configuration): void
    {
        $this->configuration = $configuration;
    }

    public function GetDatabase(): PDO
    {
        $connection = null;
        try {
            $configuration = $this->GetConfiguration();
            $connection = new PDO($configuration["DATABASE_CONNECTION_STRING"]);
        } catch (PDOException $e) {
            error_log($e);
        }
        return $connection;
    }

    /**
     * @throws \Exception
     */
    public function GeneratePassword(int $password_length): string
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

    public function GetMemcached(): Memcached
    {
        $m = new Memcached();
        $m->addServer("localhost", 11211);
        return $m;
    }

    public function GetGearman(): GearmanClient
    {
        $g = new GearmanClient();
        $g->addServer();
        return $g;
    }

}
