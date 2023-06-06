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
?>