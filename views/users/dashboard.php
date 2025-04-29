<?php include './views/header.php'; 

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: ' . PATH . '/products');
    exit;
}

echo password_hash('choconance', PASSWORD_BCRYPT).'<br>';
echo password_hash('chocokrispi', PASSWORD_BCRYPT).'<br>';

?>

<div class="container mt-4">
    <h1>Bienvenido, <?= $_SESSION['user'] ?></h1>

    <div class="row">
        <!-- Estadísticas -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Usuarios Totales</h5>
                    <p class="card-text"><?= $totalUsers ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Ventas Totales</h5>
                    <p class="card-text"><?= $totalSales ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Ingresos Totales</h5>
                    <p class="card-text">$<?= number_format($totalRevenue, 2) ?></p>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <!-- Enlaces a secciones -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <a href="<?= PATH ?>/users/list" class="btn btn-primary w-100">
                Ver Usuarios
            </a>
        </div>

        <div class="col-md-6 mb-4">
            <a href="<?= PATH ?>/sales" class="btn btn-primary w-100">
                Ver Ventas
            </a>
        </div>
    </div>

    <hr>

    <!-- Ventas recientes -->
    <h3>Ventas Recientes</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recentSales as $sale): ?>
            <tr>
                <td><?= $sale['sale_id'] ?></td>
                <td><?= $sale['date'] ?></td>
                <td>$<?= number_format($sale['total'], 2) ?></td>
                <td><?= $sale['state'] === 1 ? 'Completada' : 'Pendiente' ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include './views/footer.php'; ?>
