<?php include './views/header.php'; 

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') {
    echo "<script>alert('Acceso denegado.');</script>";
    header("Location: " . PATH . "/products");
    exit;
}

?>

<div class="container mt-5">
  <h2 class="mb-4">Gestión de Usuarios</h2>

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Teléfono</th>
        <th>Rol</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $user): ?>
        <tr>
          <td><?= $user['user_id'] ?></td>
          <td><?= htmlspecialchars($user['username']) ?></td>
          <td><?= htmlspecialchars($user['email']) ?></td>
          <td><?= htmlspecialchars($user['phone']) ?></td>
          <td><?= htmlspecialchars($user['role']) ?></td>
          <td>
          <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal<?= $user['user_id'] ?>">
            Editar
            </button>            
            <form method="POST" action="<?= PATH ?>/users/delete/<?= $user['user_id'] ?>" class="d-inline">
              <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php foreach ($users as $user): ?>
  <!-- Modal -->
  <div class="modal fade" id="editUserModal<?= $user['user_id'] ?>" tabindex="-1" aria-labelledby="editUserModalLabel<?= $user['user_id'] ?>" aria-hidden="true">
    <div class="modal-dialog">
      <form method="POST" action="<?= PATH ?>/users/update/<?= $user['user_id'] ?>">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editUserModalLabel<?= $user['user_id'] ?>">Editar Usuario: <?= htmlspecialchars($user['username']) ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="username<?= $user['user_id'] ?>" class="form-label">Nombre</label>
              <input type="text" name="username" class="form-control" id="username<?= $user['user_id'] ?>" value="<?= htmlspecialchars($user['username']) ?>" required>
            </div>
            <div class="mb-3">
              <label for="email<?= $user['user_id'] ?>" class="form-label">Correo electrónico</label>
              <input type="email" name="email" class="form-control" id="email<?= $user['user_id'] ?>" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <div class="mb-3">
              <label for="phone<?= $user['user_id'] ?>" class="form-label">Teléfono</label>
              <input type="text" name="phone" class="form-control" id="phone<?= $user['user_id'] ?>" value="<?= htmlspecialchars($user['phone']) ?>">
            </div>
            <div class="mb-3">
            <label for="id_role<?= $user['user_id'] ?>" class="form-label">Rol</label>
            <select name="id_role" class="form-select" id="role<?= $user['user_id'] ?>">
                <option value="1" <?= $user['role'] === '1' ? 'selected' : '' ?>>Admin</option>
                <option value="2" <?= $user['role'] === '2' ? 'selected' : '' ?>>Customer</option>
            </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
          </div>
        </div>
      </form>
    </div>
  </div>
<?php endforeach; ?>


<?php include './views/footer.php'; ?>
