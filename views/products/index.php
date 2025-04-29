<?php include './views/header.php'; ?>
<?php if (isset($_SESSION['error'])): ?>
  <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
  <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>

<div class="container mt-4">
  <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin'): ?>
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
            <p class="text-muted"><?= htmlspecialchars($product['category'] ?? 'Sin categoría') ?></p>
            <p class="card-text">$<?= number_format($product['price'], 2) ?></p>
            <?php if ($product['stock'] == 0): ?>
              <span class="badge bg-danger">Agotado</span>
            <?php endif; ?>
          </div>

          <div class="card-footer bg-white">
            <div class="d-flex justify-content-between">
              <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                data-bs-target="#productModal<?= $product['product_id'] ?>">
                <i class="fas fa-eye me-1"></i>Ver más
              </button>

              <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin'): ?>
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
              <?php endif; ?>
              <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Customer'): ?>                
                <form method="POST" action="<?= PATH ."/carts/create"?>" class="d-flex align-items-center gap-2 ms-2">	
                  <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>" class="form-control w-25 me-2">
                  <input type="number" name="quantity" value="1" class="form-control w-25 me-2 " min="1" max="" required>
                  <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>" class="form-control w-25 me-2">
                  <button type="submit" class="btn btn-outline-danger btn-sm"
                    onclick="return confirm('¿Agregar este producto al carrito?')">
                    <i class="fas fa-cart-plus me-1"></i>Agregar al carrito</button>

                </form>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="productModal<?= $product['product_id'] ?>" tabindex="-1" aria-hidden="true">
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
              <p><strong>Stock:</strong>
                <?php if ($product['stock'] == 0): ?>
                  <span class="text-danger">¡Agotado! Pronto habrá más.</span>
                <?php else: ?>
                  <?= $product['stock'] ?>
                <?php endif; ?>
              </p>
              <p><strong>Categoría:</strong> <?= htmlspecialchars($product['category'] ?? 'Sin categoría') ?></p>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>

      <?php include './views/products/edit.php'; ?>
    <?php endforeach; ?>
  </div>

  <!-- Para ver carrito -->


  <div id="cartPanel" class="position-fixed top-0 end-0 bg-white border-start shadow p-4"
     style="width: 350px; height: 100vh; z-index: 1050; overflow-y: auto; display: none;">
  <div class="d-flex justify-content-between mb-3">
    <h5>Mi Carrito</h5>
    <button class="btn-close" onclick="toggleCart()" aria-label="Cerrar"></button>
  </div>
  <hr>
  <div id="cartContent">
    <p>Cargando...</p>
  </div>
</div>



</div>
<script>
function toggleCart() {
  const cartPanel = document.getElementById('cartPanel');
  const cartContent = document.getElementById('cartContent');

  if (cartPanel.style.display === 'none') {
    cartPanel.style.display = 'block';

    // Llamar al endpoint AJAX que carga el carrito
    fetch('<?= PATH ?>/carts/show') // Asegúrate que este endpoint exista
      .then(response => response.text())
      .then(html => {
        cartContent.innerHTML = html;
      })
      .catch(error => {
        cartContent.innerHTML = '<p>Error al cargar el carrito.</p>';
        console.error(error);
      });

  } else {
    cartPanel.style.display = 'none';
  }
}
</script>

<?php include './views/footer.php'; ?>