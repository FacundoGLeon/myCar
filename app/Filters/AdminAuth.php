<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuth implements FilterInterface
{
    /**
     * Esta función se ejecuta ANTES de que el controlador cargue la vista.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Verificamos si NO hay sesión iniciada
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión para acceder a esta área.');
        }

        // 2. Verificamos si está logueado, pero NO es administrador
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('/')->with('error', 'Acceso denegado. Esta área es exclusiva para administradores.');
        }
    }

    /**
     * Esta función se ejecuta DESPUÉS de que el controlador responde.
     * Para este caso, no necesitamos hacer nada aquí.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No hacer nada
    }
}