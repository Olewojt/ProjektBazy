<?php
    include_once 'db.php';
    include_once 'SimpleXLSXGen.php';
    use Shuchkin\SimpleXLSXGen;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Mockup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <header class="align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">

            <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                <li><a href="index.php?name=Lekarze" class="nav-link px-4 link-dark">Lekarze</a></li>
                <li><a href="index.php?name=Pielegniarki" class="nav-link px-4 link-dark">Pielegniarki</a></li>
                <li><a href="index.php?name=Pacjenci" class="nav-link px-4 link-dark">Pacjenci</a></li>
                <li><a href="index.php?name=Zabiegi" class="nav-link px-4 link-dark">Zabiegi</a></li>
                <li><a href="index.php?name=Oddzialy" class="nav-link px-4 link-dark">Oddziały</a></li>
            </ul>
        </header>
        
        <div class="container d-flex justify-content-center">
            <h2>Wybierz jakie dane chcesz exportować<hr></h2>
        </div>
        <div class="container d-flex justify-content-around">
            <a href="dataExport.php?name=Lekarze"><button class="btn btn-primary">Lekarze</button></a>
            <a href="dataExport.php?name=Pielegniarki"><button class="btn btn-primary">Pielegniarki</button></a>
            <a href="dataExport.php?name=Pacjenci"><button class="btn btn-primary">Pacjenci</button></a>
            <a href="dataExport.php?name=Zabiegi"><button class="btn btn-primary">Zabiegi</button></a>
            <a href="dataExport.php?name=Oddzialy"><button class="btn btn-primary">Oddziały</button></a>
        </div>
        <hr>

        <?php
            if(isset($_GET['name'])){
                $db = Baza::getConnection();
                $nazwa = $_GET['name'];
                if ($nazwa=="Lekarze" | $nazwa=="Pielegniarki" | $nazwa=="Pacjenci" | $nazwa=="Zabiegi" | $nazwa=="Oddzialy"){
                    printf("
                        <div class='container mt-3'>
                            <div class='d-flex justify-content-center'>
                                <a href='/export/%s.xlsx' class='btn btn-success w-50'>Pobierz!</a>
                            </div>
                        </div>
                        <hr>
                    ", $nazwa);
                    $xlsx = Baza::export($nazwa);
                    $xlsx->saveAs("export/$nazwa.xlsx");
                }
            }
        ?>
       
</body>
</html>