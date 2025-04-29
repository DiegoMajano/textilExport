<?php include './views/header.php'; ?>

<div class="container mt-4">
  <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin'): ?>
    <!-- Solo muestra opciones de admin si está logueado y es admin -->
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
    <!-- Para usuarios normales o no logueados -->
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
          <img src="<?= htmlspecialchars($product['image_url'] ?? 'https://via.placeholder.com/300') ?>"
            class="card-img-top p-3" style="height: 200px; object-fit: contain;"
            alt="<?= htmlspecialchars($product['product']) ?>">

          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($product['product']) ?></h5>
            <p class="text-muted"><?= htmlspecialchars($product['category'] ?? 'Sin categoría') ?></p>
            <p class="card-text">$<?= number_format($product['price'], 2) ?></p>
          </div>

          <div class="card-footer bg-white">
            <div class="d-flex justify-content-between">
              <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                data-bs-target="#productModal<?= $product['product_id'] ?>">
                <i class="fas fa-eye me-1"></i>Ver más
              </button>

              <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin'): ?>
                <!-- Solo muestra opciones de edición/eliminación para admin -->
                <button type="button" class="btn btn-warning text-white w-auto fw-bold" data-bs-toggle="modal"
                  data-bs-target="#Editar<?= $product['product_id'] ?>">
                  Editar
                </button>

                <form method="POST" action="<?= PATH ?>/products/delete/<?= $product['product_id'] ?>">
                  <button type="submit" class="btn btn-outline-danger btn-sm"
                    onclick="return confirm('¿Eliminar este producto?')">
                    <i class="fas fa-trash me-1"></i>Eliminar
                  </button>
                </form>
              <?php elseif (!isset($_SESSION['user'])): ?>
                <!-- Muestra botón de login para usuarios no logueados -->
                <a href="<?= PATH ?>/users/login" class="btn btn-info btn-sm">
                  <i class="fas fa-sign-in-alt me-1"></i>Iniciar sesión
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>

      <!-- Modales (se mantienen igual) -->
      <div class="modal fade" id="productModal<?= $product['product_id'] ?>" tabindex="-1" aria-hidden="true">
        <!-- Contenido del modal de visualización -->
      </div>

      <?php include './views/products/edit.php'; ?>
    <?php endforeach; ?>
  </div>
</div>

<?php include './views/footer.php'; ?>