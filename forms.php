<?php
$zabiegiForm = '<div class="container">
                <form method="GET" action="index.php">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="dateOrder">Kolejność dat</label>
                                <select class="form-control" name="dateOrder">
                                <option value=""></option>
                                <option value="asc">Rosnąco</option>
                                <option value="desc">Malejąco</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="date">Data</label>
                                <input type="date" class="form-control" name="date">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="priority">Priorytet</label>
                                <select class="form-control" name="priority">
                                    <option value=""></option>
                                    <option value="PILNE">PILNE</option>
                                    <option value="RUTYNA">RUTYNA</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-md-6 offset-md-3 text-center">
                            <input type="text" class="form-control" name="table" value="Zabiegi" hidden>
                            <button class="btn btn-success btn-block w-75">Szukaj</button>
                        </div>
                    </div>
                </form>
            </div>';

$pacjenciForm = '<div class="container">
            <form method="GET" action="index.php">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Imię</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="surname">Nazwisko</label>
                            <input type="text" class="form-control" name="surname">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="pesel">Pesel</label>
                            <input type="text" class="form-control" name="pesel">
                        </div>
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-md-6 offset-md-3 text-center">
                        <input type="text" class="form-control" name="table" value="Pacjenci" hidden>
                        <button class="btn btn-success btn-block w-75">Szukaj</button>
                    </div>
                </div>
            </form>
        </div>';

$pacjenciEditForm = '<div class="container">
    <form method="GET" action="update.php">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Imię</label>
                    <input type="text" class="form-control" name="name" value="%s" placeholder="%s">
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="surname">Nazwisko</label>
                    <input type="text" class="form-control" name="surname" value="%s" placeholder="%s">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="pesel">Pesel</label>
                    <input type="text" class="form-control" name="pesel" value="%s" placeholder="%s">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone">Telefon</label>
                    <input type="text" class="form-control" name="phone" value="%s" placeholder="%s">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="zipCode">Kod pocztowy</label>
                    <input type="text" class="form-control" name="zipCode" value="%s" placeholder="%s">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="address">Adres</label>
                    <input type="text" class="form-control" name="address" value="%s" placeholder="%s">
                </div>
            </div>
        </div>
        </div>

        <div class="row my-2">
            <div class="col-md-6 offset-md-3 text-center">
                <input type="text" class="form-control" name="table" value="Pacjenci" hidden>
                <input type="text" class="form-control" name="record" value="%s" hidden>
                <button class="btn btn-success btn-block w-75">Zmien</button>
            </div>
        </div>
    </form>
    </div>';

$zabiegiEditForm = '<div class="container">
<form method="GET" action="update.php">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="patient_id">ID_Pacjenta</label>
                <input type="number" class="form-control" name="patient_id" value="%s">
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group">
                <label for="type">Rodzaj Zabiegu</label>
                <select name="type" class="form-control" required>
                    <option value="%s">%s</option>
                    <option value="RUTYNA">RUTYNA</option>
                    <option value="PILNE">PILNE</option>
                </select>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group py-2">
                <label for="Data_Zabiegu">Data Zabiegu</label>
                <input type="date" class="form-control" name="Data_Zabiegu" value="%s" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group py-2">
                <label for="doctor_id">ID_Lekarza</label>
                <input type="number" class="form-control" name="doctor_id" value="%s" required>
            </div>
        </div>
    </div>

    <div class="row my-2">
        <div class="col-md-6 offset-md-3 text-center">
            <input type="text" class="form-control" name="table" value="Zabiegi" hidden>
            <input type="text" class="form-control" name="record" value="%s" hidden>
            <button class="btn btn-success btn-block w-75">Zmien</button>
        </div>
    </div>
</form>
</div>';

$lekarzeEditForm = '<div class="container">
    <form method="GET" action="update.php">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Imię</label>
                    <input type="text" class="form-control" name="name" value="%s" placeholder="%s">
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="surname">Nazwisko</label>
                    <input type="text" class="form-control" name="surname" value="%s" placeholder="%s">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="specialty">Specjalizacja</label>
                    <input type="text" class="form-control" name="specialty" value="%s" placeholder="%s">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone">Telefon</label>
                    <input type="text" class="form-control" name="phone" value="%s" placeholder="%s">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="oddzial">ID_Oddziału</label>
                    <input type="number" class="form-control" name="oddzial" value="%s">
                </div>
            </div>

        </div>

        <div class="row my-2">
            <div class="col-md-6 offset-md-3 text-center">
                <input type="text" class="form-control" name="table" value="Lekarze" hidden>
                <input type="text" class="form-control" name="record" value="%s" hidden>
                <button class="btn btn-success btn-block w-75">Zmien</button>
            </div>
        </div>
    </form>
    </div>';

$pielegniarkiEditForm = '<div class="container">
    <form method="GET" action="update.php">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Imię</label>
                    <input type="text" class="form-control" name="name" value="%s" placeholder="%s">
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="surname">Nazwisko</label>
                    <input type="text" class="form-control" name="surname" value="%s" placeholder="%s">
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone">Telefon</label>
                    <input type="text" class="form-control" name="phone" value="%s" placeholder="%s">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="oddzial">ID_Oddziału</label>
                    <input type="number" class="form-control" name="oddzial" value="%s">
                </div>
            </div>
        </div>

        <div class="row my-2">
            <div class="col-md-6 offset-md-3 text-center">
                <input type="text" class="form-control" name="table" value="Pielegniarki" hidden>
                <input type="text" class="form-control" name="record" value="%s" hidden>
                <button class="btn btn-success btn-block w-75">Zmien</button>
            </div>
        </div>
    </form>
    </div>';
?>