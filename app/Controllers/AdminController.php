<?php

namespace App\Controllers;

use App\Models\VehiculoModel;
use App\Models\CategoriaModel;
use App\Controllers\BaseController;

class AdminController extends BaseController
{
    // =======================================================
    // DASHBOARD PRINCIPAL
    // =======================================================
    public function index()
    {
        $vehiculoModel  = new \App\Models\VehiculoModel();
        $clienteModel   = new \App\Models\ClienteModel();
        $alquilerModel  = new \App\Models\AlquilerModel();
        $categoriaModel = new \App\Models\CategoriaModel();

        $data = [
            'titulo'          => 'Dashboard - Admin MyCar',
            'totalVehiculos'  => $vehiculoModel->countAllResults(),
            'totalClientes'   => $clienteModel->countAllResults(),
            'totalAlquileres' => $alquilerModel->countAllResults(),
            'totalCategorias' => $categoriaModel->countAllResults(),
            
            // ¡Llamamos al método limpio del modelo!
            'ultimosMovimientos' => $alquilerModel->getUltimosMovimientos(5)
        ];

        return view('admin/dashboard', $data);
    }

    // =======================================================
    // LISTADO DE VEHÍCULOS (Con Buscador)
    // =======================================================
    public function vehiculos()
    {
        $vehiculoModel = new \App\Models\VehiculoModel();
        
        $buscar = $this->request->getGet('buscar');
        
        // ¡Encadenamos el paginate directo al método del modelo!
        $vehiculos = $vehiculoModel->getVehiculosConCategoria($buscar)->paginate(10);

        $data = [
            'titulo'    => 'Gestión de Vehículos - Admin',
            'vehiculos' => $vehiculos,
            'pager'     => $vehiculoModel->pager,
            'buscar'    => $buscar 
        ];

        return view('admin/vehiculos/index', $data);
    }

    // =======================================================
    // NUEVO VEHÍCULO
    // =======================================================
    public function nuevo()
    {
        $categoriaModel = new CategoriaModel();
        $data = [
            'titulo'     => 'Nuevo Vehículo',
            'categorias' => $categoriaModel->findAll()
        ];
        
        return view('admin/vehiculos/nuevo', $data);
    }

    // =======================================================
    // GUARDAR VEHÍCULO
    // =======================================================
    public function guardar()
    {
        $vehiculoModel = new VehiculoModel();

        // 1. Definir reglas
        $reglas = [
            'marca'        => 'required|min_length[2]',
            'modelo'       => 'required',
            'anio'         => 'required|numeric|exact_length[4]',
            'motor'        => 'required',
            'plazas'       => 'required|numeric|greater_than[0]',
            'precio_dia'   => 'required|decimal',
            'kilometraje'  => 'required|numeric',
            'descripcion'  => 'required|min_length[10]',
            'categoria_id' => 'required',
            'imagen'       => 'uploaded[imagen]|is_image[imagen]|mime_in[imagen,image/jpg,image/jpeg,image/png]|max_size[imagen,2048]',
        ];

        // 2. Definir mensajes personalizados en español
        $mensajes = [
            'marca' => ['required' => 'El campo marca es obligatorio.', 'min_length' => 'La marca debe tener al menos 2 caracteres.'],
            'modelo' => ['required' => 'El campo modelo es obligatorio.'],
            'anio' => ['required' => 'El año es obligatorio.', 'numeric' => 'El año debe ser un número.', 'exact_length' => 'El año debe tener 4 dígitos.'],
            'plazas' => ['required' => 'Indique la cantidad de plazas.', 'numeric' => 'Debe ingresar un valor numérico.', 'greater_than' => 'Debe haber al menos 1 plaza.'],
            'motor' => ['required' => 'El tipo de motor es obligatorio.'],
            'kilometraje' => ['required' => 'El kilometraje es obligatorio.', 'numeric' => 'El kilometraje debe ser numérico.'],
            'descripcion' => ['required' => 'La descripción es obligatoria.', 'min_length' => 'La descripción debe tener al menos 10 caracteres.'],
            'categoria_id' => ['required' => 'Debes seleccionar una categoría.'],
            'precio_dia' => ['required' => 'El precio por día es obligatorio.', 'decimal' => 'El precio debe ser un número válido.'],
            'imagen' => [
                'uploaded' => 'Debe seleccionar una imagen para el vehículo.',
                'is_image' => 'El archivo seleccionado no es una imagen válida.',
                'mime_in'  => 'Solo se permiten formatos JPG, JPEG y PNG.',
                'max_size' => 'La imagen es demasiado pesada (máximo 2MB).'
            ]
        ];

        // 3. Validar y redirigir
        if (!$this->validate($reglas, $mensajes)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imagen = $this->request->getFile('imagen');
        $nombreImagen = $imagen->getRandomName();
        $imagen->move(ROOTPATH . 'public/assets/img/', $nombreImagen);

        $datos = [
            'marca'        => $this->request->getPost('marca'),
            'modelo'       => $this->request->getPost('modelo'),
            'anio'         => $this->request->getPost('anio'),
            'motor'        => $this->request->getPost('motor'),
            'plazas'       => $this->request->getPost('plazas'),
            'precio_dia'   => $this->request->getPost('precio_dia'),
            'categoria_id' => $this->request->getPost('categoria_id'),
            'kilometraje'  => $this->request->getPost('kilometraje'),
            'descripcion'  => $this->request->getPost('descripcion'),
            'imagen_url'   => $nombreImagen 
        ];

        if ($vehiculoModel->save($datos)) {
            return redirect()->to('/admin/vehiculos')->with('mensaje', 'Vehículo guardado exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Ocurrió un error al guardar en la base de datos.');
        }
    }

    // =======================================================
    // ELIMINAR VEHÍCULO (Baja Lógica)
    // =======================================================
    public function eliminar($id = null)
    {
        $vehiculoModel = new VehiculoModel();

        $vehiculo = $vehiculoModel->find($id);
        
        if (!$vehiculo) {
            return redirect()->to('/admin/vehiculos')->with('error', 'El vehículo no existe o ya fue eliminado.');
        }

        $vehiculoModel->delete($id);

        return redirect()->to('/admin/vehiculos')->with('mensaje', 'Vehículo eliminado correctamente.');
    }

    // =======================================================
    // EDITAR VEHÍCULO
    // =======================================================
    public function editar($id = null)
    {
        $vehiculoModel = new VehiculoModel();
        
        $vehiculo = $vehiculoModel->find($id);
        
        if (!$vehiculo) {
            return redirect()->to('/admin/vehiculos')->with('error', 'El vehículo que intentas editar no existe.');
        }

        $data = [
            'titulo'     => 'Editar Vehículo - MyCar',
            'vehiculo'   => $vehiculo
        ];
        
        return view('admin/vehiculos/editar', $data);
    }

    // =======================================================
    // ACTUALIZAR VEHÍCULO
    // =======================================================
    public function actualizar($id = null)
    {
        $vehiculoModel = new VehiculoModel();

        $reglas = [
            'marca'        => 'required|min_length[2]',
            'modelo'       => 'required',
            'anio'         => 'required|numeric|exact_length[4]',
            'motor'        => 'required',
            'plazas'       => 'required|numeric|greater_than[0]',
            'precio_dia'   => 'required|decimal',
            'kilometraje'  => 'required|numeric',
            'descripcion'  => 'required|min_length[10]',
            'imagen'       => 'is_image[imagen]|mime_in[imagen,image/jpg,image/jpeg,image/png]|max_size[imagen,2048]',
        ];

        $mensajes = [
            'marca' => ['required' => 'El campo marca es obligatorio.', 'min_length' => 'Mínimo 2 caracteres.'],
            'modelo' => ['required' => 'El campo modelo es obligatorio.'],
            'anio' => ['required' => 'El año es obligatorio.', 'numeric' => 'Debe ser numérico.', 'exact_length' => 'Debe tener 4 dígitos.'],
            'plazas' => ['required' => 'Indique la cantidad de plazas.', 'numeric' => 'Valor numérico.', 'greater_than' => 'Mínimo 1 plaza.'],
            'motor' => ['required' => 'El motor es obligatorio.'],
            'kilometraje' => ['required' => 'El kilometraje es obligatorio.', 'numeric' => 'Debe ser numérico.'],
            'descripcion' => ['required' => 'La descripción es obligatoria.', 'min_length' => 'Mínimo 10 caracteres.'],
            'precio_dia' => ['required' => 'El precio es obligatorio.', 'decimal' => 'Debe ser un número válido.'],
            'imagen' => [
                'is_image' => 'El archivo seleccionado no es una imagen válida.',
                'mime_in'  => 'Solo se permiten formatos JPG, JPEG y PNG.',
                'max_size' => 'La imagen es demasiado pesada (máximo 2MB).'
            ]
        ];

        if (!$this->validate($reglas, $mensajes)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $datos = [
            'marca'        => $this->request->getPost('marca'),
            'modelo'       => $this->request->getPost('modelo'),
            'anio'         => $this->request->getPost('anio'),
            'motor'        => $this->request->getPost('motor'),
            'plazas'       => $this->request->getPost('plazas'),
            'precio_dia'   => $this->request->getPost('precio_dia'),
            'kilometraje'  => $this->request->getPost('kilometraje'),
            'descripcion'  => $this->request->getPost('descripcion')
        ];

        $imagen = $this->request->getFile('imagen');
        if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
            $nombreImagen = $imagen->getRandomName();
            $imagen->move(ROOTPATH . 'public/assets/img/', $nombreImagen);
            $datos['imagen_url'] = $nombreImagen; 
        }

        if ($vehiculoModel->update($id, $datos)) {
            return redirect()->to('/admin/vehiculos')->with('mensaje', 'Vehículo actualizado exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Ocurrió un error al actualizar la base de datos.');
        }
    }
}