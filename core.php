<?php

class Skeleton {
    
    public static function GetDatabase() {
        $connection = null;
        try {
            $connection = new PDO()
        }
        catch(PDOException $e) {
        }
        return $connection;
    }

}
