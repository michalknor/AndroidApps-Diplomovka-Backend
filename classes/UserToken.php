<?php
include_once 'TableSuperClass.php';
include_once 'Status.php';
include_once 'Utils.php';

class UserToken extends TableSuperClass {
        
    protected $tableName = "user_token";

    public function createNewToken($userId) {
        try {
            if ($this->conn->setAttribute(PDO::ATTR_AUTOCOMMIT, 0)) {
                $status = $this->createNewTokenTransaction($userId);
                $this->conn->setAttribute(PDO::ATTR_AUTOCOMMIT, 1);
                return $status;
            }
            
            return new Status(104);
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
    
    public function createNewTokenTransaction($userId) {
        try {
            $this->conn->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
            if ($this->conn->beginTransaction()) {
                $status = $this->lockTable($this->tableName, 1);
                if (!$status->isOK()) {
                    return $status;
                }
                $statusToReturn = $this->createNewTokenCode($userId);
                if ($statusToReturn->isOK()) {
                    $this->conn->commit();
                }
                else {
                    $this->conn->rollBack();
                }
                $status = $this->unlockTable();
                if (!$status->isOK()) {
                    return $status;
                }
                return $statusToReturn;
            }
            return new Status(100);
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
    
    public function createNewTokenCode($userId) {
        try {
            $statusToReturn = $this->generateToken();
            if (!$statusToReturn->isOK()) {
                return $statusToReturn;
            }
            
            $status = $this->delete($userId);
            if (!$status->isOK()) {
                return $status;
            }
            
            $status = $this->insertToken($userId, $statusToReturn->data["token"]);
            if (!$status->isOK()) {
                return $status;
            }

            return $statusToReturn;
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
    
    public function getUserIdFromToken($token) {
        try {
            $query = "SELECT user_id AS user_id FROM $this->tableName WHERE token = ? AND valid_from < NOW() AND NOW() < valid_to";

            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(1, $token);

            $status = $this->executeStatement($stmt);
            if (!$status->isOK()) {
                return $status;
            }

            if ($stmt->rowCount() === 0) {
                return new Status(200);
            }
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $status = new Status(1);
            $status->data = array(
                "user_id" => $row["user_id"]
            );

            return $status;
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }

    private function generateToken() {
        try {
            $utils = new Utils();
            while (true) {
                // generate token
                $statusToReturn = $utils->getRandomGeneratedToken();
                if (!$statusToReturn->isOK()) {
                    return $statusToReturn;
                }

                // query 
                $query = "SELECT token FROM $this->tableName WHERE token = ?";

                // prepare query statement
                $stmt = $this->conn->prepare($query);

                //fill parameters
                $stmt->bindParam(1, $statusToReturn->data["token"]);

                $status = $this->executeStatement($stmt);
                if ($status->isOK() && $stmt->rowCount() == 0) {
                    return $statusToReturn;
                }
            }
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }

    private function insertToken($userId, $token) {
        try {
            // query 
            $query = "INSERT INTO $this->tableName (user_id, token, valid_from, valid_to) VALUES (?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 1 DAY))";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            //fill parameters
            $stmt->bindParam(1, $userId);
            $stmt->bindParam(2, $token);

            $status = $this->executeStatement($stmt);
            
            return $status;
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
    
    private function delete($userId) {
        try {
            // query 
            $query = "DELETE FROM $this->tableName WHERE user_id = ?";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            //fill parameters
            $stmt->bindParam(1, $userId);

            $status = $this->executeStatement($stmt);
            
            return $status;
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
}
?>