<?php
namespace App\Config;

use App\Config\config;

class DB
{

    private $conn;
    private static $db;

    private function __construct()
    {
        $this->connect();
    }

    public static function instance()
    {
        if (self::$db === null) {
            self::$db = new DB();
                accessList();
        }
        return self::$db;
    }

    private function connect()
    {
        $this->conn = new \PDO("mysql:host=.SERVER.;dbname=.DATABASE.;charset=utf8", ".USERNAME.", ".PASS.");
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

        return $prepare->execute($params);

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
    public function accessList()
    {
        $file = fopen(BASE_URL . "data/log.txt", "a");

        $string = basename($_SERVER['REQUEST_URI']) . "\t" . date("d.m.Y H:i:s") . "\t" . $_SERVER['REMOTE_ADDR'] . "\n";

        fwrite($file, $string);
        fclose($file);
    }
    public function catchErrors($error)
    {
        @$open = fopen(ERROR_FILE, "a");
        $unos = $error . "\t" . date('d-m-Y H:i:s') . "\n";
        @fwrite($open, $unos);
        @fclose($open);
    }
}
