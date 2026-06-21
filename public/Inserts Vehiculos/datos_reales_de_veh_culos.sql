-- STREAMING_CHUNK:Preparando la inserción de vehículos de lujo...

-- Nos aseguramos de usar la base de datos correcta (descomenta la siguiente línea si es necesario)
-- USE mycar_db;

-- Vaciamos la tabla de vehículos por si tenías datos de prueba viejos (Opcional, ten cuidado si tienes reservas asociadas a autos viejos)
-- Si prefieres conservar los que ya tienes, NO ejecutes el TRUNCATE.
-- TRUNCATE TABLE vehiculos;

-- STREAMING_CHUNK:Insertando Ferrari, Mercedes-Benz y Aston Martin...
INSERT INTO vehiculos (categoria_id, marca, modelo, anio, plazas, motor, kilometraje, precio_dia, descripcion, imagen_url) VALUES 
-- CATEGORÍA 1: FERRARI
(1, 'Ferrari', 'SF90 Stradale', 2023, 2, '4.0 V8 Híbrido', 1500.00, 350000.00, 'El hiperdeportivo híbrido enchufable de Maranello. Con 1000 CV de potencia combinada, tracción total y una aceleración de 0 a 100 km/h en 2.5 segundos. La cúspide de la tecnología derivada de la Fórmula 1.', 'ferrari_sf90.jpg'),
(1, 'Ferrari', 'Roma', 2024, 4, '3.9 V8 Twin-Turbo', 800.00, 180000.00, 'La "Nuova Dolce Vita". Un Gran Turismo elegante, con proporciones clásicas y un diseño minimalista que esconde un motor V8 capaz de ofrecer una conducción emocionante y refinada.', 'ferrari_roma.jpg'),

-- CATEGORÍA 2: MERCEDES-BENZ
(2, 'Mercedes-Benz', 'AMG GT Black Series', 2022, 2, '4.0 V8 Biturbo', 4500.00, 280000.00, 'El AMG más extremo jamás creado para la calle. Aerodinámica activa herencia de la categoría GT3 y un motor V8 con cigüeñal plano que produce 730 CV. Una bestia devoradora de circuitos.', 'mercedes_amg_gt_black.jpg'),
(2, 'Mercedes-Benz', 'G 63 AMG', 2023, 5, '4.0 V8 Biturbo', 12000.00, 150000.00, 'El todoterreno definitivo. Lujo absoluto en el interior combinado con un sonido de escape brutal y capacidades off-road inigualables. El símbolo de estatus por excelencia.', 'mercedes_g63.jpg'),

-- CATEGORÍA 3: ASTON MARTIN
(3, 'Aston Martin', 'DBS Superleggera', 2021, 4, '5.2 V12 Twin-Turbo', 8500.00, 210000.00, 'Fuerza bruta vestida de esmoquin. Un Super GT británico que combina un diseño esculpido en fibra de carbono con un motor V12 que entrega un torque capaz de detener la rotación de la tierra.', 'aston_dbs.jpg');

-- STREAMING_CHUNK:Insertando McLaren, Porsche y Koenigsegg...
INSERT INTO vehiculos (categoria_id, marca, modelo, anio, plazas, motor, kilometraje, precio_dia, descripcion, imagen_url) VALUES 
-- CATEGORÍA 4: MCLAREN
(4, 'McLaren', '720S', 2022, 2, '4.0 V8 Twin-Turbo', 6000.00, 230000.00, 'Aerodinámica inspirada en el gran tiburón blanco. Ligero, ridículamente rápido y con una suspensión hidráulica que lo hace sorprendentemente cómodo para el día a día.', 'mclaren_720s.jpg'),
(4, 'McLaren', 'Artura', 2024, 2, '3.0 V6 Híbrido', 1200.00, 200000.00, 'La nueva era de McLaren. Un superdeportivo híbrido de alto rendimiento, ultraligero y con capacidad para conducirse en modo 100% eléctrico por la ciudad.', 'mclaren_artura.jpg'),

-- CATEGORÍA 5: PORSCHE
(5, 'Porsche', '911 GT3 RS (992)', 2023, 2, '4.0 Bóxer Atmosférico', 2500.00, 290000.00, 'Un coche de carreras con matrícula. Aerodinámica activa con DRS, motor atmosférico que gira a 9.000 rpm y precisión quirúrgica en cada curva. El arma definitiva para track-days.', 'porsche_911_gt3rs.jpg'),
(5, 'Porsche', 'Taycan Turbo S', 2024, 4, 'Eléctrico (Dual Motor)', 3000.00, 160000.00, 'El futuro de los deportivos de cuatro puertas. Aceleración que desafía las leyes de la física, recarga ultrarrápida y el inconfundible ADN dinámico de Porsche.', 'porsche_taycan.jpg'),

-- CATEGORÍA 6: KOENIGSEGG
(6, 'Koenigsegg', 'Gemera', 2024, 4, '2.0 3-cilindros Híbrido', 500.00, 500000.00, 'El primer Mega-GT del mundo. Capacidad para cuatro adultos con su equipaje, 1700 CV de potencia y portones diédricos automatizados. Una maravilla de la ingeniería sueca.', 'koenigsegg_gemera.jpg');

-- STREAMING_CHUNK:Insertando BMW y Lamborghini...
INSERT INTO vehiculos (categoria_id, marca, modelo, anio, plazas, motor, kilometraje, precio_dia, descripcion, imagen_url) VALUES 
-- CATEGORÍA 7: BMW
(7, 'BMW', 'M8 Competition', 2023, 4, '4.4 V8 TwinPower Turbo', 7000.00, 140000.00, 'El buque insignia de la división M. Lujo de primera clase, tracción total desconectable para hacer drift y un motor colosal perfecto para cruzar el continente a alta velocidad.', 'bmw_m8.jpg'),
(7, 'BMW', 'X6 M Competition', 2022, 5, '4.4 V8 TwinPower Turbo', 15000.00, 130000.00, 'El pionero de los SUV Coupé llevado al extremo. Agresividad visual, dinámica de conducción impropia para su peso y espacio de sobra para la familia.', 'bmw_x6m.jpg'),

-- CATEGORÍA 8: LAMBORGHINI
(8, 'Lamborghini', 'Huracán STO', 2023, 2, '5.2 V10 Atmosférico', 3200.00, 310000.00, 'Super Trofeo Omologata. La versión más radical del Huracán, tracción trasera, aerodinámica de competición y uno de los mejores sonidos de motor de la historia del automovilismo.', 'lamborghini_huracan_sto.jpg'),
(8, 'Lamborghini', 'Urus Performante', 2024, 5, '4.0 V8 Biturbo', 4000.00, 190000.00, 'El Super SUV redefine sus propios límites. Más ligero, más aerodinámico y con un modo especial "Rally" para dominar caminos de tierra a velocidades absurdas.', 'lamborghini_urus.jpg');

-- STREAMING_CHUNK:Finalizando inserciones.