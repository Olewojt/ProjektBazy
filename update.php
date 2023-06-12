<html>

<head>
    <title>Szpital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
<?php
    include 'db.php';

    if (isset($_GET['table']) & isset($_GET['record'])){
        $db = Baza::getConnection();
        $table = $_GET['table'];
        $id = $_GET['record'];
        $status = Baza::update($table,$id,$_GET);
        if ($status) {
            echo "<div class='container-fluid text-center my-5'><p>Pomyślnie zmodyfikowano dane</p>";
            echo "<a class='btn btn-primary' href='http://localhost:8000/index.php?table=".$table."'>Powrót</a></div>";
        }
        else {
            echo "<div class='container-fluid text-center my-5'><p>Wystąpił nieoczekiwany błąd!</p>";
            echo "<a class='btn btn-primary' href='http://localhost:8000/index.php?table=".$table."'>Powrót</a></div>";
        }
    }
?>
</body>
</html>