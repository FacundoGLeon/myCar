<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'MyCar - Alquiler de Vehículos' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Iconos de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #e74c3c;
            --bg-color: #f8f9fa;
        }
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Arial, sans-serif; }
        .navbar-custom { background-color: #2c3e50; }
        .navbar-custom .navbar-brand, .navbar-custom .nav-link { color: #ffffff; }
        .navbar-custom .nav-link:hover { color: #e74c3c; }
        .card-vehiculo { border: none; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.2s; }
        .card-vehiculo:hover { transform: translateY(-5px); }
        .btn-mycar { background-color: #e74c3c; color: white; border: none; }
        .btn-mycar:hover { background-color: #c0392b; color: white; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-custom shadow-sm mb-4">
        <div class="container">
            <!-- El Logo hace de botón de Inicio -->
            <a class="navbar-brand fw-bold" href="<?= base_url() ?>">
                <i class="bi bi-car-front-fill me-2"></i>MyCar
            </a>
            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <!-- Dejamos solo Catálogo -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('catalogo') ?>"><i class="bi bi-grid me-1"></i>Catálogo</a>
                    </li>
                </ul>
                
                <!-- LÓGICA DINÁMICA DEL MENÚ DE USUARIO -->
                <ul class="navbar-nav">
                    <?php if(session()->get('isLoggedIn')): ?>
                        
                        <!-- Si es Administrador -->
                        <?php if(session()->get('rol') == 'admin'): ?>
                            <li class="nav-item me-2">
                                <a class="nav-link text-warning fw-bold" href="<?= base_url('admin/dashboard') ?>">
                                    <i class="bi bi-speedometer2"></i> Panel Admin
                                </a>
                            </li>
                        <?php endif; ?>

                        <!-- Menú Desplegable del Usuario -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> Mi Cuenta
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li><h6 class="dropdown-header text-muted"><?= session()->get('email') ?></h6></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger fw-bold" href="<?= base_url('logout') ?>">
                                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                                    </a>
                                </li>
                            </ul>
                        </li>

                    <?php else: ?>
                        <!-- Si NO está logueado -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('login') ?>">Iniciar Sesión</a>
                        </li>
                        <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                            <a class="btn btn-outline-light btn-sm rounded-pill px-3 py-2" href="<?= base_url('registro') ?>">Regístrate</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
        <?php if(session()->getFlashdata('mensaje')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('mensaje') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </main>

    <footer class="text-center py-4 mt-5 text-muted">
        <div class="container border-top pt-3">
            <small>&copy; <?= date('Y') ?> MyCar - TP2 CodeIgniter. Todos los derechos reservados.</small>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>