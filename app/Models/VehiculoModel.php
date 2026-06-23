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

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // =======================================================
    // MÉTODOS DE CONSULTA PERSONALIZADOS
    // =======================================================

    // Trae los vehículos junto con el nombre de su categoría y aplica buscador
    public function getVehiculosConCategoria($buscar = null)
    {
        $this->select('vehiculos.*, categorias.nombre as categoria_nombre')
             ->join('categorias', 'categorias.id = vehiculos.categoria_id', 'left');

        if (!empty($buscar)) {
            $this->groupStart()
                 ->like('vehiculos.marca', $buscar)
                 ->orLike('vehiculos.modelo', $buscar)
                 ->orLike('categorias.nombre', $buscar)
                 ->orLike('vehiculos.anio', $buscar)
                 ->groupEnd();
        }

        return $this; // Retornamos $this para poder encadenar el ->paginate() en el controlador
    }

    // Filtra el catálogo público por categoría y buscador
    public function getCatalogoFiltrado($categoriaId = null, $buscar = null)
    {
        if ($categoriaId) {
            $this->where('categoria_id', $categoriaId);
        }

        if (!empty($buscar)) {
            $this->groupStart()
                 ->like('marca', $buscar)
                 ->orLike('modelo', $buscar)
                 ->groupEnd();
        }

        return $this->findAll();
    }
}