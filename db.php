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

    public static function getProcedureByDate(int $filter){
        return self::$db->conn->query("CALL filterProcedureDate($filter)");
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

    public static function import($data, $table) {
        $cols = Baza::columns($table);
        $cols = array_slice($cols, 1);
        $data = array_slice($data, 1);

        echo "<table class='table table-responsive' style='width: 90%'>";
        echo "<thead>";
        foreach( $cols as $col ) {
            printf("<th scope='col'>%s</th>", $col);
        }
        echo "</thead>";

        echo "<tbody>";
        foreach ($data as $row){
            print(vsprintf("
            <tr>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
            </tr>
            ", $row));
        }
        echo "</tbody>";
        echo "</table>";
        // self::$db->conn->query("CALL import($table)");

        // if ($table=='Lekarze'){
        //     foreach($data as $row){
        //         self::$db->conn->quert("INSERT INTO ")
        //     }
        // }

    }
}   
?>