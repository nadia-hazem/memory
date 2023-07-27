<?php

class DbConnect
{
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=fqdbhzuh_memory", "fqdbhzuh_n0NAq79EJ", "tNvTEkztxMnhMWtURtBHPvB5EHROYGBf");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}
