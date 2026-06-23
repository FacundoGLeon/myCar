<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\UsuarioModel;
use App\Controllers\BaseController;

class ClientesController extends BaseController
{
    public function index()
    {
        $clienteModel = new ClienteModel();
        $buscar = $this->request->getGet('buscar');
        
        // ¡Mira qué limpio queda esto ahora!
        $clientes = $clienteModel->getClientesConEmail($buscar)->paginate(10);

        $data = [
            'titulo'   => 'Gestión de Clientes - Admin MyCar',
            'clientes' => $clientes,
            'pager'    => $clienteModel->pager,
            'buscar'   => $buscar
        ];

        return view('admin/clientes/index', $data);
    }

    public function editar($id = null)
    {
        $clienteModel = new ClienteModel();
        
        // ¡Usamos nuestro método personalizado!
        $cliente = $clienteModel->getClienteConEmail($id);
        
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
        $alquilerModel = new \App\Models\AlquilerModel();
        
        // 1. Verificamos si existe
        $cliente = $clienteModel->find($id);
        if (!$cliente) {
            return redirect()->to('/admin/clientes')->with('error', 'El cliente no existe.');
        }

        // 2. REGLA DE NEGOCIO EN EL MODELO: ¿Tiene autos en su poder o reservas pendientes?
        if ($alquilerModel->checkClienteEnUso($id)) {
            return redirect()->to('/admin/clientes')->with('error', '¡Alto! No puedes dar de baja a este cliente porque actualmente tiene un vehículo alquilado o reservas pendientes.');
        }

        // 3. Si pasó la validación, damos de baja lógicamente a las dos tablas
        $clienteModel->delete($id);
        $usuarioModel->delete($cliente['usuario_id']);

        return redirect()->to('/admin/clientes')->with('mensaje', 'Cliente dado de baja correctamente.');
    }
}