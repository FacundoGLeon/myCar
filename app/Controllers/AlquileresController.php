<?php

namespace App\Controllers;

use App\Models\AlquilerModel;
use App\Controllers\BaseController;

class AlquileresController extends BaseController
{
    // =======================================================
    // LISTADO DE ALQUILERES (Con Filtros)
    // =======================================================
    public function index()
    {
        $alquilerModel = new AlquilerModel();
        
        // Empezamos a armar la consulta
        $builder = $alquilerModel->select('alquileres.*, clientes.nombre, clientes.apellido, vehiculos.marca, vehiculos.modelo')
                                 ->join('clientes', 'clientes.id = alquileres.cliente_id')
                                 ->join('vehiculos', 'vehiculos.id = alquileres.vehiculo_id');

        // Capturamos el filtro si existe
        $estadoFiltro = $this->request->getGet('estado');
        if (!empty($estadoFiltro)) {
            $builder->where('alquileres.estado', $estadoFiltro);
        }

        // Ordenamos y paginamos
        $alquileres = $builder->orderBy('alquileres.created_at', 'DESC')
                              ->paginate(10);

        $data = [
            'titulo'        => 'Gestión de Alquileres - Admin MyCar',
            'alquileres'    => $alquileres,
            'pager'         => $alquilerModel->pager,
            'estado_filtro' => $estadoFiltro // Lo pasamos para que el select mantenga la opción elegida
        ];

        return view('admin/alquileres/index', $data);
    }

    // =======================================================
    // PROCESAR ACCIONES DE ESTADO (Flujo Unidireccional)
    // =======================================================
    public function accion($id = null)
    {
        $alquilerModel = new AlquilerModel();
        $accion = $this->request->getPost('accion'); // puede ser: confirmar, cancelar, devolver
        
        $alquiler = $alquilerModel->find($id);
        
        if (!$alquiler) {
            return redirect()->back()->with('error', 'El registro no existe.');
        }

        $nuevoEstado = '';
        $mensaje = '';

        // LÓGICA ESTRICTA DE NEGOCIO
        if ($accion == 'confirmar' && $alquiler['estado'] == 'Pendiente') {
            $nuevoEstado = 'Alquilado';
            $mensaje = '¡Reserva confirmada! El vehículo ahora está Alquilado.';
        
        } elseif ($accion == 'cancelar' && $alquiler['estado'] == 'Pendiente') {
            $nuevoEstado = 'Cancelado';
            $mensaje = 'Reserva cancelada correctamente.';
        
        } elseif ($accion == 'devolver' && $alquiler['estado'] == 'Alquilado') {
            $nuevoEstado = 'Devuelto';
            $mensaje = '¡Devolución registrada! El vehículo vuelve a estar disponible.';
        
        } else {
            // Si intentan hackear el botón o hacer algo raro
            return redirect()->back()->with('error', 'Acción no permitida para el estado actual del alquiler.');
        }

        // Actualizamos la base de datos
        if ($alquilerModel->update($id, ['estado' => $nuevoEstado])) {
            return redirect()->back()->with('mensaje', $mensaje);
        }

        return redirect()->back()->with('error', 'Ocurrió un error en la base de datos.');
    }
}