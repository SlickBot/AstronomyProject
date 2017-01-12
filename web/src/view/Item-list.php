<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Store</title>

<h1>All items</h1>

<p>[
<a href="<?= BASE_URL . "items" ?>">All items</a> |
<a href="<?= BASE_URL . "item/add" ?>">Add new</a> |
<a href="<?= BASE_URL . "store" ?>">Item store</a>
]</p>

<ul>

    <?php foreach ($items as $item): ?>
        <li><a href="<?= BASE_URL . "item?id=" . $item["SIFRA_ARTIKLA"] ?>"><?= $item["NAZIV_ARTIKLA"] ?>: 
        	<?= $item["PROIZVAJALEC"] ?> (<?= $item["ENOTA_MER"] ?>)</a></li>
    <?php endforeach; ?>

</ul>
