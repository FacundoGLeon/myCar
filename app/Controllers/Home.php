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

        // 1. Capturamos los filtros de la URL (?categoria=X & buscar=Y)
        $categoriaId = $this->request->getGet('categoria');
        $buscar = $this->request->getGet('buscar');

        $categorias = $categoriaModel->findAll();
        
        // 2. Armamos la consulta dinámica
        $builder = $vehiculoModel->builder();
        
        if ($categoriaId) {
            $builder->where('categoria_id', $categoriaId);
        }

        if (!empty($buscar)) {
            // Buscamos por marca o modelo
            $builder->groupStart()
                    ->like('marca', $buscar)
                    ->orLike('modelo', $buscar)
                    ->groupEnd();
        }

        $vehiculos = $vehiculoModel->findAll();

        // 3. Agrupamos los vehículos por categoría
        $catalogo = [];
        foreach ($categorias as $cat) {
            if ($categoriaId && $cat['id'] != $categoriaId) {
                continue;
            }
            $catalogo[$cat['id']] = [
                'nombre' => $cat['nombre'],
                'vehiculos' => []
            ];
        }

        foreach ($vehiculos as $vehiculo) {
            if (isset($catalogo[$vehiculo['categoria_id']])) {
                $catalogo[$vehiculo['categoria_id']]['vehiculos'][] = $vehiculo;
            }
        }

        $data = [
            'titulo'                => 'Catálogo - MyCar',
            'catalogo'              => $catalogo,
            'categorias'            => $categorias, 
            'categoriaSeleccionada' => $categoriaId,
            'buscar'                => $buscar
        ];

        return view('home', $data);
    }

    // =======================================================
    // PÁGINA SOBRE NOSOTROS
    // =======================================================
    public function sobreNosotros()
    {
        $data = [
            'titulo' => 'Sobre Nosotros - MyCar (TP2)'
        ];

        return view('sobre_nosotros', $data);
    }
}