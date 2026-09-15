<?php 

namespace TomTroc\Core\DB;

use PDO;
class DB
{
    public $pdo;

    public function __construct($db, $username = NULL, $password = NULL, $host = '127.0.0.1', $port = 3306, $options = [])
    {
        $default_options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];
        $options = array_replace($default_options, $options);
        $dsn = "mysql:host=$host;dbname=$db;port=$port;charset=utf8mb4";

        $this->pdo = new PDO($dsn, $username, $password, $options);
    }
    public function run($sql, $args = NULL)
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }
}