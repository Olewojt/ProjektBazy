<?php
    include 'db.php';
    include 'SimpleXLSX.php';
    use Shuchkin\SimpleXLSX;
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
                <li><a href="mockup.php?name=Lekarze" class="nav-link px-4 link-dark">Lekarze</a></li>
                <li><a href="mockup.php?name=Pielegniarki" class="nav-link px-4 link-dark">Pielegniarki</a></li>
                <li><a href="mockup.php?name=Pacjenci" class="nav-link px-4 link-dark">Pacjenci</a></li>
                <li><a href="mockup.php?name=Zabiegi" class="nav-link px-4 link-dark">Zabiegi</a></li>
                <li><a href="mockup.php?name=Oddzialy" class="nav-link px-4 link-dark">Oddziały</a></li>
            </ul>
        </header>

        <form enctype="multipart/form-data" method="POST" action="dataImport.php">
            <input type='file' name='file' accept='.xlsx'>
            <button type="submit" class="btn btn-primary">Dodaj</button>
        </form>

        <?php
            // print_r($_FILES['file']['tmp_name']);
            $file = SimpleXLSX::parse($_FILES['file']['tmp_name']); // Sciezka do pliku ze zmiennej globalnej od php (php tworzy plik tymczasowy)
            $data = $file->rows();
            echo(count($data[0]));
            echo('<br/>');
            foreach($data as $row){
                foreach($row as $r){
                    print_r($r);
                    print_r(" ");
                }
                echo "<br>";
            }
        ?>
    </div>
</body>
</html>