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
    <title>Nastavení</title>
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
        <div class="row mt-3">
            <div class="col-md-12">
                <h1 class="display-4">Nastavení</h1>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <nav id="myTab">
                    <div class="nav nav-tabs" id="nav-tab">
                        <a class="nav-item nav-link active" id="nav-zasahy-tab" href="#zasahy">Typy zásahů</a>
                        <a class="nav-item nav-link" id="nav-servisak-tab" href="#nav-servisak">Servisní pracovníci</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active mt-3" id="zasahy">
                        <table id="myTable" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Název</th>
                                    <th>Cena</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade mt-3" id="nav-servisak">
                        <table id="myTable2" class="table table-hover table-bordered" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Jméno</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <button class="btn btn-info" id="add">Přidat</button>
                <button class="btn btn-danger" id="delete">Odebrat</button>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModal">Přídání zásahů</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="formAddRadek" action="db_add_z_s.php" method="POST">

                                        <div class="form-group">
                                            <label for="input1" id="label1"></label>
                                            <input id="input1" class="form-control" type="text">
                                        </div>
                                        <div class="form-group">
                                            <label for="input2" id="label2"></label>
                                            <input id="input2" class="form-control" type="text">
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>
                        <button id="ok" type="button" class="btn btn-primary">Přidat</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Modal -->

        <!-- Confirmation Modal -->
        <div class="modal fade" id="accept" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p id="confirmText"></p>
                    </div>
                    <div class="modal-footer">
                        <button id="confirmAccept" type="button" class="btn btn-primary">Ano</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ne</button>
                    </div>
                </div>
            </div>
        </div>

        <form id="deleteTS" action="db_delete_z_s.php" method="POST">
            <input id="del_id" type="text" style="display: none !important;">
        </form>

    </div>
    <script type="text/javascript" src="DataTables/datatables.min.js"></script>
    <script>


        $(document).ready(function () {

            $('#logoutBtn').click(function () {
                sessionStorage.clear();
                window.location.replace("login.php");
            });

            document.getElementById('myTable').style.cursor = 'pointer';
            document.getElementById('myTable2').style.cursor = 'pointer';

            $('#confirmAccept').click(function () {
                $('#deleteTS').trigger('submit');
            });
            $('#ok').click(function () {
                $('#formAddRadek').trigger('submit');
            });
            $('#delete').click(function () {
                if (!$('#nav-zasahy-tab').hasClass('active')) {
                    $('#accept .modal-title').text("Odebrat servisáka ?");
                    var tr = tableServisaci.$('tr.selected').closest('tr');
                    var row = tableServisaci.row(tr);
                    var text = row.data().servisak;
                    $('#confirmText').text(text);
                    $('#del_id').attr("name", "servisak_id")
                    var id = row.data().servisak_id;
                    $('#del_id').val(id);

                } else {
                    $('#accept .modal-title').text("Odebrat typ zásahu ?");
                    var tr = tableTypy.$('tr.selected').closest('tr');
                    var row = tableTypy.row(tr);
                    var text = row.data().nazev + " / " + row.data().cena + " Kč";
                    $('#confirmText').text(text);
                    $('#del_id').attr("name", "typ_zasahu_id")
                    var id = row.data().typ_zasahu_id;
                    $('#del_id').val(id);

                }

                $('#accept').modal('show');
            });

            $('#add').click(function () {
                $('#input1').val(null);
                $('#input2').val(null);

                if (!$('#nav-zasahy-tab').hasClass('active')) {
                    $('#myModal .modal-title').text("Přidat servisáka");
                    $('#label1').text("Jméno");
                    $('#label2').text("Příjmení");
                    $('#input1').attr("name", "jmeno")
                    $('#input2').attr("name", "prijmeni")
                } else {
                    $('.modal-title').text("Přidat typ zásahu");
                    $('#label1').text("Název zásahu");
                    $('#label2').text("Cena");
                    $('#input1').attr("name", "nazev")
                    $('#input2').attr("name", "cena")
                }
                $('#myModal').modal('show');
            });

            $('#myTable tbody').on('click', 'tr', function () {

                if ($(this).hasClass('selected')) {

                    $(this).removeClass('selected');

                }
                else {
                    var tr = tableTypy.$('tr').closest('tr');
                    var row = tableTypy.row(tr);
                    if (row.data().nazev != "") {
                        tableTypy.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                    }



                }

            });

            $('#myTable2 tbody').on('click', 'tr', function () {

                if ($(this).hasClass('selected')) {

                    $(this).removeClass('selected');

                }
                else {
                    var tr = tableServisaci.$('tr').closest('tr');
                    var row = tableServisaci.row(tr);
                    if (row.data().nazev != "") {
                        tableServisaci.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                    }



                }

            });

            $('#myTab a').on('click', function (e) {
                e.preventDefault()
                $(this).tab('show')
            })

            var tableTypy = $('#myTable').DataTable({
                "ajax": "db_select_typy.php",
                responsive: {
                    details: true
                },
                "order": [0, "asc"],
                "columns": [
                    { "data": "nazev" },
                    { "data": "cena" },
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

            var tableServisaci = $('#myTable2').DataTable({
                "ajax": "db_select_servisak.php",
                responsive: {
                    details: true
                },
                "order": [0, "asc"],
                "columns": [
                    { "data": "servisak" },
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