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

    // Mozna sprawdzic czy dane sa poprawne. Albo chuj aby dzialalo jako tako
    public static function addPatient($name, $surname, $pesel, $phone, $zip_code, $address){
        self::$db->conn->query("CALL addPatient('$name', '$surname', '$pesel', '$phone', '$zip_code', '$address')");
    }

    public static function addProcedure($patient_id, $type, $date, $doctor_id){
        self::$db->conn->query("CALL addProcedure('$patient_id', '$type', '$date', '$doctor_id')");
    }

    public static function getProcedureByDate(int $filter){
        return self::$db->conn->query("CALL filterProcedureDate($filter)");
    }

    public static function prepareImport($table) {
        return self::$db->conn->query("CALL importPrepare('$table')");
    }

    public static function filter($table, $parameters) {
        if ($table=="Zabiegi"){
            $desiredKeys = array('dateOrder', 'date', 'surname', 'priority');
            $params = array_intersect_key($parameters, array_flip($desiredKeys));

            $query = "SELECT * FROM Zabiegi WHERE 1=1 ";

            if (!empty($params['date'])){
                $filter = "AND Data_Zabiegu='%s' ";
                $filter = sprintf($filter, $params['date']);
                $concat = "%s %s";
                $query = sprintf($concat, $query, $filter);
            }
            if (!empty($params['priority'])){
                $filter = "AND Rodzaj_Zabiegu='%s' ";
                $filter = sprintf($filter, $params['priority']);
                $concat = "%s %s";
                $query = sprintf($concat, $query, $filter);
            }
            if (!empty($params['dateOrder'])){
                $filter = "ORDER BY Data_Zabiegu %s";
                $filter = sprintf($filter, $params['dateOrder']);
                $concat = "%s %s";
                $query = sprintf($concat, $query, $filter);
            }

            try {
                // print_r($query);
                return self::$db->conn->query($query);
            }
            catch (Exception $e){
                return false;
            }
        } else if( $table=="Pacjenci" ){
            $desiredKeys = array('name', 'surname', 'pesel');
            $params = array_intersect_key($parameters, array_flip($desiredKeys));

            $query = "SELECT * FROM Pacjenci WHERE 1=1 ";

            if (!empty($params['name'])){
                $filter = "AND Imie LIKE '%%%s%%' ";
                $filter = sprintf($filter, $params['name']);
                $concat = "%s %s";
                $query = sprintf($concat, $query, $filter);
            }
            if (!empty($params['surname'])){
                $filter = "AND Nazwisko LIKE '%%%s%%' ";
                $filter = sprintf($filter, $params['surname']);
                $concat = "%s %s";
                $query = sprintf($concat, $query, $filter);
            }
            if (!empty($params['pesel'])){
                $filter = "AND PESEL LIKE '%%%s%%' ";
                $filter = sprintf($filter, $params['pesel']);
                $concat = "%s %s";
                $query = sprintf($concat, $query, $filter);
            }

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