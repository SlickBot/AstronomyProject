
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "b.css" ?>">
        <title>Prijavna Stran</title>
    </head>
    <body>
        <?php
        
        //uname = EMAIL!!!
        if (isset($_POST["uname"]) && isset($_POST["password"])):
            try {

                unset($_SESSION['ID_UPORABNIK']);
                unset($_SESSION['TIP']);


                $dbh = new PDO("mysql:host=localhost;dbname=astronomicstore", "root", "ep");
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

                $email = $_POST['uname'];



                $query = "SELECT * FROM UPORABNIK where ELEKTRONSKI_NASLOV = '$email' AND STATUS = 1";
                $stmt = $dbh->prepare($query);
                $stmt->bindValue(1, $_POST["uname"]);
                $stmt->bindValue(2, md5($_POST["password"]));

                $stmt->execute();
                $user = $stmt->fetch();

                $password = $user["GESLO"];

                $_SESSION['ID_UPORABNIK'] = $user["ID_UPORABNIK"];
                $_SESSION['TIP'] = $user["TIP"];

                $stvar = $user["TIP"];

                $idid = $user["ID_UPORABNIK"];

                $valid = $user["VALIDATED"];

                if ($stvar != 3 && $stvar != 4) {
                    $date = date('Y-m-d H:i:s');


                    $ip = $_SERVER['REMOTE_ADDR'];
                    $query2 = "INSERT INTO DNEVNIK_PRIJAV (IP, CAS_PRIJAVE, CAS_ODJAVE, USPESNOST, ID_UPORABNIKA) VALUES ('$ip', '$date', NULL, 1, '$idid' )";
                    $stmt2 = $dbh->prepare($query2);

                    $stmt2->execute();


                    $query3 = "SELECT MAX(ID_PRIJAVE) AS max FROM DNEVNIK_PRIJAV";
                    $stmt3 = $dbh->prepare($query3);




                    $stmt3->execute();
                    $user2 = $stmt3->fetch();

                    $_SESSION['PRIJAVA'] = $user2["max"];
                }
                
                
                $unit = filter_input(INPUT_SERVER, "SSL_CLIENT_S_DN_OU");

                
                if ($stvar == 1 || $stvar == 2) {
                    if ($unit != "Admin" && $unit != "Prodajalec") {
                        ViewHelper::error404();
                        exit();
                    }
                }
                
                if ($valid == 1 && md5($_POST["password"]) == $password) {
                    if ($user && $stvar == 1) {
                        ViewHelper::redirect(BASE_URL . "store");
                    } elseif ($user && $stvar == 2) {
                        ViewHelper::redirect(BASE_URL . "store");
                    } elseif ($user && $stvar == 3) {
                        ViewHelper::redirect(BASE_URL . "store");
                    } else {
                        ViewHelper::redirect(BASE_URL . "Main");
                    }
                } else {
                       ViewHelper::redirect(BASE_URL . "Main");
                }
            } catch (Exception $e) {
                die($e->getMessage());
            }
        else:
            ?>

            <form method="post">
                <label>Elektronski naslov</label>
                <input type="text" name="uname" />
                <label>Geslo</label>
                <input type="password" name="password" />
                <input type="submit" value="Vpis">              
            </form>
            <form method="post">
                <button name="anonimni" value="anonimni">Anonimni uporabnik</button>
            </form>
            <form action="<?= BASE_URL . "Register" ?>" method="post">
                <input type="submit" value="Registracija">
            </form>
        <?php
        endif;
        ?>
    </body>
</html>
<?php
if (isset($_POST['anonimni'])) {
    unset($_SESSION['ID_UPORABNIK']);
    $_SESSION['ID_UPORABNIK'] = 0;
    $_SESSION['TIP'] = 4;

    ViewHelper::redirect(BASE_URL . "store");
}
?>