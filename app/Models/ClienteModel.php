<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table            = 'clientes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    protected $useSoftDeletes   = true;
    
    protected $allowedFields    = [
        'usuario_id', 'nombre', 'apellido', 
        'direccion', 'telefono', 'fecha_alta'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // =======================================================
    // MÉTODOS DE CONSULTA PERSONALIZADOS
    // =======================================================

    // Lista clientes uniendo la tabla usuarios para obtener el email
    public function getClientesConEmail($buscar = null)
    {
        $this->select('clientes.*, usuarios.email')
             ->join('usuarios', 'usuarios.id = clientes.usuario_id');

        if (!empty($buscar)) {
            $this->groupStart()
                 ->like('clientes.nombre', $buscar)
                 ->orLike('clientes.apellido', $buscar)
                 ->orLike('clientes.telefono', $buscar)
                 ->orLike('usuarios.email', $buscar)
                 ->groupEnd();
        }

        return $this;
    }

    // Trae un solo cliente con su email
    public function getClienteConEmail($id)
    {
        return $this->select('clientes.*, usuarios.email')
                    ->join('usuarios', 'usuarios.id = clientes.usuario_id')
                    ->where('clientes.id', $id)
                    ->first();
    }
}