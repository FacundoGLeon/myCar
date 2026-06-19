<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<?php 
// Inicializamos las variables para que el editor (IDE) no marque advertencias
$clientes = $clientes ?? [];
$cliente_id = $cliente_id ?? '';
$historial = $historial ?? [];
?>

<!-- Importamos los estilos de Tom Select para Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">

<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="fw-bold"><i class="bi bi-file-earmark-person text-success me-2"></i>Historial por Cliente</h2>
        <p class="text-muted">Selecciona o busca un cliente para ver el historial de todos los vehículos que ha alquilado.</p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-body p-4 bg-light">
        <form action="<?= base_url('admin/reportes/cliente') ?>" method="GET" class="row g-3 align-items-end" novalidate>
            <div class="col-md-8">
                <label class="form-label fw-bold">Buscar Cliente</label>
                <!-- Le agregamos un ID específico "select-cliente" -->
                <select name="cliente_id" id="select-cliente" placeholder="Escribe nombre, apellido o ID..." autocomplete="off" required>
                    <option value="">-- Selecciona o escribe para buscar --</option>
                    <?php foreach($clientes as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= $cliente_id == $c['id'] ? 'selected' : '' ?>>
                            ID: <?= $c['id'] ?> - <?= $c['nombre'] ?> <?= $c['apellido'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-success w-100 fw-bold"><i class="bi bi-search me-2"></i> Generar Reporte</button>
            </div>
        </form>
    </div>
</div>

<?php if ($cliente_id): ?>
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
            <h5 class="fw-bold text-success">Vehículos Alquilados por este Cliente</h5>
        </div>
        <div class="card-body p-0 mt-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4">Vehículo</th>
                            <th scope="col">Plazas</th>
                            <th scope="col">Período</th>
                            <th scope="col">Días</th>
                            <th scope="col">Monto Pagado</th>
                            <th scope="col" class="pe-4">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($historial)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Este cliente aún no ha alquilado ningún vehículo.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($historial as $h): ?>
                                <?php
                                    // Asignar color según el estado
                                    $badgeColor = 'bg-secondary'; // Por defecto
                                    switch ($h['estado']) {
                                        case 'Pendiente': $badgeColor = 'bg-warning text-dark'; break;
                                        case 'Alquilado': $badgeColor = 'bg-primary'; break;
                                        case 'Devuelto':  $badgeColor = 'bg-success'; break;
                                        case 'Cancelado': $badgeColor = 'bg-danger'; break;
                                    }
                                ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-primary"><?= $h['marca'] ?> <?= $h['modelo'] ?></td>
                                    <td><?= $h['plazas'] ?></td>
                                    <td>
                                        <small>Desde: <?= date('d/m/Y', strtotime($h['fecha_desde'])) ?></small><br>
                                        <small>Hasta: <?= date('d/m/Y', strtotime($h['fecha_hasta'])) ?></small>
                                    </td>
                                    <td><?= $h['dias'] ?></td>
                                    <td class="text-success fw-bold">$<?= number_format($h['monto_total'], 2, ',', '.') ?></td>
                                    <td class="pe-4"><span class="badge <?= $badgeColor ?>"><?= $h['estado'] ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Importamos el Script de Tom Select y lo inicializamos -->
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        new TomSelect("#select-cliente", {
            create: false,
            sortField: { field: "text", direction: "asc" }
        });
    });
</script>

<?= $this->endSection() ?>