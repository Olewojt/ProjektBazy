<?php 
    include 'db.php';
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
                    <li><a href="index.php?index=0" class="nav-link px-4 link-dark">Lekarze</a></li>
                    <li><a href="index.php?index=1" class="nav-link px-4 link-dark">Pielegniarki</a></li>
                    <li><a href="index.php?index=2" class="nav-link px-4 link-dark">Pacjenci</a></li>
                    <li><a href="index.php?index=3" class="nav-link px-4 link-dark">Zabiegi</a></li>
                    <li><a href="index.php?index=4" class="nav-link px-4 link-dark">Oddziały</a></li>
                </ul>
            </header>

            <form method="POST" onsubmit="return confirm ('Czy napewno chcesz dodać pacjenta?');" action="newPatient.php">
                <div class="form-group">
                    <label for="name">Imie</label>
                    <input type="text" class="form-control" name='name' maxlength="100" required>
                </div>
                <div class="form-group">
                    <label for="surname">Nazwisko</label>
                    <input type="text" class="form-control" name='surname' maxlength="100" required>
                </div>

                <div class="form-group">
                    <label for="pesel">PESEL</label>
                    <input type="text" class="form-control" name='pesel' maxlength="11" required>
                </div>

                <div class="form-group">
                    <label for="phone">Telefon</label>
                    <input type="text" class="form-control" name='phone' maxlength="9" required>
                </div>
                
                <div class="form-group">
                    <label for="zip_code">Kod pocztowy</label>
                    <input type="text" class="form-control" name='zip_code' maxlength="6" required>
                </div>

                <div class="form-group mb-3">
                    <label for="address">Adres</label>
                    <input type="text" class="form-control" name='address' maxlength="150" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Dodaj</button>
            </form>

            <?php
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
                    Baza::addPatient(
                        $_POST['name'],
                        $_POST['surname'],
                        $_POST['pesel'],
                        $_POST['phone'],
                        $_POST['zip_code'],
                        $_POST['address']
                    );
                }
            ?>
        </div>
    </body>
</html>