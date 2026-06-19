<?php

namespace App\Controllers;

use App\Models\AlquilerModel;
use App\Models\VehiculoModel;
use App\Models\ClienteModel;
use App\Controllers\BaseController;

class ReportesController extends BaseController
{
    // =======================================================
    // REPORTE A: HISTORIAL POR VEHÍCULO
    // Dado un vehículo -> muestra todos los clientes que lo alquilaron
    // =======================================================
    public function porVehiculo()
    {
        $vehiculoModel = new VehiculoModel();
        $alquilerModel = new AlquilerModel();
        
        $vehiculoId = $this->request->getGet('vehiculo_id');
        
        $data = [
            'titulo'      => 'Reporte: Historial por Vehículo',
            'vehiculos'   => $vehiculoModel->findAll(), // Para llenar el <select>
            'vehiculo_id' => $vehiculoId,
            'historial'   => []
        ];

        // Si se seleccionó un vehículo, buscamos su historial
        if ($vehiculoId) {
            $data['historial'] = $alquilerModel->select('alquileres.*, clientes.nombre, clientes.apellido, clientes.telefono')
                                               ->join('clientes', 'clientes.id = alquileres.cliente_id')
                                               ->where('vehiculo_id', $vehiculoId)
                                               ->orderBy('fecha_desde', 'DESC')
                                               ->findAll();
        }

        return view('admin/reportes/vehiculo', $data);
    }

    // =======================================================
    // REPORTE B: HISTORIAL POR CLIENTE
    // Dado un cliente -> muestra todos los vehículos que alquiló
    // =======================================================
    public function porCliente()
    {
        $clienteModel = new ClienteModel();
        $alquilerModel = new AlquilerModel();
        
        $clienteId = $this->request->getGet('cliente_id');
        
        $data = [
            'titulo'     => 'Reporte: Historial por Cliente',
            'clientes'   => $clienteModel->findAll(), // Para llenar el <select>
            'cliente_id' => $clienteId,
            'historial'  => []
        ];

        // Si se seleccionó un cliente, buscamos su historial
        if ($clienteId) {
            $data['historial'] = $alquilerModel->select('alquileres.*, vehiculos.marca, vehiculos.modelo, vehiculos.plazas')
                                               ->join('vehiculos', 'vehiculos.id = alquileres.vehiculo_id')
                                               ->where('cliente_id', $clienteId)
                                               ->orderBy('fecha_desde', 'DESC')
                                               ->findAll();
        }

        return view('admin/reportes/cliente', $data);
    }

    // =======================================================
    // REPORTE C: VEHÍCULOS EN CALLE (ACTUALMENTE ALQUILADOS)
    // Listado de vehículos "Alquilado" con datos del cliente actual
    // =======================================================
    public function actuales()
    {
        $alquilerModel = new AlquilerModel();
        
        // Filtramos directamente por estado 'Alquilado'
        $data = [
            'titulo'     => 'Reporte: Vehículos en Calle',
            'alquileres' => $alquilerModel->select('alquileres.*, vehiculos.marca, vehiculos.modelo, vehiculos.imagen_url, clientes.nombre, clientes.apellido, clientes.telefono')
                                          ->join('vehiculos', 'vehiculos.id = alquileres.vehiculo_id')
                                          ->join('clientes', 'clientes.id = alquileres.cliente_id')
                                          ->where('alquileres.estado', 'Alquilado')
                                          ->orderBy('fecha_hasta', 'ASC') // Ordenados por los que tienen que devolverse más pronto
                                          ->findAll()
        ];

        return view('admin/reportes/actuales', $data);
    }
}