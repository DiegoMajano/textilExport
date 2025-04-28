<?php include '../header.php'; ?>

<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow">
        <div class="card-header bg-warning text-white">
          <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Editar Producto</h4>
        </div>

        <div class="card-body">
          <form method="POST" action="<?= PATH ?>/products/edit/<?= $product['id'] ?>">
            <input type="hidden" name="id" value="<?= $product['id'] ?>">

            <div class="mb-3">
              <label for="product" class="form-label">Nombre del Producto</label>
              <input type="text" class="form-control" id="product" name="product"
                value="<?= htmlspecialchars($product['product']) ?>" required>
            </div>

            <div class="mb-3">
              <label for="description" class="form-label">Descripción</label>
              <textarea class="form-control" id="description" name="description" rows="3"
                required><?= htmlspecialchars($product['description']) ?></textarea>
            </div>

            <div class="mb-3">
              <label for="image_url" class="form-label">URL de la Imagen</label>
              <input type="text" class="form-control" id="image_url" name="image_url"
                value="<?= htmlspecialchars($product['image_url']) ?>" required>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="category_id" class="form-label">Categoría</label>
                <select class="form-select" id="category_id" name="category_id" required>
                  <option value="1" <?= $product['category_id'] == 1 ? 'selected' : '' ?>>Ropa</option>
                  <option value="2" <?= $product['category_id'] == 2 ? 'selected' : '' ?>>Accesorios</option>
                  <option value="3" <?= $product['category_id'] == 3 ? 'selected' : '' ?>>Telas</option>
                </select>
              </div>

              <div class="col-md-6 mb-3">
                <label for="price" class="form-label">Precio</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price"
                  value="<?= $product['price'] ?>" required>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" value="<?= $product['stock'] ?>"
                  required>
              </div>

              <div class="col-md-6 mb-3">
                <label for="state" class="form-label">Estado</label>
                <select class="form-select" id="state" name="state" required>
                  <option value="1" <?= $product['state'] == 1 ? 'selected' : '' ?>>Activo</option>
                  <option value="0" <?= $product['state'] == 0 ? 'selected' : '' ?>>Inactivo</option>
                </select>
              </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <a href="<?= PATH ?>/products" class="btn btn-secondary me-md-2">
                <i class="fas fa-times me-1"></i>Cancelar
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i>Guardar Cambios
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include '../footer.php'; ?>