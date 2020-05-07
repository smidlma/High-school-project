<?php

session_start();
if (isset($_SESSION['admin'])) {
    if ($_SESSION['admin'] == 0) {
        header("Location: userDashboard.php");
    }
} else {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Provozovatelé</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
        crossorigin="anonymous">

</head>

<body>

      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php"><span><i class="fa fa-home"></i></span> DashBoard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="objednavky.php">Servis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="auta.php">Auta</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="provozovatele.php">Provozovatelé</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="historie.php">Historie</a>
                    </li>

                </ul>
                <form class="form-inline">
                    <button id="logoutBtn" type="button" class="btn btn-outline-light mr-sm-3 my-2 my-sm-0">Odhlásit se</button>
                    <a href="nastaveni.php"><i class="fas fa-sliders-h fa-lg" style="color: white;"></i></a>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php

if (isset($_SESSION['info'])) {

    $info = $_SESSION['info'];

    echo "<div class='mt-2 alert alert-danger alert-dismissible fade show' role='alert'> $info <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                        </button>
                                </div>";

    unset($_SESSION['info']);
}

?>
        <div class="row mt-5">
            <div class="col-md-12">
                <form action="db_add_provozovatel.php" class="col-md-12" method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="firma">Firma</label>
                            <input name="firma" type="text" class="form-control" id="firma" placeholder="Firma">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="firs_name">Jméno</label>
                            <input name="first_name" type="text" class="form-control" id="firs_name" placeholder="Jméno"
                                required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="last_name">Příjmení</label>
                            <input name="last_name" type="text" class="form-control" id="last_name" placeholder="Příjmení"
                                required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="telefon">Telefon</label>
                            <input name="telefon" type="text" class="form-control" id="telefon" placeholder="Telefon"
                                required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="email">E-mail</label>
                            <input name="email" type="email" class="form-control" id="email" placeholder="E-mail"
                                required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="ulice">Ulice</label>
                            <input name="ulice" type="text" class="form-control" id="ulice" placeholder="Ulice"
                                required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="cislo_popisne">Číslo popisné</label>
                            <input name="cislo_popisne" type="text" class="form-control" id="cislo_popisne" placeholder="Číslo popisné"
                                required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="mesto">Město</label>
                            <input name="mesto" type="text" class="form-control" id="mesto" placeholder="Město"
                                required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="psc">PSC</label>
                            <input name="psc" type="text" class="form-control" id="psc" placeholder="PSC" required>
                        </div>

                    </div>
                    <button type="submit" class="btn btn-danger"><span><i class="fas fa-plus-circle"></i></span> Přidat
                        Provozovatele</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <table id="myTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Firma</th>
                            <th>Jméno</th>
                            <th>Telefon</th>
                            <th>E-mail</th>
                            <th>Ulice</th>
                            <th>Číslo popisné</th>
                            <th>Město</th>
                            <th>PSČ</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="DataTables/datatables.min.js"></script>
    <script>
        $(document).ready(function () {

            $('#logoutBtn').click(function () {
                sessionStorage.clear();
                window.location.replace("login.php");
            });

            var table = $('#myTable').DataTable({
                "ajax": "db_select_provozovatele.php",
                responsive: {
                    details: true
                },
                "columns": [
                    { "data": "firma" },
                    { "data": "provozovatel" },
                    { "data": "telefon" },
                    { "data": "email" },
                    { "data": "ulice" },
                    { "data": "cislo_popisne" },
                    { "data": "mesto" },
                    { "data": "psc" },
                ],
                "language": {
                    "decimal": "",
                    "emptyTable": "Žádná data",
                    "info": "Zobrazeno _START_ z _END_ z _TOTAL_ záznamů",
                    "infoEmpty": "Zobrazeno 0 z 0 z 0 záznamů",
                    "infoFiltered": "(filtered from _MAX_ total entries)",
                    "infoPostFix": "",
                    "thousands": ".",
                    "lengthMenu": "Zobrazit _MENU_ záznamů",
                    "loadingRecords": "Načítání...",
                    "search": "Vyhledat:",
                    "zeroRecords": "Žádná shoda",
                    "paginate": {
                        "first": "První",
                        "last": "Poslední",
                        "next": "Následující",
                        "previous": "Předchozí"
                    },
                    "aria": {
                        "sortAscending": ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    }
                }
            });

        });
    </script>
</body>

</html>