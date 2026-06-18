<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $errores = session()->getFlashdata('errores'); ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card card-vehiculo p-3">
            <div class="card-body">
                <h3 class="text-center mb-4"><i class="bi bi-person-plus text-muted"></i> Crear Cuenta Nueva</h3>
                
                <!-- novalidate para usar el diseño de CI4 + Bootstrap -->
                <form action="<?= base_url('registro') ?>" method="POST" novalidate>
                    
                    <h5 class="text-muted mb-3 border-bottom pb-2">Datos Personales</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label fw-bold">Nombre</label>
                            <input type="text" class="form-control <?= isset($errores['nombre']) ? 'is-invalid' : '' ?>" id="nombre" name="nombre" value="<?= old('nombre') ?>">
                            <?php if(isset($errores['nombre'])): ?>
                                <div class="invalid-feedback fw-bold"><?= $errores['nombre'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="apellido" class="form-label fw-bold">Apellido</label>
                            <input type="text" class="form-control <?= isset($errores['apellido']) ? 'is-invalid' : '' ?>" id="apellido" name="apellido" value="<?= old('apellido') ?>">
                            <?php if(isset($errores['apellido'])): ?>
                                <div class="invalid-feedback fw-bold"><?= $errores['apellido'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="telefono" class="form-label fw-bold">Teléfono</label>
                            <input type="text" class="form-control <?= isset($errores['telefono']) ? 'is-invalid' : '' ?>" id="telefono" name="telefono" value="<?= old('telefono') ?>">
                            <?php if(isset($errores['telefono'])): ?>
                                <div class="invalid-feedback fw-bold"><?= $errores['telefono'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="direccion" class="form-label fw-bold">Dirección Completa</label>
                            <input type="text" class="form-control <?= isset($errores['direccion']) ? 'is-invalid' : '' ?>" id="direccion" name="direccion" value="<?= old('direccion') ?>">
                            <?php if(isset($errores['direccion'])): ?>
                                <div class="invalid-feedback fw-bold"><?= $errores['direccion'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <h5 class="text-muted mb-3 border-bottom pb-2">Datos de Acceso</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-bold">Correo Electrónico</label>
                            <input type="email" class="form-control <?= isset($errores['email']) ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= old('email') ?>">
                            <?php if(isset($errores['email'])): ?>
                                <div class="invalid-feedback fw-bold"><?= $errores['email'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="password" class="form-label fw-bold">Contraseña</label>
                            <div class="input-group has-validation">
                                <input type="password" class="form-control <?= isset($errores['password']) ? 'is-invalid' : '' ?>" id="password" name="password">
                                <button class="btn btn-outline-secondary <?= isset($errores['password']) ? 'border-danger' : '' ?>" type="button" onclick="togglePassword('password', 'toggleIconReg')">
                                    <i class="bi bi-eye-slash" id="toggleIconReg"></i>
                                </button>
                                <?php if(isset($errores['password'])): ?>
                                    <div class="invalid-feedback fw-bold"><?= $errores['password'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 mt-2">
                        <button type="submit" class="btn btn-mycar btn-lg fw-bold">Registrarme</button>
                    </div>
                </form>
                
                <div class="text-center mt-4">
                    <span class="text-muted">¿Ya tienes una cuenta?</span> <a href="<?= base_url('login') ?>" class="text-decoration-none fw-bold" style="color: var(--secondary-color);">Inicia sesión</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        }
    }
</script>
<?= $this->endSection() ?>