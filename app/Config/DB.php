<?php
namespace App\Config;

use App\Config\config;

class DB
{

    private $conn;
    private static $db;

    private function __construct()
    {
        // echo "DB klasa napravljena!";
        $this->connect();
    }

    public static function instance()
    {
        if (self::$db === null) {
            self::$db = new DB();
        }
        return self::$db;
    }

    private function connect()
    {
        $this->conn = new \PDO("mysql:host=localhost;dbname=task-management;charset=utf8", "root", "");
        $this->conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
        $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function executeQuery(string $query)
    {
        return $this->conn->query($query)->fetchAll();
    }

    public function executeOneRow(string $query, array $params)
    {
        $prepare = $this->conn->prepare($query);
        try {
            $code = $prepare->execute($params) ? 200 : 500;
        } catch (PDOException $e) {
            $code = 409;
            // catchErrors("register.php ->".$e->getMessage());
        }
        return $code;
    }
    public function executeSelectOneRow(string $query, array $params)
    {
        $prepare = $this->conn->prepare($query);
        $prepare->execute($params);
        return $prepare->fetch();
    }
    public function executeQueryWithParam(string $query, array $params)
    {
        $prepare = $this->conn->prepare($query);
        $prepare->execute($params);
        return $prepare->fetchAll();
    }
}
