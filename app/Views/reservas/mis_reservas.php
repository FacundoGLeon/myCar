<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php $reservas = $reservas ?? []; ?>

<div class="row mb-4 mt-4">
    <div class="col-md-8">
        <h2 class="fw-bold" style="color: var(--primary-color);">
            <i class="bi bi-card-list me-2"></i>Mis Reservas
        </h2>
        <p class="text-muted">Aquí puedes hacer seguimiento del estado de todas tus solicitudes y alquileres pasados.</p>
    </div>
    <div class="col-md-4 text-md-end">
        <a href="<?= base_url('catalogo') ?>" class="btn btn-outline-secondary rounded-pill">
            <i class="bi bi-plus-circle me-1"></i> Nueva Reserva
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <?php if (empty($reservas)): ?>
            <div class="alert alert-light text-center p-5 border-0 shadow-sm rounded-4">
                <i class="bi bi-calendar-x fs-1 text-muted d-block mb-3"></i>
                <h4 class="fw-bold text-muted">Aún no tienes reservas</h4>
                <p class="text-muted">Explora nuestro catálogo y elige el auto de tus sueños.</p>
                <a href="<?= base_url('catalogo') ?>" class="btn btn-mycar px-4 rounded-pill">Ver Catálogo</a>
            </div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-lg-2 g-4">
                <?php foreach ($reservas as $r): 
                    // Configuramos colores según el estado
                    $borde = 'border-secondary';
                    $textoEstado = 'text-secondary';
                    $icono = 'bi-clock';
                    
                    if ($r['estado'] == 'Pendiente') {
                        $borde = 'border-warning';
                        $textoEstado = 'text-warning bg-warning bg-opacity-10';
                        $icono = 'bi-hourglass-split';
                    } elseif ($r['estado'] == 'Alquilado') {
                        $borde = 'border-primary';
                        $textoEstado = 'text-primary bg-primary bg-opacity-10';
                        $icono = 'bi-check2-circle';
                    } elseif ($r['estado'] == 'Devuelto') {
                        $borde = 'border-success';
                        $textoEstado = 'text-success bg-success bg-opacity-10';
                        $icono = 'bi-car-front-fill';
                    } elseif ($r['estado'] == 'Cancelado') {
                        $borde = 'border-danger';
                        $textoEstado = 'text-danger bg-danger bg-opacity-10';
                        $icono = 'bi-x-circle';
                    }
                ?>
                    <div class="col">
                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden border-start border-5 <?= $borde ?>">
                            <div class="row g-0 h-100">
                                <!-- Imagen del Auto -->
                                <div class="col-4">
                                    <img src="<?= base_url('public/assets/img/' . $r['imagen_url']) ?>" 
                                         class="img-fluid h-100 w-100" 
                                         style="object-fit: cover;" 
                                         alt="Auto">
                                </div>
                                <!-- Detalles -->
                                <div class="col-8">
                                    <div class="card-body d-flex flex-column h-100">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h5 class="fw-bold mb-0" style="color: var(--primary-color);">
                                                <?= $r['marca'] ?> <?= $r['modelo'] ?>
                                            </h5>
                                            <span class="badge rounded-pill px-3 py-2 <?= $textoEstado ?>">
                                                <i class="bi <?= $icono ?> me-1"></i> <?= $r['estado'] ?>
                                            </span>
                                        </div>
                                        
                                        <p class="text-muted small mb-3">
                                            <i class="bi bi-calendar-event me-1"></i> 
                                            <?= date('d/m/Y', strtotime($r['fecha_desde'])) ?> al <?= date('d/m/Y', strtotime($r['fecha_hasta'])) ?> 
                                            (<?= $r['dias'] ?> días)
                                        </p>
                                        
                                        <div class="mt-auto d-flex justify-content-between align-items-center bg-light p-2 rounded-3">
                                            <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Monto Total</small>
                                            <h5 class="fw-bold text-success mb-0">$<?= number_format($r['monto_total'], 2, ',', '.') ?></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- PAGINACIÓN DINÁMICA -->
            <?php if (!empty($pager)): ?>
                <div class="d-flex justify-content-center mt-5 mb-3">
                    <?= $pager->links('default', 'default_full') ?>
                </div>
            <?php endif; ?>

        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>