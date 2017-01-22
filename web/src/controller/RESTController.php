<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RESTController
 *
 * @author ep
 */
class RESTController {
    
    public static function getItems() {
        echo ViewHelper::renderJSON(ItemDB::getAllWithUrls());
    }
    
    public static function authenticate() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $data = filter_input_array(INPUT_POST);
            $signIn = ItemDB::authenticateCustomer($data["username"], $data["hash"]);
            
            if ($signIn) {
                echo ViewHelper::renderJSON(["login" => TRUE]);
            } else {
                echo ViewHelper::renderJSON(["login" => FALSE], 401);
            }
        } else {
            echo ViewHelper::error404();
        }
    }
    
    public static function getUser() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $data = filter_input_array(INPUT_POST);
            $user = ItemDB::getUser($data["username"], $data["hash"]);
            
            if ($user) {
                echo ViewHelper::renderJSON($user);
            } else {
                echo ViewHelper::renderJSON($user, 401);
            }
        } else {
            echo ViewHelper::error404();
        }
    }
    
    public static function setUser() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $data = filter_input_array(INPUT_POST);
            $edited = ItemDB::setUser($data["username"],
                                    $data["hash"],
                                    $data["id"],
                                    $data["name"],
                                    $data["surname"],
                                    $data["email"],
                                    $data["phone"],
                                    $data["address"]);
            
            if ($edited === NULL) {
                echo ViewHelper::renderJSON(["edited" => FALSE], 401);
            } else if ($edited) {
                echo ViewHelper::renderJSON(["edited" => TRUE]);
            } else {
                 echo ViewHelper::renderJSON(["edited" => FALSE]);
            }
        } else {
            echo ViewHelper::error404();
        }
    }
    
    public static function getPurchases() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $data = filter_input_array(INPUT_POST);
            $purchases = ItemDB::getPurchases($data["username"], $data["hash"]);
            
            if ($purchases) {
                echo ViewHelper::renderJSON($purchases);
            } else {
                echo ViewHelper::renderJSON([], 401);
            }
        } else {
            echo ViewHelper::error404();
        }
    }
    
    public static function getPurchase() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $data = filter_input_array(INPUT_POST);
            $purchase = ItemDB::getPurchase($data["username"], $data["hash"], $data["id"]);
            
            if ($purchase) {
                echo ViewHelper::renderJSON($purchase);
            } else {
                echo ViewHelper::renderJSON([], 401);
            }
        } else {
            echo ViewHelper::error404();
        }
    }
    
    public static function buy() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $data = filter_input_array(INPUT_POST);
            
            $purchased = ItemDB::buy($data["username"],
                                     $data["hash"],
                                     $data["list"]);
            
            if ($purchased === NULL) {
                echo ViewHelper::renderJSON(["bought" => FALSE], 401);
            } else if ($purchased) {
                echo ViewHelper::renderJSON(["bought" => TRUE]);
            } else {
                 echo ViewHelper::renderJSON(["bought" => FALSE]);
            }
        } else {
            echo ViewHelper::error404();
        }
    }
}
