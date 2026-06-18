<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php
$categorias = $categorias ?? [];
?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card border-0 shadow-sm p-4">
            <h4 class="mb-4 fw-bold">Agregar Nuevo Vehículo</h4>
            
            <form action="<?= base_url('admin/vehiculos/guardar') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Marca</label>
                        <input type="text" name="marca" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Modelo</label>
                        <input type="text" name="modelo" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Año</label>
                        <input type="number" name="anio" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Motor</label>
                        <input type="text" name="motor" class="form-control" placeholder="Ej: 1.6 Turbo">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Plazas</label>
                        <input type="number" name="plazas" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Categoría</label>
                    <select name="categoria_id" class="form-select" required>
                        <?php foreach($categorias as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= $cat['nombre'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label">Precio por Día ($)</label>
                    <input type="number" step="0.01" name="precio_dia" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Imagen del Vehículo</label>
                    <input type="file" name="imagen" class="form-control" accept="image/*" required>
                </div>


                <button type="submit" class="btn btn-primary w-100 fw-bold">Guardar Vehículo</button>
                <a href="<?= base_url('admin/vehiculos') ?>" class="btn btn-link w-100 mt-2 text-muted">Cancelar</a>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>