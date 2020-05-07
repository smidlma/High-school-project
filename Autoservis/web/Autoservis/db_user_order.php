<?php
if ($_POST) {

    require "db_connect.php";
    session_start();
    $auto_id = $_POST['auto_id'];
    $provozovatel_id = $_SESSION['id'];
    $date = $_POST['date'];
    $zavada = $_POST['zavada'];

    $check = "SELECT servisni_objednavka_id FROM servisni_objednavka WHERE datum LIKE '$date' AND stav NOT LIKE 'storno'";
    //Limit na den
    if ($conn->query($check)->num_rows > 4) {

        //Limit
        $_SESSION['info'] = "Servis na den " . $date . " nelze objednat z důvodu plné kapacity.";
        header("Location: userDashboard.php");

    } else {

        $query = "INSERT INTO servisni_objednavka() VALUES(null,'$date','přijato',null,'$zavada',$provozovatel_id,$auto_id)";

        if ($conn->query($query) === true) {
            header("Location: userDashboard.php");
        } else {
            echo "error: " . $conn->connection_error;
        }

    }

    $conn->close();

}
