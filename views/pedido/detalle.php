<h1>Detalle de la venta</h1>

<?php if (isset($venta)): ?>

<h3>Dirección de envio</h3>
Provincia: <?= $venta->departamento ?> <br />
Cuidad: <?= $venta->ciudad ?> <br />
Direccion: <?= $venta->direccion ?> <br /><br />

<h3>Datos del venta:</h3>
Número de venta: <?= $venta->id ?> <br />
Total a pagar: <?= $venta->coste ?> $ <br />
Productos:

<table>
    <tr>
        <th>Imagen</th>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Unidades</th>
    </tr>
    <?php while ($producto = $productos->fetch_object()): ?>
    <tr>
        <td>
            <?php if ($producto->imagen != null): ?>
            <img style=max-width: 200px; " src=" <?= base_url ?>uploads/images/<?= $producto->imagen ?>"
                class="img_carrito" />
            <?php else: ?>
            <img style=max-width: 200px; "  src=" <?= base_url ?>assets/img/base.png" class="img_carrito" />
            <?php endif; ?>
        </td>
        <td>
            <a href="<?= base_url ?>producto/ver&id=<?= $producto->id ?>"><?= $producto->nombre ?></a>
        </td>
        <td>
            <?= $producto->precio ?>
        </td>
        <td>
            <?= $producto->unidades ?>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php endif; ?>