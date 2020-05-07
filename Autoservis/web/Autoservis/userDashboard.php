<?php
session_start();
if (isset($_SESSION['admin'])) {
    if ($_SESSION['admin'] == 1) {
        header("Location: dashboard.php");
    }
} else {
    header("Location: login.php");
}
?>
<!doctype html>
<html lang="en">

<head>
  <title>Dashboard</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- ICONS -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
    crossorigin="anonymous">
  <!-- DATATABLES -->
  <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css" />

</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="userDashboard.php"><span><i class="fa fa-home"></i></span> Můj Autoservis</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

        </ul>
        <form class="form-inline">
          <button id="logoutBtn" type="button" class="btn btn-outline-light mr-sm-3 my-2 my-sm-0">Odhlásit se</button>
          <a href="userProfile.php"><i class="fas fa-sliders-h fa-lg" style="color: white;"></i></a>
        </form>
      </div>
    </div>
  </nav>

  <?php

if (isset($_SESSION['info'])) {
    echo "<div class='row'>
          <div class='col-md-6 mx-auto mt-5'>
              <div class='alert alert-primary alert-dismissible fade show' role='alert'>
                  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                      <span aria-hidden='true'>&times;</span>
                      <span class='sr-only'>Close</span>
                  </button>
                  <strong>" . $_SESSION['info'] ."</strong>
              </div>
          </div>
  </div>";
    unset($_SESSION['info']);

}
?>
  <!-- orderAlert -->
  <div class='col-md-6 mx-auto mt-5' style="display: none;" id="alert">
    <div class='alert alert-primary alert-dismissible fade show' role='alert'>

      <strong>Chyba objednávky: </strong> Zkontrolujte datum, vozidlo a důvod.
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
                <table id="carsTable" class="table table-hover table-bordered" style="width: 100%;">
                  <thead>
                    <tr>
                      <th>SPZ</th>
                      <th>Auto</th>
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
    <div class="row mt-5">
      <div class="col-md-8">
        <div class="card" id="block1">
          <h5 class="card-header">Aktuální servis</h5>
          <div class="card-body">
            <div class="card-text">
              <div class="col-md-12">
                <table id="myTable" style="width: 100%;" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Datum</th>
                      <th>Auto</th>
                      <th>Stav</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card" id="block2">
          <h5 class="card-header">Objednat servis</h5>
          <div class="card-body">
            <div class="card-text">
              <form action="db_user_order.php" id="order" method="POST">
                <div class="form-group">
                  <label for="date">Důvod: </label>
                  <input type="text" name="zavada" id="zavada" class="form-control" placeholder="např.: Garanční prohlídka"
                    required>
                </div>
                <div class="form-group">
                  <label for="date">Zvolte datum: </label>
                  <input type="date" name="date" id="date" class="form-control" placeholder=""
                    required>
                </div>
                <div class="form-group">
                  <label for="car">Zvolte vozidlo: </label>
                  <input type="button" value="Vozidlo" class="form-control btn btn-secondary" id="car">
                  <input type="text" style="display: none !important;" name="auto_id" id="auto_id">
                </div>
              </form>
              <div class="form-group">
                <button id="send" class="btn btn-primary form-control">Odeslat</button>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-5 mb-5">
      <div class="col-md-12">
        <div class="card">
          <h5 class="card-header">Historie</h5>
          <div class="card-body">

            <div class="card-text">

              <div class="col-md-12">
                <table id="historyTable" style="width: 100%;" class="table table-hover table-bordered">
                  <thead>
                    <tr>
                      <th>Datum</th>
                      <th>Auto</th>
                      <th>Cena celkem Kč</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>




  <!-- Modal -->
  <div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="historyModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="historyModalTitle"></h5>
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


  <!-- Optional JavaScript -->
  <!-- jQuery, Bootstrap JS -->
  <script type="text/javascript" src="DataTables/datatables.min.js"></script>

  <script>
    $(document).ready(function () {

      $('#send').click(function () {
        var today = new Date();
        if ($('#date').val() != "" && $('#zavada').val() != "") {

          if (($('#car').val() != "Vozidlo") && !($('#date').val() <= today.toISOString())) {

            $('#order').submit();

          } else {
            $('#alert').slideDown(300, function () {
              $('#alert').fadeOut(2500);
            });

          }
        } else {
          $('#alert').slideDown(300, function () {
            $('#alert').fadeOut(2500);
          });
        }

      });

      $('#logoutBtn').click(function () {
        sessionStorage.clear();
        window.location.replace("login.php");
      });

      $('#historyTable tbody').on('click', 'tr', function () {
        var tr = $(this).closest('tr');
        var row = historyTable.row(tr);
        if (row.data().datum != "") {
          $("#historyModal").modal('show');
          $('#historyModalTitle').text(row.data().datum + " / " + row.data().auto + " / " + row.data().cena + "Kč");
          showInformation(row.data().id);
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


      document.getElementById('carsTable').style.cursor = 'pointer';
      document.getElementById('historyTable').style.cursor = 'pointer';

      $('#car').click(function () {
        $('#myModal').modal('show');
      });

      $('#carsTable tbody').on('click', 'tr', function () {

        if ($(this).hasClass('selected')) {

          $(this).removeClass('selected');

          $('#ok').click(function () {

            $('#car').val("Vozidlo");
            ('#auto_id').val(null);

          });
        }
        else {

          var tr = $(this).closest('tr');
          var row = carsTable.row(tr);

          if (row.data().spz != "") {
            carsTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            $('#ok').click(function () {

              // Vybrání řádku provozovatel + auto
              var auto = row.data().auto_id;
              $('#auto').val(auto);
              var nazev = row.data().nazev
              $('#car').val(nazev);
              $('#auto_id').val(auto);
              $('#myModal').modal('hide');
            });
          }


        }

      });

      var carsTable = $('#carsTable').DataTable({
        "ajax": "db_user_select_auta.php",
        "columns": [
          { "data": "spz" },
          { "data": "nazev" },
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

      var historyTable = $('#historyTable').DataTable({
        "ajax": "db_user_select_history.php",
        "columns": [
          { "data": "datum" },
          { "data": "auto" },
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

      var table = $('#myTable').DataTable({
        "ajax": "db_user_select_curr.php",
        responsive: {
          details: true
        },
        "order": [0, "asc"],
        "columns": [
          { "data": "datum" },
          { "data": "auto" },
          { "data": "stav" },
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