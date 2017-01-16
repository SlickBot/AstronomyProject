<?php
/**
 * Created by IntelliJ IDEA.
 * User: SlickyPC
 * Date: 13.1.2017
 * Time: 17:34
 */

require_once("model/ItemDB.php");
require_once("controller/ItemController.php");
require_once("ViewHelper.php");

class RESTController {

    public static function add() {
        $data = filter_input_array(INPUT_POST, ItemController::getRules());

        if (ItemController::checkValues($data)) {
            $id = ItemDB::insert($data);
            echo ViewHelper::renderJSON("", 201);
            ViewHelper::redirect(BASE_URL . "api/books/$id");
        } else {
            echo ViewHelper::renderJSON("Missing data.", 400);
        }
    }
}
