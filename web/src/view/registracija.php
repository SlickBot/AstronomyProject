<!DOCTYPE html>
<html lang="sl">
    <a href="<?= BASE_URL . "Main" ?>">Prijavna stran</a>

    <head>
        <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "a.css" ?>">
        <meta charset="UTF-8">
        <title>Title</title>
    </head>
    <body>

        <?php
        require_once 'PEAR/Config.php';
        require_once 'HTML/QuickForm2.php';
        require_once 'HTML/QuickForm2/Rule/Required.php';
        require_once 'HTML/QuickForm2/Rule/Regex.php';
        require_once 'HTML/QuickForm2/Element/Captcha/Numeral.php';


        $ime1 = $priimek1 = $naslov1 = $teleS1 = $geslo1 = $eposta1 = "";

        $form = new HTML_QuickForm2('Registracija', 'post', array(), false);
        $ime = $form->addElement('text', 'ime')->setLabel('Ime');
        $priimek = $form->addElement('text', 'priimek')->setLabel('Priimek');
        $eposta = $form->addElement('text', 'enaslov')->setLabel('E-pošta');
        $naslov = $form->addElement('text', 'naslov')->setLabel('Naslov');
        $telefonska = $form->addElement('text', 'teleS')->setLabel('Telefonska številka');
        $geslo = $form->addElement('password', 'geslo')->setLabel('Geslo');
        $geslo2 = $form->addElement('password', 'geslo2')->setLabel('Ponovi geslo');

        $captcha = $form->addElement(new HTML_QuickForm2_Element_Captcha_Numeral('captcha[numeral]', array('id' => 'numericna_captcha'), array('label' => 'Nisi robot?')));

        $form->addElement('submit', null, array('value' => 'Potrdi!'));

// preveri pravilnost imena
        $ime->addRule(new HTML_QuickForm2_Rule_Required($ime, 'Vpiši ime'));
        $ime->addRule(new HTML_QuickForm2_Rule_Regex($ime, 'Ime je lahko sestavljeno samo iz črk!', '/^[a-žA-Ž]+$/'));

// preveri pravilnost priimka
        $priimek->addRule(new HTML_QuickForm2_Rule_Required($priimek, 'Vpiši priimek'));
        $priimek->addRule(new HTML_QuickForm2_Rule_Regex($priimek, 'Priimek je lahko sestavljen samo iz črk!', '/^[a-žA-Ž]+$/'));

// pravila za naslov
        $naslov->addRule(new HTML_QuickForm2_Rule_Required($ime, 'Vpiši naslov!'));
        $naslov->addRule(new HTML_QuickForm2_Rule_Regex($ime, 'Naslov mora vsebovati vsaj eno številko in eno ali več velikih začetnic!', '/^[a-zA-Z]([a-zA-Z-]+\s)+\d{1,4}$/'));


// preveri pravilnost našega e-poštenga naslova hrakti pa preveri če je v bazi
        $eposta->addRule(new HTML_QuickForm2_Rule_Required($ime, 'Vpiši pošto!'));
        $emailPresent = $eposta->createRule('nonempty', 'Vnesite pravilno obliko e-poštenga naslova!');
        $emailValid = $eposta->createRule('callback', '', array('callback' => 'filter_var', 'arguments' => array(FILTER_VALIDATE_EMAIL)));
        $eposta->addRule('empty')->or_($emailPresent->and_($emailValid));


// preveri pravilnost naše telefonske številke
        $telefonska->addRule(new HTML_QuickForm2_Rule_Required($ime, 'Vpiši Telefonsko številko'));
        $telefonska->addRule(($geslo->createRule('length', 'Telefonska številka mora vsebovati 9 znakov!', array('min' => 9,
                    'max' => 9))));
        $telefonska->addRule(new HTML_QuickForm2_Rule_Regex($ime, 'Pravilno vnesite telefonsko številko!', '/^\\d+([ -]\\d+)*$/'));


// preveri pravilnost in dolzine gesla
        $geslo->addRule(new HTML_QuickForm2_Rule_Required($geslo, 'Vpiši geslo, ki je dolgo vsaj 6 znakov!'));
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
            $captcha->clearCaptchaSession();
            $servername = "localhost";
            $username = "root";
            $password = "ep";
            $dbname = "astronomicstore";
            $conn = new mysqli($servername, $username, $password, $dbname);
            mysqli_set_charset($conn, 'utf8');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            $db = DBInit::getInstance();
            
            $stat0 = $db->query("SELECT MAX(ID_UPORABNIK) FROM UPORABNIK");
            $stat0->execute();
            $id_uporabnik_last = $stat0->fetch()["MAX(ID_UPORABNIK)"];
            
            $db1 = DBInit::getInstance();
            
            $stat1 = $db1->prepare("SELECT * FROM UPORABNIK WHERE ELEKTRONSKI_NASLOV = :email");
            $stat1->bindParam(":email", $eposta2);
            $stat1->execute();
            $old_email = $stat1->fetch()["ELEKTRONSKI_NASLOV"];
            
            if ($old_email) {
                echo "elektronski naslov je že zaseden!";
                exit;
            } else {
                echo '<h1>Pozdravljeni! ' . $ime2 . " " . $priimek2 . " na naši spletni strani.";
                $stmt = $conn->prepare("INSERT INTO UPORABNIK (id_uporabnik,tip, ime, priimek, elektronski_naslov,geslo,telefonska_stevilka, naslov, status, confirmed, validated) 
                                                        VALUES (?,?,?,?,?,?,?,?,1,?,0)");
                $stmt->bind_param("iissssssi", $id_uporabnik, $tip, $ime, $priimek, $elektronski_naslov, $geslo, $telefonska_stevilka, $naslov, $confirmcode);

                $id_uporabnik = $id_uporabnik_last + 1;
                $tip = 3;
                $ime = $ime2;
                $confirmcode = rand(0, 1000000);
                $priimek = $priimek2;
                $elektronski_naslov = $eposta2;
                $geslo = $geslo2;
                $telefonska_stevilka = $teleS2;
                $naslov = $naslov2;
                
                $stmt->execute();

                $stmt->close();

                $message = "Confirm your email."
                        . "Click on the link below to validate it."
                        . "http://localhost/netbeans/AstronomyProject/index.php/emailconfirm?email=$elektronski_naslov&conf=$confirmcode";
                mail('astronomicproject0@gmail.com', 'Confirmation mail for ' . $ime . " " . $priimek, $message, "From: astronomicstore@gmail.com");


                ViewHelper::redirect(BASE_URL . "Main");

                exit;
            }
            $conn->close();
        }
        echo $form;
        ?>
    </body>
</html>
