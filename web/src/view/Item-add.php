<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Add entry</title>

<h1>Add new Item</h1>

<p>[
<a href="<?= BASE_URL . "item" ?>">All items</a> |
<a href="<?= BASE_URL . "item/add" ?>">Add new</a> |
<a href="<?= BASE_URL . "store" ?>">Itemstore</a>
]</p>

<form action="<?= BASE_URL . "item/add" ?>" method="post">
        <p><label>Šifra: <input type="number" name="SIFRA_ARTIKLA" value="<?= $SIFRA_ARTIKLA ?>" /></label></p>
    <p><label>Naziv: <input type="text" name="NAZIV_ARTIKLA" value="<?= $NAZIV_ARTIKLA ?>" autofocus /></label></p>
    <p><label>Cena: <input type="number" name="CENA" value="<?= $CENA ?>" /></label></p>
    <p><label>Proizvajalec: <input type="text" name="PROIZVAJALEC" value="<?= $PROIZVAJALEC ?>" /></label></p>
    <p><label>Enote mere: <input type="number" name="ENOTA_MER" value="<?= $ENOTA_MER ?>" /></label></p>
    <p><label>ID_skupine: <input type="number" name="ID_SKUPINE" value="<?= $ID_SKUPINE ?>" /></label></p>
    <p><label>ID_naročila: <input type="number" name="ID_NAROCILA" value="<?= $ID_NAROCILA ?>" /></label></p>
    <p><button>Insert</button></p>
</form>
