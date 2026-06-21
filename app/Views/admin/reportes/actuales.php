<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="fw-bold"><i class="bi bi-car-front-fill text-dark me-2"></i>Vehículos en Calle</h2>
        <p class="text-muted">Listado en tiempo real de los vehículos que se encuentran actualmente alquilados (Estado: "Alquilado").</p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3 border-top border-dark border-4">
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
                            // Lógica corregida: Usamos 'today' para igualar las horas a 00:00:00
                            $hoy = new DateTime('today');
                            $devolucion = new DateTime($a['fecha_hasta']);
                            
                            // Calculamos la diferencia exacta en días (+ o -)
                            $diferencia = (int)$hoy->diff($devolucion)->format('%R%a');
                            
                            $esVencido = $diferencia < 0; // Solo si es menor a 0 (ayer o antes)
                            $esHoy = $diferencia === 0;   // Si debe devolverlo hoy mismo
                        ?>
                            <tr class="<?= $esVencido ? 'table-danger' : '' ?>">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url('public/assets/img/' . $a['imagen_url']) ?>" 
                                             class="rounded-3 me-3 border" 
                                             style="width: 50px; height: 35px; object-fit: cover;"
                                             onerror="this.src='https://via.placeholder.com/50x35?text=Auto'">
                                        <div class="fw-bold text-dark"><?= $a['marca'] ?> <?= $a['modelo'] ?></div>
                                    </div>
                                </td>
                                <td class="fw-bold text-muted"><?= $a['nombre'] ?> <?= $a['apellido'] ?></td>
                                <td><?= $a['telefono'] ?></td>
                                <td><?= date('d/m/Y', strtotime($a['fecha_desde'])) ?></td>
                                <td class="fw-bold <?= $esVencido ? 'text-danger' : 'text-dark' ?>">
                                    <?= date('d/m/Y', strtotime($a['fecha_hasta'])) ?>
                                </td>
                                <td class="pe-4">
                                    <?php if ($esVencido): ?>
                                        <span class="badge bg-danger shadow-sm">¡Atrasado!</span>
                                    <?php elseif ($esHoy): ?>
                                        <span class="badge bg-secondary shadow-sm">Devuelve Hoy</span>
                                    <?php else: ?>
                                        <span class="badge bg-dark shadow-sm"><?= $diferencia ?> <?= $diferencia === 1 ? 'día' : 'días' ?></span>
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