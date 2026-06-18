<?php

namespace App\Models;

use CodeIgniter\Model;

class AlquilerModel extends Model
{
    protected $table            = 'alquileres';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // El TP no pide historial de borrado para alquileres, solo estados.
    protected $useSoftDeletes   = false; 
    
    protected $allowedFields    = [
        'vehiculo_id', 'cliente_id', 'fecha_desde', 
        'dias', 'fecha_hasta', 'precio_dia', 
        'monto_total', 'estado'
    ];

    // Configuración de Fechas
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}