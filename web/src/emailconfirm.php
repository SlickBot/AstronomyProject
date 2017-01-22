<a href="<?= BASE_URL . "Main" ?>">Prijavna stran</a> </br>


<?php
$db = DBInit::getInstance();


$email = $_GET["email"];

$statement = $db->prepare("UPDATE UPORABNIK SET VALIDATED = 1 WHERE ELEKTRONSKI_NASLOV = '$email'");
$statement->execute();

echo "You have succesfully validated your mail!";
