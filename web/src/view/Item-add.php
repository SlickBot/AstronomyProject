<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "user.css" ?>">
<meta charset="UTF-8" />
<title>Dodaj</title>

<h1>Dodaj</h1>

<p>[
    <a href="<?= BASE_URL . "item" ?>">Vse stvari</a> |
    <a href="<?= BASE_URL . "item/add" ?>">Dodaj</a> |
    <a href="<?= BASE_URL . "store" ?>">Trgovina</a>
    ]</p>

<form action="<?= BASE_URL . "item/add" ?>" method="post">
    <p><label>Šifra: <input type="number" name="SIFRA_ARTIKLA" value="<?= $SIFRA_ARTIKLA ?>" /></label></p>
    <p><label>Naziv: <input type="text" name="NAZIV_ARTIKLA" value="<?= $NAZIV_ARTIKLA ?>" autofocus /></label></p>
    <p><label>Cena: <input type="number" name="CENA" value="<?= $CENA ?>" /></label></p>
    <p><label>Proizvajalec: <input type="text" name="PROIZVAJALEC" value="<?= $PROIZVAJALEC ?>" /></label></p>
    <p><label>Enote mere: <input type="number" name="ENOTA_MER" value="<?= $ENOTA_MER ?>" /></label></p>
    <p><label>ID_skupine: <input type="number" name="ID_SKUPINE" value="<?= $ID_SKUPINE ?>" /></label></p>
    <p><label>Opis: <input type="text" name="OPIS" value="<?= $OPIS ?>" /></label></p>
    <p><label>Pot do slike: <input type="text" name="URL" value="<?= $URL ?>" /></label></p>

    <p><button>Dodaj</button></p>
</form>
