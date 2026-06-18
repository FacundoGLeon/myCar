<?php

namespace App\Controllers;

use App\Models\VehiculoModel;
use App\Models\CategoriaModel;

class Home extends BaseController
{
    public function index()
    {
        $vehiculoModel = new VehiculoModel();
        $categoriaModel = new CategoriaModel();

        // 1. Capturamos si el usuario hizo clic en algún filtro de categoría de la URL (?categoria=X)
        $categoriaId = $this->request->getGet('categoria');

        // 2. Obtenemos TODAS las categorías para poder dibujar los botones en la vista
        $categorias = $categoriaModel->findAll();
        
        // 3. Optimizamos la búsqueda: Si hay filtro, buscamos solo esos. Si no, traemos todos.
        if ($categoriaId) {
            $vehiculos = $vehiculoModel->where('categoria_id', $categoriaId)->findAll();
        } else {
            $vehiculos = $vehiculoModel->findAll();
        }

        // Agrupamos los vehículos por categoría para mandarlos ordenados a la vista
        $catalogo = [];
        foreach ($categorias as $cat) {
            // Si el usuario filtró una categoría y esta no es, la saltamos para no dibujarla vacía
            if ($categoriaId && $cat['id'] != $categoriaId) {
                continue;
            }
            $catalogo[$cat['id']] = [
                'nombre' => $cat['nombre'],
                'vehiculos' => []
            ];
        }

        // Asignamos cada vehículo a su categoría correspondiente
        foreach ($vehiculos as $vehiculo) {
            if (isset($catalogo[$vehiculo['categoria_id']])) {
                $catalogo[$vehiculo['categoria_id']]['vehiculos'][] = $vehiculo;
            }
        }

        $data = [
            'titulo' => 'Catálogo - MyCar',
            'catalogo' => $catalogo,
            'categorias' => $categorias, 
            'categoriaSeleccionada' => $categoriaId // Para pintar el botón seleccionado en la vista
        ];

        return view('home', $data);
    }
}