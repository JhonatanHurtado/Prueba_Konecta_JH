<h1>Hacer venta</h1>
<p>
    <a href="<?= base_url ?>carrito/index">Ver los productos y el precio de la venta</a>
</p>
<br />

<h3>Dirección para el envio:</h3>
<form action="<?=base_url.'pedido/add'?>" method="POST">
    <label for="departamento">Departamento</label>
    <input type="text" name="departamento" required />

    <label for="ciudad">Ciudad</label>
    <input type="text" name="ciudad" required />

    <label for="direccion">Dirección</label>
    <input type="text" name="direccion" required />

    <input type="submit" value="Confirmar compra" />
</form>