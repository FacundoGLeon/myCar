<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Panel Admin - MyCar' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Iconos de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            --admin-bg: #f4f6f9;
            --sidebar-bg: #343a40;
            --sidebar-hover: #495057;
            --primary-color: #2c3e50;
            --secondary-color: #e74c3c;
            --bg-color: #f8f9fa;
        }
        body { background-color: var(--admin-bg); font-family: 'Segoe UI', Arial, sans-serif; }
        
        .sidebar {
            min-height: 100vh;
            background-color: var(--sidebar-bg);
            color: white;
            /* Asegura que el sidebar siempre cubra la altura de la pantalla */
            position: sticky;
            top: 0; 
        }
        .sidebar .nav-link {
            color: #c2c7d0;
            padding: 12px 20px;
            border-radius: 5px;
            margin-bottom: 5px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: var(--sidebar-hover);
            color: white;
        }

        /* --- FIX PARA STICKY FOOTER EN EL ADMIN --- */
        .wrapper {
            display: flex;
            min-height: 100vh;
        }
        .main-wrapper {
            display: flex;
            flex-direction: column;
            width: 100%;
        }
        .main-content {
            padding: 30px;
            flex-grow: 1; /* Esto empuja el footer hacia abajo */
        }

        .topbar {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
            padding: 15px 30px;
            margin-bottom: 30px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* FIX GLOBAL: Quitar sombras azules en inputs */
        .form-control:focus, .form-select:focus, .page-link:focus, .btn:focus {
            border-color: #343a40 !important;
            box-shadow: 0 0 0 0.25rem rgba(52, 58, 64, 0.25) !important;
        }
    </style>
</head>
<body>

    <div class="wrapper">
        <!-- MENÚ LATERAL (SIDEBAR) -->
        <nav class="sidebar flex-column p-3" style="width: 260px;">
            <a href="<?= base_url('admin/dashboard') ?>" class="text-white text-decoration-none d-flex align-items-center mb-4 mt-2 ps-2">
                <i class="bi bi-car-front-fill fs-3 me-2 text-warning"></i>
                <span class="fs-4 fw-bold">MyCar <span class="text-warning">Admin</span></span>
            </a>
            
            <hr class="text-secondary">
            
            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <a href="<?= base_url('admin/dashboard') ?>" class="nav-link <?= current_url(true)->getSegment(2) == 'dashboard' ? 'active' : '' ?>">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mt-3 mb-1 text-warning small text-uppercase fw-bold ps-3">Gestión de Flota</li>
                
                <li class="nav-item">
                    <a href="<?= base_url('admin/categorias') ?>" class="nav-link <?= current_url(true)->getSegment(2) == 'categorias' ? 'active' : '' ?>">
                        <i class="bi bi-tags me-2"></i> Categorías
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="<?= base_url('admin/vehiculos') ?>" class="nav-link <?= current_url(true)->getSegment(2) == 'vehiculos' ? 'active' : '' ?>">
                        <i class="bi bi-car-front me-2"></i> Vehículos
                    </a>
                </li>
                <li class="nav-item mt-3 mb-1 text-warning small text-uppercase fw-bold ps-3">Gestión Comercial</li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/clientes') ?>" class="nav-link <?= current_url(true)->getSegment(2) == 'clientes' ? 'active' : '' ?>">
                        <i class="bi bi-people me-2"></i> Clientes
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/alquileres') ?>" class="nav-link <?= current_url(true)->getSegment(2) == 'alquileres' ? 'active' : '' ?>">
                        <i class="bi bi-calendar-check me-2"></i> Alquileres
                    </a>
                </li>

                <!-- REPORTES -->
                <li class="nav-item mt-3 mb-1 text-warning small text-uppercase fw-bold ps-3">Reportes</li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/reportes/vehiculo') ?>" class="nav-link <?= current_url(true)->getSegment(3) == 'vehiculo' ? 'active' : '' ?>">
                        <i class="bi bi-file-earmark-text me-2"></i> Reporte Vehículo
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/reportes/cliente') ?>" class="nav-link <?= current_url(true)->getSegment(3) == 'cliente' ? 'active' : '' ?>">
                        <i class="bi bi-file-earmark-person me-2"></i> Reporte Cliente
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/reportes/actuales') ?>" class="nav-link <?= current_url(true)->getSegment(3) == 'actuales' ? 'active' : '' ?>">
                        <i class="bi bi-car-front-fill me-2"></i> Autos en Calle
                    </a>
                </li>
            </ul>
            
            <hr class="text-secondary mt-auto">
            <div class="dropdown">
                <a href="<?= base_url('/') ?>" class="nav-link text-white">
                    <i class="bi bi-arrow-left-circle me-2"></i> Ir al Catálogo
                </a>
                <a href="<?= base_url('logout') ?>" class="nav-link text-danger mt-2">
                    <i class="bi bi-box-arrow-left me-2"></i> Cerrar Sesión
                </a>
            </div>
        </nav>

        <!-- ENVOLTORIO DE COLUMNA PARA QUE EL FOOTER BAJE -->
        <div class="main-wrapper">
            <!-- CONTENIDO PRINCIPAL -->
            <main class="main-content">
                
                <!-- Barra Superior (Topbar) -->
                <div class="topbar">
                    <h4 class="m-0 text-muted">Panel de Administración</h4>
                    <div class="text-end">
                        <span class="fw-bold"><i class="bi bi-person-circle"></i> <?= session()->get('email') ?></span>
                        <span class="badge bg-warning text-dark ms-2">Admin</span>
                    </div>
                </div>

                <!-- Zona de Mensajes Flash -->
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

                <!-- Aquí se inyectan las vistas de cada sección -->
                <?= $this->renderSection('content') ?>

            </main>

            <!-- PIE DE PÁGINA EJECUTIVO (ADMIN) -->
            <footer class="bg-white border-top py-3 px-4 mt-auto">
                <div class="d-flex justify-content-between align-items-center small">
                    <div class="text-muted fw-bold">
                        &copy; <?= date('Y') ?> MyCar Admin
                    </div>
                    <div class="text-muted">
                        Versión 1.0.0 &middot; Sistema de Gestión de Alquileres
                    </div>
                </div>
            </footer>
        </div> <!-- Fin main-wrapper -->
    </div> <!-- Fin wrapper -->

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>