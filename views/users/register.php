<?php include './views/header.php'; ?>

<div class="row justify-content-center">
  <div class="col-md-6 col-lg-4">
    <div class="card shadow">
      <div class="card-body p-4">
        <h2 class="card-title text-center mb-4">
          <i class="fas fa-user-plus me-2"></i>Registro
        </h2>

        <?php if (!empty($error)): ?>
          <div class="alert alert-danger mb-3"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (!empty($validado)): ?>
          <div class="alert alert-success mb-3"><?= htmlspecialchars($validado) ?></div>
        <?php endif; ?>

        <form method="POST" action="<?= PATH . '/users/createUser' ?>">
          <div class="mb-3">
            <label for="username" class="form-label">Nombre de usuario:</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-user"></i></span>
              <input type="text" class="form-control" id="username" name="username" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-envelope"></i></span>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Contraseña:</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-lock"></i></span>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
          </div>

          <div class="mb-4">
            <label for="phone" class="form-label">Teléfono:</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-phone"></i></span>
              <input type="tel" class="form-control" id="phone" name="phone" required>
            </div>
          </div>

          <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg">
              <i class="fas fa-user-plus me-2"></i>Registrarse
            </button>
          </div>
        </form>

        <div class="mt-3 text-center">
          <a href="<?= PATH ?>/users/login" class="text-decoration-none">¿Ya tienes una cuenta? Inicia sesión</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include './views/footer.php'; ?>