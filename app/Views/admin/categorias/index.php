<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="fw-bold"><i class="bi bi-tags text-muted me-2"></i>Gestión de Categorías</h2>
        <p class="text-muted">Administra las clasificaciones de los vehículos.</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="<?= base_url('admin/categorias/nuevo') ?>" class="btn btn-dark fw-bold shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Agregar Categoría
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">ID</th>
                        <th scope="col">Nombre de Categoría</th>
                        <th scope="col" class="text-center pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($categorias)): ?>
                        <tr>
                            <!-- Cambié colspan a 3 porque ahora hay menos columnas -->
                            <td colspan="3" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No hay categorías registradas.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($categorias as $cat): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted">#<?= $cat['id'] ?></td>
                                <td class="fw-bold"><?= $cat['nombre'] ?></td>
                                <td class="text-center pe-4">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= base_url('admin/categorias/editar/' . $cat['id']) ?>" class="btn btn-outline-dark" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="<?= base_url('admin/categorias/eliminar/' . $cat['id']) ?>" 
                                           class="btn btn-outline-danger confirm-action" 
                                           title="Eliminar"
                                           data-confirm="¿Eliminar la categoría <?= $cat['nombre'] ?>? Los autos que la tengan asignada podrían quedar sin categoría.">
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
                <?= $pager->links('default', 'mi_paginador') ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>