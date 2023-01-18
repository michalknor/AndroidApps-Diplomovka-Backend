<?php
include_once 'TableSuperClass.php';
include_once 'Status.php';
include_once 'Utils.php';

class CarUser extends TableSuperClass {
        
    protected $tableName = "car_user";

    public function getDeposit($userId, $carId) : Status {
        try {
            $query = "
                    SELECT 
                    ROUND(buying_price / driven_kilometers * 0.5 + (SELECT TIMESTAMPDIFF(YEAR, u.birthdate, CURDATE()) AS age FROM user AS u WHERE id = ?) * 1.5, 2) AS deposit
                    FROM car AS c
                    JOIN car_state AS cs
                    ON c.car_state_id = cs.id
                    WHERE c.id = ? AND cs.status = 'k dispozícii'";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $userId);
            $stmt->bindParam(2, $carId);

            $status = $this->executeStatement($stmt);
            if (!$status->isOK()) {
                return $status;
            }
            
            if ($stmt->rowCount() === 0) {
                return new Status(203);
            }
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $status = new Status(1);
            $status->data = array(
                "deposit" => $row["deposit"]
            );

            return $status;
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
    
    public function rentCar($userId, $carId, $dateToExpected, $iban) : Status {
        try {     
            $status = $this->getDeposit($userId, $carId);
            
            if (!$status->isOK()) {
                return $status;
            }
            
            $query = "
                    INSERT INTO $this->tableName
                    (user_id, car_id, rent_from, rent_to_expected, deposit, deposit_iban, deposit_status_id)
                    VALUES
                    (?, ?, CURDATE(), ?, ?, ?, (SELECT id FROM deposit_status WHERE status = 'čakajúca na úhradu'))";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $userId);
            $stmt->bindParam(2, $carId);
            $stmt->bindParam(3, $dateToExpected);
            $stmt->bindParam(4, $status->data["deposit"]);
            $stmt->bindParam(5, $iban);

            $status = $this->executeStatement($stmt);
            if (!$status->isOK()) {
                return $status;
            }
            
            if ($stmt->rowCount() === 0) {
                return new Status(203);
            }

            return new Status(1);
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
    
    public function getDiscount($userId) : Status {
        try {
            $query = "
                    SELECT coeficient AS discount
                    FROM discount
                    WHERE payed <= (SELECT sum(cu.payment) FROM $this->tableName AS cu WHERE cu.user_id = ? AND rent_to IS NOT NULL)
                    ORDER BY coeficient DESC
                    LIMIT 1";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $userId);

            $status = $this->executeStatement($stmt);
            if (!$status->isOK()) {
                return $status;
            }
            
            $status = new Status(1);
            
            if ($stmt->rowCount() === 0) {
                $status->data = array(
                    "discount" => 0
                );
                return $status;
            }

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $status->data = array(
                "discount" => $row["discount"]
            );
            
            return $status;
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
    
    public function getFinalPrice($userId, $carId, $carPriceForDay) : Status {
        try {
            $status = $this->getDiscount($userId);            
            if (!$status->isOK()) {
                return $status;
            }
            
            $query = "
                    SELECT
                    CONCAT(discount * 100, '%') AS discount,
                    CONCAT(ROUND((duration * price + days_after * 100) * (1 - discount), 2), '€') AS final_price,
                    CONCAT(ROUND(days_after * 100, 2), '€') AS additional_charge,
                    rent_from AS rent_from,
                    rent_to_expected AS rent_to_expected,
                    days_after AS days_after
                    FROM (
                        SELECT '" . $status->data['discount'] . "' AS discount, 
                        '$carPriceForDay' AS price, 
                        rent_from AS rent_from,
                        rent_to_expected AS rent_to_expected,
                        (TIMESTAMPDIFF(DAY, rent_from, CURDATE()) + 1) AS duration,
                        CASE 
                            WHEN TIMESTAMPDIFF(DAY, rent_to_expected, CURDATE()) < 0 THEN 0
                            ELSE TIMESTAMPDIFF(DAY, rent_to_expected, CURDATE())
                        END AS days_after
                        FROM $this->tableName
                        WHERE user_id = ? AND car_id = ? AND rent_to IS NULL) AS t
                    ";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $userId);
            $stmt->bindParam(2, $carId);

            $status = $this->executeStatement($stmt);
            if (!$status->isOK()) {
                return $status;
            }
            
            if ($stmt->rowCount() === 0) {
                return new Status(100);
            }
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $status = new Status(1);
            $status->data = array(
                "discount" => $row["discount"],
                "final_price" => $row["final_price"],
                "additional_charge" => $row["additional_charge"],
                "rent_from" => $row["rent_from"],
                "rent_to_expected" => $row["rent_to_expected"],
                "days_after" => $row["days_after"]
            );
            
            return $status;
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
    
    public function getCarRented($userId, $carId) {
        try {
            $query = "
                    SELECT 
                    c.id AS id, 
                    CONCAT(cm2.name, ' ', cm.model) AS fullname,
                    cbs.name AS type, 
                    c.number_of_seats AS seats, 
                    ct.type AS transmission, 
                    ctof.type AS fuel, 
                    CONCAT(c.power, 'kW') AS power,
                    CONCAT(ROUND(buying_price * 0.001, 2), '€/deň') AS price_for_day, 
                    CONCAT((SELECT value FROM cons WHERE name = 'image directory'), image_location) AS image_location
                    FROM car AS c
                    JOIN car_model AS cm
                    ON c.car_model_id = cm.id
                    JOIN car_body_style AS cbs
                    ON cm.car_body_style_id = cbs.id
                    JOIN car_mafucaturer AS cm2
                    ON cm.car_manufacturer_id = cm2.id
                    JOIN car_transmission AS ct
                    ON c.car_transmission_id = ct.id
                    JOIN car_type_of_fuel AS ctof
                    ON c.car_type_of_fuel_id = ctof.id
                    JOIN $this->tableName AS cu
                    ON cu.car_id = c.id
                    WHERE cu.user_id = ? AND cu.car_id = ? AND rent_to IS NULL";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $userId);
            $stmt->bindParam(2, $carId);

            $status = $this->executeStatement($stmt);
            if (!$status->isOK()) {
                return $status;
            }

            if ($stmt->rowCount() === 0) {
                return new Status(206);
            }
            
            $status = new Status(1);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $status->data = array(
                "fullname" => $row["fullname"],
                "type" => $row["type"], 
                "seats" => $row["seats"], 
                "transmission" => $row["transmission"], 
                "fuel" => $row["fuel"], 
                "power" => $row["power"],
                "price_for_day" => $row["price_for_day"],
                "image_location" => $row["image_location"]
            );
            
            return $status;
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
    
    public function returnCar($userId, $carId, $iban, $payed_price) {
        try {            
            $query = "
                    UPDATE $this->tableName
                    SET 
                    payment_iban = ?, 
                    payment = ?, 
                    rent_to = CURDATE(), 
                    payment_status_id = (SELECT id FROM payment_status WHERE status = 'uhradená'), 
                    deposit_status_id = (SELECT id FROM deposit_status WHERE status = 'čakajúca na vrátenie')
                    WHERE user_id = ? AND car_id = ?";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $iban);
            $stmt->bindParam(2, $payed_price);
            $stmt->bindParam(3, $userId);
            $stmt->bindParam(4, $carId);

            return $this->executeStatement($stmt);
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
}
?>