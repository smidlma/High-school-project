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
  <title>Profil</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- ICONS -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
    crossorigin="anonymous">
  <!-- Bootstrap CSS -->
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

  <?php if (isset($_SESSION['info'])) {
    echo "<div class='col-md-6 mx-auto mt-5' style='display: block;'>
    <div class='alert alert-primary alert-dismissible fade show' role='alert'>
      <strong>Info: </strong> <span>". $_SESSION['info'] ."</span>
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
    </div>
  </div>";
  unset($_SESSION['info']);
}
?>
  <!-- Alert -->
  <div class='col-md-6 mx-auto mt-5' style="display: none;" id="alertInfo">
    <div class='alert alert-primary alert-dismissible fade show' role='alert'>
      <strong>Chyba: </strong> <span id="alertText"></span>
    </div>
  </div>
  <!-- END Alert -->

  <div class="container">


    <!-- Profile Card -->
    <?php include_once "db_user_profile.php"?>
    <!-- END Profile Card -->

    <!-- Update Profile Card -->
    <div class="row mt-5 mb-5" id="updateCard" style="display: none;">
      <div class="col-md-6 mx-auto">
        <div class="card">
          <h4 class="card-header">Úprava Profilu</h4>
          <div class="card-body">
            <form id="updateForm" method="POST" action="db_user_profile_update.php">
              <div class="form-group row">
                <label for="emailU" class="col-sm-4 col-form-label">E-mail</label>
                <div class="col-sm-8">
                  <input type="email" class="form-control" id="emailU" placeholder="E-mail" name="emailU" required>
                </div>
              </div>
              <div class="form-group row">
                <label for="telU" class="col-sm-4 col-form-label">Telefon</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="telU" placeholder="Telefon" name="telU" required>
                </div>
              </div>
              <button type="submit" class="btn btn-primary" id="confirmUdpdate">Uložit změny</button>
            </form>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-md-12 text-center">
                <button onclick="backToProfile('#updateCard')" type="button" class="btn btn-primary" id="discard">Zrušit</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END Update Profile Card -->


    <!-- Password Card -->
    <div class="row mt-5 mb-5" id="passwordCard" style="display: none;">
      <div class="col-md-6 mx-auto">
        <div class="card">
          <h4 class="card-header">Změna Hesla</h4>
          <div class="card-body">
            <form id="passwordForm" method="POST" action="db_user_ch_password.php">
              <div class="form-group row">
                <label for="inputPasswordOld" class="col-sm-4 col-form-label">Staré heslo</label>
                <div class="col-sm-8">
                  <input type="password" class="form-control" id="inputPasswordOld" name="old" placeholder="Staré heslo" required>
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPasswordNew" class="col-sm-4 col-form-label">Nové heslo</label>
                <div class="col-sm-8">
                  <input type="password" class="form-control" id="inputPasswordNew" name="new" placeholder="Nové heslo" required>
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPasswordNewC" class="col-sm-4 col-form-label">Potvrdit heslo</label>
                <div class="col-sm-8">
                  <input type="password" class="form-control" id="inputPasswordNewC" placeholder="Potvrdit heslo" required>
                </div>
              </div>
              <button type="submit" class="btn btn-primary" id="confirmPassword">Změnit heslo</button>
            </form>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-md-12 text-center">
                <button onclick="backToProfile('#passwordCard')" type="button" class="btn btn-primary" id="discard">Zrušit</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END Password Card -->
  </div>

  <!-- jQuery, Bootstrap JS -->
  <script type="text/javascript" src="DataTables/datatables.min.js"></script>

  <!-- Optional JavaScript -->
  <script>
    function backToProfile(card) {
      $(card).fadeOut(300, function () {
        $('#profileCard').fadeIn(200);
      });
    }
  </script>

  <script>
    $(document).ready(function () {

      $('#logoutBtn').click(function () {
        sessionStorage.clear();
        window.location.replace("login.php");
      });

      $('#passwordForm').submit(function (event) {
        var newP = $('#inputPasswordNew');
        var newPC = $('#inputPasswordNewC');

        if (newP.val().length > 7) {
          if (newP.val() == newPC.val()) {
            return;
          } else {
            $('#alertText').text("Zadaná hesla se neshodují");
            $('#alertInfo').slideDown(300);
            event.preventDefault();
          }
        } else {
          $('#alertText').text("Heslo musí být minimálně 7 znaků dlouhé");
          $('#alertInfo').slideDown(300);
          event.preventDefault();
        }
      });


      $('#profileCard').fadeIn(500);

      $('#profileUpdate').click(function () {
        $('#profileCard').fadeOut(300, function () {
          $('#updateCard').fadeIn(200);
        });
      });

      $('#passwordChange').click(function () {
        $('#profileCard').fadeOut(300, function () {
          $('#passwordCard').fadeIn(200);
        });
      });


      var email = $('#email').text();
      var telefon = $('#telefon').text();


      $('#emailU').val(email);
      $('#telU').val(telefon);

    });
  </script>

</body>

</html>