<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table            = 'clientes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // BAJA LÓGICA ACTIVADA
    protected $useSoftDeletes   = true;
    
    protected $allowedFields    = [
        'usuario_id', 'nombre', 'apellido', 
        'direccion', 'telefono', 'fecha_alta'
    ];

    // Configuración de Fechas
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}