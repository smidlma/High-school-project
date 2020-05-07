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

<?php
require "db_connect.php";

$query = "UPDATE servisni_objednavka SET stav = 'probíhá' WHERE datum < DATE(CURDATE()) AND ukonceno IS null";
$conn->query($query);
$conn->close();
?>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Objednávky</title>
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
                    <li class="nav-item active">
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
        <div class="row mt-5">
            <div class="col-md-12">
                <h1 class="display-4">Probíhající servis</h1>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <table id="myTable" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Datum</th>
                            <th>Provozovatel</th>
                            <th>Auto</th>
                            <th>Důvod</th>
                            <th>Stav</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-5 mb-5">

            <div class="btn-group" role="group">
                <div class="col-md-12">
                    <button id="add" class="btn btn-info form-group"><span><i class="fas fa-plus-circle"></i></span>
                        Přidat
                        záznamy
                        k zásahu</button>
                    <button id="detail" class="btn btn-secondary form-group"><span><i class="fas fa-search"></i></span>
                        Zobrazit
                        detail</button>
                    <button id="dokoncit" class="btn btn-success form-group"><span><i class="fas fa-check"></i></span>
                        Dokončit
                        objednávku</button>
                    <button id="storno" class="btn btn-danger form-group">Storno</button>
                </div>
            </div>

        </div>

    </div>

    <form id="updateStav" action="db_updateStav.php" method="POST">
        <input name="servisni_objednavka_id" id="objID" type="text" style="display: none !important;">
        <input name="from" type="text" value="objednavky" style="display: none !important;">
        <input type="text" name="akce" id="akce" style="display: none !important;">
    </form>

 <!-- Detail Modal -->
 <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div id="txtHint"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END Modal -->

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
                                <form id="formAddRadek" action="db_add_radek_objednavka.php" method="POST">
                                    <div class="form-group">
                                        <label for="servisakS">Servisní pracovník</label>
                                        <select class="form-control" id="servisakS">
                                            <?php
include 'db_connect.php';
$query = "SELECT servisak_id, CONCAT(jmeno,' ',prijmeni) as servisak FROM servisak WHERE valid = 0;";
$result = $conn->query($query);
while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    echo "<option value=" . $row['servisak_id'] . ">" . $row['servisak'] . "</option>";

}

?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="datum">Datum: </label>
                                        <input name="datum" type="date" class="form-control" id="datum" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="selectType">Typ zásahu</label>
                                        <select class="form-control" id="selectType">
                                            <?php
include 'db_connect.php';
$query = "SELECT typ_zasahu_id,nazev,cena FROM typ_zasahu WHERE valid = 0;";
$result = $conn->query($query);
while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    echo "<option value=" . $row['cena'] . "/" . $row['typ_zasahu_id'] . ">" . $row['nazev'] . "</option>";

}

?>
                                        </select>
                                    </div>
                                    <div id="cenaB" class="form-group">
                                        <label for="cena">Cena: </label>
                                        <input type="text" class="form-control" name="cena" id="cena" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="popis">Popis: </label>
                                        <textarea class="form-control" name="popis" id="popis" cols="30" rows="5"></textarea>
                                    </div>
                                    <input value="1" type="text" name="typ_zasahu_id" id="typZasahuId" style="display: none !important;">
                                    <input type="text" name="servisni_objednavka_id" id="servisni_objednavka_id" style="display: none !important;">
                                    <input value="1" type="text" name="servisak_id" id="servisak" style="display: none !important;">
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

    <!-- Confirmation Modal Storno -->
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


    <!-- Confirmation Modal -->
    <div class="modal fade" id="accept" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Dokončit servis ?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="servis"></p>
                </div>
                <div class="modal-footer">
                    <button id="confirmAccept" type="button" class="btn btn-primary">Ano</button>
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

            $('#dokoncit').click(function () {
                if ($('#myTable tbody tr').hasClass('selected')) {
                    $('#accept').modal('show');
                    var tr = table.$('tr.selected').closest('tr');
                    var row = table.row(tr);
                    var text = row.data().datum + " " + row.data().auto + " " + row.data().provozovatel;

                    $('#objID').val(row.data().servisni_objednavka_id);
                    $('#servis').text(text);
                    $('#akce').val('dokončeno');
                }
            });


            $('#confirmAccept').click(function () {

                $('#updateStav').trigger('submit');
            });

            $('#storno').click(function () {
                if ($('#myTable tbody tr').hasClass('selected')) {
                    $('#confirm').modal('show');
                    var tr = table.$('tr.selected').closest('tr');
                    var row = table.row(tr);
                    var text = row.data().datum + " " + row.data().auto + " " + row.data().provozovatel;
                    $('#objID').val(row.data().servisni_objednavka_id);
                    $('#objednavka').text(text);
                    $('#akce').val('storno')

                }

            });


            $('#confirmStorno').click(function () {

                $('#updateStav').trigger('submit');
            });


            $('#selectType').click(function () {
                var value = $('#selectType option:selected').val();
                var position = value.search('/');
                var cena = value.substring(0, position);
                var typZasahuId = value.substring(position + 1);
                //alert(value + " " + cena + " " + typZasahuId);
                $('#cena').val(cena);
                $('#typZasahuId').val(typZasahuId);


            });

            $('#servisakS').click(function () {


                $('#servisak').val($('#servisakS option:selected').val());

            });

            $('#myTable tbody').on('click', 'tr', function () {

                if ($(this).hasClass('selected')) {

                    $(this).removeClass('selected');

                }
                else {
                    var tr = table.$('tr').closest('tr');
                    var row = table.row(tr);
                    if (row.data().datum != "") {
                        table.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                    }



                }

            });
            $('#ok').click(function () {
                $('#formAddRadek').trigger('submit');
            })
            $('#formAddRadek').submit(function (event) {
                if ($('#datum').val() == "") {
                    $('#datum').css("border-color", "red");

                    event.preventDefault();
                } else {
                    $('#datum').removeAttr('style');
                }
                if ($('#cena').val() == "") {
                    $('#cena').css("border-color", "red");
                    event.preventDefault();
                } else {
                    $('#cena').removeAttr('style');
                }
            });
            $('#add').click(function () {
                if ($('#myTable tbody tr').hasClass('selected')) {
                    $('#myModal').modal('show');
                    var tr = table.$('tr.selected').closest('tr');
                    var row = table.row(tr);
                    $('#servisni_objednavka_id').val(row.data().servisni_objednavka_id);
                    //alert(row.data().provozovatel);

                }
            });

            $('#detail').click(function () {
                if ($('#myTable tbody tr').hasClass('selected')) {
                    var tr = table.$('tr.selected').closest('tr');
                    var row = table.row(tr);
                    var id = row.data().servisni_objednavka_id;

                    $("#detailModal").modal('show');
                    $('#detailModalTitle').text(row.data().datum + " / " + row.data().auto + " / " + row.data().provozovatel);
                    showInformation(id);
                }
            });

            function showInformation(row) {
                if (window.XMLHttpRequest) {
                    xmlhttp = new XMLHttpRequest();
                } else {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "db_getInfo.php?q=" + row, true);
                xmlhttp.send();
            }

            var table = $('#myTable').DataTable({
                "ajax": "db_select_objednavky.php",
                responsive: {
                    details: true
                },
                "columns": [

                    { "data": "datum" },
                    { "data": "provozovatel" },
                    { "data": "auto" },
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

        });
    </script>
</body>

</html>