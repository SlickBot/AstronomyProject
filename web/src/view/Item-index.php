<!DOCTYPE html>

<?php
require_once("controller/ItemController.php");
require_once("controller/StoreController.php");

define('ROOT_PATH', dirname(__DIR__) . '/');
?>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "d.css" ?>">
<meta charset="UTF-8" />


<form  method="post">
    <p><button value="Odjavise" name="Odjavise">Odjava</button></p>
</form>
<?php if ($_SESSION["TIP"] != 4) { ?>
    <form action="<?= BASE_URL . "UporabnikEdit" ?>" method="post">
        <input type="submit" value="Uporabnik">
    </form>
<?php } ?>
<?php if ($_SESSION["TIP"] == 2) { ?>

    <form action="<?= BASE_URL . "Pregled" ?>" method="post">
        <input type="submit" value="Pregled naročil-prodajalec">
    </form>
<?php } ?>
<?php if ($_SESSION["TIP"] == 3) { ?>

    <form action="<?= BASE_URL . "PregledStranka" ?>" method="post">
        <input type="submit" value="Pregled naročil-stranka">
    </form>
<?php } ?>
<?php if ($_SESSION["TIP"] == 1) { ?>

    <form action="<?= BASE_URL . "UstvariProdajalca" ?>" method="post">
        <input type="submit" value="Prodajalci">
    </form>
<?php } ?>
<?php if ($_SESSION["TIP"] == 2) { ?>

    <form action="<?= BASE_URL . "SpremeniStranke" ?>" method="post">
        <input type="submit" value="Stranke">
    </form>
<?php } ?>
<title>Trgovina</title>

<h1>Trgovina</h1>

<p>
    <?php if ($_SESSION["TIP"] == 2) { ?>
        [
        <a href="<?= BASE_URL . "item" ?>">Vse stvari</a> |
        <a href="<?= BASE_URL . "item/add" ?>">Dodaj</a> |
        <a href="<?= BASE_URL . "store" ?>">Trgovina</a>  ]

    <?php }
    ?>
<form method="post">
    <label>Iskanje: </label>
    <input type="text" name="iskalnik" />
    <input type="submit" value="Vpis">              
</form>

</p>
<div id="main">


    <?php foreach ($items as $item): ?>
        <?php
        $db = DBInit::getInstance();
        $sifra = $item["SIFRA_ARTIKLA"];
        $statement = $db->prepare("SELECT POT_SLIKE FROM SLIKA
            WHERE SIFRA_ARTIKLA = :id");
        $statement->bindParam("id", $sifra, PDO::PARAM_INT);
        $statement->execute();

        $url = $statement->fetch();
        $image = implode("", $url);
        ?>
        <?php if (!isset($_POST["iskalnik"]) || startsWith($item["NAZIV_ARTIKLA"], $_POST["iskalnik"])) { ?>
            <div class="item">
                <form action="<?= BASE_URL . "store/add-to-cart" ?>" method="post" />
                <input type="hidden" name="SIFRA_ARTIKLA" value="<?= $item["SIFRA_ARTIKLA"] ?>" />

                <p><img src="<?= $image ?>" alt="Ni slike!" style="width:304px;height:228px;"></p>
                <p><b>Naziv:</b> <?= $item["NAZIV_ARTIKLA"] ?></p>
                <p><b>Komercialna skupina(1 - teleskopi, 2 - zaščitna očala, 3 - cev):</b> <?= $item["ID_SKUPINE"] ?></p>
                <p><b>Proizvajalec: </b><?= $item["PROIZVAJALEC"] ?> </p>

                <p><b>Cena: </b><?= number_format($item["CENA"], 2) ?> EUR<br/>
                <p><b>Opis:</b> <?= $item["OPIS"] ?> </p>

                <?php if ($_SESSION["TIP"] == 3) { ?>

                    <button>Dodaj v košarico</button>
                <?php } ?>
                </form> 
            </div>
        <?php } ?>


    <?php endforeach; ?>

</div>

<?php if (!empty($cart) && $_SESSION["TIP"] == 3): ?>

    <div id="cart">
        <h3>Košarica</h3>
        <?php foreach ($cart as $item): ?>

            <form action="<?= BASE_URL . "store/update-cart" ?>" method="post">
                <input type="hidden" name="SIFRA_ARTIKLA" value="<?= $item["SIFRA_ARTIKLA"] ?>" />
                <input type="number" name="quantity" value="<?= $item["quantity"] ?>" class="update-cart" />
                &times; <?= $item["NAZIV_ARTIKLA"] ?> 
                <button>Posodobi</button> 
            </form>

        <?php endforeach; ?>

        <p>Total: <b><?= number_format($total, 2) ?> EUR</b></p>

        <form action="<?= BASE_URL . "store/purge-cart" ?>" method="post">
            <p><button>Uniči</button></p>
        </form>
        <form  method="post">
            <p><button value="naroci" name="naroci">Zaključi</button></p>
        </form>
        <?php
        if (isset($_POST['naroci']) && (!empty($cart))) {
            unset($_SESSION["TOTAL"]);
            unset($_SESSION["CURRENT"]);

            $servername = "localhost";
            $username = "root";
            $password = "ep";
            $dbname = "astronomicstore";

            $mysqli = new mysqli($servername, $username, $password, $dbname);

            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }

            if ($result = $mysqli->query("SELECT * FROM NAROCILO")) {

                $count = $result->num_rows;
                $result->close();
            }

            $mysqli->close();
            $i = 4;

            foreach ($cart as $iteme):
                $statement = $db->prepare("INSERT INTO NAROCILO  (id_narocila, id_uporabnik, datum_narocila, status_narocila, zaporedna_stevilka, kolicina_artikla)"
                        . " VALUES (:id,:uporabnik,:date,:status,:zap,:kolicina) ");
                $id = ((int) $count + $i);
                $ses = $_SESSION['ID_UPORABNIK'];
                $date = date('Y-m-d H:i:s');
                $stat = 1;
                $cnt = $count;
                $ite = $iteme["quantity"];
                $statement->bindParam(":id", $id);
                $statement->bindParam(":uporabnik", $ses);
                $statement->bindParam(":date", $date);
                $statement->bindParam(":status", $stat);
                $statement->bindParam(":zap", $cnt);
                $statement->bindParam(":kolicina", $ite);

                $statement->execute();


                $stmt = $db->prepare("INSERT INTO VSEBUJE (id_narocila, sifra_artikla)"
                        . " VALUES (:id,:sif) ");
                $id1 = ((int) $count + $i);
                $sif = $_SESSION['ID_UPORABNIK'];
                $stmt->bindParam(":id", $id);
                $stmt->bindParam(":sif", $iteme["SIFRA_ARTIKLA"]);


                $stmt->execute();
                $i++;
                $_SESSION["CURRENT"] = $count;
                $_SESSION["TOTAL"] = $total;

            endforeach;
            ViewHelper::redirect(BASE_URL . "Narocilo");
        }
        ?>



    </div>   
    <?php
endif;

function startsWith($haystack, $needle) {
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}
?>
<?php
if (isset($_POST['Odjavise'])) {
    var_dump($_SESSION['PRIJAVA']);
    var_dump($_SESSION['PRIJAVA']);
    ViewHelper::redirect(BASE_URL . "Main");
    if ($user["TIP"] != 4 && $user["TIP"] != 3) {
        $db = DBInit::getInstance();
        $date = date('Y-m-d H:i:s');
        $prijava = $_SESSION['PRIJAVA'];
        var_dump($prijava);
        $statemen = $db->prepare("UPDATE DNEVNIK_PRIJAV SET CAS_ODJAVE = '$date' WHERE ID_PRIJAVE = '$prijava'");

        $statemen->execute();
        unset($_SESSION['PRIJAVA']);
    }

    ViewHelper::redirect(BASE_URL . "Main");
}
?>