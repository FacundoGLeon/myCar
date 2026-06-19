<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Controllers\BaseController;

class CategoriasController extends BaseController
{
    // =======================================================
    // LISTADO DE CATEGORÍAS
    // =======================================================
    public function index()
    {
        $categoriaModel = new CategoriaModel();
        
        $data = [
            'titulo'     => 'Gestión de Categorías - Admin',
            'categorias' => $categoriaModel->paginate(10),
            'pager'      => $categoriaModel->pager
        ];

        return view('admin/categorias/index', $data);
    }

    // =======================================================
    // FORMULARIO NUEVA CATEGORÍA
    // =======================================================
    public function nuevo()
    {
        $data = [
            'titulo' => 'Nueva Categoría'
        ];
        
        return view('admin/categorias/nuevo', $data);
    }

    // =======================================================
    // GUARDAR CATEGORÍA
    // =======================================================
    public function guardar()
    {
        $categoriaModel = new CategoriaModel();

        $reglas = [
            'nombre'      => 'required|min_length[3]|is_unique[categorias.nombre]'
        ];

        $mensajes = [
            'nombre' => [
                'required'   => 'El nombre de la categoría es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                'is_unique'  => 'Esta categoría ya existe en la base de datos.'
            ]
        ];

        if (!$this->validate($reglas, $mensajes)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $datos = [
            'nombre'      => $this->request->getPost('nombre')
        ];

        if ($categoriaModel->save($datos)) {
            return redirect()->to('/admin/categorias')->with('mensaje', 'Categoría guardada exitosamente.');
        }

        return redirect()->back()->withInput()->with('error', 'Error al guardar la categoría.');
    }

    // =======================================================
    // FORMULARIO EDITAR CATEGORÍA
    // =======================================================
    public function editar($id = null)
    {
        $categoriaModel = new CategoriaModel();
        $categoria = $categoriaModel->find($id);
        
        if (!$categoria) {
            return redirect()->to('/admin/categorias')->with('error', 'La categoría no existe.');
        }

        $data = [
            'titulo'    => 'Editar Categoría',
            'categoria' => $categoria
        ];
        
        return view('admin/categorias/editar', $data);
    }

    // =======================================================
    // ACTUALIZAR CATEGORÍA
    // =======================================================
    public function actualizar($id = null)
    {
        $categoriaModel = new CategoriaModel();

        // Validamos is_unique exceptuando el ID actual para no dar error si no cambia el nombre
        $reglas = [
            'nombre'      => "required|min_length[3]|is_unique[categorias.nombre,id,{$id}]"
        ];

        $mensajes = [
            'nombre' => [
                'required'   => 'El nombre de la categoría es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                'is_unique'  => 'Ya existe otra categoría con ese nombre.'
            ]
        ];

        if (!$this->validate($reglas, $mensajes)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $datos = [
            'nombre'      => $this->request->getPost('nombre')
        ];

        if ($categoriaModel->update($id, $datos)) {
            return redirect()->to('/admin/categorias')->with('mensaje', 'Categoría actualizada exitosamente.');
        }

        return redirect()->back()->withInput()->with('error', 'Error al actualizar la categoría.');
    }

    // =======================================================
    // ELIMINAR CATEGORÍA (Baja lógica)
    // =======================================================
    public function eliminar($id = null)
    {
        $categoriaModel = new CategoriaModel();
        
        if (!$categoriaModel->find($id)) {
            return redirect()->to('/admin/categorias')->with('error', 'La categoría no existe.');
        }

        $categoriaModel->delete($id);
        return redirect()->to('/admin/categorias')->with('mensaje', 'Categoría eliminada correctamente.');
    }
}