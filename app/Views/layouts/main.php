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
        
        /* Utilidad para forzar el Sticky Footer */
        body { 
            background-color: var(--bg-color); 
            font-family: 'Segoe UI', Arial, sans-serif; 
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* El main debe crecer para empujar el footer hacia abajo */
        main {
            flex-grow: 1;
        }

        .navbar-custom { background-color: var(--primary-color); }
        .navbar-custom .navbar-brand, .navbar-custom .nav-link { color: #ffffff; }
        .navbar-custom .nav-link:hover { color: var(--secondary-color); }
        .card-vehiculo { border: none; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.2s; }
        .card-vehiculo:hover { transform: translateY(-5px); }
        .btn-mycar { background-color: var(--secondary-color); color: white; border: none; }
        .btn-mycar:hover { background-color: #c0392b; color: white; }

        /* FIX: Quitar sombras azules en inputs */
        .form-control:focus, .form-select:focus, .page-link:focus, .btn:focus {
            border-color: #343a40 !important;
            box-shadow: 0 0 0 0.25rem rgba(52, 58, 64, 0.25) !important;
        }

        /* Estilos personalizados para el menú desplegable */
        .dropdown-item:hover, .dropdown-item:focus {
            background-color: rgba(44, 62, 80, 0.1) !important; 
            color: var(--primary-color) !important;
        }
        .dropdown-item.active, .dropdown-item:active {
            background-color: var(--primary-color) !important; 
            color: #ffffff !important;
        }

        /* Enlaces del Footer */
        .hover-link {
            transition: color 0.3s ease;
        }
        .hover-link:hover { 
            color: var(--secondary-color) !important; 
        }
    </style>
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
                        <a class="nav-link" href="<?= base_url('sobre-nosotros') ?>"><i class="bi bi-info-circle me-1"></i>Sobre Nosotros</a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <?php if(session()->get('isLoggedIn')): ?>
                        
                        <?php if(session()->get('rol') == 'admin'): ?>
                            <li class="nav-item me-2">
                                <a class="nav-link text-warning fw-bold" href="<?= base_url('admin/dashboard') ?>">
                                    <i class="bi bi-speedometer2"></i> Panel Admin
                                </a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> Mi Cuenta
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li><h6 class="dropdown-header text-muted"><?= session()->get('email') ?></h6></li>
                                <li><hr class="dropdown-divider"></li>
                                
                                <?php if(session()->get('rol') == 'cliente'): ?>
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
                                    <li><hr class="dropdown-divider"></li>
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
                            <a class="btn btn-outline-light btn-sm rounded-pill px-3 py-2" href="<?= base_url('registro') ?>">Regístrate</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
        <?php if(session()->getFlashdata('mensaje')): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('mensaje') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </main>

    <!-- PIE DE PÁGINA (FOOTER COMERCIAL) -->
    <footer class="mt-auto py-5 border-top" style="background-color: var(--primary-color); color: #bdc3c7;">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5 class="text-white fw-bold mb-3"><i class="bi bi-car-front-fill me-2 text-white"></i>MyCar</h5>
                    <p class="small text-white-50">La plataforma líder en alquiler de vehículos deportivos y de lujo. Calidad, seguridad y pasión en cada kilómetro recorrido.</p>
                </div>
                <div class="col-md-4 mb-3 text-md-center">
                    <h6 class="text-white fw-bold mb-3">Enlaces Útiles</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?= base_url('catalogo') ?>" class="text-decoration-none text-white-50 hover-link">Catálogo de Flota</a></li>
                        <li class="mb-2"><a href="<?= base_url('sobre-nosotros') ?>" class="text-decoration-none text-white-50 hover-link"><i class="bi bi-info-circle me-1"></i> Sobre Nosotros (TP2)</a></li>
                        <li><a href="#" class="text-decoration-none text-white-50 hover-link">Términos y Condiciones</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3 text-md-end">
                    <h6 class="text-white fw-bold mb-3">Síguenos</h6>
                    <div class="d-flex justify-content-md-end gap-3 fs-5">
                        <a href="#" class="text-white-50 hover-link"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white-50 hover-link"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white-50 hover-link"><i class="bi bi-twitter-x"></i></a>
                    </div>
                </div>
            </div>
            <div class="text-center pt-4 mt-4 border-top" style="border-color: rgba(255,255,255,0.1) !important;">
                <p class="small text-white-50 mb-0">&copy; <?= date('Y') ?> MyCar. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>