<?php
include_once 'Status.php';

class Utils {
        
    public function getRandomSeed() {
        list($usec, $sec) = explode(' ', microtime());
        return $sec + $usec * 1000000;
    }
    
    public function getRandomGeneratedToken() {
        try {
            mt_srand($this->getRandomSeed());

            $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $charactersLength = strlen($characters);
            $generatedToken = "";
            
            for ($i = 0; $i < 32; $i++) {
                $generatedToken .= $characters[rand(0, $charactersLength - 1)];
            }
            
            $status = new Status(1);
            $status->data = array("token" => $generatedToken);

            return $status;
        }
        catch (Exception $e) {
            return new Status(100);
        }
    }
    
    public function sha3256Encrypt($password) {
        return hash("sha3-256" , $password . "SuperTajnySaltXD123");
    }
}
?>