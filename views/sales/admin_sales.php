<?php include './views/header.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    echo "<script>alert('Acceso denegado.');</script>";
    header("Location: " . PATH . "/products");
    exit;
}
?>

<div class="container mt-5">
  <h2 class="mb-4">Gestión de Ventas</h2>

  <?php if (!empty($sales)): ?>
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>ID Venta</th>
          <th>Cliente</th>
          <th>Fecha</th>
          <th>Total</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($sales as $sale): ?>
          <tr>
            <td><?= $sale['sale_id'] ?></td>
            <td><?= htmlspecialchars($sale['username']) ?></td>
            <td><?= htmlspecialchars($sale['date']) ?></td>
            <td>$<?= number_format($sale['total'], 2) ?></td>
            <td><?= $sale['state'] == 1 ? 'Completado' : 'Pendiente' ?></td>
            <td>
              <a href="<?= PATH ?>/sales/show/<?= $sale['sale_id'] ?>" class="btn btn-sm btn-info">Ver Detalle</a>
              <a href="<?= PATH ?>/sales/pdf/<?= $sale['sale_id'] ?>" target="_blank" class="btn btn-sm btn-success">Descargar PDF</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-warning">No hay ventas registradas.</div>
  <?php endif; ?>
</div>

<?php include './views/footer.php'; ?>
