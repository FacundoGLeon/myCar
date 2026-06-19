<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="fw-bold"><i class="bi bi-car-front-fill text-warning me-2"></i>Vehículos en Calle</h2>
        <p class="text-muted">Listado en tiempo real de los vehículos que se encuentran actualmente alquilados (Estado: "Alquilado").</p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3 border-top border-warning border-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Vehículo</th>
                        <th scope="col">Cliente a Cargo</th>
                        <th scope="col">Teléfono Cliente</th>
                        <th scope="col">Fecha Salida</th>
                        <th scope="col">Debe Devolver</th>
                        <th scope="col" class="pe-4">Días Restantes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($alquileres)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-check-circle fs-1 d-block mb-2 text-success"></i>
                                Toda la flota se encuentra en la agencia. No hay autos alquilados actualmente.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($alquileres as $a): 
                            // Calculamos días restantes
                            $hoy = new DateTime();
                            $devolucion = new DateTime($a['fecha_hasta']);
                            $restantes = $hoy->diff($devolucion)->days;
                            $esVencido = $devolucion < $hoy;
                        ?>
                            <tr class="<?= $esVencido ? 'table-danger' : '' ?>">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url('public/assets/img/' . $a['imagen_url']) ?>" 
                                             class="rounded-3 me-3 border" 
                                             style="width: 50px; height: 35px; object-fit: cover;"
                                             onerror="this.src='https://via.placeholder.com/50x35?text=Auto'">
                                        <div class="fw-bold"><?= $a['marca'] ?> <?= $a['modelo'] ?></div>
                                    </div>
                                </td>
                                <td class="fw-bold"><?= $a['nombre'] ?> <?= $a['apellido'] ?></td>
                                <td><?= $a['telefono'] ?></td>
                                <td><?= date('d/m/Y', strtotime($a['fecha_desde'])) ?></td>
                                <td class="fw-bold <?= $esVencido ? 'text-danger' : 'text-primary' ?>">
                                    <?= date('d/m/Y', strtotime($a['fecha_hasta'])) ?>
                                </td>
                                <td class="pe-4">
                                    <?php if ($esVencido): ?>
                                        <span class="badge bg-danger">¡Atrasado!</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark"><?= $restantes ?> días</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>