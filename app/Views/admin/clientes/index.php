<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="fw-bold"><i class="bi bi-people text-muted me-2"></i>Gestión de Clientes</h2>
        <p class="text-muted">Administra los perfiles de los usuarios registrados en la plataforma.</p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Cliente</th>
                        <th scope="col">Contacto</th>
                        <th scope="col">Dirección</th>
                        <th scope="col">Fecha Alta</th>
                        <th scope="col" class="text-center pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($clientes)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-person-x fs-1 d-block mb-2"></i>
                                Aún no hay clientes registrados en el sistema.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($clientes as $c): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-3 fw-bold" style="width: 40px; height: 40px;">
                                            <?= strtoupper(substr($c['nombre'], 0, 1) . substr($c['apellido'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold"><?= $c['nombre'] ?> <?= $c['apellido'] ?></h6>
                                            <small class="text-muted text-uppercase">ID: <?= $c['id'] ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div><i class="bi bi-envelope text-muted"></i> <?= $c['email'] ?></div>
                                    <div><i class="bi bi-telephone text-muted"></i> <?= $c['telefono'] ?></div>
                                </td>
                                <td><span class="text-truncate d-inline-block" style="max-width: 200px;" title="<?= $c['direccion'] ?>"><?= $c['direccion'] ?></span></td>
                                <td><?= date('d/m/Y', strtotime($c['fecha_alta'])) ?></td>
                                <td class="text-center pe-4">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= base_url('admin/clientes/editar/' . $c['id']) ?>" class="btn btn-outline-primary" title="Editar Perfil">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="<?= base_url('admin/clientes/eliminar/' . $c['id']) ?>" 
                                           class="btn btn-outline-danger" 
                                           title="Dar de Baja"
                                           onclick="return confirm('¿Estás seguro de dar de baja al cliente <?= $c['nombre'] ?>? No podrá volver a iniciar sesión.');">
                                            <i class="bi bi-person-x"></i>
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