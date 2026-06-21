<?php 
/**
 * @var \CodeIgniter\Pager\PagerRenderer $pager
 */
$pager->setSurroundCount(2) 
?>

<nav aria-label="Paginación de MyCar">
    <ul class="pagination justify-content-center mb-0">
        
        <!-- Botones de "Anterior" y "Primero" -->
        <?php if ($pager->hasPrevious()) : ?>
            <li class="page-item">
                <a class="page-link shadow-sm" href="<?= $pager->getFirst() ?>" aria-label="Primero">
                    <span aria-hidden="true"><i class="bi bi-chevron-double-left"></i></span>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link shadow-sm" href="<?= $pager->getPrevious() ?>" aria-label="Anterior">
                    <span aria-hidden="true"><i class="bi bi-chevron-left"></i></span>
                </a>
            </li>
        <?php endif ?>

        <!-- Números de Página -->
        <?php foreach ($pager->links() as $link) : ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link shadow-sm" href="<?= $link['uri'] ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <!-- Botones de "Siguiente" y "Último" -->
        <?php if ($pager->hasNext()) : ?>
            <li class="page-item">
                <a class="page-link shadow-sm" href="<?= $pager->getNext() ?>" aria-label="Siguiente">
                    <span aria-hidden="true"><i class="bi bi-chevron-right"></i></span>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link shadow-sm" href="<?= $pager->getLast() ?>" aria-label="Último">
                    <span aria-hidden="true"><i class="bi bi-chevron-double-right"></i></span>
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav>

<!-- Estilo extra para que respete tu paleta de colores en vez del azul de Bootstrap -->
<style>
    .pagination .page-link {
        color: var(--primary-color);
        border-radius: 5px;
        margin: 0 3px;
        border: 1px solid #dee2e6;
    }
    .pagination .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }
    .pagination .page-link:hover {
        background-color: #f8f9fa;
        color: var(--secondary-color);
    }
</style>