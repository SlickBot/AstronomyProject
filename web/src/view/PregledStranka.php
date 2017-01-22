<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "user.css" ?>">
<meta charset="UTF-8" />

<title>Pregled naročil</title>

<h1>Pregled naročil</h1>
<a href="<?= BASE_URL . "store" ?>">Trgovina</a>
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

    $id = $_SESSION["ID_UPORABNIK"];

    $sql = "SELECT A.NAZIV_ARTIKLA, N.STATUS_NAROCILA, N.KOLICINA_ARTIKLA, N.ZAPOREDNA_STEVILKA  FROM NAROCILO N, VSEBUJE V, ARTIKEL A
        WHERE N.ID_NAROCILA = V.ID_NAROCILA AND A.SIFRA_ARTIKLA = V.SIFRA_ARTIKLA AND N.ID_UPORABNIK = '$id'";
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
        echo "<table><tr><th>NAZIV ARTIKLA</th><th>STATUS</th><th>KOLIČINA</th><th>ZAPOREDNA ŠTEVILKA</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["NAZIV_ARTIKLA"] . "</td><td>" . $row["STATUS_NAROCILA"] . "</td><td>" . $row["KOLICINA_ARTIKLA"] . "</td><td>" . $row["ZAPOREDNA_STEVILKA"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
    $conn->close();
    ?>


</div>
