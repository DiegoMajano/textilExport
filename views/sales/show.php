<?php include './views/header.php'; ?>

<div class="container mt-4">
  <h2>Resumen de Compra</h2>

  <p><strong>Usuario:</strong> <?= htmlspecialchars($sale['username']) ?></p>
  <p><strong>Email:</strong> <?= htmlspecialchars($sale['email']) ?></p>
  <p><strong>Télefono de contacto:</strong> <?= ($sale['phone']) ?></p>
  <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($sale['date'])) ?></p>
  <p><strong>Total:</strong> $<?= number_format($sale['total'], 2) ?></p>

  <table class="table table-bordered mt-4">
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

  <!-- Botón para PDF -->
  <a href="<?= PATH ?>/sales/pdf/<?= $sale['sale_id'] ?>" class="btn btn-success" target="_blank">
    <i class="fas fa-file-pdf me-1"></i> Descargar PDF
  </a>
</div>

<?php include './views/footer.php'; ?>
