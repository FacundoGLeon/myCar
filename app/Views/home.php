<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php 
// Solución para evitar falsas advertencias de Intelephense en VS Code
$categoriaSeleccionada = $categoriaSeleccionada ?? null; 
$categorias = $categorias ?? [];
$catalogo = $catalogo ?? [];
?>

<!-- Banner de Bienvenida -->
<div class="p-5 mb-4 bg-light rounded-3 shadow-sm border" style="background: linear-gradient(to right, #2c3e50, #4ca1af); color: white;">
    <div class="container-fluid py-3">
        <h1 class="display-5 fw-bold"><i class="bi bi-car-front-fill"></i> Bienvenido a MyCar</h1>
        <p class="col-md-8 fs-4">La mejor flota de vehículos deportivos y de lujo listos para tu próxima aventura.</p>
        <?php if(!session()->get('isLoggedIn')): ?>
            <a href="<?= base_url('registro') ?>" class="btn btn-mycar btn-lg fw-bold">Regístrate para Alquilar</a>
        <?php endif; ?>
    </div>
</div>

<!-- Barra de Filtros (NUEVO) -->
<div class="mb-4 text-center">
    <div class="btn-group flex-wrap gap-2" role="group" aria-label="Filtros de Categoría">
        <!-- Botón para ver "Todos" -->
        <a href="<?= base_url() ?>" class="btn <?= empty($categoriaSeleccionada) ? 'btn-primary' : 'btn-outline-primary' ?> rounded-pill px-4 fw-bold shadow-sm">
            Todas las Marcas
        </a>
        
        <!-- Botones dinámicos por cada categoría -->
        <?php foreach ($categorias as $cat): ?>
            <a href="<?= base_url('?categoria=' . $cat['id']) ?>" 
               class="btn <?= ($categoriaSeleccionada == $cat['id']) ? 'btn-primary' : 'btn-outline-primary' ?> rounded-pill px-4 fw-bold shadow-sm">
                <?= $cat['nombre'] ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- Catálogo de Vehículos Agrupados por Categoría -->
<h2 class="mb-4 text-muted border-bottom pb-2">Nuestra Flota Disponible</h2>

<?php foreach ($catalogo as $categoria): ?>
    <!-- Solo mostramos la categoría si tiene vehículos -->
    <?php if (count($categoria['vehiculos']) > 0): ?>
        <h4 class="mt-5 mb-3 fw-bold text-uppercase" style="color: var(--primary-color);">
            <?= $categoria['nombre'] ?>
        </h4>
        
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($categoria['vehiculos'] as $v): ?>
                <div class="col">
                    <div class="card card-vehiculo h-100">
                        <!-- Imagen del vehículo. Si no encuentra la imagen física, muestra un placeholder -->
                        <img src="<?= base_url('public/assets/img/' . $v['imagen_url']) ?>" 
                             class="card-img-top" 
                             alt="<?= $v['marca'] . ' ' . $v['modelo'] ?>" 
                             style="height: 200px; object-fit: cover;"
                             onerror="this.src='https://via.placeholder.com/400x250?text=Foto+No+Disponible'">
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold"><?= $v['marca'] ?> <?= $v['modelo'] ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Año <?= $v['anio'] ?> • <?= $v['plazas'] ?> Plazas</h6>
                            <p class="card-text small text-muted flex-grow-1">
                                <?= substr($v['descripcion'], 0, 80) ?>...
                            </p>
                            
                            <ul class="list-group list-group-flush mb-3">
                                <li class="list-group-item px-0"><i class="bi bi-speedometer2"></i> Motor: <?= $v['motor'] ?></li>
                                <li class="list-group-item px-0 fw-bold text-success fs-5">
                                    $<?= number_format($v['precio_dia'], 2, ',', '.') ?> <small class="text-muted fs-6">/ día</small>
                                </li>
                            </ul>
                            
                            <!-- Botones de Acción -->
                            <?php if(session()->get('rol') == 'admin'): ?>
                                <a href="#" class="btn btn-outline-secondary disabled w-100">Eres Administrador</a>
                            <?php else: ?>
                                <!-- Si no es admin (es cliente o visitante), mostramos el botón de reserva -->
                                <a href="<?= base_url('reserva/nuevo/' . $v['id']) ?>" class="btn btn-mycar w-100 fw-bold">
                                    <i class="bi bi-calendar-check"></i> Reservar Ahora
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

<?php if (empty($catalogo)): ?>
    <div class="alert alert-info text-center mt-5">
        <i class="bi bi-info-circle fs-4 d-block mb-2"></i>
        No hay vehículos disponibles en este momento.
    </div>
<?php endif; ?>

<?= $this->endSection() ?>