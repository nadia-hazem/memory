<?php
class Database
{
    private $host = 'localhost';
    private $db_name = 'memory';
    private $username = 'root';
    private $password = '';
    private $pdo;

    public function connect() 
    {
        $dsn = "mysql:host=$this->host;dbname=$this->db_name";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        try 
        {
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        } 
        catch (PDOException $e) 
        {
            echo 'Connection failed: ' . $e->getMessage();
            exit;
        }
        return $this->pdo;
    }
}