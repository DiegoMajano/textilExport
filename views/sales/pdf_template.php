<h2>Resumen de Compra</h2>
<p><strong>Cliente:</strong> <?= htmlspecialchars($sale['username']) ?></p>
<p><strong>Email:</strong> <?= $sale['email'] ?></p>
<p><strong>Télefono de contacto:</strong> <?= $sale['phone'] ?></p>
<p><strong>Fecha:</strong> <?= $sale['date'] ?></p>
<p><strong>Total:</strong> $<?= number_format($sale['total'], 2) ?></p>

<table border="1" cellpadding="5" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th>Producto</th>
      <th>Cantidad</th>
      <th>Precio unitario</th>
      <th>Subtotal</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($sale['details'] as $item): ?>
    <tr>
      <td><?= htmlspecialchars($item['product']) ?></td>
      <td><?= $item['quantity'] ?></td>
      <td>$<?= number_format($item['price'], 2) ?></td>
      <td>$<?= number_format($item['quantity'] * $item['price'], 2) ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
