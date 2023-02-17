<?php

class Skeleton {
    
    protected array $configuration; 
    
    function __construct(string $configuration) {
        $this->configuration = parse_ini_file($configuration); 
    }

    public function GetDatabase() {
        $connection = null;
        try {
            $connection = new PDO($this->configuration["DATABASE_CONNECTION_STRING"]);
        }
        catch(PDOException $e) {
            error_log($e); 
        }
        return $connection;
    }

}
