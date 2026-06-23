<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<?php $estado_filtro = $estado_filtro ?? ''; ?>

<div class="row mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold"><i class="bi bi-calendar-check text-muted me-2"></i>Gestión de Alquileres</h2>
        <p class="text-muted">Administra las reservas y controla las devoluciones.</p>
    </div>
    <div class="col-md-6">
        <!-- BARRA DE FILTROS -->
        <form action="<?= base_url('admin/alquileres') ?>" method="GET" class="d-flex justify-content-end bg-white p-3 rounded-3 shadow-sm">
            <div class="d-flex align-items-center">
                <label class="fw-bold me-2 text-nowrap">Filtrar por Estado:</label>
                <select name="estado" class="form-select form-select-sm me-2" style="width: 150px;">
                    <option value="">Todos</option>
                    <option value="Pendiente" <?= $estado_filtro == 'Pendiente' ? 'selected' : '' ?>>Pendientes</option>
                    <option value="Alquilado" <?= $estado_filtro == 'Alquilado' ? 'selected' : '' ?>>Alquilados</option>
                    <option value="Devuelto" <?= $estado_filtro == 'Devuelto' ? 'selected' : '' ?>>Devueltos</option>
                    <option value="Cancelado" <?= $estado_filtro == 'Cancelado' ? 'selected' : '' ?>>Cancelados</option>
                </select>
                <button type="submit" class="btn btn-sm btn-dark">Filtrar</button>
                <?php if($estado_filtro): ?>
                    <a href="<?= base_url('admin/alquileres') ?>" class="btn btn-sm btn-outline-danger ms-2" title="Limpiar Filtro"><i class="bi bi-x-lg"></i></a>
                <?php endif; ?>
            </div>
        </form>
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
                        <th scope="col">Estado</th>
                        <th scope="col" class="text-center pe-4">Acción Requerida</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($alquileres)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-journal-x fs-1 d-block mb-2"></i>
                                No se encontraron alquileres con estos criterios.
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
                                <td>
                                    <?php
                                        $badge = 'bg-secondary';
                                        if ($alq['estado'] == 'Pendiente') $badge = 'bg-warning text-dark';
                                        if ($alq['estado'] == 'Alquilado') $badge = 'bg-primary';
                                        if ($alq['estado'] == 'Devuelto') $badge = 'bg-success';
                                        if ($alq['estado'] == 'Cancelado') $badge = 'bg-danger';
                                    ?>
                                    <span class="badge <?= $badge ?> px-2 py-1"><?= $alq['estado'] ?></span><br>
                                    <small class="fw-bold text-success">$<?= number_format($alq['monto_total'], 2, ',', '.') ?></small>
                                </td>
                                <td class="text-center pe-4">
                                    
                                    <!-- LÓGICA DE BOTONES SEGÚN EL ESTADO -->
                                    <?php if ($alq['estado'] == 'Pendiente'): ?>
                                        <div class="d-flex flex-column gap-1 align-items-center">
                                            <form action="<?= base_url('admin/alquileres/accion/' . $alq['id']) ?>" method="POST" class="w-100">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="accion" value="confirmar">
                                                <button type="submit" class="btn btn-sm btn-success w-100 fw-bold confirm-action" data-confirm="¿Confirmar esta reserva y pasar el auto a estado Alquilado?">
                                                    <i class="bi bi-check-circle me-1"></i> Aprobar
                                                </button>
                                            </form>
                                            <form action="<?= base_url('admin/alquileres/accion/' . $alq['id']) ?>" method="POST" class="w-100">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="accion" value="cancelar">
                                                <button type="submit" class="btn btn-sm btn-outline-danger w-100 confirm-action" data-confirm="¿Seguro que deseas cancelar esta reserva?">
                                                    <i class="bi bi-x-circle me-1"></i> Cancelar
                                                </button>
                                            </form>
                                        </div>

                                    <?php elseif ($alq['estado'] == 'Alquilado'): ?>
                                        <form action="<?= base_url('admin/alquileres/accion/' . $alq['id']) ?>" method="POST">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="accion" value="devolver">
                                            <button type="submit" class="btn btn-sm btn-primary fw-bold confirm-action" data-confirm="¿Confirmar que el cliente devolvió el auto en condiciones?">
                                                <i class="bi bi-arrow-return-left me-1"></i> Registrar Devolución
                                            </button>
                                        </form>

                                    <?php else: ?>
                                        <span class="text-muted small"><i class="bi bi-lock-fill"></i> Operación Finalizada</span>
                                    <?php endif; ?>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if (!empty($pager)): ?>
            <div class="card-footer bg-white border-0 p-3 d-flex justify-content-center">
                <?= $pager->links('default', 'mi_paginador') ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>