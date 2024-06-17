<?php
namespace App\Models;

use PDO;
use PDOException;

class Database{
    protected $connection;

    public function __construct() {
        $servername = "localhost";
        $username = "root";
        $password = "Password123!";
        $dbname = "analyse_cv";

        try {
            $this->connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // set the PDO error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}
