<?php

require_once("model/ItemDB.php");
require_once("model/Cart.php");
require_once("ViewHelper.php");

class StoreController {

    public static function index() {
        $vars = [
            "items" => ItemDB::getAll(),
            "cart" => Cart::getAll(),
            "total" => Cart::total()
        ];

        ViewHelper::render("view/Item-index.php", $vars);
    }

    public static function addToCart() {
        $id = isset($_POST["SIFRA_ARTIKLA"]) ? intval($_POST["SIFRA_ARTIKLA"]) : null;

        if ($id !== null) {
            Cart::add($id);
        }

        ViewHelper::redirect(BASE_URL . "store");
    }

    public static function updateCart() {
        $id = (isset($_POST["SIFRA_ARTIKLA"])) ? intval($_POST["SIFRA_ARTIKLA"]) : null;
        $quantity = (isset($_POST["quantity"])) ? intval($_POST["quantity"]) : null;

        if ($id !== null && $quantity !== null) {
            Cart::update($id, $quantity);
        }

        ViewHelper::redirect(BASE_URL . "store");
    }

    public static function purgeCart() {
        Cart::purge();

        ViewHelper::redirect(BASE_URL . "store");
    }

    public static function emptyCart() {
        Cart::purge();
    }

    public static function narocilo() {
        $vars = [
            "items" => ItemDB::getAll(),
            "cart" => Cart::getAll(),
            "total" => Cart::total()
        ];
        ViewHelper::render("view/zakljucek.php", [ $vars]);
    }

    public static function posamezno() {
        ViewHelper::render("view/posamezno.php", []);
    }

    public static function storaniraj() {
        ViewHelper::render("view/Storaniraj.php", []);
    }

    public static function potrjeno() {
        ViewHelper::render("view/Potrjeno.php", []);
    }

}
