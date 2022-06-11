<!-- BARRA LATERAL -->
<aside id="lateral">

    <div id="carrito" class="block_aside">
        <h3>Mi carrito</h3>
        <ul>
            <?php $stats = Utils::statsCarrito(); ?>
            <li><a href="<?=base_url?>carrito/index">Productos (<?=$stats['count']?>)</a></li>
            <li><a href="<?=base_url?>carrito/index">Total: <?=$stats['total']?> $</a></li>
        </ul>
    </div>

    <div id="login" class="block_aside">

        <ul>
            <li><a href="<?=base_url?>categoria/index">Gestionar categorias</a></li>
            <li><a href="<?=base_url?>producto/gestion">Gestionar productos</a></li>
            <li><a href="<?=base_url?>pedido/gestion">Gestionar ventas</a></li>
        </ul>
    </div>

</aside>

<!-- CONTENIDO CENTRAL -->
<div id="central">