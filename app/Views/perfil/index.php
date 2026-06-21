<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $errores = session()->getFlashdata('errores'); ?>

<?php 
$cliente = $cliente ?? [];
$usuario = $usuario ?? [];
$errores = session()->getFlashdata('errores'); 
?>

<div class="row justify-content-center py-5">
    <div class="col-md-8">
        <h2 class="fw-bold mb-4" style="color: var(--primary-color);">
            <i class="bi bi-person-gear me-2"></i>Mi Perfil
        </h2>

        <form action="<?= base_url('perfil/actualizar') ?>" method="POST" novalidate>
            <?= csrf_field() ?>

            <!-- TARJETA 1: Datos Personales -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="fw-bold text-muted mb-0">Datos Personales</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Nombre</label>
                            <input type="text" class="form-control <?= isset($errores['nombre']) ? 'is-invalid' : '' ?>" name="nombre" value="<?= old('nombre', $cliente['nombre']) ?>">
                            <?php if(isset($errores['nombre'])): ?>
                                <div class="invalid-feedback fw-bold"><?= $errores['nombre'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Apellido</label>
                            <input type="text" class="form-control <?= isset($errores['apellido']) ? 'is-invalid' : '' ?>" name="apellido" value="<?= old('apellido', $cliente['apellido']) ?>">
                            <?php if(isset($errores['apellido'])): ?>
                                <div class="invalid-feedback fw-bold"><?= $errores['apellido'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Teléfono</label>
                            <input type="text" class="form-control <?= isset($errores['telefono']) ? 'is-invalid' : '' ?>" name="telefono" value="<?= old('telefono', $cliente['telefono']) ?>">
                            <?php if(isset($errores['telefono'])): ?>
                                <div class="invalid-feedback fw-bold"><?= $errores['telefono'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Dirección Completa</label>
                            <input type="text" class="form-control <?= isset($errores['direccion']) ? 'is-invalid' : '' ?>" name="direccion" value="<?= old('direccion', $cliente['direccion']) ?>">
                            <?php if(isset($errores['direccion'])): ?>
                                <div class="invalid-feedback fw-bold"><?= $errores['direccion'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TARJETA 2: Seguridad y Acceso -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="fw-bold text-muted mb-0">Seguridad de la Cuenta</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted">Correo Electrónico (Solo Lectura)</label>
                        <input type="email" class="form-control bg-light" value="<?= $usuario['email'] ?>" readonly>
                        <div class="form-text">Tu correo electrónico de acceso no puede modificarse por seguridad.</div>
                    </div>
                    
                    <hr class="text-muted">
                    
                    <p class="text-muted small mb-3"><i class="bi bi-info-circle me-1"></i> Si no deseas cambiar tu contraseña, deja estos campos vacíos.</p>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Nueva Contraseña</label>
                            <input type="password" class="form-control <?= isset($errores['password']) ? 'is-invalid' : '' ?>" name="password" placeholder="********">
                            <?php if(isset($errores['password'])): ?>
                                <div class="invalid-feedback fw-bold"><?= $errores['password'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control <?= isset($errores['password_confirm']) ? 'is-invalid' : '' ?>" name="password_confirm" placeholder="********">
                            <?php if(isset($errores['password_confirm'])): ?>
                                <div class="invalid-feedback fw-bold"><?= $errores['password_confirm'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="<?= base_url('catalogo') ?>" class="btn btn-light border shadow-sm px-4 fw-bold">Cancelar</a>
                <button type="submit" class="btn btn-mycar shadow-sm px-5 fw-bold">
                    <i class="bi bi-save me-1"></i> Guardar Cambios
                </button>
            </div>
            
        </form>
    </div>
</div>

<?= $this->endSection() ?>