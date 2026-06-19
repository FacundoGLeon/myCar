<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="fw-bold"><i class="bi bi-car-front text-muted me-2"></i>Gestión de Vehículos</h2>
        <p class="text-muted">Administra el catálogo de la flota disponible para alquiler.</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="<?= base_url('admin/vehiculos/nuevo') ?>" class="btn btn-success fw-bold shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Agregar Vehículo
        </a>
    </div>
</div>

<!-- BLOQUE PARA MOSTRAR MENSAJES DE ÉXITO O ERROR -->
<!-- <?php if (session()->has('mensaje')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> <?= session('mensaje') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->has('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= session('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?> -->

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Vehículo</th>
                        <th scope="col">Categoría</th>
                        <th scope="col">Año / Plazas</th>
                        <th scope="col">Precio (Día)</th>
                        <th scope="col" class="text-center pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($vehiculos)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No hay vehículos registrados en el sistema.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($vehiculos as $v): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url('public/assets/img/' . $v['imagen_url']) ?>" 
                                             class="rounded-3 me-3" 
                                             style="width: 60px; height: 40px; object-fit: cover;"
                                             onerror="this.src='https://via.placeholder.com/60x40?text=Auto'">
                                        <div>
                                            <h6 class="mb-0 fw-bold"><?= $v['marca'] ?> <?= $v['modelo'] ?></h6>
                                            <small class="text-muted"><i class="bi bi-speedometer2"></i> <?= $v['motor'] ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-secondary"><?= $v['categoria_nombre'] ?></span></td>
                                <td><?= $v['anio'] ?> • <i class="bi bi-people-fill text-muted"></i> <?= $v['plazas'] ?></td>
                                <td class="fw-bold text-success">$<?= number_format($v['precio_dia'], 2, ',', '.') ?></td>
                                <td class="text-center pe-4">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <!-- BOTÓN EDITAR -->
                                        <a href="<?= base_url('admin/vehiculos/editar/' . $v['id']) ?>" class="btn btn-outline-primary" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <!-- BOTÓN ELIMINAR -->
                                        <a href="<?= base_url('admin/vehiculos/eliminar/' . $v['id']) ?>" 
                                           class="btn btn-outline-danger" 
                                           title="Eliminar (Baja Lógica)"
                                           onclick="return confirm('¿Estás seguro de que deseas eliminar el vehículo <?= $v['marca'] ?> <?= $v['modelo'] ?>?');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if (!empty($pager)): ?>
            <div class="card-footer bg-white border-0 p-3 d-flex justify-content-center">
                <?= $pager->links('default', 'default_full') ?>
            </div>
        <?php endif; ?>
        
    </div>
</div>

<?= $this->endSection() ?>