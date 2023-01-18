<?php
include_once 'TableSuperClass.php';
include_once 'Status.php';
include_once 'Utils.php';

class User extends TableSuperClass {
    
    protected $tableName = "user";

    public function getId($username, $passwordHashed) {
        try {
            $query = "SELECT id AS id, CONCAT(forename, ' ', surname) AS fullname FROM $this->tableName WHERE username = ? AND password_hashed = ?";

            $stmt = $this->conn->prepare($query);
            
            $passwordHashedWithSalt = (new Utils())->sha3256Encrypt(strtolower($passwordHashed));
            
            $stmt->bindParam(1, $username);
            $stmt->bindParam(2, $passwordHashedWithSalt);

            $status = $this->executeStatement($stmt);
            if (!$status->isOK()) {
                return $status;
            }

            if ($stmt->rowCount() === 0) {
                return new Status(201);
            }
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $status = new Status(1);
            $status->data = array("id" => $row['id'], "fullname" => $row['fullname']);

            return $status;
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
    
    public function getBirthdate($id, $birthdate) {
        try {
            $query = "SELECT birthdate AS birthdate FROM $this->tableName WHERE id = ? AND birthdate = ?";

            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(1, $id);
            $stmt->bindParam(2, $birthdate);

            $status = $this->executeStatement($stmt);
            if (!$status->isOK()) {
                return $status;
            }

            if ($stmt->rowCount() === 0) {
                return new Status(204);
            }
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $status = new Status(1);
            $status->data = array("birthdate" => $row['birthdate']);

            return $status;
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
    
    public function getIBAN($id) {
        try {
            $query = "SELECT IBAN AS IBAN FROM $this->tableName WHERE id = ?";

            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(1, $id);

            $status = $this->executeStatement($stmt);
            if (!$status->isOK()) {
                return $status;
            }

            if ($stmt->rowCount() === 0) {
                return new Status(100);
            }
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $status = new Status(1);
            $status->data = array("IBAN" => $row['IBAN']);

            return $status;
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
}
?>