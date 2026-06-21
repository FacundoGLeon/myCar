<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php $buscar = $buscar ?? ''; ?>

<div class="row mb-4 align-items-center">
    <div class="col-md-5">
        <h2 class="fw-bold"><i class="bi bi-car-front text-muted me-2"></i>Gestión de Vehículos</h2>
        <p class="text-muted mb-0">Administra el catálogo de la flota disponible.</p>
    </div>
    <div class="col-md-7 d-flex justify-content-end gap-2">
        <!-- BARRA DE BÚSQUEDA -->
        <form action="<?= base_url('admin/vehiculos') ?>" method="GET" class="d-flex">
            <div class="input-group shadow-sm" style="width: 350px;">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="buscar" class="form-control border-start-0" placeholder="Buscar marca, modelo, categoría..." value="<?= esc($buscar) ?>">
                <button type="submit" class="btn btn-dark fw-bold">Buscar</button>
                <?php if($buscar): ?>
                    <a href="<?= base_url('admin/vehiculos') ?>" class="btn btn-outline-danger" title="Limpiar"><i class="bi bi-x-lg"></i></a>
                <?php endif; ?>
            </div>
        </form>

        <a href="<?= base_url('admin/vehiculos/nuevo') ?>" class="btn btn-dark fw-bold shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Nuevo
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Imagen</th>
                        <th scope="col">Vehículo</th>
                        <th scope="col">Categoría</th>
                        <th scope="col">Año / Plazas</th>
                        <th scope="col">Precio (Día)</th>
                        <th scope="col" class="text-center pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($vehiculos)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-car-front-fill fs-1 d-block mb-2"></i>
                                <?php if($buscar): ?>
                                    No se encontraron vehículos que coincidan con "<strong><?= esc($buscar) ?></strong>".
                                <?php else: ?>
                                    Aún no hay vehículos registrados.
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($vehiculos as $v): ?>
                            <tr>
                                <td class="ps-4">
                                    <img src="<?= base_url('public/assets/img/' . $v['imagen_url']) ?>" 
                                         alt="Auto" style="width: 80px; height: 50px; object-fit: cover;" 
                                         class="rounded border"
                                         onerror="this.src='https://via.placeholder.com/80x50?text=Sin+Foto'">
                                </td>
                                <td><div class="fw-bold"><?= $v['marca'] ?> <?= $v['modelo'] ?></div></td>
                                <td><span class="badge bg-secondary"><?= $v['categoria_nombre'] ?? 'Sin Categoría' ?></span></td>
                                <td><?= $v['anio'] ?> • <i class="bi bi-people-fill text-muted"></i> <?= $v['plazas'] ?></td>
                                <td class="fw-bold text-success">$<?= number_format($v['precio_dia'], 2) ?></td>
                                <td class="text-center pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('admin/vehiculos/editar/' . $v['id']) ?>" class="btn btn-outline-dark"><i class="bi bi-pencil-square"></i></a>
                                        <a href="<?= base_url('admin/vehiculos/eliminar/' . $v['id']) ?>" class="btn btn-outline-danger" onclick="return confirm('¿Seguro que deseas eliminar este vehículo?');"><i class="bi bi-trash"></i></a>
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
                <?= $pager->links('default', 'mi_paginador') ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>