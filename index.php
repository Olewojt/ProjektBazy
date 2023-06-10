<?php 
    include __DIR__."/SimpleXLSX.php";
    include 'db.php';
    use Shuchkin\SimpleXLSX;
    include 'forms.php';

    $db = Baza::getConnection();
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Szpital</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    </head>

    <body>
        <div class="container">
            <header class="align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
                    <ul class="nav col-10 col-md-auto mb-2 justify-content-center mb-md-0">
                        <li><a href="index.php?table=Lekarze" class="nav-link px-4 link-dark">Lekarze</a></li>
                        <li><a href="index.php?table=Pielegniarki" class="nav-link px-4 link-dark">Pielegniarki</a></li>
                        <li><a href="index.php?table=Pacjenci" class="nav-link px-4 link-dark">Pacjenci</a></li>
                        <li><a href="index.php?table=Zabiegi" class="nav-link px-4 link-dark">Zabiegi</a></li>
                        <li><a href="index.php?table=Oddzialy" class="nav-link px-4 link-dark">Oddziały</a></li>
                        <a href='add.php' class='pe-4'><button type="button" class="btn btn-primary">Dodaj</button></a>
                        <a href='dataImport.php' class='pe-4'><button type="button" class="btn btn-primary">Importuj</button></a>
                        <a href='dataExport.php'><button type="button" class="btn btn-primary">Exportuj</button></a>
                    </ul>
            </header>
        </div>

        <?php
            if(isset($_GET['table'])){
                if($_GET['table']=="Zabiegi"){
                    echo $zabiegiForm;
                } else if ($_GET['table']=="Pacjenci"){
                    echo $pacjenciForm;
                }
            }
        ?>


        <div class="row justify-content-center">
            <table class="table table-responsive" style="width: 90%">
                <?php
                    if(isset($_GET['dateOrder']) & isset($_GET['date']) & isset($_GET['priority']) ){
                        $parameters = [
                            "dateOrder" => $_GET['dateOrder'],
                            "date" => $_GET['date'],
                            "priority" => $_GET['priority'],
                        ];
                        $tab = Baza::filter($_GET['table'], $parameters);
                    } else if(isset($_GET['name']) & isset($_GET['surname']) & isset($_GET['pesel'])){
                        $parameters = [
                            "name" => $_GET['name'],
                            "surname" => $_GET['surname'],
                            "pesel" => $_GET['pesel'],
                        ];
                        $tab = Baza::filter($_GET['table'], $parameters);
                    }
                    else {
                        $tab = Baza::getTable($_GET['table']); 
                    }

                    //$db = Baza::getConnection(); // Utworz obiekt baza ktory inicjuje połączenie z bazą
                    // Obiekt już istnieje więc można wykonywać funckje statyczne na tej klasie
                    if($tab){
                        $cols = Baza::columns($_GET['table']);
    
                        echo "<thead>";
                            foreach($cols as $col) {
                                echo "<th scope='col'>".$col."</th>";
                            }
                        echo "</thead>";
    
                        echo "<tbody>";
                            while ($row = $tab->fetch_assoc()) {
                                echo "<tr>";
                                foreach ($row as $data) {
                                    echo "<td>".$data."</td>";
                                }
                                echo "</tr>";
                            }
                        echo "</tbody>";
                    } else {
                        echo "<div class='text-center'>Nie ma takiej tabeli</div>";
                    }
                ?>
            </table>
        </div>
    </body>
</html>