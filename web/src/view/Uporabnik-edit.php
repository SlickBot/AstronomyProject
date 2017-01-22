<!DOCTYPE html>
<html lang="sl">
    <a href="<?= BASE_URL . "store" ?>">Trgovina</a>
    <head>
        <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "user.css" ?>">
        <meta charset="UTF-8">
        <title>Uredi uporabnika</title>
        <h1>Uredi uporabnika</h1>
    </head>
    <body>


        <?php
        require_once("ViewHelper.php");
        require_once 'HTML/QuickForm2.php';
        require_once 'HTML/QuickForm2/Rule/Required.php';
        require_once 'HTML/QuickForm2/Rule/Regex.php';


        $ime1 = $priimek1 = $naslov1 = $teleS1 = $geslo1 = $eposta1 = "";

        $iduporabnik = intval($_SESSION['ID_UPORABNIK']);


        $form = new HTML_QuickForm2('Sprememba');
        $ime = $form->addElement('text', 'ime')->setLabel('Ime');
        $priimek = $form->addElement('text', 'priimek')->setLabel('Priimek');
        $eposta = $form->addElement('text', 'enaslov')->setLabel('E-pošta');
        $naslov = $form->addElement('text', 'naslov')->setLabel('Naslov');
        $telefonska = $form->addElement('text', 'teleS')->setLabel('Telefonska številka');
        $geslo = $form->addElement('password', 'geslo')->setLabel('Geslo');
        $geslo2 = $form->addElement('password', 'geslo2')->setLabel('Ponovi geslo');

        $form->addElement('submit', null, array('value' => 'Potrdi!'));

// preveri pravilnost imena
        $ime->addRule(new HTML_QuickForm2_Rule_Regex($ime, 'Ime je lahko sestavljeno samo iz črk!', '/^[a-žA-Ž]+$/'));

// preveri pravilnost priimka
        $priimek->addRule(new HTML_QuickForm2_Rule_Regex($priimek, 'Priimek je lahko sestavljen samo iz črk!', '/^[a-žA-Ž]+$/'));

        $naslov->addRule(new HTML_QuickForm2_Rule_Regex($ime, 'Naslov mora vsebovati vsaj eno številko in eno ali več velikih začetnic!', '/^[a-žA-Ž]([a-žA-Ž-]+\s)+\d{1,4}$/'));


// preveri pravilnost našega e-poštenga naslova hrakti pa preveri če je v bazi
        $emailPresent = $eposta->createRule('nonempty', 'Vnesite pravilno obliko e-poštenga naslova!');
        $emailValid = $eposta->createRule('callback', '', array('callback' => 'filter_var', 'arguments' => array(FILTER_VALIDATE_EMAIL)));
        $eposta->addRule('empty')->or_($emailPresent->and_($emailValid));


// preveri pravilnost naše telefonske številke
        $telefonska->addRule(($geslo->createRule('minlength', 'Telefonska številka mora vsebovati 9 znakov!', 9)));
        $telefonska->addRule(new HTML_QuickForm2_Rule_Regex($ime, 'Pravilno vnesite telefonsko številko!', '/^\\d+([ -]\\d+)*$/'));


// preveri pravilnost in dolzine gesla
        $geslo->addRule('empty')
                ->and_($geslo2->createRule('empty'))
                ->or_($geslo->createRule('minlength', 'Geslo je prekratko', 6))
                ->and_($geslo2->createRule('eq', 'Gesli, ki ste jih vpisali se ne ujemata', $geslo));

        $ime2 = $priimek2 = $naslov2 = $teleS2 = $geslo2 = $eposta2 = "";


        if (isset($_POST["ime"]) && isset($_POST["priimek"]) && isset($_POST["enaslov"]) && isset($_POST["naslov"]) &&
                isset($_POST["teleS"]) && isset($_POST["geslo"]) && isset($_POST["geslo2"])) {
            $ime2 = uredi_podatke($_POST["ime"]);
            $priimek2 = uredi_podatke($_POST["priimek"]);
            $eposta2 = uredi_podatke($_POST["enaslov"]);
            $naslov2 = uredi_podatke($_POST["naslov"]);
            $teleS2 = uredi_podatke($_POST["teleS"]);
            $geslo2 = md5(uredi_podatke($_POST["geslo2"]));
        }

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
            echo $iduporabnik . "dsadadsa";
            $sql = "SELECT * FROM UPORABNIK WHERE ID_UPORABNIK = '$iduporabnik'";
            $result = $conn->query($sql);
            $row_count = $result->num_rows;
            $st = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo $row["IME"];
                    if (isset($_POST["ime"]) && !empty($_POST["ime"]) && $_POST["ime"] != $row["IME"]) {
                        echo $iduporabnik;
                        $stmt = $conn->prepare("UPDATE UPORABNIK SET IME = ? WHERE ID_UPORABNIK = '$iduporabnik'");
                        $stmt->bind_param("s", $_POST["ime"]);
                        $stmt->execute();
                    }
                    if (isset($_POST["priimek"]) && !empty($_POST["priimek"]) && $_POST["priimek"] != $row["PRIIMEK"]) {
                        $stmt = $conn->prepare("UPDATE UPORABNIK SET PRIIMEK = ? WHERE ID_UPORABNIK = '$iduporabnik'");
                        $stmt->bind_param("s", $_POST["priimek"]);
                        $stmt->execute();
                    }
                    if (isset($_POST["enaslov"]) && !empty($_POST["enaslov"]) && $_POST["enaslov"] != $row["ELEKTRONSKI_NASLOV"]) {
                        $stmt = $conn->prepare("UPDATE UPORABNIK SET ELEKTRONSKI_NASLOV = ? WHERE ID_UPORABNIK = '$iduporabnik'");
                        $stmt->bind_param("s", $_POST["enaslov"]);
                        $stmt->execute();
                    }
                    if ($row["TIP"] = 3 && isset($_POST["teleS"]) && !empty($_POST["teleS"]) && $_POST["teleS"] != $row["TELEFONSKA_STEVILKA"]) {
                        $stmt = $conn->prepare("UPDATE UPORABNIK SET TELEFONSKA_STEVILKA = ? WHERE ID_UPORABNIK = '$iduporabnik'");
                        $stmt->bind_param("i", $_POST["teleS"]);
                        $stmt->execute();
                    }
                    if (isset($_POST["geslo2"]) && !empty($_POST["geslo2"]) && $_POST["geslo2"] != $row["GESLO"]) {
                        $stmt = $conn->prepare("UPDATE UPORABNIK SET GESLO = ? WHERE ID_UPORABNIK = '$iduporabnik'");
                        $stmt->bind_param("s", $_POST["geslo2"]);
                        $stmt->execute();
                    }
                    if ($row["TIP"] = 3 && isset($_POST["naslov"]) && !empty($_POST["naslov"]) && $_POST["naslov"] != $row["NASLOV"]) {
                        $stmt = $conn->prepare("UPDATE UPORABNIK SET NASLOV = ? WHERE ID_UPORABNIK = '$iduporabnik'");
                        $stmt->bind_param("s", $_POST["naslov"]);
                        $stmt->execute();
                    }
                    ViewHelper::redirect(BASE_URL . "store");
                }
            }
            $conn->close();
        }
        echo $form;
        ?>
    </body>
</html>
