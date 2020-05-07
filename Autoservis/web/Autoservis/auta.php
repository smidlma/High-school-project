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
    <title>Auta</title>
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
                    <li class="nav-item active">
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
        <?php

if (isset($_SESSION['info'])) {

    $info = $_SESSION['info'];

    echo "<div class='mt-2 alert alert-danger alert-dismissible fade show' role='alert'> $info <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                        </button>
                                </div>";

    unset($_SESSION['info']);
}
if (isset($_SESSION['info2'])) {

    $info = $_SESSION['info2'];

    echo "<div class='mt-2 alert alert-danger alert-dismissible fade show' role='alert'> $info2 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                        </button>
                                </div>";

    unset($_SESSION['info2']);
}

?>

        <div id="info" style="display: none;" class='mt-2 alert alert-danger alert-dismissible fade show' role='alert'>
            Provozovatel nebyl vybrán

        </div>

        <div class="row mt-5">
            <div class="col-md-12">
                <form action="db_add_auto.php" class="col-md-12" method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="spz">SPZ</label>
                            <input name="spz" type="text" class="form-control" id="spz" placeholder="SPZ" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="znacka">Značka</label>
                            <input name="znacka" type="text" class="form-control" id="znacka" placeholder="Značka"
                                required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="model">Model</label>
                            <input name="model" type="text" class="form-control" id="model" placeholder="Model"
                                required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="rok_vyroby">Rok výroby</label>
                            <input name="rok_vyroby" type="text" class="form-control" id="rok_vyroby" placeholder="Rok výroby"
                                required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="motor">VIN</label>
                            <input name="motor" type="text" class="form-control" id="motor" placeholder="VIN"
                                required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="provoz">Vybrat provozovatele</label>
                            <input type="button" class="form-control btn btn-info" id="provoz" value="Žádný">
                        </div>

                        <input name="provozovatel" id="provozovatel" type="text" style="display:none" required>
                    </div>
                    <button id="submitBtn" type="submit" class="btn btn-danger"><span><i class="fas fa-plus-circle"></i></span>
                        Přidat
                        Auto</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModal">Vyber provozovatele</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="provozTable" class="table table-hover table-bordered" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Firma</th>
                                <th>Provozovatel</th>
                                <th>E-mail</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>
                    <button id="ok" type="button" class="btn btn-primary">OK</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END Modal -->

    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <table id="myTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Provozovatel</th>
                            <th>SPZ</th>
                            <th>Značka</th>
                            <th>Model</th>
                            <th>Rok výroby</th>
                            <th>VIN</th>
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

            document.getElementById('provozTable').style.cursor = 'pointer';

            $('#submitBtn').click(function () {
                var provozovatel = $('#provozovatel').val();

                if (provozovatel == "") {

                    $('#info').show(100);
                }
            });

            $('#provoz').click(function () {
                $('#myModal').modal('show');
            });

            var provozTable = $('#provozTable').DataTable({
                "ajax": "db_choose_provozovatele.php",
                responsive: {
                    details: true
                },
                "columns": [

                    { "data": "firma" },
                    { "data": "provozovatel" },
                    { "data": "email" },
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

            $('#provozTable tbody').on('click', 'tr', function () {

                if ($(this).hasClass('selected')) {

                    $(this).removeClass('selected');

                    $('#ok').click(function () {
                        $('#provozovatel').val(null);
                        $('#provoz').val("Žádný");
                    });
                }
                else {

                    var tr = $(this).closest('tr');
                    var row = provozTable.row(tr);
                    
                    if (row.data().firma != "") {
                        provozTable.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                        // Vybrání řádku s
                        $('#ok').click(function () {


                            //alert(row.data().provozovatel_id);
                            var selected = row.data().provozovatel_id;
                            $('#provozovatel').val(selected);
                            var selectedName = row.data().provozovatel;
                            $('#provoz').val(selectedName);
                            $('#myModal').modal('hide');
                        });
                    }

                }

            });

            var table = $('#myTable').DataTable({
                "ajax": "db_select_auta.php",
                responsive: {
                    details: true
                },
                "columns": [

                    { "data": "provozovatel" },
                    { "data": "spz" },
                    { "data": "znacka" },
                    { "data": "model" },
                    { "data": "rok_vyroby" },
                    { "data": "motor" },

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