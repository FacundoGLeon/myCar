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
    <!-- Estilos Personalizados -->
    <link rel="stylesheet" href="<?= base_url('public/assets/css/main.css') ?>">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-custom shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= base_url() ?>">
                <i class="bi bi-car-front-fill me-2"></i>MyCar
            </a>
            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('sobre-nosotros') ?>"><i
                                class="bi bi-info-circle me-1"></i>Sobre Nosotros</a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <?php if (session()->get('isLoggedIn')): ?>

                        <?php if (session()->get('rol') == 'admin'): ?>
                            <li class="nav-item me-2">
                                <a class="nav-link text-warning fw-bold" href="<?= base_url('admin/dashboard') ?>">
                                    <i class="bi bi-speedometer2"></i> Panel Admin
                                </a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> Mi Cuenta
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li>
                                    <h6 class="dropdown-header text-muted"><?= session()->get('email') ?></h6>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                <?php if (session()->get('rol') == 'cliente'): ?>
                                    <li>
                                        <a class="dropdown-item fw-bold text-dark" href="<?= base_url('perfil') ?>">
                                            <i class="bi bi-person-gear me-2"></i>Mi Perfil
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item fw-bold text-primary" href="<?= base_url('mis-reservas') ?>">
                                            <i class="bi bi-card-list me-2"></i>Mis Reservas
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                <?php endif; ?>

                                <li>
                                    <a class="dropdown-item text-danger fw-bold" href="<?= base_url('logout') ?>">
                                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                                    </a>
                                </li>
                            </ul>
                        </li>

                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('login') ?>">Iniciar Sesión</a>
                        </li>
                        <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                            <a class="btn btn-outline-light btn-sm rounded-pill px-3 py-2"
                                href="<?= base_url('registro') ?>">Regístrate</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
        <?php if (session()->getFlashdata('mensaje')): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('mensaje') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </main>

    <!-- PIE DE PÁGINA (FOOTER CENTRADO PREMIUM) -->
    <footer class="main-footer mt-auto py-4">
        <div class="container text-center">
            <!-- Marca/Logo -->
            <div class="mb-2">
                <a href="<?= base_url() ?>" class="text-decoration-none d-inline-flex align-items-center">
                    <span class="fs-4 fw-bold text-white"><i
                            class="bi bi-car-front-fill me-2 text-danger"></i>MyCar</span>
                </a>
            </div>

            <!-- Eslogan corto -->
            <p class="small opacity-75 max-width-600 mx-auto mb-3">
                La plataforma líder en alquiler de vehículos deportivos y de lujo. Calidad, seguridad y pasión en cada
                kilómetro recorrido.
            </p>

            <!-- Enlaces Horizontales -->
            <div class="footer-nav mb-3">
                <a href="<?= base_url('catalogo') ?>" class="footer-nav-link">Catálogo de Flota</a>
                <span class="footer-nav-separator">•</span>
                <a href="<?= base_url('sobre-nosotros') ?>" class="footer-nav-link">Sobre Nosotros (TP2)</a>
                <span class="footer-nav-separator">•</span>
                <a href="#" class="footer-nav-link">Términos y Condiciones</a>
            </div>

            <!-- Derechos Reservados -->
            <div class="footer-bottom pt-3">
                <p class="small opacity-50 mb-0">&copy; <?= date('Y') ?> MyCar. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>