<?php

namespace App\Controllers;

use App\Models\VehiculoModel;
use App\Models\AlquilerModel;
use App\Models\ClienteModel;

class ReservaController extends BaseController
{
    public function nuevo($id = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión para realizar una reserva.');
        }

        $vehiculoModel = new VehiculoModel();
        $alquilerModel = new AlquilerModel();
        
        $vehiculo = $vehiculoModel->find($id);

        if (!$vehiculo) {
            return redirect()->to('/catalogo')->with('error', 'El vehículo seleccionado no existe.');
        }

        // ¡Reemplazamos el Query Builder por nuestro método limpio!
        $reservasActivas = $alquilerModel->getReservasActivasPorVehiculo($id);
        
        $fechasOcupadas = [];
        foreach ($reservasActivas as $res) {
            $fechasOcupadas[] = [
                'from' => $res['fecha_desde'],
                'to'   => $res['fecha_hasta']
            ];
        }

        $data = [
            'titulo'         => 'Reservar Vehículo - MyCar',
            'vehiculo'       => $vehiculo,
            'fechasOcupadas' => json_encode($fechasOcupadas) 
        ];

        return view('reservas/nuevo', $data);
    }

    public function guardar($id = null)
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');

        $vehiculoModel = new VehiculoModel();
        $alquilerModel = new AlquilerModel();
        $clienteModel  = new ClienteModel();

        $vehiculo = $vehiculoModel->find($id);
        $rangoCrudo = $this->request->getPost('fechas_rango');

        if (empty($rangoCrudo)) return redirect()->back()->with('error', 'Por favor, selecciona las fechas.');

        $rangoCrudo = str_replace(' to ', ' a ', $rangoCrudo);
        $partes = explode(' a ', $rangoCrudo);

        $fechaDesde = substr(trim($partes[0]), 0, 10);
        $fechaHasta = isset($partes[1]) ? substr(trim($partes[1]), 0, 10) : $fechaDesde;

        $diferencia = strtotime($fechaHasta) - strtotime($fechaDesde);
        $dias = max(1, round($diferencia / 86400) + 1);

        $hoy = date('Y-m-d');
        if ($fechaDesde < $hoy) return redirect()->back()->with('error', "No puedes reservar en el pasado.");

        // ¡Verificación limpia utilizando el modelo!
        if ($alquilerModel->verificarSuperposicion($vehiculo['id'], $fechaDesde, $fechaHasta)) {
            return redirect()->back()->with('error', 'El vehículo ya se encuentra reservado en esas fechas.');
        }

        $cliente = $clienteModel->where('usuario_id', session()->get('usuario_id'))->first();
        if (!$cliente) return redirect()->to('/')->with('error', 'Perfil de cliente no encontrado.');

        $datosAlquiler = [
            'vehiculo_id' => $vehiculo['id'],
            'cliente_id'  => $cliente['id'],
            'fecha_desde' => $fechaDesde,
            'dias'        => $dias,
            'fecha_hasta' => $fechaHasta,
            'precio_dia'  => $vehiculo['precio_dia'],
            'monto_total' => $vehiculo['precio_dia'] * $dias,
            'estado'      => 'Pendiente'
        ];

        if ($alquilerModel->save($datosAlquiler)) {
            return redirect()->to('/catalogo')->with('mensaje', '¡Reserva enviada con éxito!');
        }

        return redirect()->back()->with('error', 'Ocurrió un problema al guardar en la Base de Datos.');
    }

    public function misReservas()
    {
        if (!session()->get('isLoggedIn') || session()->get('rol') !== 'cliente') {
            return redirect()->to('/login');
        }

        $alquilerModel = new AlquilerModel();
        $clienteModel  = new ClienteModel();

        $cliente = $clienteModel->where('usuario_id', session()->get('usuario_id'))->first();

        if (!$cliente) return redirect()->to('/')->with('error', 'Perfil no encontrado.');

        $data = [
            'titulo'   => 'Mis Reservas - MyCar',
            // ¡Llamada limpia al método del Modelo!
            'reservas' => $alquilerModel->getReservasPorCliente($cliente['id'])->paginate(10),
            'pager'    => $alquilerModel->pager
        ];

        return view('reservas/mis_reservas', $data);
    }
}