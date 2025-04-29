<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: DejaVu Sans, sans-serif; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #000; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
  </style>
</head>
<body>
  <h2>Resumen de Compra</h2>
  <p><strong>Usuario:</strong> <?= htmlspecialchars($sale['username']) ?></p>
  <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($sale['date'])) ?></p>
  <p><strong>Total:</strong> $<?= number_format($sale['total'], 2) ?></p>

  <table>
    <thead>
      <tr>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio Unitario</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($sale['details'] as $item): ?>
        <tr>
          <td><?= htmlspecialchars($item['product']) ?></td>
          <td><?= $item['quantity'] ?></td>
          <td>$<?= number_format($item['price'], 2) ?></td>
          <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>
