<?php

namespace App\Models;

use CodeIgniter\Model;

class VehiculoModel extends Model
{
    protected $table            = 'vehiculos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // BAJA LÓGICA ACTIVADA
    protected $useSoftDeletes   = true;
    
    protected $allowedFields    = [
        'categoria_id', 'marca', 'modelo', 'anio', 
        'plazas', 'motor', 'kilometraje', 'precio_dia', 
        'descripcion', 'imagen_url'
    ];

    // Configuración de Fechas
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}