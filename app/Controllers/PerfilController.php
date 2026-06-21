<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\UsuarioModel;
use App\Controllers\BaseController;

class PerfilController extends BaseController
{
    public function index()
    {
        // 1. Verificar que sea un cliente logueado
        if (!session()->get('isLoggedIn') || session()->get('rol') !== 'cliente') {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión para ver tu perfil.');
        }

        $clienteModel = new ClienteModel();
        $usuarioModel = new UsuarioModel();
        
        $usuarioId = session()->get('usuario_id');

        // 2. Traer los datos de ambas tablas
        $cliente = $clienteModel->where('usuario_id', $usuarioId)->first();
        $usuario = $usuarioModel->find($usuarioId);

        if (!$cliente || !$usuario) {
            return redirect()->to('/')->with('error', 'No se encontró la información del perfil.');
        }

        $data = [
            'titulo'  => 'Mi Perfil - MyCar',
            'cliente' => $cliente,
            'usuario' => $usuario
        ];

        return view('perfil/index', $data);
    }

    public function actualizar()
    {
        if (!session()->get('isLoggedIn') || session()->get('rol') !== 'cliente') {
            return redirect()->to('/login');
        }

        $clienteModel = new ClienteModel();
        $usuarioModel = new UsuarioModel();
        
        $usuarioId = session()->get('usuario_id');
        $cliente = $clienteModel->where('usuario_id', $usuarioId)->first();

        // 1. Reglas de Validación Básicas (Datos Personales)
        $reglas = [
            'nombre'    => 'required|min_length[3]',
            'apellido'  => 'required|min_length[3]',
            'telefono'  => 'required|min_length[6]|numeric',
            'direccion' => 'required'
        ];

        $mensajes = [
            'nombre'    => ['required' => 'El nombre es obligatorio.', 'min_length' => 'Mínimo 3 caracteres.'],
            'apellido'  => ['required' => 'El apellido es obligatorio.', 'min_length' => 'Mínimo 3 caracteres.'],
            'telefono'  => ['required' => 'El teléfono es obligatorio.', 'numeric' => 'Solo números.', 'min_length' => 'Teléfono muy corto.'],
            'direccion' => ['required' => 'La dirección es obligatoria.']
        ];

        // 2. Si el usuario escribió algo en "Nueva Contraseña", le agregamos reglas estrictas
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $reglas['password'] = 'min_length[6]';
            $reglas['password_confirm'] = 'matches[password]';
            
            $mensajes['password'] = ['min_length' => 'La nueva contraseña debe tener mínimo 6 caracteres.'];
            $mensajes['password_confirm'] = ['matches' => 'Las contraseñas no coinciden.'];
        }

        // Ejecutar validación
        if (!$this->validate($reglas, $mensajes)) {
            return redirect()->back()->withInput()->with('errores', $this->validator->getErrors());
        }

        // 3. Actualizar Datos Personales en tabla CLIENTES
        $datosCliente = [
            'nombre'    => $this->request->getPost('nombre'),
            'apellido'  => $this->request->getPost('apellido'),
            'telefono'  => $this->request->getPost('telefono'),
            'direccion' => $this->request->getPost('direccion')
        ];
        $clienteModel->update($cliente['id'], $datosCliente);

        // 4. Actualizar Contraseña en tabla USUARIOS (Solo si escribió una nueva)
        if (!empty($password)) {
            $usuarioModel->update($usuarioId, [
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ]);
        }

        return redirect()->to('/perfil')->with('mensaje', '¡Tu perfil se ha actualizado correctamente!');
    }
}