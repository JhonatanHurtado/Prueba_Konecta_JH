<h1>Carrito de la compra</h1>

<?php if(isset($_SESSION['carrito']) && count($_SESSION['carrito']) >= 1): ?>
<table>
    <tr>
        <th>Imagen</th>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Unidades</th>
        <th>Eliminar</th>
    </tr>
    <?php 
		foreach($carrito as $indice => $elemento): 
		$producto = $elemento['producto'];
	?>

    <tr>
        <td>
            <?php if ($producto->imagen != null): ?>
            <img style="max-width: 200px;" src="<?= base_url ?>uploads/images/<?= $producto->imagen ?>"
                class="img_carrito" />
            <?php else: ?>
            <img style="max-width: 200px;" src="<?= base_url ?>assets/img/base.png" class="img_carrito" />
            <?php endif; ?>
        </td>
        <td>
            <a href="<?= base_url ?>producto/ver&id=<?=$producto->id?>"><?=$producto->nombre?></a>
        </td>
        <td>
            <?=$producto->precio?>
        </td>
        <td>
            <?=$elemento['unidades']?>
            <div class="updown-unidades">
                <a href="<?=base_url?>carrito/up&index=<?=$indice?>&stock=<?=$producto->stock?>&id=<?=$producto->id?>"
                    class="button">+</a>
                <a href="<?=base_url?>carrito/down&index=<?=$indice?>&stock=<?=$producto->stock?>&id=<?=$producto->id?>"
                    class="button">-</a>
            </div>
        </td>
        <td>
            <a href="<?=base_url?>carrito/delete&index=<?=$indice?>&id=<?=$producto->id?>&stock=<?=$producto->stock?>"
                class="button button-carrito button-red">Quitar
                producto</a>
        </td>
    </tr>

    <?php endforeach; ?>
</table>
<br />
<div class="total-carrito">
    <?php $stats = Utils::statsCarrito(); ?>
    <h3>Precio total: <?=$stats['total']?> $</h3>
    <a href="<?=base_url?>pedido/hacer" class="button button-pedido">Comprar</a>
</div>

<?php else: ?>
<p>El carrito está vacio, añade algun producto</p>
<?php endif; ?>