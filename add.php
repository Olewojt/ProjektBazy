<?php 
    include 'db.php';

    $form1 = '
        <form method="POST" onsubmit="return confirm (\'Czy napewno chcesz dodać pacjenta?\');" action="add.php?name=Pacjent">
        <div class="form-group">
            <label for="name">Imie</label>
            <input type="text" class="form-control" name="name" maxlength="100" required>
        </div>
        <div class="form-group">
            <label for="surname">Nazwisko</label>
            <input type="text" class="form-control" name="surname" maxlength="100" required>
        </div>

        <div class="form-group">
            <label for="pesel">PESEL</label>
            <input type="text" class="form-control" name="pesel" maxlength="11" required>
        </div>

        <div class="form-group">
            <label for="phone">Telefon</label>
            <input type="text" class="form-control" name="phone" maxlength="9" required>
        </div>
        
        <div class="form-group">
            <label for="zip_code">Kod pocztowy</label>
            <input type="text" class="form-control" name="zip_code" maxlength="6" required>
        </div>

        <div class="form-group mb-3">
            <label for="address">Adres</label>
            <input type="text" class="form-control" name="address" maxlength="150" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Dodaj</button>
    </form>
    ';

    $form2 = '
        <form method="POST" onsubmit="return confirm (\'Czy napewno chcesz dodać zabieg?\');" action="add.php?name=Zabieg">
        <div class="form-group">
            <label for="ID_Pacjenta">ID Pacjenta</label>
            <input type="number" min="1" class="form-control" name="ID_Pacjenta" required>
        </div>
        
        <div class="form-group py-2">
            <label for="rodzaj_zabiegu">Rodzaj Zabiegu</label>
            <select name="Rodzaj_Zabiegu" class="form-control" required>
                <option value="RUTYNA">Rutyna</option>
                <option value="PILNE">Pilne</option>
            </select>
        </div>

        <div class="form-group py-2">
            <label for="Data_Zabiegu">Data Zabiegu</label>
            <input type="date" class="form-control" name="Data_Zabiegu" required>
        </div>

        <div class="form-group py-2">
            <label for="ID_Lekarza">ID Lekarza</label>
            <input type="number" min="1" class="form-control" name="ID_Lekarza" required>
        </div>

        <button type="submit" class="btn btn-primary">Dodaj</button>
    </form>
    ';
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Szpital - Dodaj</title>
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
                <h2>Dodaj<hr></h2>
            </div>
            <div class="container d-flex justify-content-around">
                <a href="add.php?table=Pacjent"><button class="btn btn-primary">Pacjenta</button></a>
                <a href="add.php?table=Zabieg"><button class="btn btn-primary">Zabieg</button></a>
            </div>

            <?php
                if(isset($_GET['table'])){
                    $name = $_GET['table'];
                    if($name=="Pacjent"){
                        print($form1);
                    }
                    else if($name=="Zabieg"){
                        print($form2);
                    }

                    $valid = False;
                    foreach ($_POST as $elem){
                        if (empty($elem)){
                            $valid = False;
                        } else {
                            $valid = True;
                        }
                    }

                    if($valid){
                        $db = Baza::getConnection();
                        if ($name == "Pacjent") {
                            Baza::addPatient(
                                $_POST['name'],
                                $_POST['surname'],
                                $_POST['pesel'],
                                $_POST['phone'],
                                $_POST['zip_code'],
                                $_POST['address']
                            );
                        }
                        else if ($name == "Zabieg"){
                            Baza::addProcedure(
                                $_POST['ID_Pacjenta'],
                                $_POST['Rodzaj_Zabiegu'],
                                $_POST['Data_Zabiegu'],
                                $_POST['ID_Lekarza']
                            );
                        }
                    }
                }
            ?>
        </div>
    </body>
</html>