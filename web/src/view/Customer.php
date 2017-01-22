<title>Pregled strank</title>
<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "user.css" ?>">
<h1>Pregled Strank</h1>
<a href="<?= BASE_URL . "customer/add" ?>">Dodaj stranko</a> |
<a href="<?= BASE_URL . "SpremeniStranke" ?>">Vse stranke</a> | 
<a href="<?= BASE_URL . "store" ?>">Trgovina</a> </br></br>

<b>Stranke:</b>
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

    $sql = "SELECT *  FROM UPORABNIK
        WHERE TIP = 3";
    $result = $conn->query($sql);



    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <a href="<?= BASE_URL . "edit-stranka?mailpostaposta=" . $row["ELEKTRONSKI_NASLOV"] ?>" name="povezava" method="post"><?= $row["IME"] ?> 
                <?= $row["PRIIMEK"] ?> (<?= $row["ELEKTRONSKI_NASLOV"] ?>) (<?= $row["TELEFONSKA_STEVILKA"] ?>) (<?= $row["NASLOV"] ?>), Status (1 - aktiven, 0 - neaktiven): <?= $row["STATUS"] ?> </a></br>

            <?php
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
    $conn->close();
    ?>


</div>