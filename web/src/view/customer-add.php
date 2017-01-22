<!DOCTYPE html>
<html lang="sl">
    <a href="<?= BASE_URL . "SpremeniStranke" ?>">Vse stranke</a> | 
    <a href="<?= BASE_URL . "store" ?>">Trgovina</a>
    <head>
        <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "user.css" ?>">
        <meta charset="UTF-8">
        <title>Title</title>
    </head>
    <body>


        <?php
        require_once 'HTML/QuickForm2.php';
        require_once 'HTML/QuickForm2/Rule/Required.php';
        require_once 'HTML/QuickForm2/Rule/Regex.php';


        $ime1 = $priimek1 = $naslov1 = $teleS1 = $geslo1 = $eposta1 = $id_uporabnik = "";

        $form = new HTML_QuickForm2('Registracija');
        $ime = $form->addElement('text', 'ime')->setLabel('Ime');
        $priimek = $form->addElement('text', 'priimek')->setLabel('Priimek');
        $eposta = $form->addElement('text', 'enaslov')->setLabel('E-pošta');
        $naslov = $form->addElement('text', 'naslov')->setLabel('Naslov');
        $telefonska = $form->addElement('text', 'teleS')->setLabel('Telefonska številka');
        $id_uporabnik = $form->addElement('text', 'id_uporabnik')->setLabel('Identifikator prodajalca');
        $geslo = $form->addElement('password', 'geslo')->setLabel('Geslo');
        $geslo2 = $form->addElement('password', 'geslo2')->setLabel('Ponovi geslo');

        $form->addElement('submit', null, array('value' => 'Potrdi!'));

// preveri pravilnost imena
        $ime->addRule(new HTML_QuickForm2_Rule_Required($ime, 'Ime je potreben!'));
        $ime->addRule(new HTML_QuickForm2_Rule_Regex($ime, 'Ime je lahko sestavljeno samo iz črk!', '/^[a-zA-Z]+$/'));

        $id_uporabnik->addRule(new HTML_QuickForm2_Rule_Regex($ime, 'Pravilno vnesite identifikator!', '/^\\d+([ -]\\d+)*$/'));


// preveri pravilnost priimka
        $priimek->addRule(new HTML_QuickForm2_Rule_Required($priimek, 'Priimek je potreben!'));
        $priimek->addRule(new HTML_QuickForm2_Rule_Regex($priimek, 'Priimek je lahko sestavljen samo iz črk!', '/^[a-zA-Z]+$/'));

        $naslov->addRule(new HTML_QuickForm2_Rule_Required($ime, 'Naslov je potreben!'));
        $naslov->addRule(new HTML_QuickForm2_Rule_Regex($ime, 'Naslov mora vsebovati vsaj eno številko in eno ali več velikih začetnic!', '/^[a-zA-Z]([a-zA-Z-]+\s)+\d{1,4}$/'));


// preveri pravilnost našega e-poštenga naslova hrakti pa preveri če je v bazi
        $eposta->addRule(new HTML_QuickForm2_Rule_Required($ime, 'Pošta je potrebna!'));
        $emailPresent = $eposta->createRule('nonempty', 'Vnesite pravilno obliko e-poštenga naslova!');
        $emailValid = $eposta->createRule('callback', '', array('callback' => 'filter_var', 'arguments' => array(FILTER_VALIDATE_EMAIL)));
        $eposta->addRule('empty')->or_($emailPresent->and_($emailValid));


// preveri pravilnost naše telefonske številke
        $telefonska->addRule(new HTML_QuickForm2_Rule_Required($ime, 'Telefonska številka je potrebna!'));
        $telefonska->addRule(($geslo->createRule('minlength', 'Telefonska številka mora vsebovati 9 znakov!', 9)));
        $telefonska->addRule(new HTML_QuickForm2_Rule_Regex($ime, 'Pravilno vnesite telefonsko številko!', '/^\\d+([ -]\\d+)*$/'));


// preveri pravilnost in dolzine gesla
        $geslo->addRule('empty')
                ->and_($geslo2->createRule('empty'))
                ->or_($geslo->createRule('minlength', 'Geslo je prekratko', 6))
                ->and_($geslo2->createRule('eq', 'Gesli, ki ste jih vpisali se ne ujemata', $geslo));

        $ime2 = $priimek2 = $naslov2 = $teleS2 = $geslo2 = $eposta2 = "";


        if (isset($_POST["ime"]) && isset($_POST["priimek"]) && isset($_POST["enaslov"]) && isset($_POST["geslo"]) && isset($_POST["geslo2"]) && isset($_POST["id_uporabnik"])) {
            $ime2 = uredi_podatke($_POST["ime"]);
            $priimek2 = uredi_podatke($_POST["priimek"]);
            $eposta2 = uredi_podatke($_POST["enaslov"]);
            $naslov2 = uredi_podatke($_POST["naslov"]);
            $teleS2 = uredi_podatke($_POST["teleS"]);
            $geslo2 = md5(uredi_podatke($_POST["geslo2"]));
            $id_uporabnik2 = uredi_podatke($_POST["id_uporabnik"]);
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
            $stmt = $conn->prepare("INSERT INTO UPORABNIK (id_uporabnik,tip, ime, priimek, elektronski_naslov,geslo,telefonska_stevilka, naslov, status, confirmed, validated) 
                                                                VALUES (?,?,?,?,?,?,?,?,?,0,1)");
            $stmt->bind_param("iissssssi", $id_uporabnik, $tip, $ime, $priimek, $elektronski_naslov, $geslo, $telefonska_stevilka, $naslov, $sprem);

            $sprem = 1;
            $tip = 3;
            $ime = $ime2;
            $priimek = $priimek2;
            $elektronski_naslov = $eposta2;
            $id_uporabnik = $id_uporabnik2;
            $geslo = $geslo2;
            $telefonska_stevilka = $teleS2;
            $naslov = $naslov2;
            $stmt->execute();
            $stmt->close();

            ViewHelper::redirect(BASE_URL . "SpremeniStranke");

            $conn->close();
        }
        echo $form;
        ?>
    </body>
</html>
