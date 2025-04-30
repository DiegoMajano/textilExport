

<?php include './views/header.php'; ?>
<?php if (!empty($_SESSION['success_message'])): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= $_SESSION['success_message']; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
  </div>
  <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<div class="container mt-5">
  <h2 class="mb-4">Listado de Categorías</h2>

    <!-- Botón para abrir el modal de nueva categoría -->
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#newCategoryModal">
    Nueva Categoría
    </button>

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($categories as $cat): ?>
      <tr>
        <td><?= $cat['category_id'] ?></td>
        <td><?= htmlspecialchars($cat['category']) ?></td>
        <td><?= htmlspecialchars($cat['description']) ?></td>
        <td>
          <!-- Botón para abrir el modal -->
          <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editCategoryModal<?= $cat['category_id']?>">
            Editar
          </button>

          <!-- Formulario eliminar -->
          <form action="<?= PATH . '/categories/delete/' . $cat['category_id'] ?>" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta categoría?');">
            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
          </form>
        </td>
      </tr>

      <!-- Modal de edición -->
      <div class="modal fade" id="editCategoryModal<?= $cat['category_id'] ?>" tabindex="-1" aria-labelledby="editCategoryModalLabel<?= $cat['category_id'] ?>" aria-hidden="true">
        <div class="modal-dialog">
          <form method="POST" action="<?= PATH . '/categories/update/' . $cat['category_id'] ?>">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel<?= $cat['category_id'] ?>">Editar Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <label for="category<?= $cat['category_id'] ?>" class="form-label">Nombre</label>
                  <input type="text" class="form-control" name="category" id="category<?= $cat['category_id'] ?>" value="<?= htmlspecialchars($cat['category']) ?>" required>
                </div>
                <div class="mb-3">
                  <label for="description<?= $cat['category_id'] ?>" class="form-label">Descripción</label>
                  <input type="text" class="form-control" name="description" id="description<?= $cat['category_id'] ?>" value="<?= htmlspecialchars($cat['description']) ?>" required>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    <?php endforeach; ?>

    </tbody>
  </table>
</div>

<!-- Modal Nueva Categoría -->
<div class="modal fade" id="newCategoryModal" tabindex="-1" aria-labelledby="newCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="<?= PATH ?>/categories/create">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newCategoryModalLabel">Nueva Categoría</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="categoryName" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="categoryName" name="category" required>
          </div>
          <div class="mb-3">
            <label for="categoryDesc" class="form-label">Descripción</label>
            <input type="text" class="form-control" id="categoryDesc" name="description" required>
          </div>
          <input type="hidden" name="state" value="1"> <!-- Estado activo por defecto -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>



<?php include './views/footer.php'; ?>
