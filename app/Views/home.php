<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php 
$categoriaSeleccionada = $categoriaSeleccionada ?? null; 
$buscar = $buscar ?? '';
$categorias = $categorias ?? [];
$catalogo = $catalogo ?? [];
?>

<style>
    /* Estilos personalizados para los botones de categorías */
    .btn-categoria {
        border: 1px solid var(--primary-color);
        color: var(--primary-color);
        background-color: transparent;
        font-weight: 500;
        transition: all 0.2s ease-in-out;
    }
    .btn-categoria:hover {
        background-color: rgba(44, 62, 80, 0.1); /* Sutil fondo grisáceo-azulado */
        color: var(--primary-color);
    }
    .btn-categoria.active {
        background-color: var(--primary-color);
        color: #ffffff;
        border-color: var(--primary-color);
        box-shadow: 0 4px 6px rgba(44, 62, 80, 0.2);
    }

    /* Estilo para el botón Buscar combinando con tu Navbar */
    .btn-buscar {
        background-color: var(--primary-color);
        color: white;
        border: 1px solid var(--primary-color);
        transition: all 0.2s ease;
    }
    .btn-buscar:hover {
        background-color: #1a252f; /* Un tono más oscuro para el hover */
        border-color: #1a252f;
        color: white;
    }
</style>

<!-- Banner de Bienvenida -->
<div class="p-5 mb-4 bg-light rounded-3 shadow-sm border" style="background: linear-gradient(to right, #2c3e50, #4ca1af); color: white;">
    <div class="container-fluid py-3">
        <h1 class="display-5 fw-bold"><i class="bi bi-car-front-fill"></i> Bienvenido a MyCar</h1>
        <p class="col-md-8 fs-4">La mejor flota de vehículos deportivos y de lujo listos para tu próxima aventura.</p>
        <?php if(!session()->get('isLoggedIn')): ?>
            <a href="<?= base_url('registro') ?>" class="btn btn-mycar btn-lg fw-bold">Regístrate para Alquilar</a>
        <?php endif; ?>
    </div>
</div>

<!-- BARRA DE BÚSQUEDA Y FILTROS -->
<div class="card border-0 shadow-sm rounded-3 mb-5 p-3">
    <form action="<?= base_url('catalogo') ?>" method="GET">
        <div class="row g-2 align-items-center">
            
            <!-- Buscador de Texto -->
            <div class="col-md-6">
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="buscar" class="form-control border-start-0" placeholder="Buscar por marca o modelo..." value="<?= esc($buscar) ?>">
                    <!-- Mantenemos la categoría si ya estaba filtrada -->
                    <?php if($categoriaSeleccionada): ?>
                        <input type="hidden" name="categoria" value="<?= $categoriaSeleccionada ?>">
                    <?php endif; ?>
                    <!-- Usamos nuestra nueva clase btn-buscar -->
                    <button class="btn btn-buscar px-4 fw-bold" type="submit">Buscar</button>
                </div>
            </div>

            <!-- Botones de Categorías -->
            <div class="col-md-6 text-md-end text-center mt-3 mt-md-0">
                <!-- Dropdown para versión móvil -->
                <div class="dropdown d-inline-block d-md-none w-100">
                    <button class="btn btn-outline-secondary w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Filtrar por Categoría
                    </button>
                    <ul class="dropdown-menu w-100">
                        <li><a class="dropdown-item" href="<?= base_url('catalogo' . ($buscar ? '?buscar='.$buscar : '')) ?>">Todas las Marcas</a></li>
                        <?php foreach ($categorias as $cat): ?>
                            <li><a class="dropdown-item" href="<?= base_url('catalogo?categoria=' . $cat['id'] . ($buscar ? '&buscar='.$buscar : '')) ?>"><?= $cat['nombre'] ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <!-- Botones en versión escritorio -->
                <div class="d-none d-md-block">
                    <!-- Todos -->
                    <a href="<?= base_url('catalogo' . ($buscar ? '?buscar='.$buscar : '')) ?>" 
                       class="btn btn-categoria btn-sm rounded-pill px-3 mb-1 <?= empty($categoriaSeleccionada) ? 'active' : '' ?>">
                        Todos
                    </a>
                    <!-- Categorías Dinámicas -->
                    <?php foreach ($categorias as $cat): ?>
                        <a href="<?= base_url('catalogo?categoria=' . $cat['id'] . ($buscar ? '&buscar='.$buscar : '')) ?>" 
                           class="btn btn-categoria btn-sm rounded-pill px-3 mb-1 <?= ($categoriaSeleccionada == $cat['id']) ? 'active' : '' ?>">
                            <?= $cat['nombre'] ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            
        </div>
    </form>
</div>

<!-- Catálogo de Vehículos Agrupados por Categoría -->
<h2 class="mb-4 text-muted border-bottom pb-2">Nuestra Flota Disponible</h2>

<?php 
$encontroAutos = false;
foreach ($catalogo as $categoria): 
?>
    <?php if (count($categoria['vehiculos']) > 0): 
        $encontroAutos = true;
    ?>
        <h4 class="mt-4 mb-3 fw-bold text-uppercase" style="color: var(--primary-color);">
            <?= $categoria['nombre'] ?>
        </h4>
        
        <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
            <?php foreach ($categoria['vehiculos'] as $v): ?>
                <div class="col">
                    <div class="card card-vehiculo h-100">
                        <img src="<?= base_url('public/assets/img/' . $v['imagen_url']) ?>" 
                             loading="lazy" 
                             class="card-img-top" 
                             alt="<?= $v['marca'] . ' ' . $v['modelo'] ?>" 
                             style="height: 200px; object-fit: cover;"
                             onerror="this.src='https://via.placeholder.com/400x250?text=Foto+No+Disponible'">
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold"><?= $v['marca'] ?> <?= $v['modelo'] ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Año <?= $v['anio'] ?> • <?= $v['plazas'] ?> Plazas</h6>
                            <p class="card-text small text-muted flex-grow-1">
                                <?= substr($v['descripcion'], 0, 80) ?>...
                            </p>
                            
                            <ul class="list-group list-group-flush mb-3">
                                <li class="list-group-item px-0"><i class="bi bi-speedometer2"></i> Motor: <?= $v['motor'] ?></li>
                                <li class="list-group-item px-0 fw-bold text-success fs-5">
                                    $<?= number_format($v['precio_dia'], 2, ',', '.') ?> <small class="text-muted fs-6">/ día</small>
                                </li>
                            </ul>
                            
                            <?php if(session()->get('rol') == 'admin'): ?>
                                <a href="#" class="btn btn-outline-secondary disabled w-100">Eres Administrador</a>
                            <?php else: ?>
                                <a href="<?= base_url('reserva/nuevo/' . $v['id']) ?>" class="btn btn-mycar w-100 fw-bold">
                                    <i class="bi bi-calendar-check"></i> Reservar Ahora
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

<?php if (!$encontroAutos): ?>
    <div class="alert alert-warning text-center mt-5 p-5 border-0 shadow-sm rounded-4">
        <i class="bi bi-search fs-1 d-block mb-3 text-muted"></i>
        <h4 class="fw-bold">No se encontraron vehículos</h4>
        <p class="text-muted mb-0">Prueba buscando con otros términos o seleccionando otra categoría.</p>
        <?php if(!empty($buscar) || !empty($categoriaSeleccionada)): ?>
            <a href="<?= base_url('catalogo') ?>" class="btn btn-primary mt-3 rounded-pill px-4">Ver toda la flota</a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>