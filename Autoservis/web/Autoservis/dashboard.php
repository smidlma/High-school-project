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
    <title>Dashboard</title>
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
                    <li class="nav-item">
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

        <div id="info" style="display: none;" class='mt-2 alert alert-danger alert-dismissible fade show' role='alert'>
            Vozidlo nebylo vybráno.
        </div>

        <div class="row mt-5">
            <form action="db_add_objednavka.php" method="POST" class="col-md-12" id="formS">
                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label for="datum">Datum</label>
                        <input name="datum" type="date" data-date-format="YYYY MM DD" class="form-control" id="datum"
                            required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="zavada">Důvod</label>
                        <input name="zavada" type="text" class="form-control" id="zavada" placeholder="volitelný...">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="vozidlo">Vybrat vozidlo</label>
                        <input type="button" class="form-control btn btn-info" id="vozidlo" value="Žádné">
                    </div>

                    <input name="auto" id="auto" type="text" style="display:none !important;">
                    <input name="provozovatel" id="provozovatel" type="text" style="display:none !important; ">
                </div>
                <button type="submit" id="send" class="btn btn-danger "><span><i class="fas fa-plus-circle"></i></span>
                    Přidat
                    prohlídku</button>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModal">Vyber vozidlo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="spzTable" class="table table-hover table-bordered" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Provozovatel</th>
                                            <th>Značka</th>
                                            <th>Model</th>
                                            <th>SPZ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="close" type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>
                    <button id="ok" type="button" class="btn btn-primary">OK</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END Modal -->

    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <h1 class="display-4">Aktuální servisní situace</h1>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <table id="myTable" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Datum</th>
                            <th>Auto</th>
                            <th>Jméno</th>
                            <th>Telefon</th>
                            <th>Důvod</th>
                            <th>Stav</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Confirmation -->
    <div class="container mb-5">
        <div class="row mt-3">
            <div class="col-md-12">
                <form id="updateStav" action="db_updateStav.php" method="POST">
                    <input name="servisni_objednavka_id" id="objID" type="text" style="display: none !important;">
                    <input name="from" type="text" value="dashboard" style="display: none !important;">
                    <input name="akce" type="text" value="storno" style="display: none !important;">
                    <button type="button" id="storno" class="btn btn-danger">Storno</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Stornovat objednávku ?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="objednavka"></p>
                </div>
                <div class="modal-footer">
                    <button id="confirmStorno" type="button" class="btn btn-primary">Ano</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Ne</button>
                </div>
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

            document.getElementById('myTable').style.cursor = 'pointer';
            document.getElementById('spzTable').style.cursor = 'pointer';

            $('#storno').click(function () {
                if ($('#myTable tbody tr').hasClass('selected')) {
                    $('#confirm').modal('show');
                    var tr = table.$('tr.selected').closest('tr');
                    var row = table.row(tr);
                    var text = row.data().datum + " " + row.data().auto + " " + row.data().provozovatel;
                    $('#objID').val(row.data().servisni_objednavka_id);
                    $('#objednavka').text(text);


                }

            });

            $('#confirmStorno').click(function () {

                $('#updateStav').trigger('submit');
            });




            $('#formS').submit(function (event) {
                if ($('#vozidlo').val() === "Žádné") {
                    $('#info').show().delay(3000).fadeOut(1000);
                    event.preventDefault();
                }
            });
            var table = $('#myTable').DataTable({
                "ajax": "db_select_dashboard.php",
                responsive: {
                    details: true
                },
                "order": [0, "asc"],
                "columns": [
                    { "data": "datum" },
                    { "data": "auto" },
                    { "data": "provozovatel" },
                    { "data": "telefon" },
                    { "data": "zavada" },
                    { "data": "stav" }
                    
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

            $('#myTable tbody').on('click', 'tr', function () {
                if ($(this).hasClass('selected')) {

                    $(this).removeClass('selected');

                }
                else {

                    var tr = $(this).closest('tr');
                    var row = table.row(tr);
                    if (row.data().datum != "") {
                        table.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                    }

                }

            });


            $('#vozidlo').click(function () {
                $('#myModal').modal('show');
            });

            var spzTable = $('#spzTable').DataTable({
                "ajax": "db_select_auta_dash.php",
                responsive: {
                    details: true
                },
                "columns": [
                    { "data": "provozovatel" },
                    { "data": "znacka" },
                    { "data": "model" },
                    { "data": "spz" },
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
            //
            $('#spzTable tbody').on('click', 'tr', function () {

                if ($(this).hasClass('selected')) {

                    $(this).removeClass('selected');

                    $('#ok').click(function () {
                        $('#provozovatel').val(null);
                        $('#vozidlo').val("Žádné");

                    });
                }
                else {

                    var tr = $(this).closest('tr');
                    var row = spzTable.row(tr);
                    if (row.data().datum != "") {
                        spzTable.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');

                        $('#ok').click(function () {

                            // Vybrání řádku provozovatel + auto
                            var provozovatel = row.data().provozovatel_id
                            $('#provozovatel').val(provozovatel);
                            var auto = row.data().auto_id;
                            $('#auto').val(auto);
                            var nazev = row.data().znacka + " " + row.data().model;
                            $('#vozidlo').val(nazev);

                            $('#myModal').modal('hide');
                        });
                    }


                }


            });

        });
    </script>
</body>

</html>