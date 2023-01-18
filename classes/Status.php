<?php
class Status {
    private $code;
    private $message;

    public $data;

    // constructor with $db as database connection
    public function __construct($code) {
        $this->code = $code;
        switch ($code) {
            case 1: 
                $this->message = "OK";
                break;
            case 100: 
                $this->message = "Neznáma chyba.";
                break;
            case 101:
                $this->message = "Chyba v SQL dopyte.";
                break;
            case 102:
                $this->message = "SQL error kód nie je 0.";
                break;
            case 103:
                $this->message = "Nepovolený názov tabuľky.";
                break;
            case 104:
                $this->message = "Nepodarilo sa nastaviť autocommit.";
                break;
            case 200:
                $this->message = "Neautorizovaný prístup.\n\nBoli ste odhlásený z dôvodu prihlásenia na inom zariadení alebo vám vypršala platnosť prihlásenia.";
                break;
            case 201:
                $this->message = "Nesprávne meno alebo heslo.";
                break;
            case 202:
                $this->message = "Ľutujeme pre vami zvolené kritéria momentálne nemáme dostupné žiadne vozidlo. Skúste zmeniť kritéria vyhľadávania.";
                break;
            case 203:
                $this->message = "Vozidlo neexistuje alebo je momentálne nedostupné.";
                break;
            case 204:
                $this->message = "Zlý dátum narodenia.";
                break;
            case 205:
                $this->message = "Vozidlo neexistuje.";
                break;
            case 206:
                $this->message = "Vozidlo neexistuje alebo ho už nemáte požičané.";
                break;
            case 300:
                $this->message = "Nezadaný údaj!";
                break;
            case 301:
                $this->message = "Nezadaný údaj 'username'!";
                break;
            case 302:
                $this->message = "Nezadaný údaj 'password'!";
                break;
            case 303:
                $this->message = "Nezadaný údaj 'car_id'!";
                break;
            case 304:
                $this->message = "Nezadaný údaj 'rent_to_expected'!";
                break;
            case 305:
                $this->message = "Nezadaný údaj 'IBAN'!";
                break;
            case 306:
                $this->message = "Zlý formát 'rent_to_expected'!";
                break;
            case 307:
                $this->message = "Zadali ste nesprávny dátum konca vypožičania!";
                break;
            case 308:
                $this->message = "Nezadaný údaj 'birthdate'!";
                break;
            case 309:
                $this->message = "Nezadaný údaj 'odometer'!";
                break;
            case 310:
                $this->message = "Neplatná hodnota odometra!";
                break;
            default:
                $this->message = "";
            }
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function getCode() {
        return $this->code;
    }

    public function getMessage() {
        return $this->message;
    }
    
    public function getData() {
        return $this->data;
    }

    public function isOK() {
        return $this->getCode() === 1;
    }

    public function echoJson() {
        if ($this->isOK()) {
            echo json_encode(
                array(
                    "status" => $this->getCode(),
                    "message" => $this->getMessage(),
                    "data" => $this->getData()
                ), JSON_UNESCAPED_UNICODE);
        }
        else {
            echo json_encode(
                array(
                    "status" => $this->getCode(),
                    "message" => $this->getMessage()
                ), JSON_UNESCAPED_UNICODE);
        }
    }
}
?>