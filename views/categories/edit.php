<?php include './views/header.php'; ?>

<div class="container mt-5">
  <h2>Editar Categoría</h2>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form action="<?= PATH ?>/categories/update/<?= $category['id'] ?>" method="POST">
    <div class="mb-3">
      <label for="name" class="form-label">Nombre</label>
      <input type="text" class="form-control" name="name" id="name" value="<?= htmlspecialchars($category['name']) ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Guardar cambios</button>
    <a href="<?= PATH ?>/categories/index" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

<?php include './views/footer.php'; ?>
