<?php
class Database {
    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "car_sharing";
    private $username = "root";
    private $password = "";

    // get the database connection
    public function getConnection() {
        try {
            $conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $conn->exec("set names utf8");
            
            return $conn;
        }
        catch(PDOException $exception) {
            return null;
        }
    }
}
?>