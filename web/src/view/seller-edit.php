<!DOCTYPE html>
<html lang="sl">
    <a href="<?= BASE_URL . "UstvariProdajalca" ?>">Vsi prodajalci</a> | 
    <a href="<?= BASE_URL . "store" ?>">Trgovina</a>
    <head>
        <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "user.css" ?>">
        <meta charset="UTF-8">
        <title>Uredi prodjalaca</title>
    </head>
    <body>
    <h1>Uredi prodajalca</h1>
        <?php
        require_once("ViewHelper.php");
        require_once 'HTML/QuickForm2.php';
        require_once 'HTML/QuickForm2/Rule/Required.php';
        require_once 'HTML/QuickForm2/Rule/Regex.php';


        $ime = $priimek = $geslo = $eposta = $geslo2 = "";
        if (isset($_GET["mailposta"])) {
            $mail = $_GET["mailposta"];
        }
        if (empty($_SESSION['test'])) {
            $_SESSION['test'] = $mail;
        }


        $form = new HTML_QuickForm2('Sprememba');
        $ime = $form->addElement('text', 'ime')->setLabel('Ime');
        $priimek = $form->addElement('text', 'priimek')->setLabel('Priimek');
        $eposta = $form->addElement('text', 'enaslov')->setLabel('E-pošta');
        $geslo = $form->addElement('password', 'geslo')->setLabel('Geslo');
        $geslo2 = $form->addElement('password', 'geslo2')->setLabel('Ponovi geslo');


        $value1 = $form->addElement('radio', 't1', array('value' => 1), array('content' => 'Aktiviraj'));
        $value2 = $form->addElement('radio', 't1', array('value' => 2), array('content' => 'Deaktiviraj'));

        $form->addElement('submit', null, array('value' => 'Potrdi!'));

// preveri pravilnost imena
        $ime->addRule(new HTML_QuickForm2_Rule_Regex($ime, 'Ime je lahko sestavljeno samo iz črk!', '/^[a-zA-Z]+$/'));

// preveri pravilnost priimka
        $priimek->addRule(new HTML_QuickForm2_Rule_Regex($priimek, 'Priimek je lahko sestavljen samo iz črk!', '/^[a-zA-Z]+$/'));


// preveri pravilnost našega e-poštenga naslova hrakti pa preveri če je v bazi
        $emailPresent = $eposta->createRule('nonempty', 'Vnesite pravilno obliko e-poštenga naslova!');
        $emailValid = $eposta->createRule('callback', '', array('callback' => 'filter_var', 'arguments' => array(FILTER_VALIDATE_EMAIL)));
        $eposta->addRule('empty')->or_($emailPresent->and_($emailValid));

// preveri pravilnost in dolzine gesla
        $geslo->addRule('empty')
                ->and_($geslo2->createRule('empty'))
                ->or_($geslo->createRule('minlength', 'Geslo je prekratko', 6))
                ->and_($geslo2->createRule('eq', 'Gesli, ki ste jih vpisali se ne ujemata', $geslo));

        $ime2 = $priimek2 = $geslo2 = $enaslov = $eposta2 = "";


        if (isset($_POST["ime"])) {
            $ime2 = uredi_podatke($_POST["ime"]);
        }
        if (isset($_POST["priimek"])) {
            $priimek2 = uredi_podatke($_POST["priimek"]);
        }
        if (isset($_POST["geslo"])) {
            $geslo2 = uredi_podatke($_POST["geslo"]);
        }
        if (isset($_POST["enaslov"])) {
            $enaslov2 = uredi_podatke($_POST["enaslov"]);
        }
        echo $eposta2;

        function uredi_podatke($podatki) {
            $podatki = trim($podatki);
            $podatki = stripslashes($podatki);
            $podatki = htmlspecialchars($podatki);
            return $podatki;
        }

        if ($form->validate()) {
            $servername = "localhost";
            $username = "root";
            $password = "ep";
            $dbname = "astronomicstore";
            $conn = new mysqli($servername, $username, $password, $dbname);
            mysqli_set_charset($conn, 'utf8');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $ses = $_SESSION['test'];
            $sql = "SELECT * FROM UPORABNIK WHERE ELEKTRONSKI_NASLOV = '$ses'";
            $result = $conn->query($sql);
            $row_count = $result->num_rows;
            $st = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if (isset($_POST["ime"]) && !empty($_POST["ime"]) && $_POST["ime"] != $row["IME"]) {
                        $stmt = $conn->prepare("UPDATE UPORABNIK SET IME = ? WHERE ELEKTRONSKI_NASLOV = '$ses'");
                        $stmt->bind_param("s", $_POST["ime"]);

                        $stmt->execute();
                    }
                    if (isset($_POST["priimek"]) && !empty($_POST["priimek"]) && $_POST["priimek"] != $row["PRIIMEK"]) {
                        $stmt = $conn->prepare("UPDATE UPORABNIK SET PRIIMEK = ? WHERE ELEKTRONSKI_NASLOV = '$ses'");
                        $stmt->bind_param("s", $_POST["priimek"]);
                        $stmt->execute();
                    }
                    if (isset($_POST["enaslov"]) && !empty($_POST["enaslov"]) && $_POST["enaslov"] != $row["ELEKTRONSKI_NASLOV"]) {
                        $stmt = $conn->prepare("UPDATE UPORABNIK SET ELEKTRONSKI_NASLOV = ? WHERE ELEKTRONSKI_NASLOV = '$ses'");
                        $stmt->bind_param("s", $_POST["enaslov"]);
                        $stmt->execute();
                    }
                    if (isset($_POST["geslo2"]) && !empty($_POST["geslo2"]) && $_POST["geslo2"] != $row["GESLO"]) {
                        $stmt = $conn->prepare("UPDATE UPORABNIK SET GESLO = ? WHERE ELEKTRONSKI_NASLOV = '$ses'");
                        $stmt->bind_param("s", $_POST["geslo2"]);
                        $stmt->execute();
                    }
                    echo $_POST["t1"];
                    if ($_POST["t1"] == 1) {
                        $stmt = $conn->prepare("UPDATE UPORABNIK SET STATUS = 1 WHERE ELEKTRONSKI_NASLOV = '$ses'");
                        $stmt->execute();
                    } else if ($_POST["t1"] == 2) {
                        $stmt = $conn->prepare("UPDATE UPORABNIK SET STATUS = 0 WHERE ELEKTRONSKI_NASLOV = '$ses'");
                        $stmt->execute();
                    }
                    unset($_SESSION["test"]);
                    ViewHelper::redirect(BASE_URL . "UstvariProdajalca");
                }
            } else {
                echo mysqli_error($conn);
            }
            unset($_SESSION["test"]);
            ViewHelper::redirect(BASE_URL . "UstvariProdajalca");
            $conn->close();
        }
        echo $form;
        ?>
    </body>
</html>