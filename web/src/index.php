<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

//require_once 'Main';

// enables sessions for the entire app
session_start();

require_once("controller/ItemController.php");
require_once("controller/StoreController.php");

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

/* Uncomment to see the contents of variables
var_dump(BASE_URL);
var_dump(IMAGES_URL);
var_dump(CSS_URL);
var_dump($path);
exit(); */

$urls = [
    "helloworld" => function () {
        ItemController::helloWorld();
    },
    "item" => function () {
      ItemController::index();
    },
    "item/add" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            ItemController::add();
        } else {
            ItemController::showAddForm();
        }
    },
    "item/edit" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            ItemController::edit();
        } else {
            ItemController::showEditForm();
        }
    },
    "item/delete" => function () {
        ItemController::delete();
    },
    "store" => function () {
        StoreController::index();
    },
    "store/add-to-cart" => function () {
        StoreController::addToCart();
    },
    "store/update-cart" => function () {
        StoreController::updateCart();
    },
    "store/purge-cart" => function () {
        StoreController::purgeCart();
    },
    "" => function () {
        ViewHelper::redirect(BASE_URL . "helloworld");
    },
];

try {
    if (isset($urls[$path])) {
       $urls[$path]();
    } else {
        echo "No controller for '$path'";
    }
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
    // ViewHelper::error404();
}

/*
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Primer strani za prijavo</title>
    </head>
    <body>-->
        <?php

        if (isset($_POST["uname"]) && isset($_POST["password"])):
            try {
                $dbh = new PDO("mysql:host=localhost;dbname=astronomicstore", "root", "ep");
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

                $ime = $_POST['uname'];
                echo $ime;

                $query = "SELECT * FROM uporabnik where IME like '$ime'";
                $stmt = $dbh->prepare($query);
                $stmt->bindValue(1, $_POST["uname"]);
                $stmt->bindValue(2, md5($_POST["password"]));


                $stmt->execute();
                $user = $stmt->fetch();
                $stvar = $user["TIP"];
                var_dump($stvar);


                if ($user && $stvar == 1) {
                    echo "Dobrodošli na skrivni strani kot admin!";
                    var_dump($user);
                } elseif ($user && $stvar == 2) {
                    echo "Dobrodošli na skrivni strani kot Prodajalec!";
                  
                    var_dump($user);
                }
                elseif ($user && $stvar == 3) {
               
                    echo "Dobrodošli na skrivni strani kot Stranka!";
                    var_dump($user);
                }
                {
                    echo "Prijava neuspešna.";
                }
            } catch (Exception $e) {
                die($e->getMessage());
            }
        else:
            ?><form action="<?= basename(__FILE__) ?>" method="post">
                Username <input type="text" name="uname" />
                Password <input type="password" name="password" />
                <input type="submit" value="Pošlji podatke">
            </form>
        <?php
        endif;
        ?>
    </body>
</html>-->
*/