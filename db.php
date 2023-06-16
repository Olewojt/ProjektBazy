<?php

include 'SimpleXLSXGen.php';

use PSpell\Dictionary;
use Shuchkin\SimpleXLSXGen;

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
        try {
            return self::$db->conn->query("CALL getData('$table')");
        }
        catch (Exception $e){
            return false;
        }
    }

    // Mozna sprawdzic czy dane sa poprawne.
    public static function addPatient($name, $surname, $pesel, $phone, $zip_code, $address){
        self::$db->conn->query("CALL addPatient('$name', '$surname', '$pesel', '$phone', '$zip_code', '$address')");
    }

    public static function addProcedure($patient_id, $type, $date, $doctor_id){
        self::$db->conn->query("CALL addProcedure('$patient_id', '$type', '$date', '$doctor_id')");
    }

    public static function prepareImport($table) {
        return self::$db->conn->query("CALL importPrepare('$table')");
    }

    public static function remove($table, $id){
        $colname = self::columns($table)[0];
        $query = sprintf("DELETE FROM %s WHERE %s=%s",$table, $colname, $id);
        return self::$db->conn->query($query);
    }

    public static function getResource($table, $id){
        $colname = self::columns($table)[0];
        $query = sprintf("SELECT * FROM %s WHERE %s=%s",$table, $colname, $id);
        $res = self::$db->conn->query($query);
        $first = $res->fetch_row();
        if (!empty($first)){
            return $first;
        } else {
            return false;
        }
    }

    public static function update($table, $id, $parameters){
        if ($table == "Zabiegi"){
            $desiredKeys = array('patient_id', 'type', 'Data_Zabiegu', 'doctor_id');
            $params = array_intersect_key($parameters, array_flip($desiredKeys));
            $query = sprintf("UPDATE Zabiegi SET ID_Pacjenta=%s, Rodzaj_Zabiegu='%s', Data_Zabiegu='%s', ID_Lekarza=%s WHERE ID_Zabiegu=%s", 
                $params['patient_id'],$params['type'],$params['Data_Zabiegu'],$params['doctor_id'], $id
            );
            try{
                return self::$db->conn->query($query);
            } catch (Exception $e){
                return false;
            }

        } else if ($table == "Pacjenci"){
            $desiredKeys = array('name', 'surname', 'pesel', 'phone', 'zipCode', 'address');
            $params = array_intersect_key($parameters, array_flip($desiredKeys));
            $query = sprintf("UPDATE Pacjenci SET Imie='%s', Nazwisko='%s', PESEL='%s', Telefon='%s', Kod_Pocztowy='%s', Adres='%s' WHERE ID_Pacjenta=%s", 
                $params['name'],
                $params['surname'],
                $params['pesel'],
                $params['phone'],
                $params['zipCode'],
                $params['address'],
                $id
            );
            try{
                return self::$db->conn->query($query);
            } catch (Exception $e){
                return false;
            }

        } else if ($table == "Lekarze"){
            $desiredKeys = array('name', 'surname', 'specialty', 'phone', 'oddzial');
            $params = array_intersect_key($parameters, array_flip($desiredKeys));
            $query = sprintf("UPDATE Lekarze SET Imie='%s', Nazwisko='%s', Specjalizacja='%s', Telefon='%s', ID_Oddzialu=%s WHERE ID_Lekarza=%s", 
                $params['name'],
                $params['surname'],
                $params['specialty'],
                $params['phone'],
                $params['oddzial'],
                $id
            );
            try{
                return self::$db->conn->query($query);
            } catch (Exception $e){
                return false;
            }

        } else if ($table == "Pielegniarki"){
            $desiredKeys = array('name', 'surname', 'phone', 'oddzial');
            $params = array_intersect_key($parameters, array_flip($desiredKeys));
            $query = sprintf("UPDATE Pielegniarki SET Imie='%s', Nazwisko='%s', Telefon='%s', ID_Oddzialu=%s WHERE ID_Pielegniarki=%s", 
                $params['name'],
                $params['surname'],
                $params['phone'],
                $params['oddzial'],
                $id
            );
            try{
                return self::$db->conn->query($query);
            } catch (Exception $e){
                print($e);
                return false;
            }
        }
    }

    public static function filter($table, $parameters) {
        if ($table=="Zabiegi"){
            $desiredKeys = array('dateOrder', 'date', 'priority');
            $params = array_intersect_key($parameters, array_flip($desiredKeys));
            $query = sprintf("CALL filterProcedureTable('%s','%s','%s')", $params["date"], $params["priority"], $params["dateOrder"]);
            try {
                return self::$db->conn->query($query);
            }
            catch (Exception $e){
                return false;
            }
        } else if( $table=="Pacjenci" ){
            $desiredKeys = array('name', 'surname', 'pesel');
            $params = array_intersect_key($parameters, array_flip($desiredKeys));
            $query = sprintf("CALL filterPatientsTable('%s','%s','%s')", $params["name"], $params["surname"], $params["pesel"]);
            try {
                return self::$db->conn->query($query);
            }
            catch (Exception $e){
                return false;
            }
        }
    }

    public static function columns($table) {
        $cols = [
            'Lekarze' => ["ID_Lekarza", "Imie", "Nazwisko", "Specjalizacja", "Telefon", "ID_Oddzialu"],
            'Oddzialy' => ["ID_Oddzialu", "Budynek", "Sektor", "Ulica"],
            'Pacjenci' => ["ID_Pacjenta", "Imie", "Nazwisko", "PESEL", "Telefon", "Kod_pocztowy", "Adres"],
            'Pielegniarki' => ["ID_Pielegniarki", "Imie", "Nazwisko", "Telefon", "ID_Oddzialu"],
            'Zabiegi' => ["ID_Zabiegu", "ID_Pacjenta", "Rodzaj_Zabiegu", "Data_Zabiegu", "ID_Lekarza"],
        ];
        return $cols[$table];
    }

    public static function validate($data): array
    {
        foreach ($data as $row) {
            foreach ($row as $elem){
                $elem = trim($elem);
                if (strlen($elem)==0) return $row;
            }
        }
        return [];
    } 

    public static function export($table){

        $cols = Baza::columns($table);
        $cols = array_slice($cols, 1);
        $parsedData = [$cols];
        $data = self::$db->conn->query("CALL getData('$table')");
        echo "<table class='table table-responsive' style='width: 90%'>";
            echo "<thead>";
            foreach( $cols as $col ) {
                printf("<th scope='col'>%s</th>", $col);
            }
            echo "</thead>";
        while ($rowData = mysqli_fetch_row($data)){
            $rowData = array_slice($rowData, 1);
            print("<tr>");
            foreach ($rowData as $elem){
                printf("<td>%s</td>", $elem);
            }
            print("</tr>");
            array_push($parsedData, $rowData);
        }
        echo "</tbody>";
        echo "</table>";

        return SimpleXLSXGen::fromArray($parsedData);
    }

    public static function import($data, $table) {
        $cols = Baza::columns($table);
        $cols = array_slice($cols, 1);
        $data = array_slice($data, 1);

        $validated = Baza::validate($data, $table);
        // $validated = ['dasad'];
        // Baza::prepareImport($table);
        // Jesli dlugosc zwroconej tablicy jest rowna 0 to znaczy ze wszystkie rekordy sa git
        if ( count($validated) == 0 ) {
            echo "<table class='table table-responsive' style='width: 90%'>";
            echo "<thead>";
            foreach( $cols as $col ) {
                printf("<th scope='col'>%s</th>", $col);
            }
            echo "</thead>";
    
            echo "<tbody>";
            foreach ($data as $row){
                print("<tr>");
                foreach ($row as $elem){
                    printf("<td>%s</td>", $elem);
                }
                print("</tr>");
            }
            echo "</tbody>";
            echo "</table>";

            if ( Baza::prepareImport($table) == true) {
                self::$db->conn->query("SET FOREIGN_KEY_CHECKS=0");
                if ($table=='Lekarze'){
                    $query = "INSERT INTO Lekarze(Imie, Nazwisko, Specjalizacja, Telefon, ID_Oddzialu) VALUES ('%s', '%s', '%s', '%s', '%s')";
                    foreach($data as $row){
                        self::$db->conn->query(vsprintf($query, $row));
                    }
                }

                else if ($table=='Pielegniarki'){
                    $query = "INSERT INTO Pielegniarki(Imie, Nazwisko, Telefon, ID_Oddzialu) VALUES ('%s', '%s', '%s', '%s')";
                    foreach($data as $row){
                        self::$db->conn->query(vsprintf($query, $row));
                    }
                }

                else if ($table=='Oddzialy'){
                    $query = "INSERT INTO Oddzialy(Budynek, Sektor, Ulica) VALUES ('%s', '%s', '%s')";
                    foreach($data as $row){
                        self::$db->conn->query(vsprintf($query, $row));
                    }
                }

                else if ($table=='Pacjenci'){
                    $query = "INSERT INTO Pacjenci(Imie, Nazwisko, PESEL, Telefon, Kod_Pocztowy, Adres) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')";
                    foreach($data as $row){
                        self::$db->conn->query(vsprintf($query, $row));
                    }
                }

                else if ($table=='Zabiegi'){
                    $query = "INSERT INTO Zabiegi(ID_Pacjenta, Rodzaj_Zabiegu, Data_Zabiegu, ID_Lekarza) VALUES ('%s', '%s', '%s', '%s')";
                    foreach($data as $row){
                        self::$db->conn->query(vsprintf($query, $row));
                    }
                }
                self::$db->conn->query("SET FOREIGN_KEY_CHECKS=1");
            }

        } else {
            printf("Dany rekord jest niepoprawny: %s", print_r($validated));
        }
    }
}   
?>