<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "user.css" ?>">
<meta charset="UTF-8" />
<title>Artikli</title>

<h1>Artikli</h1>

<p>[
    <a href="<?= BASE_URL . "item" ?>">Vse stvari</a> |
    <a href="<?= BASE_URL . "item/add" ?>">Dodaj</a> |
    <a href="<?= BASE_URL . "store" ?>">Trgovina</a>
    ]</p>

<ul>

    <?php foreach ($items as $item): ?>
        <li><a href="<?= BASE_URL . "item?id=" . $item["SIFRA_ARTIKLA"] ?>"><?= $item["NAZIV_ARTIKLA"] ?>: 
                <?= $item["PROIZVAJALEC"] ?> (<?= $item["ENOTA_MER"] ?>)</a></li>
    <?php endforeach; ?>

</ul>
