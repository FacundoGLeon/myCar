<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php $c = $categoria ?? []; ?>

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card border-0 shadow-sm p-4">
            <h4 class="mb-4 fw-bold">Editar Categoría: <?= $c['nombre'] ?></h4>
            
            <form action="<?= base_url('admin/categorias/actualizar/' . $c['id']) ?>" method="POST" novalidate>
                <?= csrf_field() ?>
                
                <div class="mb-4">
                    <label class="form-label">Nombre de la Categoría</label>
                    <input type="text" name="nombre" 
                           class="form-control <?= session('errors.nombre') ? 'is-invalid' : '' ?>" 
                           value="<?= old('nombre', $c['nombre']) ?>">
                    <?php if (session('errors.nombre')): ?>
                        <div class="invalid-feedback d-block"><?= session('errors.nombre') ?></div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-dark w-100 fw-bold">Actualizar Categoría</button>
                <a href="<?= base_url('admin/categorias') ?>" class="btn btn-link w-100 mt-2 text-muted">Cancelar</a>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>