<?php

namespace App\Controllers;

use App\Models\AlquilerModel;
use App\Models\VehiculoModel;
use App\Models\ClienteModel;
use App\Controllers\BaseController;

class ReportesController extends BaseController
{
    public function porVehiculo()
    {
        $vehiculoModel = new VehiculoModel();
        $alquilerModel = new AlquilerModel();
        $vehiculoId = $this->request->getGet('vehiculo_id');
        
        $data = [
            'titulo'      => 'Reporte: Historial por Vehículo',
            'vehiculos'   => $vehiculoModel->findAll(),
            'vehiculo_id' => $vehiculoId,
            'historial'   => []
        ];

        if ($vehiculoId) {
            // ¡Llamada limpia al método del Modelo!
            $data['historial'] = $alquilerModel->getHistorialPorVehiculo($vehiculoId)->paginate(10);
            $data['pager'] = $alquilerModel->pager;
        }

        return view('admin/reportes/vehiculo', $data);
    }

    public function porCliente()
    {
        $clienteModel = new ClienteModel();
        $alquilerModel = new AlquilerModel();
        $clienteId = $this->request->getGet('cliente_id');
        
        $data = [
            'titulo'     => 'Reporte: Historial por Cliente',
            'clientes'   => $clienteModel->findAll(),
            'cliente_id' => $clienteId,
            'historial'  => []
        ];

        if ($clienteId) {
            // ¡Llamada limpia al método del Modelo!
            $data['historial'] = $alquilerModel->getHistorialPorCliente($clienteId)->paginate(10);
            $data['pager'] = $alquilerModel->pager;
        }

        return view('admin/reportes/cliente', $data);
    }

    public function actuales()
    {
        $alquilerModel = new AlquilerModel();
        
        $data = [
            'titulo'     => 'Reporte: Vehículos en Calle',
            // ¡Llamada limpia al método del Modelo!
            'alquileres' => $alquilerModel->getVehiculosEnCalle()
        ];

        return view('admin/reportes/actuales', $data);
    }
}