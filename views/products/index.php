<?php include './views/header.php'; ?>

<div class="container mt-4">
  <?php if ($_SESSION['role'] == 'admin'): ?>
    <div class="d-flex justify-content-between mb-4">
      <a href="<?= PATH ?>/products/create" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Agregar producto
      </a>

      <form class="d-flex" method="GET" action="<?= PATH ?>/products">
        <input class="form-control me-2" type="search" placeholder="Buscar producto..." name="search">
        <button class="btn btn-outline-primary" type="submit">
          <i class="fas fa-search me-1"></i>Buscar
        </button>
      </form>
    </div>
  <?php else: ?>
    <div class="d-flex justify-content-end mb-4">
      <form class="d-flex" method="GET" action="<?= PATH ?>/products">
        <input class="form-control me-2" type="search" placeholder="Buscar producto..." name="search">
        <button class="btn btn-outline-primary" type="submit">
          <i class="fas fa-search me-1"></i>Buscar
        </button>
      </form>
    </div>
  <?php endif; ?>

  <div class="row">
    <?php foreach ($products as $product): ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow">
          <img src="<?= htmlspecialchars($product['image_url']) ?>" class="card-img-top p-3"
            style="height: 200px; object-fit: contain;" alt="<?= htmlspecialchars($product['product']) ?>">

          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($product['product']) ?></h5>
            <p class="text-muted"><?= htmlspecialchars($product['category_name'] ?? 'Sin categoría') ?></p>
            <p class="card-text">$<?= number_format($product['price'], 2) ?></p>
          </div>

          <div class="card-footer bg-white">
            <div class="d-flex justify-content-between">
              <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                data-bs-target="#productModal<?= $product['id'] ?>">
                <i class="fas fa-eye me-1"></i>Ver más
              </button>

              <?php if ($_SESSION['role'] == 'admin'): ?>
                <a href="<?= PATH ?>/products/edit/<?= $product['id'] ?>" class="btn btn-outline-warning btn-sm">
                  <i class="fas fa-edit me-1"></i>Editar
                </a>

                <form method="POST" action="<?= PATH ?>/products/delete/<?= $product['id'] ?>">
                  <button type="submit" class="btn btn-outline-danger btn-sm"
                    onclick="return confirm('¿Eliminar este producto?')">
                    <i class="fas fa-trash me-1"></i>Eliminar
                  </button>
                </form>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal para ver detalles -->
      <div class="modal fade" id="productModal<?= $product['id'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><?= htmlspecialchars($product['product']) ?></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <img src="<?= htmlspecialchars($product['image_url']) ?>" class="img-fluid mb-3"
                alt="<?= htmlspecialchars($product['product']) ?>">
              <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
              <p><strong>Precio:</strong> $<?= number_format($product['price'], 2) ?></p>
              <p><strong>Stock:</strong> <?= $product['stock'] ?></p>
              <p><strong>Categoría:</strong> <?= htmlspecialchars($product['category_name'] ?? 'Sin categoría') ?></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php include '../footer.php'; ?>