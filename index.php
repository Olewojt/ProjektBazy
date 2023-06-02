<!DOCTYPE html>

<html>
    <head>
        <title>Mockup</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    </head>

    <body>
        <div class="container">
            <header class="align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
                    <ul class="nav col-10 col-md-auto mb-2 justify-content-center mb-md-0">
                        <li><a href="index.php?name=Lekarze" class="nav-link px-4 link-dark">Lekarze</a></li>
                        <li><a href="index.php?name=Pielegniarki" class="nav-link px-4 link-dark">Pielegniarki</a></li>
                        <li><a href="index.php?name=Pacjenci" class="nav-link px-4 link-dark">Pacjenci</a></li>
                        <li><a href="index.php?name=Zabiegi" class="nav-link px-4 link-dark">Zabiegi</a></li>
                        <li><a href="index.php?name=Oddzialy" class="nav-link px-4 link-dark">Oddziały</a></li>
                        <a href='newPatient.php' class='px-4'><button type="button" class="btn btn-primary">Dodaj</button></a>
                        <a href='dataImport.php'><button type="button" class="btn btn-primary">Importuj</button></a>
                    </ul>
            </header>
        </div>

        <div class="row justify-content-center">
            <table class="table table-responsive" style="width: 90%">
                <?php
                    include __DIR__."/SimpleXLSX.php";
                    include 'db.php';
                    use Shuchkin\SimpleXLSX;

                    $db = Baza::getConnection(); // Utworz obiekt baza ktory inicjuje połączenie z bazą
                    $tab = Baza::getTable($_GET['name']); // Obiekt już istnieje więc można wykonywać funckje statyczne na tej klasie i jak oliwka brazil skakać na kutasie
                    $cols = Baza::columns($_GET['name']);

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
                ?>
            </table>
        </div>
    </body>
</html>