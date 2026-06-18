<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriaModel extends Model
{
    protected $table            = 'categorias';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nombre'];

    // Esta tabla es sencilla, no requiere control de timestamps
    protected $useTimestamps = false;
}