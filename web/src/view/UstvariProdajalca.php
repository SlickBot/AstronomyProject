<title></title>
<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "user.css" ?>">
<h1>Pregled Prodajalcev</h1>
<a href="<?= BASE_URL . "seller/add" ?>">Dodaj prodajalca</a> |
<a href="<?= BASE_URL . "UstvariProdajalca" ?>">Vsi prodajalci</a> | 
<a href="<?= BASE_URL . "store" ?>">Trgovina</a> </br></br>

<b>Prodajalci:</b>
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
        WHERE TIP = 2";
    $result = $conn->query($sql);




    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <a href="<?= BASE_URL . "edit-uporabnik?mailposta=" . $row["ELEKTRONSKI_NASLOV"] ?>" name="povezava" method="post"><?= $row["IME"] ?> 
                <?= $row["PRIIMEK"] ?> (<?= $row["ELEKTRONSKI_NASLOV"] ?>), Status (1 - aktiven, 0 - neaktiven): <?= $row["STATUS"] ?> </a></br>

            <?php
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
    $conn->close();
    ?>


</div>