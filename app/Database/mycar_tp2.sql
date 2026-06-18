-- ---------------------------------------------------------
-- 1. TABLA USUARIOS (Maneja Autenticación y Roles)
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'cliente') NOT NULL DEFAULT 'cliente',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    deleted_at DATETIME NULL
);

-- ---------------------------------------------------------
-- 2. TABLA CLIENTES (Perfil del usuario)
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    telefono VARCHAR(50) NOT NULL,
    fecha_alta DATE NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at DATETIME NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- ---------------------------------------------------------
-- 3. TABLA CATEGORIAS
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

-- ---------------------------------------------------------
-- 4. TABLA VEHICULOS
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS vehiculos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT NOT NULL,
    marca VARCHAR(100) NOT NULL,
    modelo VARCHAR(100) NOT NULL,
    anio INT NOT NULL,
    plazas INT NOT NULL,
    motor VARCHAR(100) NOT NULL,
    kilometraje DECIMAL(10,2) NOT NULL,
    precio_dia DECIMAL(10,2) NOT NULL,
    descripcion TEXT,
    imagen_url VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at DATETIME NULL,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

-- ---------------------------------------------------------
-- 5. TABLA ALQUILERES
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS alquileres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vehiculo_id INT NOT NULL,
    cliente_id INT NOT NULL,
    fecha_desde DATE NOT NULL,
    dias INT NOT NULL,
    fecha_hasta DATE NOT NULL,
    precio_dia DECIMAL(10,2) NOT NULL,
    monto_total DECIMAL(10,2) NOT NULL,
    estado ENUM('Pendiente', 'Alquilado', 'Devuelto', 'Cancelado') DEFAULT 'Pendiente', 
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (vehiculo_id) REFERENCES vehiculos(id),
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);

-- ---------------------------------------------------------
-- INSERCIÓN DE DATOS BASE (Solo Categorías)
-- ---------------------------------------------------------
INSERT IGNORE INTO categorias (id, nombre) VALUES 
(1, 'Ferrari'), (2, 'Mercedes-Benz'), (3, 'Aston Martin'), (4, 'McLaren'), 
(5, 'Porsche'), (6, 'Koenigsegg'), (7, 'BMW'), (8, 'Lamborghini');