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

        // Buscamos todas las reservas activas
        $reservasActivas = $alquilerModel->where('vehiculo_id', $id)
                                         ->whereIn('estado', ['Pendiente', 'Alquilado'])
                                         ->findAll();
        
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
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $vehiculoModel = new VehiculoModel();
        $alquilerModel = new AlquilerModel();
        $clienteModel  = new ClienteModel();

        $vehiculo = $vehiculoModel->find($id);

        // ================================================================
        // 🛡️ LÓGICA BLINDADA: Procesamos todo el texto 100% en PHP
        // ================================================================
        $rangoCrudo = $this->request->getPost('fechas_rango');

        if (empty($rangoCrudo)) {
            return redirect()->back()->with('error', 'Por favor, selecciona las fechas en el calendario.');
        }

        // 1. Normalizamos (Flatpickr usa " to " en inglés o " a " en español)
        $rangoCrudo = str_replace(' to ', ' a ', $rangoCrudo);
        $partes = explode(' a ', $rangoCrudo);

        // 2. Extraemos las fechas y aseguramos que tengan solo 10 caracteres (YYYY-MM-DD)
        $fechaDesde = substr(trim($partes[0]), 0, 10);
        $fechaHasta = isset($partes[1]) ? substr(trim($partes[1]), 0, 10) : $fechaDesde;

        // 3. Calculamos la cantidad de días estrictamente en el Servidor
        $diferencia = strtotime($fechaHasta) - strtotime($fechaDesde);
        $dias = max(1, round($diferencia / 86400) + 1);

        // 4. Validación del pasado (Mostrando la fecha exacta si falla para poder depurar)
        $hoy = date('Y-m-d');
        if ($fechaDesde < $hoy) {
            return redirect()->back()->with('error', "Error del servidor: Tú enviaste ($fechaDesde), pero el servidor cree que HOY es ($hoy). Revisa el reloj de tu PC.");
        }

        // ================================================================
        // CONTINÚA LA LÓGICA NORMAL
        // ================================================================
        
        $superposicion = $alquilerModel->where('vehiculo_id', $vehiculo['id'])
            ->whereIn('estado', ['Pendiente', 'Alquilado'])
            ->groupStart()
                ->where('fecha_desde <=', $fechaHasta)
                ->where('fecha_hasta >=', $fechaDesde)
            ->groupEnd()
            ->first();

        if ($superposicion) {
            return redirect()->back()->with('error', 'El vehículo ya se encuentra reservado en esas fechas.');
        }

        $cliente = $clienteModel->where('usuario_id', session()->get('usuario_id'))->first();
        if (!$cliente) {
            return redirect()->to('/')->with('error', 'Error crítico: No se encontró tu perfil de cliente en la base de datos.');
        }

        // Calcular Monto Total en PHP (Para evitar manipulaciones del usuario)
        $montoTotal = $vehiculo['precio_dia'] * $dias;

        $datosAlquiler = [
            'vehiculo_id' => $vehiculo['id'],
            'cliente_id'  => $cliente['id'],
            'fecha_desde' => $fechaDesde,
            'dias'        => $dias,
            'fecha_hasta' => $fechaHasta,
            'precio_dia'  => $vehiculo['precio_dia'],
            'monto_total' => $montoTotal,
            'estado'      => 'Pendiente'
        ];

        if ($alquilerModel->save($datosAlquiler)) {
            return redirect()->to('/catalogo')->with('mensaje', '¡Reserva enviada con éxito! La agencia la revisará pronto.');
        }

        return redirect()->back()->with('error', 'Ocurrió un problema al guardar en la Base de Datos.');
    }
}