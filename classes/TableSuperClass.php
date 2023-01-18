<?php
include_once 'Status.php';

class TableSuperClass {
    // database connection and table name
    protected $conn;

    protected $tableName = "";

    // constructor with $db as database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    protected function executeStatement($stmt) {
        try {
            if (!$stmt->execute()) {
                return new Status(101);
            }
            if ($stmt->errorCode() !== "00000") {
                return new Status(102);
            }
            return new Status(1);
        }
        catch (Exception $ex) {
            return new Status(100);
        }
    }

    protected function isTableNameValid($tableName) {
        try {
            if (preg_match('/\w+(_\w)*/', $tableName)) {
                return true;
            }
            return false;
        }
        catch (Exception $e) {
            return false;
        }
    }

    protected function lockTable($tableName, $write) {
        try {
            if (!$this->isTableNameValid($tableName)) {
                return new Status(103);
            }

            $lockType = $write ? "WRITE" : "READ";
            $query = "LOCK TABLES $tableName $lockType";

            $stmt = $this->conn->prepare($query);

            return $this->executeStatement($stmt);
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }

    protected function unlockTable() {
        try {
            $query = "UNLOCK TABLES";

            $stmt = $this->conn->prepare($query);

            return $this->executeStatement($stmt);
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
}
?>