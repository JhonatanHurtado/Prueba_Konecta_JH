<?php if (isset($product)): ?>
<h1><?= $product->nombre ?></h1>
<div id="detail-product">
    <div class="image">
        <?php if ($product->imagen != null): ?>
        <img src="<?= base_url ?>uploads/images/<?= $product->imagen ?>" />
        <?php else: ?>
        <img src="<?= base_url ?>assets/img/base.png" />
        <?php endif; ?>
    </div>
    <div class="data">
        <p class="description">

            <i>Referencia: </i> <br>
            <?= $product->referencia ?> <br><br>
            <i>Peso: </i> <br>
            <?= $product->peso ?> <br><br>
            <i>Stock: </i> <br>
            <?= $product->stock ?> <br><br>
            <i>Descripción: </i> <br>
            <?= $product->descripcion ?> <br>
        </p>
        <p class="price"><?= $product->precio ?>$</p>
        <?php if ($stock_actual == 0): ?>

        <a class="button" style="background-color: red;">No hay Stock</a>
        <?php else: ?>
        <a href="<?=base_url?>carrito/add&id=<?=$product->id?>" class="button">Comprar</a>

        <?php endif; ?>
    </div>
</div>
<?php else: ?>
<h1>El producto no existe</h1>
<?php endif; ?>