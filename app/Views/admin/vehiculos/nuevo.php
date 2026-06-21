<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<?php
$categorias = $categorias ?? [];
?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card border-0 shadow-sm p-4">
            <h4 class="mb-4 fw-bold">Agregar Nuevo Vehículo</h4>
            
            <form action="<?= base_url('admin/vehiculos/guardar') ?>" novalidate method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Marca</label>
                        <input type="text" name="marca" 
                               class="form-control <?= session('errors.marca') ? 'is-invalid' : '' ?>" 
                               value="<?= old('marca') ?>">
                        <?php if (session('errors.marca')): ?>
                            <div class="invalid-feedback d-block">
                                <?= session('errors.marca') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Modelo</label>
                        <input type="text" name="modelo" 
                               class="form-control <?= session('errors.modelo') ? 'is-invalid' : '' ?>" 
                               value="<?= old('modelo') ?>">
                        <?php if (session('errors.modelo')): ?>
                            <div class="invalid-feedback d-block">
                                <?= session('errors.modelo') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Año</label>
                        <input type="number" name="anio" 
                               class="form-control <?= session('errors.anio') ? 'is-invalid' : '' ?>" 
                               value="<?= old('anio') ?>">
                        <?php if (session('errors.anio')): ?>
                            <div class="invalid-feedback d-block">
                                <?= session('errors.anio') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Plazas</label>
                        <input type="number" name="plazas" 
                               class="form-control <?= session('errors.plazas') ? 'is-invalid' : '' ?>" 
                               value="<?= old('plazas') ?>">
                        <?php if (session('errors.plazas')): ?>
                            <div class="invalid-feedback d-block">
                                <?= session('errors.plazas') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Precio por Día ($)</label>
                        <input type="number" step="0.01" name="precio_dia" 
                               class="form-control <?= session('errors.precio_dia') ? 'is-invalid' : '' ?>" 
                               value="<?= old('precio_dia') ?>">
                        <?php if (session('errors.precio_dia')): ?>
                            <div class="invalid-feedback d-block">
                                <?= session('errors.precio_dia') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Motor</label>
                        <input type="text" name="motor" 
                               class="form-control <?= session('errors.motor') ? 'is-invalid' : '' ?>" 
                               value="<?= old('motor') ?>">
                        <?php if (session('errors.motor')): ?>
                            <div class="invalid-feedback d-block">
                                <?= session('errors.motor') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kilometraje</label>
                        <input type="number" step="0.01" name="kilometraje" 
                               class="form-control <?= session('errors.kilometraje') ? 'is-invalid' : '' ?>" 
                               value="<?= old('kilometraje') ?>">
                        <?php if (session('errors.kilometraje')): ?>
                            <div class="invalid-feedback d-block">
                                <?= session('errors.kilometraje') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Categoría</label>
                    <select name="categoria_id" 
                            class="form-select <?= session('errors.categoria_id') ? 'is-invalid' : '' ?>" required>
                        <option value="">Seleccione una categoría</option>
                        <?php foreach($categorias as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= old('categoria_id') == $cat['id'] ? 'selected' : '' ?>>
                                <?= $cat['nombre'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (session('errors.categoria_id')): ?>
                        <div class="invalid-feedback d-block">
                            <?= session('errors.categoria_id') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción Detallada</label>
                    <textarea name="descripcion" 
                              class="form-control <?= session('errors.descripcion') ? 'is-invalid' : '' ?>" 
                              rows="3" required><?= old('descripcion') ?></textarea>
                    <?php if (session('errors.descripcion')): ?>
                        <div class="invalid-feedback d-block">
                            <?= session('errors.descripcion') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Imagen del Vehículo</label>
                    <input type="file" name="imagen" 
                           class="form-control <?= session('errors.imagen') ? 'is-invalid' : '' ?>" 
                           accept="image/*" required>
                    <?php if (session('errors.imagen')): ?>
                        <div class="invalid-feedback d-block">
                            <?= session('errors.imagen') ?>
                        </div>
                    <?php endif; ?>
                    <small class="text-muted">Formatos aceptados: JPG, PNG. Tamaño máximo: 2MB.</small>
                </div>

                <button type="submit" class="btn btn-dark w-100 fw-bold">Guardar Vehículo</button>
                <a href="<?= base_url('admin/vehiculos') ?>" class="btn btn-link w-100 mt-2 text-muted">Cancelar</a>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>