<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<?php
// Evitamos alertas del IDE
$totalVehiculos = $totalVehiculos ?? 0;
$totalClientes = $totalClientes ?? 0;
$totalAlquileres = $totalAlquileres ?? 0;
$totalCategorias = $totalCategorias ?? 0;
$ultimosMovimientos = $ultimosMovimientos ?? [];
?>

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
                    <h2 class="fw-bold mb-0"><?= $totalVehiculos ?></h2>
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
                    <h2 class="fw-bold mb-0"><?= $totalClientes ?></h2>
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
                    <h2 class="fw-bold mb-0"><?= $totalAlquileres ?></h2>
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
                    <h2 class="fw-bold mb-0"><?= $totalCategorias ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-12"> <!-- Lo expandí a 12 columnas para que la tabla se vea mejor -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="fw-bold"><i class="bi bi-clock-history text-muted me-2"></i>Últimos Movimientos (Top 5)</h5>
            </div>
            <div class="card-body p-0 mt-3">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Fecha Reg.</th>
                                <th>Cliente</th>
                                <th>Vehículo Reservado</th>
                                <th>Total</th>
                                <th class="pe-4">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($ultimosMovimientos)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Aún no hay alquileres registrados en el sistema.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($ultimosMovimientos as $mov): ?>
                                    <?php
                                        // Asignar color al badge según el estado
                                        $badge = 'bg-secondary';
                                        if ($mov['estado'] == 'Pendiente') $badge = 'bg-warning text-dark';
                                        if ($mov['estado'] == 'Alquilado') $badge = 'bg-primary';
                                        if ($mov['estado'] == 'Devuelto')  $badge = 'bg-success';
                                        if ($mov['estado'] == 'Cancelado') $badge = 'bg-danger';
                                    ?>
                                    <tr>
                                        <td class="ps-4 text-muted small"><?= date('d/m/Y H:i', strtotime($mov['created_at'])) ?></td>
                                        <td class="fw-bold"><?= $mov['nombre'] ?> <?= $mov['apellido'] ?></td>
                                        <td class="text-primary"><?= $mov['marca'] ?> <?= $mov['modelo'] ?></td>
                                        <td class="fw-bold text-success">$<?= number_format($mov['monto_total'], 2, ',', '.') ?></td>
                                        <td class="pe-4"><span class="badge <?= $badge ?>"><?= $mov['estado'] ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>