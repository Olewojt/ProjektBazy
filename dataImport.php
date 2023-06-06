<?php
    include 'db.php';
    include 'SimpleXLSX.php';
    use Shuchkin\SimpleXLSX;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Szpital - import</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <header class="align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">

            <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                <li><a href="index.php?table=Lekarze" class="nav-link px-4 link-dark">Lekarze</a></li>
                <li><a href="index.php?table=Pielegniarki" class="nav-link px-4 link-dark">Pielegniarki</a></li>
                <li><a href="index.php?table=Pacjenci" class="nav-link px-4 link-dark">Pacjenci</a></li>
                <li><a href="index.php?table=Zabiegi" class="nav-link px-4 link-dark">Zabiegi</a></li>
                <li><a href="index.php?table=Oddzialy" class="nav-link px-4 link-dark">Oddziały</a></li>
            </ul>
        </header>
        
        <div class="container d-flex justify-content-center">
            <h2>Wybierz jakie dane chcesz zaimportować<hr></h2>
        </div>
        <div class="container d-flex justify-content-around">
                <a href="dataImport.php?table=Lekarze"><button class="btn btn-primary">Lekarze</button></a>
                <a href="dataImport.php?table=Pielegniarki"><button class="btn btn-primary">Pielegniarki</button></a>
                <a href="dataImport.php?table=Pacjenci"><button class="btn btn-primary">Pacjenci</button></a>
                <a href="dataImport.php?table=Zabiegi"><button class="btn btn-primary">Zabiegi</button></a>
                <a href="dataImport.php?table=Oddzialy"><button class="btn btn-primary">Oddziały</button></a>
        </div>

        <div class="container d-flex justify-content-around m-3">
            <?php
                if (isset($_GET['table'])){
                    $table = $_GET['table'];
                    $db = Baza::getConnection();
                    printf('
                        <h3>%s</h3>
                        <form enctype="multipart/form-data" method="POST" action="dataImport.php?table=%s">
                            <input type="file" name="file" accept=".xlsx">
                            <input type="hidden" name="table" value="%s">
                            <button type="submit" class="btn btn-primary">Dodaj</button>
                        </form>
                        </div>
                    ', $table, $table, $table);
                    if(!empty($_FILES['file']['tmp_name'])){
                        $file = SimpleXLSX::parse($_FILES['file']['tmp_name']); // Sciezka do pliku ze zmiennej globalnej od php (php tworzy plik tymczasowy)
                        $data = $file->rows();

                        if ($_POST['table']=="Lekarze"){
                            Baza::import($data, "Lekarze");
                        }
                        else if ($_POST['table']=="Pielegniarki"){
                            Baza::import($data, "Pielegniarki");
                        }
                        else if ($_POST['table']=="Pacjenci"){
                            Baza::import($data, "Pacjenci");
                        }
                        else if ($_POST['table']=="Zabiegi"){
                            Baza::import($data, "Zabiegi");
                        }
                        else if ($_POST['table']=="Oddzialy"){
                            Baza::import($data, "Oddzialy");
                        }
                        else {
                            echo "Wystąpił błąd!";
                        }
                    }
                }
            ?>
    </div>
</body>
</html>