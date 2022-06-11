<h1>Gestionar ventas</h1>
<table>
    <tr>
        <th>Nº Pedido</th>
        <th>Coste</th>
        <th>Fecha</th>
        <th>Estado</th>
    </tr>
    <?php
	while ($ped = $pedidos->fetch_object()):
		?>

    <tr>
        <td>
            <a href="<?= base_url ?>pedido/detalle&id=<?= $ped->id ?>"><?= $ped->id ?></a>
        </td>
        <td>
            <?= $ped->coste ?> $
        </td>
        <td>
            <?= $ped->fecha ?>
        </td>
        <td>
            <?= $ped->estado ?>
        </td>
    </tr>

    <?php endwhile; ?>
</table>