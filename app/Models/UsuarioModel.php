<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array'; // Según la teoría del profesor
    
    // BAJA LÓGICA ACTIVADA
    protected $useSoftDeletes   = true; 
    
    // Campos que permitimos insertar/modificar desde los controladores
    protected $allowedFields    = ['email', 'password', 'rol'];

    // Configuración de Fechas
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at'; // CodeIgniter llenará este campo al hacer delete()
}