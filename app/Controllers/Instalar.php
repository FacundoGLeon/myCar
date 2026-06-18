<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Instalar extends BaseController
{
    public function index()
    {
        // 0. Crear la Base de Datos automáticamente (Bypass de CodeIgniter)
        // Nos conectamos directo a MySQL en WAMP (usuario 'root', sin contraseña)
        $mysqli = new \mysqli('localhost', 'root', '');
        if ($mysqli->connect_error) {
            return "Error al conectar con MySQL: " . $mysqli->connect_error;
        }
        // Creamos la base de datos si no existe
        $mysqli->query("CREATE DATABASE IF NOT EXISTS mycar_db");
        $mysqli->close();

        // 1. Conectamos a la base de datos (ahora sí usamos CodeIgniter)
        $db = \Config\Database::connect();

        // 2. Buscamos el archivo SQL
        $rutaSql = APPPATH . 'Database/mycar_tp2.sql';
        
        if (!file_exists($rutaSql)) {
            return "Error: No se encontró el archivo SQL en: " . $rutaSql;
        }

        // Leemos el contenido del archivo
        $sql = file_get_contents($rutaSql);

        // Separamos las consultas por punto y coma (;)
        $consultas = explode(';', $sql);

        // Ejecutamos cada consulta para crear las tablas
        foreach ($consultas as $consulta) {
            $consultaLimpia = trim($consulta);
            if (!empty($consultaLimpia)) {
                $db->query($consultaLimpia);
            }
        }

        // 3. Crear el Usuario Administrador con Hash
        $adminEmail = 'admin@mycar.com';
        $passwordPlana = 'admin123'; // Esta es la clave que usarás para entrar
        
        // Encriptamos la clave usando el algoritmo seguro por defecto de PHP
        $passwordHash = password_hash($passwordPlana, PASSWORD_DEFAULT);

        // Verificamos si el admin ya existe para no duplicarlo si corres el script 2 veces
        $adminExiste = $db->table('usuarios')->where('email', $adminEmail)->get()->getRow();

        if (!$adminExiste) {
            $datosAdmin = [
                'email'    => $adminEmail,
                'password' => $passwordHash,
                'rol'      => 'admin'
            ];
            
            // Insertamos el admin en la base de datos
            $db->table('usuarios')->insert($datosAdmin);
            
            echo "<h2>✅ ¡Instalación Completada con Éxito!</h2>";
            echo "<p>Las tablas y categorías se crearon correctamente.</p>";
            echo "<h3>Credenciales del Administrador:</h3>";
            echo "<ul>";
            echo "<li><b>Usuario:</b> " . $adminEmail . "</li>";
            echo "<li><b>Contraseña:</b> " . $passwordPlana . " <i>(Guardada de forma segura mediante hash)</i></li>";
            echo "</ul>";
            echo "<p>Por seguridad, recuerda eliminar o comentar este archivo (app/Controllers/Instalar.php) una vez en producción.</p>";
        } else {
            echo "<h2>⚠️ El sistema ya estaba instalado.</h2>";
            echo "<p>Las tablas ya existen y el administrador ya está registrado.</p>";
        }
    }
}