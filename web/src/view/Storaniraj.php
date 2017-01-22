<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "user.css" ?>">
<meta charset="UTF-8" />

<title>Pregled naročil</title>

<h1>Pregled naročil</h1>

<a href="<?= BASE_URL . "store" ?>">Trgovina</a> |
<a href="<?= BASE_URL . "Pregled" ?>">Pregled naročil</a> |
<a href="<?= BASE_URL . "Potrjena" ?>">Potrjena naročila</a>


<div id="main">
    <?php
    $db = DBInit::getInstance();
    $idnar = $_GET["idnar"];
    $statement = $db->prepare("SELECT A.NAZIV_ARTIKLA, N.STATUS_NAROCILA, N.KOLICINA_ARTIKLA, N.DATUM_NAROCILA,N.ZAPOREDNA_STEVILKA, N.ID_NAROCILA  FROM NAROCILO N, VSEBUJE V, ARTIKEL A
        WHERE N.ID_NAROCILA = V.ID_NAROCILA AND A.SIFRA_ARTIKLA = V.SIFRA_ARTIKLA AND N.ID_NAROCILA = '$idnar'");
    $statement->execute();

    $narocilo = $statement->fetch();
    ?>
    <div class="narocilo">
        <form method="post" />
        <p><b>Naziv artikla: </b><?= $narocilo["NAZIV_ARTIKLA"] ?></p>
        <p><b>Datum naročila: </b><?= $narocilo["DATUM_NAROCILA"] ?> </p>

        <p><b>Status naročila: </b><?= $narocilo["STATUS_NAROCILA"] ?> <br/>
        <p><b>Zaporedna številka: </b><?= $narocilo["ZAPOREDNA_STEVILKA"] ?> <br/>
        <p><b>Količina artikla: </b><?= $narocilo["KOLICINA_ARTIKLA"] ?> </p>

        <p><button value="storniraj" name="storniraj">Storniraj naročilo</button></p>


        </form> 
        <a href="<?= BASE_URL . "Potrjena" ?>"><b>Potrdi</b></a>

    </div>
</div>

<?php
if (isset($_POST['storniraj'])) {
    $db = DBInit::getInstance();
    $idnar = $_GET["idnar"];
    $statement = $db->prepare("UPDATE NAROCILO SET STATUS_NAROCILA = 4 WHERE ID_NAROCILA = '$idnar'");
    $statement->execute();
}
?>
