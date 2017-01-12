<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Item detail</title>

<h1>Details of: <?= $item["NAZIV_ARTIKLA"] ?></h1>

<p>[
<a href="<?= BASE_URL . "item" ?>">All items</a> |
<a href="<?= BASE_URL . "item/add" ?>">Add new</a> |
<a href="<?= BASE_URL . "store" ?>">Item store</a>
]</p>

<ul>
    <li>Naziv: <b><?= $item["NAZIV_ARTIKLA"] ?></b></li>
    <li>Cena: <b><?= $item["CENA"] ?> EUR</b></li>
    <li>Proizvajalec: <b><?= $item["PROIZVAJALEC"] ?></b></li>
    <li>Enota mer: <b><?= $item["ENOTA_MER"] ?></b></li>
    <li>ID_naročila: <b><?= $item["ID_NAROCILA"] ?> </b></li>
    <li>ID_skupine: <b><?= $item["ID_SKUPINE"] ?></b></li>
</ul>

<p>[ <a href="<?= BASE_URL . "item/edit?id=" . $_GET["id"] ?>">Edit</a> |
<a href="<?= BASE_URL . "item" ?>">Item index</a> ]</p>
