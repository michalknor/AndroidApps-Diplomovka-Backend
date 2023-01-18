<?php
include_once 'TableSuperClass.php';
include_once 'Status.php';
include_once 'Utils.php';

class Car extends TableSuperClass {
    
    protected $tableName = "car";

    public function getCarOffer($typeList, $fuelList, $transmissionList, $seats, $powerFrom, $powerTo, $page) {
        try {
            $actualParam = 0;
            
            $query = "
                    SELECT 
                    c.id AS id, 
                    CONCAT(cm2.name, ' ', cm.model) AS fullname, 
                    cbs.name AS type, 
                    c.number_of_seats AS seats, 
                    ct.type AS transmission, 
                    ctof.type AS fuel, 
                    CONCAT(c.power, 'kW') AS power,
                    colour AS colour,
                    CONCAT(ROUND(buying_price * 0.001, 2), '€/deň') AS price_for_day, 
                    CONCAT((SELECT value FROM cons WHERE name = 'image directory'), image_location) AS image_location
                    FROM $this->tableName AS c
                    JOIN car_model AS cm
                    ON c.car_model_id = cm.id
                    JOIN car_body_style AS cbs
                    ON cm.car_body_style_id = cbs.id
                    JOIN car_mafucaturer AS cm2
                    ON cm.car_manufacturer_id = cm2.id
                    JOIN car_transmission AS ct
                    ON c.car_transmission_id = ct.id
                    JOIN car_state AS cs
                    ON c.car_state_id = cs.id
                    JOIN car_type_of_fuel AS ctof
                    ON c.car_type_of_fuel_id = ctof.id
                    JOIN car_colour AS cc
                    ON c.car_colour_id = cc.id";
            
            $where = " WHERE cs.status = 'k dispozícii' AND ";
            if ($typeList != "") {
                $typeArray = explode(",", $typeList);
                $where .= " cbs.name IN (?";
                for ($i = 1; $i < count($typeArray); $i++) {
                    $where .= ", ?";
                }
                $where .= ") AND";
            }
            if ($fuelList != "") {
                $fuelArray = explode(",", $fuelList);
                $where .= " ctof.type IN (?";
                for ($i = 1; $i < count($fuelArray); $i++) {
                    $where .= ", ?";
                }
                $where .= ") AND";
            }
            if ($transmissionList != "") {
                $transmissionArray = explode(",", $transmissionList);
                $where .= " ct.type IN (?";
                for ($i = 1; $i < count($transmissionArray); $i++) {
                    $where .= ", ?";
                }
                $where .= ") AND";
            }
            if ($seats != "") {
                $where .= " c.number_of_seats >= ? AND";
            }
            if ($powerFrom != "") {
                $where .= " c.power >= ? AND";
            }
            if ($powerTo != "") {
                $where .= " c.power <= ? AND";
            }
            
            if ($where == " WHERE") {
                $where = "";
            }
            else {
                $where = substr($where, 0, -4);
            }
            $offset = ($page - 1) * 10;
            $stmt = $this->conn->prepare($query . $where . " LIMIT 10 OFFSET $offset");
            
            if ($typeList != "") {
                for ($i = 0; $i < count($typeArray); $i++) {
                    $actualParam++;
                    $stmt->bindParam($actualParam, $typeArray[$i]);
                }
            }
            if ($fuelList != "") {
                for ($i = 0; $i < count($fuelArray); $i++) {
                    $actualParam++;
                    $stmt->bindParam($actualParam, $fuelArray[$i]);
                }
            }
            if ($transmissionList != "") {
                for ($i = 0; $i < count($transmissionArray); $i++) {
                    $actualParam++;
                    $stmt->bindParam($actualParam, $transmissionArray[$i]);
                }
            }
            if ($seats != "") {
                $actualParam++;
                $stmt->bindParam($actualParam, $seats);
            }
            if ($powerFrom != "") {
                $actualParam++;
                $stmt->bindParam($actualParam, $powerFrom);
            }
            if ($powerTo != "") {
                $actualParam++;
                $stmt->bindParam($actualParam, $powerTo);
            }

            $status = $this->executeStatement($stmt);
            if (!$status->isOK()) {
                return $status;
            }

            if ($stmt->rowCount() === 0) {
                return new Status(202);
            }
            
            $status = $this->getCarOfferCount($typeList, $fuelList, $transmissionList, $seats, $powerFrom, $powerTo);
            if (!$status->isOK()) {
                return $status;
            }
            
            $status->data["offer"] = array();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            for ($j = 0; $j < $stmt->rowCount(); $j++) {
                $status->data["offer"][$j] = array(
                    "id" => $row["id"], 
                    "fullname" => $row["fullname"], 
                    "type" => $row["type"], 
                    "seats" => $row["seats"], 
                    "transmission" => $row["transmission"], 
                    "fuel" => $row["fuel"], 
                    "power" => $row["power"], 
                    "colour" => $row["colour"], 
                    "price_for_day" => $row["price_for_day"],
                    "image_location" => $row["image_location"]
                );
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            }
            
            return $status;
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
    
    public function getCarOfferCount($typeList, $fuelList, $transmissionList, $seats, $powerFrom, $powerTo) {
        try {
            $actualParam = 0;
            
            $query = "
                    SELECT 
                    count(c.id) as total
                    FROM $this->tableName AS c
                    JOIN car_model AS cm
                    ON c.car_model_id = cm.id
                    JOIN car_body_style AS cbs
                    ON cm.car_body_style_id = cbs.id
                    JOIN car_mafucaturer AS cm2
                    ON cm.car_manufacturer_id = cm2.id
                    JOIN car_transmission AS ct
                    ON c.car_transmission_id = ct.id
                    JOIN car_state AS cs
                    ON c.car_state_id = cs.id
                    JOIN car_type_of_fuel AS ctof
                    ON c.car_type_of_fuel_id = ctof.id
                    JOIN car_colour AS cc
                    ON c.car_colour_id = cc.id";
            
            $where = " WHERE cs.status = 'k dispozícii' AND ";
            if ($typeList != "") {
                $typeArray = explode(",", $typeList);
                $where .= " cbs.name IN (?";
                for ($i = 1; $i < count($typeArray); $i++) {
                    $where .= ", ?";
                }
                $where .= ") AND";
            }
            if ($fuelList != "") {
                $fuelArray = explode(",", $fuelList);
                $where .= " ctof.type IN (?";
                for ($i = 1; $i < count($fuelArray); $i++) {
                    $where .= ", ?";
                }
                $where .= ") AND";
            }
            if ($transmissionList != "") {
                $transmissionArray = explode(",", $transmissionList);
                $where .= " ct.type IN (?";
                for ($i = 1; $i < count($transmissionArray); $i++) {
                    $where .= ", ?";
                }
                $where .= ") AND";
            }
            if ($seats != "") {
                $where .= " c.number_of_seats >= ? AND";
            }
            if ($powerFrom != "") {
                $where .= " c.power >= ? AND";
            }
            if ($powerTo != "") {
                $where .= " c.power <= ? AND";
            }
            
            if ($where == " WHERE") {
                $where = "";
            }
            else {
                $where = substr($where, 0, -4);
            }
            
            $stmt = $this->conn->prepare($query . $where);
            
            if ($typeList != "") {
                for ($i = 0; $i < count($typeArray); $i++) {
                    $actualParam++;
                    $stmt->bindParam($actualParam, $typeArray[$i]);
                }
            }
            if ($fuelList != "") {
                for ($i = 0; $i < count($fuelArray); $i++) {
                    $actualParam++;
                    $stmt->bindParam($actualParam, $fuelArray[$i]);
                }
            }
            if ($transmissionList != "") {
                for ($i = 0; $i < count($transmissionArray); $i++) {
                    $actualParam++;
                    $stmt->bindParam($actualParam, $transmissionArray[$i]);
                }
            }
            if ($seats != "") {
                $actualParam++;
                $stmt->bindParam($actualParam, $seats);
            }
            if ($powerFrom != "") {
                $actualParam++;
                $stmt->bindParam($actualParam, $powerFrom);
            }
            if ($powerTo != "") {
                $actualParam++;
                $stmt->bindParam($actualParam, $powerTo);
            }

            $status = $this->executeStatement($stmt);
            if (!$status->isOK()) {
                return $status;
            }

            if ($stmt->rowCount() === 0) {
                return new Status(202);
            }

            $status = new Status(1);
            $status->data = array("total" => intval($stmt->fetch(PDO::FETCH_ASSOC)["total"]));
            
            return $status;
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
    
    public function getCarUserOffer($userId, $page) {
        try {
            $actualParam = 1;
            
            $query = "
                    SELECT 
                    c.id AS id, 
                    CONCAT(cm2.name, ' ', cm.model) AS fullname, 
                    cbs.name AS type, 
                    c.number_of_seats AS seats, 
                    ct.type AS transmission, 
                    ctof.type AS fuel, 
                    CONCAT(c.power, 'kW') AS power,
                    colour AS colour,
                    CONCAT(ROUND(buying_price * 0.001, 2), '€/deň') AS price_for_day, 
                    CONCAT((SELECT value FROM cons WHERE name = 'image directory'), image_location) AS image_location
                    FROM $this->tableName AS c
                    JOIN car_model AS cm
                    ON c.car_model_id = cm.id
                    JOIN car_body_style AS cbs
                    ON cm.car_body_style_id = cbs.id
                    JOIN car_mafucaturer AS cm2
                    ON cm.car_manufacturer_id = cm2.id
                    JOIN car_transmission AS ct
                    ON c.car_transmission_id = ct.id
                    JOIN car_state AS cs
                    ON c.car_state_id = cs.id
                    JOIN car_type_of_fuel AS ctof
                    ON c.car_type_of_fuel_id = ctof.id
                    JOIN car_colour AS cc
                    ON c.car_colour_id = cc.id
                    JOIN car_user AS cu
                    ON cu.car_id = c.id
                    WHERE cu.user_id = ? AND rent_to IS NULL ";
            $offset = ($page - 1) * 10;
            $stmt = $this->conn->prepare($query . " LIMIT 10 OFFSET $offset");
            
            $stmt->bindParam($actualParam, $userId);

            $status = $this->executeStatement($stmt);
            if (!$status->isOK()) {
                return $status;
            }

            if ($stmt->rowCount() === 0) {
                return new Status(202);
            }
            
            $status = $this->getCarUserOfferCount($userId);
            if (!$status->isOK()) {
                return $status;
            }
            
            $status->data["offer"] = array();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            for ($j = 0; $j < $stmt->rowCount(); $j++) {
                $status->data["offer"][$j] = array(
                    "id" => $row["id"], 
                    "fullname" => $row["fullname"], 
                    "type" => $row["type"], 
                    "seats" => $row["seats"], 
                    "transmission" => $row["transmission"], 
                    "fuel" => $row["fuel"], 
                    "power" => $row["power"], 
                    "colour" => $row["colour"], 
                    "price_for_day" => $row["price_for_day"],
                    "image_location" => $row["image_location"]
                );
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            }
            
            return $status;
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
    
    public function getCarUserOfferCount($userId) {
        try {
            $actualParam = 1;
            
            $query = "
                    SELECT 
                    count(c.id) as total
                    FROM $this->tableName AS c
                    JOIN car_user AS cu
                    ON cu.car_id = c.id
                    WHERE cu.user_id = ? AND rent_to IS NULL ";
            
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam($actualParam, $userId);

            $status = $this->executeStatement($stmt);
            if (!$status->isOK()) {
                return $status;
            }

            if ($stmt->rowCount() === 0) {
                return new Status(202);
            }

            $status = new Status(1);
            $status->data = array("total" => intval($stmt->fetch(PDO::FETCH_ASSOC)["total"]));
            
            return $status;
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
    
    public function getCar($id) {
        try {
            $query = "
                    SELECT 
                    c.id AS id, 
                    CONCAT(cm2.name, ' ', cm.model) AS fullname,
                    cm2.name AS manufacturer, 
                    cm.model AS model, 
                    cbs.name AS type, 
                    c.number_of_seats AS seats, 
                    ct.type AS transmission, 
                    ctof.type AS fuel, 
                    CONCAT(c.power, 'kW') AS power,
                    colour AS colour,
                    CONCAT(ROUND(buying_price * 0.001, 2), '€/deň') AS price_for_day, 
                    CONCAT((SELECT value FROM cons WHERE name = 'image directory'), image_location) AS image_location
                    FROM $this->tableName AS c
                    JOIN car_model AS cm
                    ON c.car_model_id = cm.id
                    JOIN car_body_style AS cbs
                    ON cm.car_body_style_id = cbs.id
                    JOIN car_mafucaturer AS cm2
                    ON cm.car_manufacturer_id = cm2.id
                    JOIN car_transmission AS ct
                    ON c.car_transmission_id = ct.id
                    JOIN car_state AS cs
                    ON c.car_state_id = cs.id
                    JOIN car_type_of_fuel AS ctof
                    ON c.car_type_of_fuel_id = ctof.id
                    JOIN car_colour AS cc
                    ON c.car_colour_id = cc.id
                    WHERE c.id = ? AND cs.status = 'k dispozícii'";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $id);

            $status = $this->executeStatement($stmt);
            if (!$status->isOK()) {
                return $status;
            }

            if ($stmt->rowCount() === 0) {
                return new Status(203);
            }
            
            $statusCarFeatures = $this->getCarFeatures($id);
            if (!$statusCarFeatures->isOK()) {
                return $statusCarFeatures;
            }
            
            $status = new Status(1);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $status->data = array(
                "id" => $row["id"], 
                "fullname" => $row["fullname"],
                "manufacturer" => $row["manufacturer"], 
                "model" => $row["model"], 
                "type" => $row["type"], 
                "seats" => $row["seats"], 
                "transmission" => $row["transmission"], 
                "fuel" => $row["fuel"], 
                "power" => $row["power"], 
                "colour" => $row["colour"], 
                "price_for_day" => $row["price_for_day"],
                "image_location" => $row["image_location"],
                "features" => $statusCarFeatures->getData()
            );
            
            return $status;
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
    
    public function getCarPrice($id) : Status {
        try {
            $query = "
                    SELECT
                    ROUND(buying_price * 0.001, 2) AS price_for_day
                    FROM $this->tableName AS c
                    WHERE c.id = ?";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $id);

            $status = $this->executeStatement($stmt);
            if (!$status->isOK()) {
                return $status;
            }

            if ($stmt->rowCount() === 0) {
                return new Status(205);
            }
            
            $status = new Status(1);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $status->data = array(
                "price_for_day" => $row["price_for_day"]
            );
            
            return $status;
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
    
    public function getCarFeatures($id) {
        try {
            $query = "
                    SELECT 
                    cfc.category AS category,
                    cf.name AS name,
                    cf.description AS description
                    FROM $this->tableName AS c
                    JOIN car_model AS cm
                    ON c.car_model_id = cm.id
                    JOIN car_model_car_feature AS cmcf
                    ON cm.id = cmcf.car_model_id
                    JOIN car_feature AS cf
                    ON cmcf.car_feature_id = cf.id
                    JOIN car_feature_category AS cfc
                    ON cf.car_feature_category_id = cfc.id
                    WHERE c.id = ?
                    
                    UNION
                    
                    SELECT 
                    cfc.category AS category,
                    cf.name AS name,
                    cf.description AS description
                    FROM $this->tableName AS c
                    JOIN car_car_feature AS ccf
                    ON c.id = ccf.car_id
                    JOIN car_feature AS cf
                    ON ccf.car_feature_id = cf.id
                    JOIN car_feature_category AS cfc
                    ON cf.car_feature_category_id = cfc.id
                    WHERE c.id = ?";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $id);
            $stmt->bindParam(2, $id);

            $status = $this->executeStatement($stmt);
            if (!$status->isOK()) {
                return $status;
            }

            $status = new Status(1);
            if ($stmt->rowCount() > 0) {
                $status->data = array("comfort" => array(), "secure" => array());
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $comfort = 0;
                $secure = 0;
                for ($j = 0; $j < $stmt->rowCount(); $j++) {
                    if ($row["category"] == "komfortné") {
                        $status->data["comfort"][$comfort] = array(
                            "name" => $row["name"], 
                            "description" => $row["description"]
                        );
                        $comfort++;
                    }
                    elseif ($row["category"] == "bezpečnostné") {
                        $status->data["secure"][$secure] = array(
                            "name" => $row["name"], 
                            "description" => $row["description"]
                        );
                        $secure++;
                    }
                    
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                }
            }
            
            return $status;
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
    
    public function getCarOfferFilters() {
        try {
            $query = "SELECT name AS name FROM car_body_style";
            
            $stmt = $this->conn->prepare($query);

            $status = $this->executeStatement($stmt);
            if (!$status->isOK()) {
                return $status;
            }

            $statusToReturn = new Status(1);
            $statusToReturn->data = array("carBodyType" => array(), "transmission" => array(), "fuel" => array());
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            for ($i = 0; $i < $stmt->rowCount(); $i++) {
                $statusToReturn->data["carBodyType"][$i] = $row["name"];
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            }
            
            $query = "SELECT type AS type FROM car_transmission";
            
            $stmt = $this->conn->prepare($query);

            $status = $this->executeStatement($stmt);
            if (!$status->isOK()) {
                return $status;
            }
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            for ($i = 0; $i < $stmt->rowCount(); $i++) {
                $statusToReturn->data["transmission"][$i] = $row["type"];
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            }
            
            $query = "SELECT type AS type FROM car_type_of_fuel";
            
            $stmt = $this->conn->prepare($query);

            $status = $this->executeStatement($stmt);
            if (!$status->isOK()) {
                return $status;
            }
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            for ($i = 0; $i < $stmt->rowCount(); $i++) {
                $statusToReturn->data["fuel"][$i] = $row["type"];
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            }
            
            return $statusToReturn;
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
    
    public function getExpectedPrice($id, $rent_to_expected) {
        try {
            $query = "
                    SELECT CONCAT(ROUND((TIMESTAMPDIFF(DAY, CURDATE(), '$rent_to_expected') + 1) * buying_price * 0.001, 2), '€') AS price
                    FROM $this->tableName
                    WHERE id = ?";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $id);

            $status = $this->executeStatement($stmt);
            if (!$status->isOK()) {
                return $status;
            }

            if ($stmt->rowCount() === 0) {
                return new Status(205);
            }
            
            $status = new Status(1);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $status->data = array(
                "price" => $row["price"]
            );
            
            return $status;
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
    
    public function getOdometer($id) {
        try {
            $query = "
                    SELECT driven_kilometers AS odometer
                    FROM $this->tableName
                    WHERE id = ?";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $id);

            $status = $this->executeStatement($stmt);
            if (!$status->isOK()) {
                return $status;
            }

            if ($stmt->rowCount() === 0) {
                return new Status(205);
            }
            
            $status = new Status(1);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $status->data = array(
                "odometer" => $row["odometer"]
            );
            
            return $status;
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
    
    public function setOdometer($id, $odometer) {
        try {
            $query = "
                    UPDATE $this->tableName
                    SET driven_kilometers = ?
                    WHERE id = ?";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $odometer);
            $stmt->bindParam(2, $id);

            return $this->executeStatement($stmt);
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
    
    public function setState($id, $status) {
        try {
            $query = "
                    UPDATE $this->tableName
                    SET car_state_id = (SELECT id FROM car_state WHERE status = ?)
                    WHERE id = ?";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $status);
            $stmt->bindParam(2, $id);

            return $this->executeStatement($stmt);
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
}
?>