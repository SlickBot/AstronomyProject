<?php

require_once("ViewHelper.php");

class UporabnikController {

    public static function index() {

        ViewHelper::render("Main.php", []);
    }

    public static function register() {

        ViewHelper::render("view/registracija.php", []);
    }

    public static function changeData() {
        ViewHelper::render("view/Uporabnik-edit.php", []);
    }

    public static function naročilo() {
        ViewHelper::render("view/naročilo.php", []);
    }

    public static function pregled() {
        ViewHelper::render("view/Pregled.php", []);
    }

    public static function pregledStranka() {
        ViewHelper::render("view/PregledStranka.php", []);
    }

    public static function UstvariProdajalca() {
        ViewHelper::render("view/UstvariProdajalca.php", []);
    }

    public static function add() {
        ViewHelper::render("view/seller-add.php", []);
    }

    public static function edit() {
        ViewHelper::render("view/seller-edit.php", []);
    }

    public static function customer() {
        ViewHelper::render("view/Customer.php", []);
    }

    public static function addcustomer() {
        ViewHelper::render("view/customer-add.php", []);
    }

    public static function editcustomer() {
        ViewHelper::render("view/customer-edit.php", []);
    }

    public static function confirm() {
        ViewHelper::render("emailconfirm.php", []);
    }

}
