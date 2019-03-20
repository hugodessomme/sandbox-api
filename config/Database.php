<?php

class Database
{
    private $host = 'localhost';
    private $db_name = 'sandbox-api';
    private $user = 'root';
    private $password = '';
    private $db;

    public function connect()
    {
        $this->db = null;

        try {
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];
            
            $this->db = new PDO(
                'mysql:host='.$this->host.';dbname='.$this->db_name,
                $this->user,
                $this->password,
                $options
            );
        } catch(PDOException $e) {
            die('Connection Error: ' . $e->getMessage());
        }

        return $this->db;
    }
}