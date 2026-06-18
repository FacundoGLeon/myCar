<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ClienteAuth implements FilterInterface
{
    /**
     * Esta función se ejecuta ANTES de que el controlador cargue la vista.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Verificamos si NO hay sesión iniciada
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión para realizar una reserva.');
        }

        // 2. Verificamos si está logueado, pero NO es un cliente
        if (session()->get('rol') !== 'cliente') {
            return redirect()->to('/')->with('error', 'Acceso denegado. Esta sección es exclusiva para clientes.');
        }
    }

    /**
     * Esta función se ejecuta DESPUÉS de que el controlador responde.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No hacer nada
    }
}
