<?php
namespace Secret;
use Memcached;
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
        $alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $alphabet_len = strlen($alphabet) - 1;
        $password = array();
        for($i=0; $i < $password_length; $i++)
        {
            $random_letter = $alphabet[random_int(0, $alphabet_len)];
            $password[] = $random_letter;
        }
        return implode($password);
    }

    public function get_memcached(): Memcached
    {
        $m = new Memcached();
        $m->addServer("localhost", 11211);
        return  $m;
    }

}
