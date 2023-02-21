<?php
namespace Secret;
use PDO;

class Secret
{
    private array $configuration;

    function __construct(string $configuration)
    {
        $cfg = parse_ini_file($configuration);
        if($cfg === false)
        {
            error_log();
        }
        else
        {
            $this->set_configuration($cfg);
        }
    }

    public function get_configuration(): array
    {
        return $this->configuration;
    }

    public function set_configuration(array $configuration): void
    {
        $this->configuration = $configuration;
    }
    public function get_database(): PDO
    {
        $connection = null;
        try {
            $configuration = $this->get_configuration();
            $connection = new PDO($configuration["DATABASE_CONNECTION_STRING"]);
        } catch (PDOException $e) {
            error_log($e);
        }
        return $connection;
    }

    public function generate_password(int $password_length): string
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $number_of_chars = strlen($chars);
        $results = "";
        for($i=0; $i < $password_length; $i++)
        {
            $results .= $chars[random_int(0, $number_of_chars)];
        }
        return $results;
    }
}
