<?php

// Singleton do połączenia z bazom
class Baza {
    private static $db;
    private $conn;

    private function __construct() {
        $this->conn = new mysqli('localhost', 'root', 'root', 'Szpital');
    }

    function __destruct() {
        $this->conn->close();
    }

    public static function getConnection() {
        // Jeśli nie istnieje obiekt Baza to utworz
        if (self::$db == null) { 
            self::$db = new Baza();
        }
        return self::$db;
    }

    // Zwraca obiekt mysqli_result
    public static function getTable($table){
        return self::$db->conn->query("CALL getData('$table')");
    }

    // Mozna sprawdzic czy dane sa poprawne. Albo chuj aby dzialalo jako tako
    public static function addPatient($name, $surname, $pesel, $phone, $zip_code, $address){
        self::$db->conn->query("CALL addPatient('$name', '$surname', '$pesel', '$phone', '$zip_code', '$address')");
    }
}   
?>