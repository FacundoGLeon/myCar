<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card card-vehiculo p-3">
            <div class="card-body">
                <h3 class="text-center mb-4"><i class="bi bi-person-circle text-muted"></i> Iniciar Sesión</h3>
                
                <!-- El novalidate desactiva los globitos por defecto del navegador -->
                <form action="<?= base_url('login') ?>" method="POST" novalidate>
                    <div class="mb-3">
                        <label for="email" class="form-label text-muted fw-bold">Correo Electrónico</label>
                        <input type="email" class="form-control form-control-lg" id="email" name="email" value="<?= old('email') ?>" placeholder="ejemplo@correo.com">
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label text-muted fw-bold">Contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="********">
                            <button class="btn btn-outline-secondary" type="button" id="togglePasswordBtn" onclick="togglePassword('password', 'toggleIcon')">
                                <i class="bi bi-eye-slash" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-mycar btn-lg fw-bold">Ingresar</button>
                    </div>
                </form>
                
                <hr class="mt-4">
                
                <div class="text-center mt-3">
                    <span class="text-muted">¿No tienes cuenta?</span> <a href="<?= base_url('registro') ?>" class="text-decoration-none fw-bold" style="color: var(--secondary-color);">Regístrate aquí</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para el ojo de la contraseña -->
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