<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "user.css" ?>">
<meta charset="UTF-8" />
<title>Izdelki</title>

<h1>Detajli od: <?= $item["NAZIV_ARTIKLA"] ?></h1>

<p>[
    <a href="<?= BASE_URL . "item" ?>">Vse stvari</a> |
    <a href="<?= BASE_URL . "item/add" ?>">Dodaj</a> |
    <a href="<?= BASE_URL . "store" ?>">Trgovina</a>
    ]</p>

<ul>
    <li>Naziv: <b><?= $item["NAZIV_ARTIKLA"] ?></b></li>
    <li>Cena: <b><?= $item["CENA"] ?> EUR</b></li>
    <li>Proizvajalec: <b><?= $item["PROIZVAJALEC"] ?></b></li>
    <li>Enota mer: <b><?= $item["ENOTA_MER"] ?></b></li>
    <li>ID_skupine: <b><?= $item["ID_SKUPINE"] ?></b></li>
    <li>ID_skupine: <b><?= $item["OPIS"] ?></b></li>
</ul>

<p>[ <a href="<?= BASE_URL . "item/edit?id=" . $_GET["id"] ?>">Spremeni</a> |
    <a href="<?= BASE_URL . "item" ?>">Vse stvari</a> ]</p>
