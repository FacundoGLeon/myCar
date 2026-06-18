<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\ClienteModel;

class Auth extends BaseController
{
    // =======================================================
    // LOGIN
    // =======================================================
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        $data['titulo'] = 'Iniciar Sesión - MyCar';
        return view('auth/login', $data);
    }

    public function procesarLogin()
    {
        $session = session();
        $usuarioModel = new UsuarioModel();
        
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        $usuario = $usuarioModel->where('email', $email)->first();
        
        if ($usuario && password_verify($password, $usuario['password'])) {
            $sesData = [
                'usuario_id' => $usuario['id'],
                'email'      => $usuario['email'],
                'rol'        => $usuario['rol'],
                'isLoggedIn' => true
            ];
            $session->set($sesData);
            
            if ($usuario['rol'] == 'admin') {
                return redirect()->to('/admin/dashboard')->with('mensaje', '¡Bienvenido Administrador!');
            } else {
                return redirect()->to('/')->with('mensaje', '¡Inicio de sesión exitoso!');
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'Credenciales incorrectas. Verifica tu correo y contraseña.');
        }
    }

    // =======================================================
    // REGISTRO DE CLIENTES
    // =======================================================
    public function registro()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        $data['titulo'] = 'Registrarse - MyCar';
        return view('auth/registro', $data);
    }

    public function procesarRegistro()
    {
        // Reglas de validación con mensajes personalizados y elegantes
        $reglas = [
            'nombre' => [
                'rules'  => 'required|min_length[3]',
                'errors' => [
                    'required' => 'El nombre es obligatorio.',
                    'min_length' => 'El nombre debe tener al menos 3 letras.'
                ]
            ],
            'apellido' => [
                'rules'  => 'required|min_length[3]',
                'errors' => [
                    'required' => 'El apellido es obligatorio.',
                    'min_length' => 'El apellido debe tener al menos 3 letras.'
                ]
            ],
            'telefono' => [
                'rules'  => 'required|min_length[6]|numeric',
                'errors' => [
                    'required' => 'El teléfono es obligatorio.',
                    'min_length' => 'Ingresa un número de teléfono válido.',
                    'numeric' => 'El teléfono solo debe contener números.'
                ]
            ],
            'direccion' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Debes ingresar tu dirección completa.'
                ]
            ],
            'email' => [
                'rules'  => 'required|valid_email|is_unique[usuarios.email]',
                'errors' => [
                    'required' => 'El correo electrónico es obligatorio.',
                    'valid_email' => 'Por favor, ingresa un correo con formato válido.',
                    'is_unique' => 'Este correo ya está registrado en nuestro sistema.'
                ]
            ],
            'password' => [
                'rules'  => 'required|min_length[6]',
                'errors' => [
                    'required' => 'La contraseña es obligatoria.',
                    'min_length' => 'La contraseña debe tener mínimo 6 caracteres por seguridad.'
                ]
            ]
        ];

        // Ejecutar validación
        if (!$this->validate($reglas)) {
            // Si falla, enviamos los errores de vuelta a la vista
            return redirect()->back()->withInput()->with('errores', $this->validator->getErrors());
        }

        // Si pasa la validación, insertamos en BD
        $usuarioModel = new UsuarioModel();
        $clienteModel = new ClienteModel();

        $datosUsuario = [
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'rol'      => 'cliente'
        ];
        
        $usuarioModel->insert($datosUsuario);
        $usuarioId = $usuarioModel->getInsertID();

        $datosCliente = [
            'usuario_id' => $usuarioId,
            'nombre'     => $this->request->getPost('nombre'),
            'apellido'   => $this->request->getPost('apellido'),
            'direccion'  => $this->request->getPost('direccion'),
            'telefono'   => $this->request->getPost('telefono'),
            'fecha_alta' => date('Y-m-d')
        ];
        
        $clienteModel->insert($datosCliente);

        return redirect()->to('/login')->with('mensaje', '¡Registro exitoso! Ahora puedes iniciar sesión.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('mensaje', 'Has cerrado sesión correctamente.');
    }
}