<?php

namespace App\Controllers;

use App\Models\AlquilerModel;
use App\Controllers\BaseController;

class AlquileresController extends BaseController
{
    // =======================================================
    // LISTADO DE ALQUILERES
    // =======================================================
    public function index()
    {
        $alquilerModel = new AlquilerModel();
        
        // Hacemos JOIN con clientes y vehículos para traer los nombres
        $alquileres = $alquilerModel->select('alquileres.*, clientes.nombre, clientes.apellido, vehiculos.marca, vehiculos.modelo')
                                    ->join('clientes', 'clientes.id = alquileres.cliente_id')
                                    ->join('vehiculos', 'vehiculos.id = alquileres.vehiculo_id')
                                    ->orderBy('alquileres.created_at', 'DESC')
                                    ->paginate(10);

        $data = [
            'titulo'     => 'Gestión de Alquileres - Admin MyCar',
            'alquileres' => $alquileres,
            'pager'      => $alquilerModel->pager
        ];

        return view('admin/alquileres/index', $data);
    }

    // =======================================================
    // CAMBIAR ESTADO DEL ALQUILER
    // =======================================================
    public function cambiarEstado($id = null)
    {
        $alquilerModel = new AlquilerModel();
        $nuevoEstado = $this->request->getPost('estado');

        // Validamos que el estado sea uno de los permitidos por la BD
        $estadosPermitidos = ['Pendiente', 'Alquilado', 'Devuelto', 'Cancelado'];
        
        if (!in_array($nuevoEstado, $estadosPermitidos)) {
            return redirect()->back()->with('error', 'Estado no válido.');
        }

        if ($alquilerModel->update($id, ['estado' => $nuevoEstado])) {
            return redirect()->back()->with('mensaje', 'Estado del alquiler actualizado a: ' . $nuevoEstado);
        }

        return redirect()->back()->with('error', 'Ocurrió un error al actualizar el estado.');
    }
}