<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php $c = $cliente ?? []; ?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card border-0 shadow-sm p-4">
            <h4 class="mb-4 fw-bold">Editar Perfil de Cliente</h4>
            
            <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                <div>
                    <strong>Email de Acceso:</strong> <?= $c['email'] ?><br>
                    <small>El correo electrónico no puede ser modificado por el administrador por razones de seguridad.</small>
                </div>
            </div>

            <form action="<?= base_url('admin/clientes/actualizar/' . $c['id']) ?>" method="POST" novalidate>
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" 
                               class="form-control <?= session('errors.nombre') ? 'is-invalid' : '' ?>" 
                               value="<?= old('nombre', $c['nombre']) ?>">
                        <?php if (session('errors.nombre')): ?>
                            <div class="invalid-feedback d-block"><?= session('errors.nombre') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Apellido</label>
                        <input type="text" name="apellido" 
                               class="form-control <?= session('errors.apellido') ? 'is-invalid' : '' ?>" 
                               value="<?= old('apellido', $c['apellido']) ?>">
                        <?php if (session('errors.apellido')): ?>
                            <div class="invalid-feedback d-block"><?= session('errors.apellido') ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Teléfono de Contacto</label>
                        <input type="text" name="telefono" 
                               class="form-control <?= session('errors.telefono') ? 'is-invalid' : '' ?>" 
                               value="<?= old('telefono', $c['telefono']) ?>">
                        <?php if (session('errors.telefono')): ?>
                            <div class="invalid-feedback d-block"><?= session('errors.telefono') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Dirección Completa</label>
                        <input type="text" name="direccion" 
                               class="form-control <?= session('errors.direccion') ? 'is-invalid' : '' ?>" 
                               value="<?= old('direccion', $c['direccion']) ?>">
                        <?php if (session('errors.direccion')): ?>
                            <div class="invalid-feedback d-block"><?= session('errors.direccion') ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-dark w-100 fw-bold">Actualizar Datos</button>
                <a href="<?= base_url('admin/clientes') ?>" class="btn btn-link w-100 mt-2 text-muted">Cancelar y Volver</a>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>