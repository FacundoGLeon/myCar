<?php

namespace App\Controllers;

use App\Models\VehiculoModel;
use App\Models\AlquilerModel;
use App\Models\ClienteModel;

class Reserva extends BaseController
{
    /**
     * Muestra el formulario/detalle de reserva para el vehículo seleccionado.
     */
    public function nuevo($id = null)
    {
        if (empty($id)) {
            return redirect()->to('/')->with('error', 'Vehículo no especificado.');
        }

        $vehiculoModel = new VehiculoModel();
        $vehiculo = $vehiculoModel->find($id);

        if (!$vehiculo) {
            return redirect()->to('/')->with('error', 'El vehículo solicitado no existe.');
        }

        $data = [
            'titulo' => 'Reservar ' . $vehiculo['marca'] . ' ' . $vehiculo['modelo'] . ' - MyCar',
            'vehiculo' => $vehiculo
        ];

        return view('reservas/detalleVehiculo', $data);
    }

    /**
     * Procesa y guarda la reserva en la base de datos.
     */
    public function guardar()
    {
        // Reglas de validación
        $reglas = [
            'vehiculo_id' => [
                'rules'  => 'required|is_not_unique[vehiculos.id]',
                'errors' => [
                    'required' => 'El vehículo es obligatorio.',
                    'is_not_unique' => 'El vehículo seleccionado no es válido.'
                ]
            ],
            'fecha_desde' => [
                'rules'  => 'required|valid_date[Y-m-d]',
                'errors' => [
                    'required' => 'La fecha de inicio es obligatoria.',
                    'valid_date' => 'La fecha ingresada no tiene un formato válido.'
                ]
            ],
            'dias' => [
                'rules'  => 'required|integer|greater_than[0]',
                'errors' => [
                    'required' => 'La cantidad de días es obligatoria.',
                    'integer' => 'Los días deben ser un número entero.',
                    'greater_than' => 'Debes alquilar por al menos 1 día.'
                ]
            ]
        ];

        if (!$this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errores', $this->validator->getErrors());
        }

        $vehiculoId = $this->request->getPost('vehiculo_id');
        $fechaDesde = $this->request->getPost('fecha_desde');
        $dias = (int)$this->request->getPost('dias');

        // Validar que la fecha no esté en el pasado
        $hoy = date('Y-m-d');
        if ($fechaDesde < $hoy) {
            return redirect()->back()->withInput()->with('error', 'La fecha de inicio no puede ser en el pasado.');
        }

        // Obtener el cliente logueado
        $usuarioId = session()->get('usuario_id');
        $clienteModel = new ClienteModel();
        $cliente = $clienteModel->where('usuario_id', $usuarioId)->first();

        if (!$cliente) {
            return redirect()->to('/login')->with('error', 'No se encontró tu perfil de cliente. Vuelve a iniciar sesión.');
        }

        // Obtener datos del vehículo para calcular el precio
        $vehiculoModel = new VehiculoModel();
        $vehiculo = $vehiculoModel->find($vehiculoId);

        if (!$vehiculo) {
            return redirect()->back()->withInput()->with('error', 'El vehículo seleccionado no es válido.');
        }

        // Cálculos
        $precioDia = $vehiculo['precio_dia'];
        $montoTotal = $precioDia * $dias;

        // Calcular fecha de finalización
        $fechaDesdeObj = new \DateTime($fechaDesde);
        $fechaHastaObj = clone $fechaDesdeObj;
        $fechaHastaObj->modify("+$dias days");
        $fechaHasta = $fechaHastaObj->format('Y-m-d');

        // Guardar alquiler
        $alquilerModel = new AlquilerModel();
        $datosAlquiler = [
            'vehiculo_id' => $vehiculoId,
            'cliente_id'  => $cliente['id'],
            'fecha_desde' => $fechaDesde,
            'dias'        => $dias,
            'fecha_hasta' => $fechaHasta,
            'precio_dia'  => $precioDia,
            'monto_total' => $montoTotal,
            'estado'      => 'Pendiente'
        ];

        if ($alquilerModel->insert($datosAlquiler)) {
            return redirect()->to('/')->with('mensaje', '¡Tu reserva del ' . $vehiculo['marca'] . ' ' . $vehiculo['modelo'] . ' ha sido confirmada con éxito! Su estado actual es: Pendiente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Ocurrió un error al guardar la reserva. Por favor intenta de nuevo.');
        }
    }
}
