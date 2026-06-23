<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    /* Efectos y animaciones personalizadas */
    .hero-gradient {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        position: relative;
        overflow: hidden;
    }

    .hero-gradient::before {
        content: "";
        position: absolute;
        top: -50%;
        left: -30%;
        width: 160%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 60%);
        pointer-events: none;
    }

    .animate-car {
        display: inline-block;
        animation: floatCar 3s ease-in-out infinite;
    }

    @keyframes floatCar {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-8px);
        }
    }

    .feature-card {
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .feature-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.08) !important;
        border-color: rgba(42, 82, 152, 0.2);
    }

    .team-card {
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .team-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 18px rgba(0, 0, 0, 0.06) !important;
    }

    .icon-box {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        font-size: 1.5rem;
    }

    .team-badge {
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .logo-emblem {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 50%;
        width: 100px;
        height: 100px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
    }

    .academic-header {
        border-left: 4px solid var(--primary-color);
        padding-left: 1rem;
    }
</style>

<!-- Banner Principal con Identidad / Logo -->
<div class="p-5 mb-5 rounded-4 shadow-sm hero-gradient text-center text-md-start">
    <div class="row align-items-center g-4">
        <div class="col-md-3 text-center">
            <div class="logo-emblem mb-2 mb-md-0">
                <i class="bi bi-car-front-fill text-white fs-1 animate-car"></i>
            </div>
            <div class="mt-2 text-white fw-bold tracking-wider fs-4">MyCar</div>
        </div>
        <div class="col-md-9">
            <span class="badge bg-danger rounded-pill px-3 py-2 text-uppercase mb-2 team-badge">Trabajo Práctico N.º
                2</span>
            <h1 class="display-5 fw-bold mb-3">Sobre Nosotros</h1>
            <p class="lead mb-0 opacity-90">Conoce el contexto institucional, académico y las capacidades operativas de
                la plataforma <strong>MyCar</strong>.</p>
        </div>
    </div>
</div>

<!-- SECCIÓN: EL EQUIPO DE DESARROLLO (De la versión antigua, estilizado) -->
<div class="row justify-content-center mb-5">
    <div class="col-md-11">
        <h3 class="fw-bold mb-4 text-center text-dark">Equipo de Desarrollo</h3>
        <p class="text-center text-muted mb-5">Este sistema fue diseñado, programado y testeado en su totalidad por
            nuestro equipo para el Trabajo Práctico de la universidad.</p>

        <div class="row g-4 justify-content-center">
            <!-- Desarrolladora 1 -->
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-4 team-card"
                    style="border-top: 5px solid var(--secondary-color) !important;">
                    <div class="mb-3 mt-2">
                        <img src="<?= base_url('public/assets/img/sobreNosotros/Maru.jpeg') ?>" class="rounded-circle shadow-sm"
                            style="width: 130px; height: 130px; object-fit: cover;" alt="María Pía Garcés Broncal">
                    </div>

                    <h4 class="fw-bold mb-1">María Pía Garcés Broncal</h4>
                    <span class="badge bg-dark rounded-pill mb-3 px-3 py-2">Desarrolladora Full-Stack</span>
                    <p class="text-muted small mb-0">Encargada de la arquitectura de la base de datos, maquetación de
                        vistas, lógica de negocio y validaciones del sistema.</p>
                </div>
            </div>

            <!-- Desarrollador 2 -->
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-4 team-card"
                    style="border-top: 5px solid var(--primary-color) !important;">
                    <div class="mb-3 mt-2">
                        <img src="<?= base_url('public/assets/img/sobreNosotros/Facu.jpeg') ?>" class="rounded-circle shadow-sm"
                        style="width: 130px; height: 130px; object-fit: cover;" alt="Facundo Gabriel León">
                    </div>
                    <h4 class="fw-bold mb-1">Facundo Gabriel León</h4>
                    <span class="badge bg-dark rounded-pill mb-3 px-3 py-2">Desarrollador Full-Stack</span>
                    <p class="text-muted small mb-0">Responsable del desarrollo del backend, flujos de seguridad
                        (autenticación), panel de administración y diseño UX/UI.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 justify-content-center mb-5">

    <!-- SECCIÓN: INFORMACIÓN ACADÉMICA -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-4 p-md-5">
            <div class="d-flex align-items-center mb-4">
                <div class="icon-box bg-primary-subtle text-primary mb-0 me-3">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <h3 class="fw-bold mb-0 text-dark">Información Académica</h3>
            </div>

            <div class="academic-header mb-4">
                <h5 class="text-muted fw-semibold mb-1">Materia</h5>
                <p class="text-dark fw-bold mb-0 fs-5">Tópicos Avanzados de Programación Web</p>
                <small class="text-muted">Carrera: Tecnicatura Universitaria en Web (TUW) – UNSL</small>
            </div>

            <div class="academic-header">
                <h5 class="text-muted fw-semibold mb-1">Supervisión</h5>
                <p class="text-dark fw-bold mb-0">Prof. Mario Peralta</p>
                <small class="text-muted">Docente a cargo de la cátedra</small>
            </div>
        </div>
    </div>

    <!-- SECCIÓN: DETALLES DEL TRABAJO PRÁCTICO (Mejorado simétricamente con fondo claro) -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-4 p-md-5 bg-white">
            <div class="d-flex align-items-center mb-4">
                <div class="icon-box bg-danger-subtle text-danger mb-0 me-3">
                    <i class="bi bi-laptop"></i>
                </div>
                <h3 class="fw-bold mb-0 text-dark">Detalles del Trabajo Práctico</h3>
            </div>

            <p class="mb-4 text-muted" style="text-align: justify; line-height: 1.8;">
                <strong>MyCar</strong> es un Sistema de Gestión de Alquileres de Vehículos construido desde cero como
                requisito de aprobación universitaria. El objetivo principal fue desarrollar una aplicación web completa
                que integre de manera segura y eficiente la gestión de bases de datos relacionales, autenticación de
                usuarios y una interfaz amigable.
            </p>

            <h5 class="fw-bold mb-3 text-dark mt-4"><i class="bi bi-cpu text-danger me-2"></i>Tecnologías Utilizadas:
            </h5>
            <div class="d-flex flex-wrap gap-2">
                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2"><i
                        class="bi bi-fire me-1"></i> CodeIgniter 4 (PHP)</span>
                <span class="badge bg-info-subtle text-info border border-info-subtle px-3 py-2"><i
                        class="bi bi-database me-1"></i> MySQL</span>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2"><i
                        class="bi bi-bootstrap me-1"></i> Bootstrap 5</span>
                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2"><i
                        class="bi bi-calendar-check me-1"></i> Flatpickr.js</span>
                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-2"><i
                        class="bi bi-bell-fill me-1"></i> SweetAlert2</span>
            </div>
        </div>
    </div>
</div>

<!-- SECCIÓN: FUNCIONALIDADES (La app permite) -->
<div class="mb-5">
    <div class="text-center mb-4">
        <h3 class="fw-bold" style="color: var(--primary-color);">¿Qué permite realizar la aplicación?</h3>
        <p class="text-muted">Descubre las funciones principales implementadas tanto para clientes como para el personal
            administrativo.</p>
    </div>

    <div class="row g-4">
        <!-- Feature 1: Catálogo y Búsqueda -->
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 feature-card">
                <div class="icon-box bg-success-subtle text-success">
                    <i class="bi bi-search"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">Búsqueda y Filtrado</h5>
                <p class="text-muted small mb-0">Búsqueda rápida por marca o modelo, y filtrado dinámico mediante
                    categorías interactivas en la flota disponible.</p>
            </div>
        </div>

        <!-- Feature 2: Realizar Reserva -->
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 feature-card">
                <div class="icon-box bg-danger-subtle text-danger">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">Realizar Reservas</h5>
                <p class="text-muted small mb-0">Selección de vehículos, ingreso de fechas de retiro y devolución, y
                    cálculo automático del costo total del alquiler.</p>
            </div>
        </div>

        <!-- Feature 3: Gestión de Perfil -->
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 feature-card">
                <div class="icon-box bg-info-subtle text-info">
                    <i class="bi bi-person-gear"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">Perfil de Cliente</h5>
                <p class="text-muted small mb-0">Actualización en tiempo real de datos esenciales del cliente, tales
                    como número de teléfono, domicilio, DNI y licencia de conducir.</p>
            </div>
        </div>

        <!-- Feature 4: Historial de Reservas -->
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 feature-card">
                <div class="icon-box bg-warning-subtle text-warning">
                    <i class="bi bi-card-list"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">Seguimiento de Reservas</h5>
                <p class="text-muted small mb-0">Historial completo para los clientes, permitiendo revisar en vivo si
                    sus solicitudes están Pendientes, Aprobadas o Rechazadas.</p>
            </div>
        </div>

        <!-- Feature 5: Panel de Administración -->
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 feature-card">
                <div class="icon-box bg-primary-subtle text-primary">
                    <i class="bi bi-speedometer2"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">Panel del Administrador</h5>
                <p class="text-muted small mb-0">Dashboard con indicadores rápidos, gestión completa (CRUD) de
                    vehículos, categorías y clientes, y control de alquileres.</p>
            </div>
        </div>

        <!-- Feature 6: Reportes del Negocio -->
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 feature-card">
                <div class="icon-box bg-dark bg-opacity-10 text-dark">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">Estadísticas y Reportes</h5>
                <p class="text-muted small mb-0">Visualización de reportes avanzados que segmentan alquileres por
                    vehículo, por cliente o listados de alquileres en curso.</p>
            </div>
        </div>
    </div>
</div>

<hr class="my-5 opacity-25">

<!-- Botones de Acción al Final -->
<div class="text-center mb-5">
    <a href="<?= base_url() ?>" class="btn btn-mycar btn-lg fw-bold px-5 rounded-pill shadow-sm">
        <i class="bi bi-car-front-fill me-2"></i>Explorar Catálogo de Vehículos
    </a>
</div>

<?= $this->endSection() ?>