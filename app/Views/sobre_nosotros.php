<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Banner Principal -->
<div class="p-5 mb-5 rounded-4 shadow-sm text-center" style="background: linear-gradient(135deg, var(--primary-color), #4ca1af); color: white;">
    <h1 class="display-4 fw-bold mb-3"><i class="bi bi-info-circle-fill me-2"></i>Sobre el Proyecto</h1>
    <p class="lead mb-0">Conoce al equipo de desarrollo detrás de la plataforma <strong>MyCar</strong>.</p>
</div>

<div class="row justify-content-center mb-5">
    <!-- SECCIÓN: EL EQUIPO -->
    <div class="col-md-10 mb-5">
        <h3 class="fw-bold mb-4 text-center" style="color: var(--primary-color);">Equipo de Desarrollo</h3>
        <p class="text-center text-muted mb-4">Este sistema fue diseñado, programado y testeado en su totalidad por nuestro equipo para el Trabajo Práctico de la universidad.</p>

        <div class="row g-4 justify-content-center">
            
            <!-- Desarrolladora 1 -->
            <div class="col-md-5">
                <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-4" style="border-top: 5px solid var(--secondary-color) !important;">
                    <div class="mb-3 mt-2">
                        <!-- Icono de Avatar Femenino -->
                        <div class="bg-light rounded-circle d-inline-flex justify-content-center align-items-center" style="width: 80px; height: 80px;">
                            <i class="bi bi-person-hearts fs-1" style="color: var(--secondary-color);"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-1">María Pía Garcés Broncal</h4>
                    <span class="badge bg-dark rounded-pill mb-3 px-3 py-2">Desarrolladora Full-Stack</span>
                    <p class="text-muted small">Encargada de la arquitectura de la base de datos, maquetación de vistas, lógica de negocio y validaciones del sistema.</p>
                </div>
            </div>

            <!-- Desarrollador 2 -->
            <div class="col-md-5">
                <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-4" style="border-top: 5px solid var(--primary-color) !important;">
                    <div class="mb-3 mt-2">
                        <!-- Icono de Avatar Masculino -->
                        <div class="bg-light rounded-circle d-inline-flex justify-content-center align-items-center" style="width: 80px; height: 80px;">
                            <i class="bi bi-person-workspace fs-1" style="color: var(--primary-color);"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-1">Facundo Gabriel León</h4>
                    <span class="badge bg-dark rounded-pill mb-3 px-3 py-2">Desarrollador Full-Stack</span>
                    <p class="text-muted small">Responsable del desarrollo del backend, flujos de seguridad (autenticación), panel de administración y diseño UX/UI.</p>
                </div>
            </div>

        </div>
    </div>

    <!-- SECCIÓN: EL PROYECTO -->
    <div class="col-md-10">
        <div class="card border-0 shadow-sm rounded-4 bg-light p-4 p-md-5">
            <h3 class="fw-bold mb-4" style="color: var(--primary-color);"><i class="bi bi-laptop me-2"></i>Detalles del Trabajo Práctico</h3>
            
            <p class="text-muted mb-4" style="text-align: justify; line-height: 1.8;">
                <strong>MyCar</strong> es un Sistema de Gestión de Alquileres de Vehículos construido desde cero como requisito de aprobación universitaria. El objetivo principal fue desarrollar una aplicación web completa que integre de manera segura y eficiente la gestión de bases de datos relacionales, autenticación de usuarios y una interfaz amigable.
            </p>

            <h5 class="fw-bold mt-4 mb-3">Tecnologías Utilizadas:</h5>
            <div class="d-flex flex-wrap gap-2 mb-2">
                <span class="badge border border-secondary text-dark bg-white px-3 py-2"><i class="bi bi-fire text-danger me-1"></i> CodeIgniter 4 (PHP)</span>
                <span class="badge border border-secondary text-dark bg-white px-3 py-2"><i class="bi bi-database text-primary me-1"></i> MySQL</span>
                <span class="badge border border-secondary text-dark bg-white px-3 py-2"><i class="bi bi-bootstrap text-purple me-1"></i> Bootstrap 5</span>
                <span class="badge border border-secondary text-dark bg-white px-3 py-2"><i class="bi bi-calendar-check text-success me-1"></i> Flatpickr.js</span>
            </div>
            
            <hr class="my-4 text-muted">
            <div class="text-center">
                <a href="<?= base_url('catalogo') ?>" class="btn btn-mycar fw-bold px-4 rounded-pill">Volver al Catálogo</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>