<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Textil Export</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
      <div class="container">
        <h1 id="CompanyName" class="text-center my-3">Textil Export</h1>
        <ul class="navbar-nav ms-auto align-items-center gap-4">
          <li class="nav-item">
            <a class="nav-link text-white" href="<?= PATH ?>">Inicio</a>
          </li>
          <li class="nav-item">
            <?php if (isset($_SESSION['user']) && isset($_SESSION['role'])): ?>
              <!-- Usuario logueado con rol definido -->
              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class="fas fa-user me-1"></i><?= htmlspecialchars($_SESSION['user']) ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                  <li><span class="dropdown-item-text">
                      <i class="fas fa-user-tag me-1"></i>
                      <?= htmlspecialchars($_SESSION['role']) ?>
                    </span></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="<?= PATH ?>/users/profile">
                      <i class="fas fa-user-circle me-1"></i>Perfil
                    </a></li>
                  <li><a class="dropdown-item" href="<?= PATH ?>/users/logout">
                      <i class="fas fa-sign-out-alt me-1"></i>Cerrar sesión
                    </a></li>
                </ul>
              </div>
            <?php else: ?>
              <!-- Usuario no logueado o sin rol definido -->
              <a class="btn btn-outline-light" href="<?= PATH ?>/users/login">
                <i class="fas fa-sign-in-alt me-1"></i>Iniciar sesión
              </a>
            <?php endif; ?>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <main class="container my-4">