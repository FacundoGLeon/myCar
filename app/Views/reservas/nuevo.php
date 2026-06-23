<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
$v = $vehiculo ?? [];
$ocupadas = $fechasOcupadas ?? '[]';
?>

<!-- Estilos de Flatpickr (El Calendario) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/airbnb.css">

<!-- Estilos Personalizados del Calendario -->
<link rel="stylesheet" href="<?= base_url('public/assets/css/nuevo.css') ?>">

<div class="row justify-content-center py-5">
    <div class="col-md-11">
        <div class="card border-0 shadow-lg overflow-hidden rounded-4">
            <div class="row g-0">
                <!-- Columna Izquierda: Resumen del Auto -->
                <div class="col-md-5 bg-light border-end">
                    <img src="<?= base_url('public/assets/img/' . $v['imagen_url']) ?>" class="img-fluid w-100"
                        style="height: 350px; object-fit: cover;" alt="Foto de <?= $v['marca'] ?>"
                        onerror="this.src='https://via.placeholder.com/600x400?text=Auto'">

                    <div class="p-4">
                        <h3 class="fw-bold mb-1" style="color: var(--primary-color);"><?= $v['marca'] ?>
                            <?= $v['modelo'] ?>
                        </h3>
                        <p class="text-muted mb-3"><i class="bi bi-tag-fill me-2"></i>Año <?= $v['anio'] ?> •
                            <?= $v['plazas'] ?> Plazas
                        </p>

                        <!-- NUEVA INFORMACIÓN DETALLADA DEL VEHÍCULO -->
                        <div class="mb-4">
                            <p class="small text-muted mb-3" style="text-align: justify; line-height: 1.6;">
                                <?= $v['descripcion'] ?>
                            </p>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge border bg-white text-dark fw-normal shadow-sm px-2 py-2">
                                    <i class="bi bi-speedometer2 text-primary me-1"></i> Motor: <?= $v['motor'] ?>
                                </span>
                                <span class="badge border bg-white text-dark fw-normal shadow-sm px-2 py-2">
                                    <i class="bi bi-signpost-split text-primary me-1"></i> Km:
                                    <?= number_format($v['kilometraje'], 0, ',', '.') ?>
                                </span>
                            </div>
                        </div>

                        <div class="bg-white p-3 rounded-3 shadow-sm border mb-3 text-center">
                            <h6 class="text-muted text-uppercase small fw-bold">Precio Unitario</h6>
                            <h3 class="fw-bold text-success mb-0" id="precio_base"
                                data-precio="<?= $v['precio_dia'] ?>">
                                $<?= number_format($v['precio_dia'], 2, ',', '.') ?> <span
                                    class="fs-6 text-muted fw-normal">/día</span>
                            </h3>
                        </div>

                        <div class="alert alert-secondary border-0 shadow-sm mt-4 text-center">
                            <i class="bi bi-info-circle me-1"></i> Las fechas <span
                                class="text-decoration-line-through text-muted fw-bold">tachadas</span> ya se encuentran
                            reservadas.
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha: El Gran Calendario -->
                <div class="col-md-7 p-4 p-lg-5">
                    <h3 class="fw-bold mb-1">Selecciona tus Fechas</h3>
                    <p class="text-muted mb-4">Haz clic en la fecha de retiro y luego en la fecha de devolución.</p>

                    <form action="<?= base_url('reserva/guardar/' . $v['id']) ?>" method="POST" id="formReserva">
                        <?= csrf_field() ?>

                        <!-- Contenedor visual del calendario -->
                        <div class="mb-4 d-flex justify-content-center">
                            <input type="hidden" name="fechas_rango" id="input_fechas_rango">
                            <div id="calendario_visual"></div>
                        </div>

                        <hr class="text-muted my-4">

                        <!-- Resumen Total Dinámico -->
                        <div class="row align-items-center bg-light p-3 rounded-3 border border-2 mb-4"
                            style="border-color: var(--primary-color) !important;">
                            <div class="col-6">
                                <h6 class="mb-0 text-muted fw-bold text-uppercase">Días seleccionados</h6>
                                <h4 class="mb-0 fw-bold" id="dias_texto">0 días</h4>
                            </div>
                            <div class="col-6 text-end border-start">
                                <h6 class="mb-0 text-muted fw-bold text-uppercase">Monto Total</h6>
                                <h2 class="mb-0 fw-bold" style="color: var(--primary-color);" id="total_dinamico">$0,00
                                </h2>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-mycar btn-lg w-100 fw-bold shadow-sm" id="btnConfirmar"
                            disabled>
                            <i class="bi bi-calendar-range me-2"></i> Selecciona las fechas arriba
                        </button>
                        <a href="<?= base_url('catalogo') ?>" class="btn btn-link w-100 text-muted mt-2">Cancelar y
                            Volver al Catálogo</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts de Flatpickr -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- Idioma Español -->
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ocupadasData = <?= $ocupadas ?>;
        const precioBase = parseFloat(document.getElementById('precio_base').getAttribute('data-precio'));
        const textoTotal = document.getElementById('total_dinamico');
        const textoDias = document.getElementById('dias_texto');
        const btnConfirmar = document.getElementById('btnConfirmar');

        // Inicializar el súper calendario atado al div contenedor
        flatpickr("#calendario_visual", {
            inline: true,
            mode: "range",
            minDate: "today",
            dateFormat: "Y-m-d", // Formato visual
            locale: "es",
            showMonths: 1,
            disable: ocupadasData,

            onChange: function (selectedDates, dateStr, instance) {
                // EXIGIMOS 2 CLICS (Inicio y Fin) para habilitar el formulario
                if (selectedDates.length === 2) {

                    // Lógica visual del Frontend (Solo para mostrarle al usuario el total, no se envía por POST)
                    const diffTime = Math.abs(selectedDates[1] - selectedDates[0]);
                    const dias = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                    let total = dias * precioBase;

                    textoDias.innerHTML = '<span class="text-success">' + dias + (dias === 1 ? " día" : " días") + '</span>';
                    textoTotal.innerText = '$' + total.toLocaleString('es-AR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

                    // Le enviamos la frase completa a nuestro PHP Blindado
                    document.getElementById('input_fechas_rango').value = dateStr;

                    btnConfirmar.disabled = false;
                    btnConfirmar.innerHTML = '<i class="bi bi-check-circle me-2"></i> Confirmar Solicitud de Reserva';
                } else {
                    // Está pendiente el día de devolución
                    document.getElementById('input_fechas_rango').value = "";

                    textoDias.innerHTML = '<span style="color: var(--secondary-color);"><i class="bi bi-hand-index-thumb"></i> Falta devolución</span>';
                    textoTotal.innerText = "$0,00";

                    btnConfirmar.disabled = true;
                    btnConfirmar.innerHTML = '<i class="bi bi-calendar-range me-2"></i> Elige día de devolución...';
                }
            }
        });
    });
</script>

<?= $this->endSection() ?>