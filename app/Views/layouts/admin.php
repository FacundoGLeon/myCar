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

    <!-- Estilos Personalizados Admin -->
    <link rel="stylesheet" href="<?= base_url('public/assets/css/admin.css') ?>">
</head>

<body>

    <div class="wrapper">
        <!-- MENÚ LATERAL (SIDEBAR) -->
        <nav class="sidebar flex-column p-3" style="width: 260px;">
            <a href="<?= base_url('admin/dashboard') ?>"
                class="text-white text-decoration-none d-flex align-items-center mb-4 mt-2 ps-2">
                <i class="bi bi-car-front-fill fs-3 me-2 text-warning"></i>
                <span class="fs-4 fw-bold">MyCar <span class="text-warning">Admin</span></span>
            </a>

            <hr class="text-secondary">

            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <a href="<?= base_url('admin/dashboard') ?>"
                        class="nav-link <?= current_url(true)->getSegment(2) == 'dashboard' ? 'active' : '' ?>">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mt-3 mb-1 text-warning small text-uppercase fw-bold ps-3">Gestión de Flota</li>

                <li class="nav-item">
                    <a href="<?= base_url('admin/categorias') ?>"
                        class="nav-link <?= current_url(true)->getSegment(2) == 'categorias' ? 'active' : '' ?>">
                        <i class="bi bi-tags me-2"></i> Categorías
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('admin/vehiculos') ?>"
                        class="nav-link <?= current_url(true)->getSegment(2) == 'vehiculos' ? 'active' : '' ?>">
                        <i class="bi bi-car-front me-2"></i> Vehículos
                    </a>
                </li>
                <li class="nav-item mt-3 mb-1 text-warning small text-uppercase fw-bold ps-3">Gestión Comercial</li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/clientes') ?>"
                        class="nav-link <?= current_url(true)->getSegment(2) == 'clientes' ? 'active' : '' ?>">
                        <i class="bi bi-people me-2"></i> Clientes
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/alquileres') ?>"
                        class="nav-link <?= current_url(true)->getSegment(2) == 'alquileres' ? 'active' : '' ?>">
                        <i class="bi bi-calendar-check me-2"></i> Alquileres
                    </a>
                </li>

                <!-- REPORTES -->
                <li class="nav-item mt-3 mb-1 text-warning small text-uppercase fw-bold ps-3">Reportes</li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/reportes/vehiculo') ?>"
                        class="nav-link <?= current_url(true)->getSegment(3) == 'vehiculo' ? 'active' : '' ?>">
                        <i class="bi bi-file-earmark-text me-2"></i> Reporte Vehículo
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/reportes/cliente') ?>"
                        class="nav-link <?= current_url(true)->getSegment(3) == 'cliente' ? 'active' : '' ?>">
                        <i class="bi bi-file-earmark-person me-2"></i> Reporte Cliente
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/reportes/actuales') ?>"
                        class="nav-link <?= current_url(true)->getSegment(3) == 'actuales' ? 'active' : '' ?>">
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
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.body.addEventListener('click', function (e) {
                const btn = e.target.closest('.confirm-action');
                if (btn) {
                    e.preventDefault();
                    const mensaje = btn.getAttribute('data-confirm') || '¿Estás seguro de realizar esta acción?';

                    Swal.fire({
                        title: '¿Confirmar Acción?',
                        text: mensaje,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#2c3e50',
                        cancelButtonColor: '#e74c3c',
                        confirmButtonText: 'Sí, confirmar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = btn.closest('form');
                            if (form && btn.type === 'submit') {
                                if (btn.name) {
                                    const hiddenInput = document.createElement('input');
                                    hiddenInput.type = 'hidden';
                                    hiddenInput.name = btn.name;
                                    hiddenInput.value = btn.value || '1';
                                    form.appendChild(hiddenInput);
                                }
                                form.submit();
                            } else if (btn.tagName === 'A') {
                                window.location.href = btn.href;
                            }
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>