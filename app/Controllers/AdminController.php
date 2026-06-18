<?php

namespace App\Controllers;

use App\Models\VehiculoModel;
use App\Models\CategoriaModel;

class AdminController extends BaseController
{
    public function index()
    {
        $data = [
            'titulo' => 'Panel de Control - MyCar'
        ];
        
        return view('admin/dashboard', $data);
    }

    // =======================================================
    // GESTIÓN DE VEHÍCULOS
    // =======================================================
    public function vehiculos()
    {
        $vehiculoModel = new VehiculoModel();
        
        // Hacemos un join manual con la tabla categorías para traer el "nombre" de la categoría y no solo el número (ID)
        // El 'vehiculos.*' trae todos los campos del auto, y 'categorias.nombre as categoria_nombre' trae la marca.
        $vehiculos = $vehiculoModel->select('vehiculos.*, categorias.nombre as categoria_nombre')
                                   ->join('categorias', 'categorias.id = vehiculos.categoria_id')
                                   ->paginate(10); // Trae 10 registros por página

        $data = [
            'titulo'    => 'Gestión de Vehículos - Admin MyCar',
            'vehiculos' => $vehiculos,
            'pager'     => $vehiculoModel->pager // Esto es lo que crea los botones (Anterior/Siguiente)
        ];

        return view('admin/vehiculos/index', $data);
    }

    public function nuevo()
    {
        $categoriaModel = new CategoriaModel();
        $data = [
            'titulo'     => 'Nuevo Vehículo',
            'categorias' => $categoriaModel->findAll()
        ];
        
        return view('admin/vehiculos/nuevo', $data);
    }

    public function guardar()
    {
        $vehiculoModel = new VehiculoModel();
        
        // 1. Capturar el archivo
        $imagen = $this->request->getFile('imagen');
        $nombreImagen = 'default.jpg'; // Valor por defecto

        // 2. Validar si se subió correctamente
        if ($imagen->isValid() && !$imagen->hasMoved()) {
            // Generar un nombre único para evitar que se pisen los archivos
            $nombreImagen = $imagen->getRandomName();
            // Mover a public/assets/img/
            $imagen->move(ROOTPATH . 'public/assets/img/', $nombreImagen);
        }

        // 3. Preparar los datos incluyendo el nombre del archivo
        $datos = [
            'marca'        => $this->request->getPost('marca'),
            'modelo'       => $this->request->getPost('modelo'),
            'anio'         => $this->request->getPost('anio'),
            'motor'        => $this->request->getPost('motor'),
            'plazas'       => $this->request->getPost('plazas'),
            'precio_dia'   => $this->request->getPost('precio_dia'),
            'categoria_id' => $this->request->getPost('categoria_id'),
            'imagen_url'   => $nombreImagen 
        ];

        if ($vehiculoModel->save($datos)) {
            return redirect()->to('/admin/vehiculos')->with('mensaje', 'Vehículo y foto subidos con éxito.');
        } else {
            return redirect()->back()->with('error', 'Error al guardar.');
        }
    }
}