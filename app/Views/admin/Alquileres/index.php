<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="fw-bold"><i class="bi bi-calendar-check text-muted me-2"></i>Gestión de Alquileres</h2>
        <p class="text-muted">Administra las reservas y el estado actual de los alquileres.</p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">ID / Fecha</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Vehículo</th>
                        <th scope="col">Período</th>
                        <th scope="col">Total</th>
                        <th scope="col" class="text-center pe-4">Estado y Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($alquileres)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-journal-x fs-1 d-block mb-2"></i>
                                No hay alquileres registrados en el sistema.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($alquileres as $alq): ?>
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold">#<?= $alq['id'] ?></span><br>
                                    <small class="text-muted"><?= date('d/m/Y H:i', strtotime($alq['created_at'])) ?></small>
                                </td>
                                <td>
                                    <div class="fw-bold"><?= $alq['nombre'] ?> <?= $alq['apellido'] ?></div>
                                    <small class="text-muted"><i class="bi bi-person-badge"></i> ID: <?= $alq['cliente_id'] ?></small>
                                </td>
                                <td>
                                    <div class="fw-bold text-primary"><?= $alq['marca'] ?> <?= $alq['modelo'] ?></div>
                                </td>
                                <td>
                                    <div style="font-size: 0.9rem;">
                                        <i class="bi bi-calendar-event text-success"></i> <?= date('d/m/Y', strtotime($alq['fecha_desde'])) ?><br>
                                        <i class="bi bi-calendar-event-fill text-danger"></i> <?= date('d/m/Y', strtotime($alq['fecha_hasta'])) ?>
                                    </div>
                                    <span class="badge bg-light text-dark border mt-1"><?= $alq['dias'] ?> días</span>
                                </td>
                                <td class="fw-bold text-success">
                                    $<?= number_format($alq['monto_total'], 2, ',', '.') ?>
                                </td>
                                <td class="text-center pe-4">
                                    <!-- Formulario rápido para cambiar estado -->
                                    <form action="<?= base_url('admin/alquileres/cambiarEstado/' . $alq['id']) ?>" method="POST" class="d-flex justify-content-center align-items-center">
                                        <?= csrf_field() ?>
                                        
                                        <?php
                                            // Asignamos un color según el estado
                                            $color = 'secondary';
                                            if ($alq['estado'] == 'Pendiente') $color = 'warning ';//text-dark
                                            if ($alq['estado'] == 'Alquilado') $color = 'primary';
                                            if ($alq['estado'] == 'Devuelto') $color = 'success';
                                            if ($alq['estado'] == 'Cancelado') $color = 'danger';
                                        ?>
                                        
                                        <select name="estado" class="form-select form-select-sm border-<?= $color ?> text-<?= $color ?> fw-bold me-2" style="width: 120px;" onchange="this.form.submit()">
                                            <option value="Pendiente" <?= $alq['estado'] == 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                                            <option value="Alquilado" <?= $alq['estado'] == 'Alquilado' ? 'selected' : '' ?>>Alquilado</option>
                                            <option value="Devuelto" <?= $alq['estado'] == 'Devuelto' ? 'selected' : '' ?>>Devuelto</option>
                                            <option value="Cancelado" <?= $alq['estado'] == 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
                                        </select>
                                    </form>
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