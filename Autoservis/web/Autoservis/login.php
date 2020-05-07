<!doctype html>
<html lang="en">

<head>
    <title>Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <?php
session_start();



if (isset($_SESSION['info'])) {
    echo "<div class='row'>
                    <div class='col-md-6 mx-auto mt-5'>
                        <div class='alert alert-primary alert-dismissible fade show' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                                <span class='sr-only'>Close</span>
                            </button>
                            <strong>Chyba přihlášení: </strong> Nesprávné uživatelské jméno nebo heslo
                        </div>
                    </div>
            </div>";
    unset($_SESSION['info']);
    
}
session_destroy();

?>
        <div class="row">
            <div class="col-md-6 mx-auto mt-5">
                <div class="card border">
                    <div class="card-body">
                        <h4 class="card-title">Přihlášení</h4>
                        <form action="db_login.php" method="POST">
                            <div class="form-group card-text">
                                <label for="">E-mail: </label>
                                <input type="text" name="user" id="user" class="form-control" placeholder="Zadejte e-mail"
                                    required>
                            </div>
                            <div class="form-group card-text">
                                <label for="">Heslo: </label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Zadejte heslo"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Přihlásit se</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
</body>

</html>