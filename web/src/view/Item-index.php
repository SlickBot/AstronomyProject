<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8"/>
<title>Item store</title>

<h1>Item store</h1>

<p>[
    <a href="<?= BASE_URL . "item" ?>">All items</a> |
    <a href="<?= BASE_URL . "item/add" ?>">Add new</a> |
    <a href="<?= BASE_URL . "store" ?>">Item store</a>
    ]</p>

<div id="main">
    <?php foreach ($items as $item): ?>

        <div class="item">
            <form action="<?= BASE_URL . "store/add-to-cart" ?>" method="post">
                <input type="hidden" name="SIFRA_ARTIKLA" value="<?= $item["SIFRA_ARTIKLA"] ?>"/>
                <p><img src="../slike/cev.jpg" alt="Mountain View" style="width:304px;height:228px;"></p>
                <p><?= $item["NAZIV_ARTIKLA"] ?></p>
                <p><?= $item["ID_NAROCILA"] ?></p>
                <p><?= $item["ID_SKUPINE"] ?></p>
                <p><?= $item["PROIZVAJALEC"] ?>, <?= $item["ENOTA_MER"] ?> </p>
                <p><?= number_format($item["CENA"], 2) ?> EUR</p><br/>
                <button>Add to cart</button>
            </form>
        </div>

    <?php endforeach; ?>

</div>

<?php if (!empty($cart)): ?>

    <div id="cart">
        <h3>Shopping cart</h3>
        <?php foreach ($cart as $item): ?>

            <form action="<?= BASE_URL . "store/update-cart" ?>" method="post">
                <input type="hidden" name="SIFRA_ARTIKLA" value="<?= $item["SIFRA_ARTIKLA"] ?>"/>
                <input type="number" name="quantity" value="<?= $item["quantity"] ?>" class="update-cart"/>
                &times; <?= $item["NAZIV_ARTIKLA"] ?>
                <button>Update</button>
            </form>

        <?php endforeach; ?>

        <p>Total: <b><?= number_format($total, 2) ?> EUR</b></p>

        <form action="<?= BASE_URL . "store/purge-cart" ?>" method="post">
            <p>
                <button>Purge cart</button>
            </p>
        </form>
    </div>

<?php endif; ?>
