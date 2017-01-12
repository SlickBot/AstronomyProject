<?php

require_once("model/ItemDB.php");
require_once("ViewHelper.php");

class ItemController {

    public static function index() {
        if (isset($_GET["id"])) {
            ViewHelper::render("view/Item-detail.php", ["item" => ItemDB::get($_GET["id"])]);
        } else {
            ViewHelper::render("view/Item-list.php", ["items" => ItemDB::getAll()]);
        }
    }

    public static function showAddForm($values = ["NAZIV_ARTIKLA" => "", "CENA" => "",
        "SIFRA_ARTIKLA" => "", "ENOTA_MER" => "", "ID_SKUPINE" => "", "ID_NAROCILA" => "",
         "PROIZVAJALEC" => ""]) {
        ViewHelper::render("view/Item-add.php", $values);
    }

    public static function add() {
        $validData = isset($_POST["ID_SKUPINE"]) && !empty($_POST["ID_SKUPINE"]) &&
                isset($_POST["PROIZVAJALEC"]) && !empty($_POST["PROIZVAJALEC"]) &&
                isset($_POST["ENOTA_MER"]) && !empty($_POST["ENOTA_MER"]) &&
                isset($_POST["ID_NAROCILA"]) && !empty($_POST["ID_NAROCILA"]) &&
                isset($_POST["NAZIV_ARTIKLA"]) && !empty($_POST["NAZIV_ARTIKLA"]) &&
                isset($_POST["CENA"]) && !empty($_POST["CENA"]);

        if ($validData) {
            ItemDB::insert($_POST["SIFRA_ARTIKLA"], $_POST["ID_SKUPINE"], $_POST["ID_NAROCILA"], $_POST["NAZIV_ARTIKLA"],$_POST["CENA"],
                    $_POST["PROIZVAJALEC"],$_POST["ENOTA_MER"] );
            ViewHelper::redirect(BASE_URL . "item");
        } else {
            self::showAddForm($_POST);
        }
    }

    public static function showEditForm($item = []) {
        if (empty($item)) {
            $item = ItemDB::get($_GET["id"]);
        }

        ViewHelper::render("view/Item-edit.php", ["item" => $item]);
    }

    public static function edit() {
        $validData = isset($_POST["ID_SKUPINE"]) && !empty($_POST["ID_SKUPINE"]) &&
                 isset($_POST["SIFRA_ARTIKLA"]) && !empty($_POST["SIFRA_ARTIKLA"]) &&
                isset($_POST["PROIZVAJALEC"]) && !empty($_POST["PROIZVAJALEC"]) &&
                isset($_POST["ENOTA_MER"]) && !empty($_POST["ENOTA_MER"]) &&
                isset($_POST["ID_NAROCILA"]) && !empty($_POST["ID_NAROCILA"]) &&
                isset($_POST["NAZIV_ARTIKLA"]) && !empty($_POST["NAZIV_ARTIKLA"]) &&
                isset($_POST["CENA"]) && !empty($_POST["CENA"]);

        if ($validData) {
            ItemDB::update(
                $_POST["SIFRA_ARTIKLA"],
                $_POST["ID_SKUPINE"],
                $_POST["ID_NAROCILA"],
                $_POST["NAZIV_ARTIKLA"],
                $_POST["CENA"],
                $_POST["PROIZVAJALEC"],
                $_POST["ENOTA_MER"]
            );
            ViewHelper::redirect(BASE_URL . "item?id=" . $_POST["SIFRA_ARTIKLA"]);
        } else {
            self::showEditForm($_POST);
        }
    }

    public static function delete() {
        $validDelete = isset($_POST["delete_confirmation"]) && isset($_POST["SIFRA_ARTIKLA"]) && !empty($_POST["SIFRA_ARTIKLA"]);

        if ($validDelete) {
            ItemDB::delete($_POST["SIFRA_ARTIKLA"]);
            $url = BASE_URL . "item";
        } else {
            if (isset($_POST["SIFRA_ARTIKLA"])) {
                $url = BASE_URL . "item/edit?id=" . $_POST["SIFRA_ARTIKLA"];
            } else {
                $url = BASE_URL . "item";
            }
        }

        ViewHelper::redirect($url);
    }

    public static function getPicture() {
        
    }

    public static function helloWorld() {
        echo "Hello world";
    }
}
