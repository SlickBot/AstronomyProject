<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "user.css" ?>">
<meta charset="UTF-8" />
<title>Spremeni artikel</title>

<h1>Spremeni artikel</h1>

<p>[
    <a href="<?= BASE_URL . "item" ?>">Vse stvari</a> |
    <a href="<?= BASE_URL . "item/add" ?>">Dodaj</a> |
    <a href="<?= BASE_URL . "store" ?>">Trgovina</a>
    ]</p>

<form action="<?= BASE_URL . "item/edit" ?>" method="post">
    <input type="hidden" name="SIFRA_ARTIKLA" value="<?= $item["SIFRA_ARTIKLA"] ?>"  />
    <p><label>Naziv: <input type="text" name="NAZIV_ARTIKLA" value="<?= $item["NAZIV_ARTIKLA"] ?>" autofocus /></label></p>
    <p><label>Proizvajalec: <input type="text" name="PROIZVAJALEC" value="<?= $item["PROIZVAJALEC"] ?>" /></label></p>
    <p><label>Cena: <input type="number" name="CENA" value="<?= $item["CENA"] ?>" /> EUR</label></p>
    <p><label>Enota mer: <input type="number" name="ENOTA_MER" value="<?= $item["ENOTA_MER"] ?>" /></label></p>
    <p><label>ID skupine: <input type="number" name="ID_SKUPINE" value="<?= $item["ID_SKUPINE"] ?>" /></label></p>  
    <p><label>Opis: <input type="Text" name="OPIS" value="<?= $item["OPIS"] ?>" /></label></p>



    <p><button>Posodobi</button></p>
</form>

<form action="<?= BASE_URL . "item/delete" ?>" method="post">
    <input type="hidden" name="SIFRA_ARTIKLA" value="<?= $item["SIFRA_ARTIKLA"] ?>"  />
    <label>Izbriši artikel? <input type="checkbox" name="delete_confirmation" /></label>
    <button type="submit" class="important">Izbriši</button>
</form>
