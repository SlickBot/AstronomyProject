<?php
// enables sessions for the entire app
session_start();

require_once("controller/ItemController.php");
require_once("controller/StoreController.php");
require_once("controller/UporabnikController.php");
require_once("controller/RESTController.php");

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

$urls = [
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
    "Main" => function () {
        UporabnikController::index();
    },
    "Register" => function () {
        UporabnikController::register();
    },
    "Naročilo" => function () {
        UporabnikController::naročilo();
    },
    "UporabnikEdit" => function () {
        UporabnikController::changeData();
    },
    "Pregled" => function () {
        UporabnikController::pregled();
    },
    "PregledStranka" => function () {
        UporabnikController::pregledStranka();
    },
    "seller/add" => function () {
        UporabnikController::add();
    },
    "customer/add" => function () {
        UporabnikController::addcustomer();
    },
    "UstvariProdajalca" => function () {
        UporabnikController::UstvariProdajalca();
    },
    "edit-uporabnik" => function () {
        UporabnikController::edit();
    },
    "Posamezno" => function () {
        StoreController::posamezno();
    },
    "Storniraj" => function () {
        StoreController::storaniraj();
    },
    "Potrjena" => function () {
        StoreController::potrjeno();
    },
    "emailconfirm" => function () {
        UporabnikController::confirm();
    },
    "edit-stranka" => function () {
        UporabnikController::editcustomer();
    },
    "SpremeniStranke" => function () {
        UporabnikController::customer();
    },
    "Narocilo" => function () {
        StoreController::narocilo();
    },
    "api/items" => function () {
        RESTController::getItems();
    },
    "api/authenticate" => function () {
        RESTController::authenticate();
    },
    "api/user" => function () {
        RESTController::getUser();
    },
    "api/edit_user" => function () {
        RESTController::setUser();
    },
    "api/purchases" => function () {
        RESTController::getPurchases();
    },
    "api/purchase" => function () {
        RESTController::getPurchase();
    },
    "api/buy" => function () {
        RESTController::buy();
    },
    "" => function () {
        ViewHelper::redirect(BASE_URL . "Main");
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
}
?>   




