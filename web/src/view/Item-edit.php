<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Edit entry</title>

<h1>Edit item</h1>

<p>[
<a href="<?= BASE_URL . "item" ?>">All items</a> |
<a href="<?= BASE_URL . "item/add" ?>">Add new</a> |
<a href="<?= BASE_URL . "store" ?>">Item store</a>
]</p>

<form action="<?= BASE_URL . "item/edit" ?>" method="post">
    <input type="hidden" name="SIFRA_ARTIKLA" value="<?= $item["SIFRA_ARTIKLA"] ?>"  />
    <p><label>Naziv: <input type="text" name="NAZIV_ARTIKLA" value="<?= $item["NAZIV_ARTIKLA"] ?>" autofocus /></label></p>
    <p><label>Proizvajalec: <input type="text" name="PROIZVAJALEC" value="<?= $item["PROIZVAJALEC"] ?>" /></label></p>
    <p><label>Cena: <input type="number" name="CENA" value="<?= $item["CENA"] ?>" /> EUR</label></p>
    <p><label>Enota mer: <input type="number" name="ENOTA_MER" value="<?= $item["ENOTA_MER"] ?>" /></label></p>
    <p><label>ID skupine: <input type="number" name="ID_SKUPINE" value="<?= $item["ID_SKUPINE"] ?>" /> EUR</label></p>
    <p><label>ID naročila: <input type="number" name="ID_NAROCILA" value="<?= $item["ID_NAROCILA"] ?>" /></label></p>
  
    <p><button>Update record</button></p>
</form>

<form action="<?= BASE_URL . "item/delete" ?>" method="post">
    <input type="hidden" name="SIFRA_ARTIKLA" value="<?= $item["SIFRA_ARTIKLA"] ?>"  />
    <label>Delete? <input type="checkbox" name="delete_confirmation" /></label>
    <button type="submit" class="important">Delete record</button>
</form>
