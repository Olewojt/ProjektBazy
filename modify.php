<?php 
    include __DIR__."/SimpleXLSX.php";
    include 'db.php';
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
            if ( isset($_GET['table']) & isset($_GET['record']) ){
                $table = $_GET['table'];
                $id = $_GET['record'];
                $result = Baza::getResource($table, $id);
                if ($table == "Pacjenci"){
                    $form = sprintf($pacjenciEditForm, 
                        $result[1], $result[1],
                        $result[2], $result[2],
                        $result[3], $result[3],    
                        $result[4], $result[4],    
                        $result[5], $result[5],    
                        $result[6], $result[6],
                        $id   
                    );
                    echo $form;
                } else if ($table == "Zabiegi"){
                    $form = sprintf($zabiegiEditForm,
                        $result[1], 
                        $result[2], $result[2],
                        $result[3], 
                        $result[4],
                        $id
                    ); 
                    echo $form;
                } else if ($table == "Lekarze"){
                    $form = sprintf($lekarzeEditForm,
                        $result[1], $result[1],
                        $result[2], $result[2],
                        $result[3], $result[3],
                        $result[4], $result[4],
                        $result[5],
                        $id
                    ); 
                    echo $form;
                } else if ($table == "Pielegniarki"){
                    $form = sprintf($pielegniarkiEditForm,
                        $result[1], $result[1],
                        $result[2], $result[2],
                        $result[3], $result[3],
                        $result[4], 
                        $id
                    ); 
                    echo $form;
                }
                echo "<div class='container d-flex justify-content-center'><a class='btn btn-danger text-center' onclick=\"return confirm('Czy napewno chcesz usunąć?');\" href='remove.php?table=".$_GET['table']."&record=".$_GET['record']."'>Usuń</a></div>";
            }
        ?>

    </body>
</html>