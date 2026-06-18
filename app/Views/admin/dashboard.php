<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold">Resumen del Sistema</h2>
        <p class="text-muted">Bienvenido al panel de control. Aquí tienes un vistazo rápido de MyCar.</p>
    </div>
</div>

<div class="row g-4">
    <!-- Tarjeta Vehículos -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                    <i class="bi bi-car-front fs-2 text-primary"></i>
                </div>
                <div>
                    <h6 class="card-title text-muted mb-0">Vehículos</h6>
                    <h2 class="fw-bold mb-0">--</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjeta Clientes -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body d-flex align-items-center">
                <div class="bg-success bg-opacity-10 p-3 rounded-3 me-3">
                    <i class="bi bi-people fs-2 text-success"></i>
                </div>
                <div>
                    <h6 class="card-title text-muted mb-0">Clientes</h6>
                    <h2 class="fw-bold mb-0">--</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjeta Reservas -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body d-flex align-items-center">
                <div class="bg-warning bg-opacity-10 p-3 rounded-3 me-3">
                    <i class="bi bi-calendar-check fs-2 text-warning"></i>
                </div>
                <div>
                    <h6 class="card-title text-muted mb-0">Alquileres</h6>
                    <h2 class="fw-bold mb-0">--</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjeta Categorías -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body d-flex align-items-center">
                <div class="bg-info bg-opacity-10 p-3 rounded-3 me-3">
                    <i class="bi bi-tags fs-2 text-info"></i>
                </div>
                <div>
                    <h6 class="card-title text-muted mb-0">Categorías</h6>
                    <h2 class="fw-bold mb-0">--</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="fw-bold"><i class="bi bi-clock-history text-muted me-2"></i>Últimos Movimientos</h5>
            </div>
            <div class="card-body p-4 text-center text-muted">
                <p>Pronto aquí se verán los alquileres recientes de los clientes.</p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>