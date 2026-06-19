<?php

namespace App\Controllers;

use App\Models\VehiculoModel;
use App\Models\CategoriaModel;
use App\Controllers\BaseController;

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
        
        $vehiculos = $vehiculoModel->select('vehiculos.*, categorias.nombre as categoria_nombre')
                                   ->join('categorias', 'categorias.id = vehiculos.categoria_id')
                                   ->paginate(10);

        $data = [
            'titulo'    => 'Gestión de Vehículos - Admin MyCar',
            'vehiculos' => $vehiculos,
            'pager'     => $vehiculoModel->pager
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
            'marca' => [
                'required'   => 'El campo marca es obligatorio.',
                'min_length' => 'La marca debe tener al menos 2 caracteres.'
            ],
            'modelo' => [
                'required'   => 'El campo modelo es obligatorio.'
            ],
            'anio' => [
                'required'     => 'El año es obligatorio.',
                'numeric'      => 'El año debe ser un número.',
                'exact_length' => 'El año debe tener 4 dígitos.'
            ],
            'plazas' => [
                'required'     => 'Indique la cantidad de plazas.',
                'numeric'      => 'Debe ingresar un valor numérico.',
                'greater_than' => 'Debe haber al menos 1 plaza.'
            ],
            'motor' => [
                'required' => 'El tipo de motor es obligatorio.'
            ],
            'kilometraje' => [
                'required' => 'El kilometraje es obligatorio.',
                'numeric'  => 'El kilometraje debe ser numérico.'
            ],
            'descripcion' => [
                'required'   => 'La descripción es obligatoria.',
                'min_length' => 'La descripción debe tener al menos 10 caracteres.'
            ],
            'categoria_id' => [
                'required' => 'Debes seleccionar una categoría.'
            ],
            'precio_dia' => [
                'required' => 'El precio por día es obligatorio.',
                'decimal'  => 'El precio debe ser un número válido.'
            ],
            'imagen' => [
                'uploaded' => 'Debe seleccionar una imagen para el vehículo.',
                'is_image' => 'El archivo seleccionado no es una imagen válida.',
                'mime_in'  => 'Solo se permiten formatos JPG, JPEG y PNG.',
                'max_size' => 'La imagen es demasiado pesada (máximo 2MB).'
            ]
        ];

        // 3. Validar y redirigir SOLO LOS ERRORES en un arreglo puro (getErrors)
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

        // Verificamos si el vehículo existe antes de intentar borrar
        $vehiculo = $vehiculoModel->find($id);
        
        if (!$vehiculo) {
            return redirect()->to('/admin/vehiculos')->with('error', 'El vehículo no existe o ya fue eliminado.');
        }

        // Ejecutamos la baja lógica. CodeIgniter automáticamente pondrá la fecha en 'deleted_at'
        $vehiculoModel->delete($id);

        return redirect()->to('/admin/vehiculos')->with('mensaje', 'Vehículo eliminado correctamente.');
    }

    // =======================================================
    // EDITAR VEHÍCULO (Cargar Formulario)
    // =======================================================
    public function editar($id = null)
    {
        $vehiculoModel = new VehiculoModel();
        $categoriaModel = new CategoriaModel();

        // Buscamos el auto en la BD
        $vehiculo = $vehiculoModel->find($id);
        
        if (!$vehiculo) {
            return redirect()->to('/admin/vehiculos')->with('error', 'El vehículo que intentas editar no existe.');
        }

        $data = [
            'titulo'     => 'Editar Vehículo - MyCar',
            'vehiculo'   => $vehiculo,
            'categorias' => $categoriaModel->findAll()
        ];
        
        return view('admin/vehiculos/editar', $data);
    }

    // =======================================================
    // ACTUALIZAR VEHÍCULO (Guardar Cambios)
    // =======================================================
    public function actualizar($id = null)
    {
        $vehiculoModel = new VehiculoModel();

        // 1. Definir reglas (Notarás que 'imagen' ya no tiene la regla 'uploaded')
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
            'imagen'       => 'is_image[imagen]|mime_in[imagen,image/jpg,image/jpeg,image/png]|max_size[imagen,2048]',
        ];

        // 2. Mensajes (Quitamos el mensaje de "uploaded" para la imagen)
        $mensajes = [
            'marca' => ['required' => 'El campo marca es obligatorio.', 'min_length' => 'Mínimo 2 caracteres.'],
            'modelo' => ['required' => 'El campo modelo es obligatorio.'],
            'anio' => ['required' => 'El año es obligatorio.', 'numeric' => 'Debe ser numérico.', 'exact_length' => 'Debe tener 4 dígitos.'],
            'plazas' => ['required' => 'Indique la cantidad de plazas.', 'numeric' => 'Valor numérico.', 'greater_than' => 'Mínimo 1 plaza.'],
            'motor' => ['required' => 'El motor es obligatorio.'],
            'kilometraje' => ['required' => 'El kilometraje es obligatorio.', 'numeric' => 'Debe ser numérico.'],
            'descripcion' => ['required' => 'La descripción es obligatoria.', 'min_length' => 'Mínimo 10 caracteres.'],
            'categoria_id' => ['required' => 'Debes seleccionar una categoría.'],
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

        // Recuperamos los datos de texto
        $datos = [
            'marca'        => $this->request->getPost('marca'),
            'modelo'       => $this->request->getPost('modelo'),
            'anio'         => $this->request->getPost('anio'),
            'motor'        => $this->request->getPost('motor'),
            'plazas'       => $this->request->getPost('plazas'),
            'precio_dia'   => $this->request->getPost('precio_dia'),
            'categoria_id' => $this->request->getPost('categoria_id'),
            'kilometraje'  => $this->request->getPost('kilometraje'),
            'descripcion'  => $this->request->getPost('descripcion')
        ];

        // 3. Procesar imagen SOLO si el usuario seleccionó una nueva
        $imagen = $this->request->getFile('imagen');
        if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
            $nombreImagen = $imagen->getRandomName();
            $imagen->move(ROOTPATH . 'public/assets/img/', $nombreImagen);
            $datos['imagen_url'] = $nombreImagen; 
        }

        // 4. Actualizar usando el método 'update'
        if ($vehiculoModel->update($id, $datos)) {
            return redirect()->to('/admin/vehiculos')->with('mensaje', 'Vehículo actualizado exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Ocurrió un error al actualizar la base de datos.');
        }
    }
}