<?php

namespace App\Models;

use CodeIgniter\Model;

class AlquilerModel extends Model
{
    protected $table            = 'alquileres';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    protected $useSoftDeletes   = false;
    
    protected $allowedFields    = [
        'vehiculo_id', 'cliente_id', 'fecha_desde', 
        'dias', 'fecha_hasta', 'precio_dia', 
        'monto_total', 'estado'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // =======================================================
    // MÉTODOS DE CONSULTA PERSONALIZADOS
    // =======================================================

    // 1. Dashboard: Trae los últimos X movimientos
    public function getUltimosMovimientos($limite = 5)
    {
        return $this->select('alquileres.*, clientes.nombre, clientes.apellido, vehiculos.marca, vehiculos.modelo')
                    ->join('clientes', 'clientes.id = alquileres.cliente_id')
                    ->join('vehiculos', 'vehiculos.id = alquileres.vehiculo_id')
                    ->orderBy('alquileres.created_at', 'DESC')
                    ->limit($limite)
                    ->findAll();
    }

    // 2. Gestión Alquileres: Listado completo con filtros
    public function getAlquileresDetallados($estadoFiltro = null)
    {
        $this->select('alquileres.*, clientes.nombre, clientes.apellido, vehiculos.marca, vehiculos.modelo')
             ->join('clientes', 'clientes.id = alquileres.cliente_id')
             ->join('vehiculos', 'vehiculos.id = alquileres.vehiculo_id');

        if (!empty($estadoFiltro)) {
            $this->where('alquileres.estado', $estadoFiltro);
        }

        return $this->orderBy('alquileres.created_at', 'DESC');
    }

    // 3. Reporte A: Historial por Vehículo
    public function getHistorialPorVehiculo($vehiculoId)
    {
        return $this->select('alquileres.*, clientes.nombre, clientes.apellido, clientes.telefono')
                    ->join('clientes', 'clientes.id = alquileres.cliente_id')
                    ->where('vehiculo_id', $vehiculoId)
                    ->orderBy('fecha_desde', 'DESC');
    }

    // 4. Reporte B: Historial por Cliente
    public function getHistorialPorCliente($clienteId)
    {
        return $this->select('alquileres.*, vehiculos.marca, vehiculos.modelo, vehiculos.plazas')
                    ->join('vehiculos', 'vehiculos.id = alquileres.vehiculo_id')
                    ->where('cliente_id', $clienteId)
                    ->orderBy('fecha_desde', 'DESC');
    }

    // 5. Reporte C: Vehículos actualmente en calle
    public function getVehiculosEnCalle()
    {
        return $this->select('alquileres.*, vehiculos.marca, vehiculos.modelo, vehiculos.imagen_url, clientes.nombre, clientes.apellido, clientes.telefono')
                    ->join('vehiculos', 'vehiculos.id = alquileres.vehiculo_id')
                    ->join('clientes', 'clientes.id = alquileres.cliente_id')
                    ->where('alquileres.estado', 'Alquilado')
                    ->orderBy('fecha_hasta', 'ASC')
                    ->findAll();
    }

    // 6. Historial de Reservas de un Cliente Específico
    public function getReservasPorCliente($clienteId)
    {
        return $this->select('alquileres.*, vehiculos.marca, vehiculos.modelo, vehiculos.imagen_url')
                    ->join('vehiculos', 'vehiculos.id = alquileres.vehiculo_id')
                    ->where('cliente_id', $clienteId)
                    ->orderBy('alquileres.created_at', 'DESC');
    }

    // 7. Calendario: Buscar reservas activas para bloquear fechas en el frontend
    public function getReservasActivasPorVehiculo($vehiculoId)
    {
        return $this->where('vehiculo_id', $vehiculoId)
                    ->whereIn('estado', ['Pendiente', 'Alquilado'])
                    ->findAll();
    }

    // 8. Seguridad: Validar en el Backend que las fechas no se superpongan
    public function verificarSuperposicion($vehiculoId, $fechaDesde, $fechaHasta)
    {
        return $this->where('vehiculo_id', $vehiculoId)
                    ->whereIn('estado', ['Pendiente', 'Alquilado'])
                    ->groupStart()
                        ->where('fecha_desde <=', $fechaHasta)
                        ->where('fecha_hasta >=', $fechaDesde)
                    ->groupEnd()
                    ->first();
    }

    // 9. Regla de Negocio: Verificar si un vehículo está en uso activo
    public function checkVehiculoEnUso($vehiculoId)
    {
        return $this->where('vehiculo_id', $vehiculoId)
                    ->whereIn('estado', ['Pendiente', 'Alquilado'])
                    ->first();
    }

    // 10. Regla de Negocio: Verificar si un cliente tiene alquileres activos
    public function checkClienteEnUso($clienteId)
    {
        return $this->where('cliente_id', $clienteId)
                    ->whereIn('estado', ['Pendiente', 'Alquilado'])
                    ->first();
    }
}