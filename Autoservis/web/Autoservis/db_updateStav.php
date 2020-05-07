<?php
require "db_connect.php";
if ($_POST) {
    $servisni_objednavka_id = $_POST['servisni_objednavka_id'];
    $akce = $_POST['akce'];

    $query = "UPDATE servisni_objednavka SET stav = '$akce', ukonceno = CURDATE() WHERE servisni_objednavka_id = $servisni_objednavka_id;";

    if ($conn->query($query) === true) {

        if ($_POST['from'] == "dashboard") {
            header("Location: dashboard.php");
        }

        if ($_POST['from'] == "objednavky") {
            $query = "SELECT CONCAT(znacka,' ',model,' ',rok_vyroby) AS auto
            FROM auto INNER JOIN servisni_objednavka USING(auto_id)
            WHERE servisni_objednavka_id = $servisni_objednavka_id;";

            $result = $conn->query($query);
            $auto = $result->fetch_assoc();

           

            $query = "SELECT email AS email
            FROM provozovatel INNER JOIN servisni_objednavka USING(provozovatel_id)
            WHERE servisni_objednavka_id = $servisni_objednavka_id;";

            $result = $conn->query($query);
            $email = $result->fetch_assoc();

            require "mailSender/dokonceno.php";

            header("Location: objednavky.php");

        }
    } else {
        echo "Error: " . $query . "<br>" . $conn->connect_error;
    }

}
$conn->close();
