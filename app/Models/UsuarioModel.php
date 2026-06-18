<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // BAJA LÓGICA ACTIVADA
    protected $useSoftDeletes   = true; 
    
    protected $allowedFields    = ['email', 'password', 'rol'];

    // Configuración de Fechas
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    
    // AQUÍ ESTÁ LA MAGIA: Al dejarlo vacío, CodeIgniter ya no intentará buscar esta columna
    protected $updatedField  = ''; 
    
    protected $deletedField  = 'deleted_at';
}