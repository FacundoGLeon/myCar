<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<?php
$categorias = $categorias ?? [];
$v = $vehiculo ?? []; // Datos actuales del auto
?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card border-0 shadow-sm p-4">
            <h4 class="mb-4 fw-bold">Editar Vehículo: <?= $v['marca'] ?> <?= $v['modelo'] ?></h4>
            
            <!-- Apuntamos a la nueva ruta 'actualizar' con el ID del vehículo -->
            <form action="<?= base_url('admin/vehiculos/actualizar/' . $v['id']) ?>" novalidate method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Marca</label>
                        <input type="text" name="marca" 
                               class="form-control <?= session('errors.marca') ? 'is-invalid' : '' ?>" 
                               value="<?= old('marca', $v['marca']) ?>">
                        <?php if (session('errors.marca')): ?>
                            <div class="invalid-feedback d-block"><?= session('errors.marca') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Modelo</label>
                        <input type="text" name="modelo" 
                               class="form-control <?= session('errors.modelo') ? 'is-invalid' : '' ?>" 
                               value="<?= old('modelo', $v['modelo']) ?>">
                        <?php if (session('errors.modelo')): ?>
                            <div class="invalid-feedback d-block"><?= session('errors.modelo') ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Año</label>
                        <input type="number" name="anio" 
                               class="form-control <?= session('errors.anio') ? 'is-invalid' : '' ?>" 
                               value="<?= old('anio', $v['anio']) ?>">
                        <?php if (session('errors.anio')): ?>
                            <div class="invalid-feedback d-block"><?= session('errors.anio') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Plazas</label>
                        <input type="number" name="plazas" 
                               class="form-control <?= session('errors.plazas') ? 'is-invalid' : '' ?>" 
                               value="<?= old('plazas', $v['plazas']) ?>">
                        <?php if (session('errors.plazas')): ?>
                            <div class="invalid-feedback d-block"><?= session('errors.plazas') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Precio por Día ($)</label>
                        <input type="number" step="0.01" name="precio_dia" 
                               class="form-control <?= session('errors.precio_dia') ? 'is-invalid' : '' ?>" 
                               value="<?= old('precio_dia', $v['precio_dia']) ?>">
                        <?php if (session('errors.precio_dia')): ?>
                            <div class="invalid-feedback d-block"><?= session('errors.precio_dia') ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Motor</label>
                        <input type="text" name="motor" 
                               class="form-control <?= session('errors.motor') ? 'is-invalid' : '' ?>" 
                               value="<?= old('motor', $v['motor']) ?>">
                        <?php if (session('errors.motor')): ?>
                            <div class="invalid-feedback d-block"><?= session('errors.motor') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kilometraje</label>
                        <input type="number" step="0.01" name="kilometraje" 
                               class="form-control <?= session('errors.kilometraje') ? 'is-invalid' : '' ?>" 
                               value="<?= old('kilometraje', $v['kilometraje']) ?>">
                        <?php if (session('errors.kilometraje')): ?>
                            <div class="invalid-feedback d-block"><?= session('errors.kilometraje') ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Categoría</label>
                    <select name="categoria_id" class="form-select <?= session('errors.categoria_id') ? 'is-invalid' : '' ?>" required>
                        <option value="">Seleccione una categoría</option>
                        <?php foreach($categorias as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= old('categoria_id', $v['categoria_id']) == $cat['id'] ? 'selected' : '' ?>>
                                <?= $cat['nombre'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (session('errors.categoria_id')): ?>
                        <div class="invalid-feedback d-block"><?= session('errors.categoria_id') ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción Detallada</label>
                    <textarea name="descripcion" 
                              class="form-control <?= session('errors.descripcion') ? 'is-invalid' : '' ?>" 
                              rows="3" required><?= old('descripcion', $v['descripcion']) ?></textarea>
                    <?php if (session('errors.descripcion')): ?>
                        <div class="invalid-feedback d-block"><?= session('errors.descripcion') ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label class="form-label d-block">Imagen del Vehículo</label>
                    <div class="d-flex align-items-center mb-2">
                        <?php if (!empty($v['imagen_url'])): ?>
                            <img src="<?= base_url('public/assets/img/' . $v['imagen_url']) ?>" alt="Actual" class="rounded me-3 border" style="height: 60px; width: 90px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="flex-grow-1">
                            <input type="file" name="imagen" class="form-control <?= session('errors.imagen') ? 'is-invalid' : '' ?>" accept="image/*">
                            <!-- Nota aclaratoria porque la imagen no es obligatoria -->
                            <small class="text-muted">Deja este campo vacío si deseas conservar la imagen actual.</small>
                        </div>
                    </div>
                    <?php if (session('errors.imagen')): ?>
                        <div class="invalid-feedback d-block"><?= session('errors.imagen') ?></div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold">Actualizar Vehículo</button>
                <a href="<?= base_url('admin/vehiculos') ?>" class="btn btn-link w-100 mt-2 text-muted">Cancelar y Volver</a>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>