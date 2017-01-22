<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "user.css" ?>">
<?php
require_once("controller/ItemController.php");
?>
<title>Oddaj naročilo</title>

<h1>oddaj naročilo</h1>
</p>
<?php
$db = DBInit::getInstance();

$stmt = $db->prepare("SELECT * FROM NAROCILO WHERE ZAPOREDNA_STEVILKA = :zap");
$zaporedna = $_SESSION["CURRENT"];
$stmt->bindParam(":zap", $zaporedna);
$stmt->execute();
$count = $stmt->fetchAll();
?>

<?php foreach ($count as $item): ?>
    <?php
    $db = DBInit::getInstance();

    $stmt = $db->prepare("SELECT A.NAZIV_ARTIKLA FROM ARTIKEL A,VSEBUJE V WHERE V.ID_NAROCILA = :id AND "
            . "V.SIFRA_ARTIKLA = A.SIFRA_ARTIKLA");
    $id = $item["ID_NAROCILA"];
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $count = $stmt->fetch();
    ?>
    <p><b>Artikel:</b> <?= $count["NAZIV_ARTIKLA"] ?></p>

    <p><b>Številka naročila:</b>  <?= $item["ZAPOREDNA_STEVILKA"] ?></p>
    <p><b>Datum naročila:</b>  <?= $item["DATUM_NAROCILA"] ?> </p>
    <p><b>Status naročila(1 - ODDANO, 2 - POTRJENO, 5 - PREKLICANO):</b>  <?= $item["STATUS_NAROCILA"] ?> <br/>
    <p><b>Količina artikla:</b>  <?= $item["KOLICINA_ARTIKLA"] ?> </p>
    </br></br>
    </form>


<?php endforeach; ?>
<p><b>SKUPAJ: <?= $_SESSION["TOTAL"] ?> EUR </b></p>

<form  method="post">
    <p><button value="potrdi" name="potrdi">Potrdi naročilo</button></p>
</form>
<form  method="post">
    <p><button value="preklic" name="preklic">Prekliči naročilo</button></p>
</form>
<a href="<?= BASE_URL . "store" ?>"><b>OK</b></a>


<?php
if (isset($_POST['potrdi'])) {
    $db = DBInit::getInstance();

    $statement = $db->prepare("UPDATE NAROCILO SET STATUS_NAROCILA = 2 WHERE ZAPOREDNA_STEVILKA = :zap");
    $zaporedna = $_SESSION["CURRENT"];
    $statement->bindParam(":zap", $zaporedna);

    $statement->execute();
    ViewHelper::redirect(BASE_URL . "Narocilo");
} else if (isset($_POST['preklic'])) {
    $db = DBInit::getInstance();

    $statement = $db->prepare("UPDATE NAROCILO SET STATUS_NAROCILA = 5 WHERE ZAPOREDNA_STEVILKA = :zap");
    $zaporedna = $_SESSION["CURRENT"];
    $statement->bindParam(":zap", $zaporedna);

    $statement->execute();
    ViewHelper::redirect(BASE_URL . "Narocilo");
}
?>