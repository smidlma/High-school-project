<?php
require "db_connect.php";

$id = $_SESSION['id'];
$query = "SELECT jmeno,prijmeni,email,telefon,CONCAT(ulice,' ',cislo_popisne,' ',mesto,' ',psc) AS adresa
FROM provozovatel INNER JOIN adresa USING(adresa_id)
WHERE provozovatel_id = $id";

$result = $conn->query($query);
$row = $result->fetch_array(MYSQLI_ASSOC);

echo "<div class='row mt-5 mb-5' style='display: none;' id='profileCard'>
<div class='col-md-6 mx-auto'>
  <div class='card'>
    <h4 class='card-header'>Profil</h4>
    <div class='card-body'>
      <div class='form-group row'>
        <h5 class='col-md-4 col-form-label'>Jméno</h5>
        <div class='col-md-8'>
          <h5 readonly class='form-control' id='jmeno'>". $row['jmeno'] ."</h5>
        </div>
      </div>
      <div class='form-group row'>
        <h5 class='col-md-4 col-form-label'>Příjmení</h5>
        <div class='col-md-8'>
          <h5 readonly class='form-control' id='prijmeni'>". $row['prijmeni'] ."</h5>
        </div>
      </div>
      <div class='form-group row'>
        <h5 class='col-md-4 col-form-label'>E-mail</h5>
        <div class='col-md-8'>
          <h5 readonly class='form-control' id='email' >". $row['email'] ."</h5>
        </div>
      </div>
      <div class='form-group row'>
        <h5 class='col-md-4 col-form-label'>Telefon</h5>
        <div class='col-md-8'>
          <h5 readonly class='form-control'  id='telefon'>". $row['telefon'] ."</h5>
        </div>
      </div>
      <div class='form-group row'>
        <h5 class='col-md-4 col-form-label'>Adresa</h5>
        <div class='col-md-8'>
          <h5 readonly class='form-control' id='adresa'>". $row['adresa'] ."</h5>
        </div>
      </div>
    </div>
    <div class='card-footer'>
      <div class='row'>
        <div class='col-md-12 text-center'>
          <button type='button' class='btn btn-primary' id='profileUpdate'>Upravit profil</button>
          <button type='button' class='btn btn-primary' id='passwordChange'>Změnit heslo</button>
        </div>
      </div>
    </div>
  </div>
</div>
</div>";
$conn->close();