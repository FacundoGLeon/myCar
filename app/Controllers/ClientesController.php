<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\UsuarioModel;
use App\Controllers\BaseController;

class ClientesController extends BaseController
{
    // =======================================================
    // LISTADO DE CLIENTES (Con Buscador)
    // =======================================================
    public function index()
    {
        $clienteModel = new ClienteModel();
        
        $builder = $clienteModel->select('clientes.*, usuarios.email')
                                ->join('usuarios', 'usuarios.id = clientes.usuario_id');

        // Capturamos la palabra a buscar
        $buscar = $this->request->getGet('buscar');
        
        if (!empty($buscar)) {
            // Usamos groupStart para que los OR no rompan otras condiciones (como el deleted_at)
            $builder->groupStart()
                    ->like('clientes.nombre', $buscar)
                    ->orLike('clientes.apellido', $buscar)
                    ->orLike('clientes.telefono', $buscar)
                    ->orLike('usuarios.email', $buscar)
                    ->groupEnd();
        }

        $clientes = $builder->paginate(10);

        $data = [
            'titulo'   => 'Gestión de Clientes - Admin MyCar',
            'clientes' => $clientes,
            'pager'    => $clienteModel->pager,
            'buscar'   => $buscar // Para mantener el texto en el input
        ];

        return view('admin/clientes/index', $data);
    }

    // =======================================================
    // FORMULARIO EDITAR CLIENTE
    // =======================================================
    public function editar($id = null)
    {
        $clienteModel = new ClienteModel();
        
        // Buscamos al cliente y también traemos su email
        $cliente = $clienteModel->select('clientes.*, usuarios.email')
                                ->join('usuarios', 'usuarios.id = clientes.usuario_id')
                                ->where('clientes.id', $id)
                                ->first();
        
        if (!$cliente) {
            return redirect()->to('/admin/clientes')->with('error', 'El cliente no existe.');
        }

        $data = [
            'titulo'  => 'Editar Cliente',
            'cliente' => $cliente
        ];
        
        return view('admin/clientes/editar', $data);
    }

    // =======================================================
    // ACTUALIZAR CLIENTE
    // =======================================================
    public function actualizar($id = null)
    {
        $clienteModel = new ClienteModel();

        $reglas = [
            'nombre'    => 'required|min_length[2]',
            'apellido'  => 'required|min_length[2]',
            'telefono'  => 'required|min_length[6]',
            'direccion' => 'required'
        ];

        $mensajes = [
            'nombre'    => ['required' => 'El nombre es obligatorio.', 'min_length' => 'Mínimo 2 caracteres.'],
            'apellido'  => ['required' => 'El apellido es obligatorio.', 'min_length' => 'Mínimo 2 caracteres.'],
            'telefono'  => ['required' => 'El teléfono es obligatorio.', 'min_length' => 'Teléfono muy corto.'],
            'direccion' => ['required' => 'La dirección es obligatoria.']
        ];

        if (!$this->validate($reglas, $mensajes)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $datos = [
            'nombre'    => $this->request->getPost('nombre'),
            'apellido'  => $this->request->getPost('apellido'),
            'telefono'  => $this->request->getPost('telefono'),
            'direccion' => $this->request->getPost('direccion')
        ];

        if ($clienteModel->update($id, $datos)) {
            return redirect()->to('/admin/clientes')->with('mensaje', 'Datos del cliente actualizados.');
        }

        return redirect()->back()->withInput()->with('error', 'Error al actualizar el cliente.');
    }

    // =======================================================
    // ELIMINAR CLIENTE (Baja lógica en ambas tablas)
    // =======================================================
    public function eliminar($id = null)
    {
        $clienteModel = new ClienteModel();
        $usuarioModel = new UsuarioModel();
        
        $cliente = $clienteModel->find($id);
        
        if (!$cliente) {
            return redirect()->to('/admin/clientes')->with('error', 'El cliente no existe.');
        }

        // Primero borramos al cliente (baja lógica)
        $clienteModel->delete($id);
        
        // Luego borramos a su usuario asociado para que no pueda loguearse más
        $usuarioModel->delete($cliente['usuario_id']);

        return redirect()->to('/admin/clientes')->with('mensaje', 'Cliente dado de baja correctamente.');
    }
}