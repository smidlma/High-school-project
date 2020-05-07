<?php
require "db_connect.php";
$q = $_GET['q'];

$sql = "SELECT datum,sor.cena,popis,CONCAT(jmeno,' ',prijmeni) AS servisak,nazev FROM servisni_objednavka_radky sor
INNER JOIN servisak USING(servisak_id)
INNER JOIN typ_zasahu USING (typ_zasahu_id) WHERE servisni_objednavka_id = $q;";

if (($result = $conn->query($sql)) == true) {

    $i = 1;
    while ($row = $result->fetch_array()) {

        echo "<div class='row'>
    <div class='col-md-12'>
        <div class='card bg-light mb-3'>
            <div class='card-header'>$i. " . $row['nazev'] . "</div>
            <div class='card-body'>

                <ul class='list-group'>
                    <li class='list-group-item'>
                        <h5 class='card-title'>Datum: </h5>
                        <p class='card-text'>" . $row['datum'] . "</p>
                    </li>
                    <li class='list-group-item'>
                        <h5 class='card-title'>Provedl: </h5>
                        <p class='card-text'>" . $row['servisak'] . "</p>
                    </li>
                    <li class='list-group-item'>
                        <h5 class='card-title'>Cena: </h5>
                        <p class='card-text'>" . $row['cena'] . " Kč</p>
                    </li>
                    <li class='list-group-item'>
                        <h5 class='card-title'>Popis: </h5>
                        <p class='card-text'>" . $row['popis'] . "</p>
                    </li>

                </ul>

            </div>
        </div>
    </div>
</div>";
        $i++;
    }
}else
{
   echo $conn->connect_error;
}
$conn->close();
