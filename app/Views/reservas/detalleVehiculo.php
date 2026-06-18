<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container py-2">
    <!-- Botón Volver -->
    <div class="mb-4">
        <a href="<?= base_url('catalogo') ?>" class="btn btn-outline-secondary rounded-pill px-3 shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Volver al Catálogo
        </a>
    </div>

    <!-- Alertas de Error de Validación / Servidor -->
    <?php if(session()->getFlashdata('errores')): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <h6 class="fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>Por favor corrige los siguientes errores:</h6>
            <ul class="mb-0 ps-3">
                <?php foreach(session()->getFlashdata('errores') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-octagon-fill me-2"></i><?= esc(session()->getFlashdata('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- Panel Izquierdo: Ficha Técnica del Vehículo -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <!-- Imagen del Vehículo con Fallback -->
                <div class="position-relative">
                    <img src="<?= base_url('assets/img/' . $vehiculo['imagen_url']) ?>" 
                         class="img-fluid w-100" 
                         alt="<?= esc($vehiculo['marca'] . ' ' . $vehiculo['modelo']) ?>" 
                         style="max-height: 400px; object-fit: cover; width: 100%;"
                         onerror="this.src='https://via.placeholder.com/800x500?text=Foto+No+Disponible'">
                    <span class="position-absolute top-0 end-0 bg-primary text-white px-3 py-1 m-3 rounded-pill fw-bold small">
                        <?= esc($vehiculo['anio']) ?>
                    </span>
                </div>
                
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h2 class="fw-bold mb-1" style="color: var(--primary-color);">
                                <?= esc($vehiculo['marca']) ?> <?= esc($vehiculo['modelo']) ?>
                            </h2>
                        </div>
                        <div class="text-end">
                            <span class="fs-4 fw-bold text-success d-block">
                                $<?= number_format($vehiculo['precio_dia'], 2, ',', '.') ?>
                            </span>
                            <small class="text-muted">por día de alquiler</small>
                        </div>
                    </div>

                    <p class="text-muted mb-4 fs-5">
                        <?= esc($vehiculo['descripcion']) ?>
                    </p>

                    <h5 class="fw-bold border-bottom pb-2 mb-3"><i class="bi bi-gear-wide-connected text-muted me-2"></i>Especificaciones Técnicas</h5>
                    <div class="row g-3 text-center">
                        <div class="col-6 col-sm-3">
                            <div class="bg-light p-3 rounded-3 border">
                                <i class="bi bi-speedometer2 text-primary fs-3 d-block mb-1"></i>
                                <span class="small text-muted d-block">Motor</span>
                                <span class="fw-bold text-dark"><?= esc($vehiculo['motor']) ?></span>
                            </div>
                        </div>
                        <div class="col-6 col-sm-3">
                            <div class="bg-light p-3 rounded-3 border">
                                <i class="bi bi-people-fill text-primary fs-3 d-block mb-1"></i>
                                <span class="small text-muted d-block">Capacidad</span>
                                <span class="fw-bold text-dark"><?= esc($vehiculo['plazas']) ?> Plazas</span>
                            </div>
                        </div>
                        <div class="col-6 col-sm-3">
                            <div class="bg-light p-3 rounded-3 border">
                                <i class="bi bi-gauge2 text-primary fs-3 d-block mb-1"></i>
                                <span class="small text-muted d-block">Kilometraje</span>
                                <span class="fw-bold text-dark"><?= number_format($vehiculo['kilometraje'], 0, ',', '.') ?> km</span>
                            </div>
                        </div>
                        <div class="col-6 col-sm-3">
                            <div class="bg-light p-3 rounded-3 border">
                                <i class="bi bi-calendar-event text-primary fs-3 d-block mb-1"></i>
                                <span class="small text-muted d-block">Año Modelo</span>
                                <span class="fw-bold text-dark"><?= esc($vehiculo['anio']) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Derecho: Formulario de Reserva -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #1e272e 0%, #2f3640 100%); color: white;">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-calendar-check-fill text-warning display-4"></i>
                        <h3 class="fw-bold mt-2 text-warning">Reserva tu Vehículo</h3>
                        <p class="text-light text-opacity-75">Configura las fechas de tu alquiler y confirma al instante.</p>
                    </div>

                    <form action="<?= base_url('reserva/guardar') ?>" method="POST" id="bookingForm">
                        <?= csrf_field() ?>
                        
                        <input type="hidden" name="vehiculo_id" id="vehiculo_id" value="<?= $vehiculo['id'] ?>">

                        <!-- Fecha Desde -->
                        <div class="mb-4">
                            <label for="fecha_desde" class="form-label fw-bold text-warning">
                                <i class="bi bi-calendar-event me-2"></i>Fecha de Inicio
                            </label>
                            <input type="date" 
                                   class="form-control form-control-lg bg-dark text-white border-secondary" 
                                   id="fecha_desde" 
                                   name="fecha_desde" 
                                   min="<?= date('Y-m-d') ?>" 
                                   value="<?= old('fecha_desde', date('Y-m-d')) ?>" 
                                   required>
                        </div>

                        <!-- Cantidad de Días -->
                        <div class="mb-4">
                            <label for="dias" class="form-label fw-bold text-warning">
                                <i class="bi bi-clock-history me-2"></i>Cantidad de Días
                            </label>
                            <input type="number" 
                                   class="form-control form-control-lg bg-dark text-white border-secondary" 
                                   id="dias" 
                                   name="dias" 
                                   min="1" 
                                   value="<?= old('dias', 1) ?>" 
                                   required>
                        </div>

                        <!-- Resumen Interactivo en Tiempo Real -->
                        <div class="p-3 mb-4 rounded-3 bg-white bg-opacity-10 border border-light border-opacity-10">
                            <h6 class="fw-bold text-warning mb-3 border-bottom border-light border-opacity-25 pb-2">
                                <i class="bi bi-receipt me-2"></i>Resumen de Reserva
                            </h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-light text-opacity-75">Precio por día:</span>
                                <span class="fw-bold">$<?= number_format($vehiculo['precio_dia'], 2, ',', '.') ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-light text-opacity-75">Días de alquiler:</span>
                                <span id="summary-dias" class="fw-bold">1</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-light text-opacity-75">Fecha de devolución:</span>
                                <span id="summary-fecha-hasta" class="fw-bold text-info">-</span>
                            </div>
                            <hr class="my-2 border-light border-opacity-25">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-light text-opacity-75 fs-5">Monto Total:</span>
                                <span id="summary-total" class="fw-bold text-success fs-3">$0.00</span>
                            </div>
                        </div>

                        <!-- Botón Enviar -->
                        <button type="submit" class="btn btn-mycar btn-lg w-100 fw-bold py-3 text-uppercase shadow-sm border-0 mt-2">
                            <i class="bi bi-check-circle-fill me-2"></i>Confirmar Reserva
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts para cálculos en tiempo real -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const precioDia = parseFloat(<?= json_encode($vehiculo['precio_dia']) ?>);
    const inputFechaDesde = document.getElementById('fecha_desde');
    const inputDias = document.getElementById('dias');
    
    const displayDias = document.getElementById('summary-dias');
    const displayFechaHasta = document.getElementById('summary-fecha-hasta');
    const displayTotal = document.getElementById('summary-total');

    // Función para dar formato de moneda en pesos argentinos (ARS / Local)
    function formatCurrency(amount) {
        return '$' + new Intl.NumberFormat('es-AR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(amount);
    }

    // Función para calcular y renderizar el resumen
    function actualizarResumen() {
        const dias = parseInt(inputDias.value) || 0;
        const fechaDesdeVal = inputFechaDesde.value;

        // Actualizar días en el resumen
        displayDias.textContent = dias;

        // Calcular y mostrar monto total
        const total = precioDia * dias;
        displayTotal.textContent = formatCurrency(total);

        // Calcular y mostrar fecha de devolución
        if (fechaDesdeVal && dias > 0) {
            // Descomponer la fecha para evitar desfases de zona horaria en JS
            const partes = fechaDesdeVal.split('-');
            const anio = parseInt(partes[0]);
            const mes = parseInt(partes[1]) - 1;
            const dia = parseInt(partes[2]);

            const fechaObj = new Date(anio, mes, dia);
            fechaObj.setDate(fechaObj.getDate() + dias);

            // Formatear fecha a DD/MM/YYYY
            const d = String(fechaObj.getDate()).padStart(2, '0');
            const m = String(fechaObj.getMonth() + 1).padStart(2, '0');
            const y = fechaObj.getFullYear();

            displayFechaHasta.textContent = `${d}/${m}/${y}`;
        } else {
            displayFechaHasta.textContent = '-';
        }
    }

    // Listeners
    inputFechaDesde.addEventListener('input', actualizarResumen);
    inputDias.addEventListener('input', actualizarResumen);
    inputDias.addEventListener('change', function() {
        // Asegurar que el mínimo de días sea siempre 1
        if (parseInt(inputDias.value) < 1 || isNaN(parseInt(inputDias.value))) {
            inputDias.value = 1;
        }
        actualizarResumen();
    });

    // Cargar inicial
    actualizarResumen();
});
</script>

<?= $this->endSection() ?>
