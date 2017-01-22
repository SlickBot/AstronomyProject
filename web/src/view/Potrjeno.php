
<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "user.css" ?>">
<meta charset="UTF-8" />

<title>Pregled naročil</title>

<h1>Pregled naročil</h1>

<a href="<?= BASE_URL . "store" ?>">Trgovina</a> |
<a href="<?= BASE_URL . "Pregled" ?>">Pregled naročil</a>

<div id="main">
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "ep";
    $dbname = "astronomicstore";
    $conn = new mysqli($servername, $username, $password, $dbname);
    mysqli_set_charset($conn, 'utf8');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    unset($_SESSION["CURRENT"]);

    $sql = "SELECT A.NAZIV_ARTIKLA, N.STATUS_NAROCILA, N.KOLICINA_ARTIKLA, N.ZAPOREDNA_STEVILKA, N.ID_NAROCILA  FROM NAROCILO N, VSEBUJE V, ARTIKEL A
        WHERE N.ID_NAROCILA = V.ID_NAROCILA AND A.SIFRA_ARTIKLA = V.SIFRA_ARTIKLA AND N.STATUS_NAROCILA = 10 ORDER BY N.ZAPOREDNA_STEVILKA";
    $result = $conn->query($sql);
    ?> <b>Naročila:</b> <?php
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            ?>
            <form  method="post" />

            <li><a href="<?= BASE_URL . "Storniraj?idnar=" . $row["ID_NAROCILA"] ?>">Naziv: <?= $row["NAZIV_ARTIKLA"] ?>, Status: 
                    <?= $row["STATUS_NAROCILA"] ?>, Količina: <?= $row["KOLICINA_ARTIKLA"] ?>, Zaporedna številka: <?= $row["ZAPOREDNA_STEVILKA"] ?>:</a></li>



        </form> 
        <?php
    }
    echo "</table>";
} else {
    echo "0 results";
}
$conn->close();
?>


</div>