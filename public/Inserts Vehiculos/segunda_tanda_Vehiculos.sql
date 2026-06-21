-- Nos aseguramos de usar la base de datos correcta (descomenta la siguiente línea si es necesario)
-- USE mycar_db;

-- ¡ATENCIÓN! No puse el TRUNCATE aquí para NO borrar los 14 autos que ya insertaste antes.
-- Esto simplemente AGREGARÁ estos 12 autos nuevos a tu catálogo actual.

INSERT INTO vehiculos (categoria_id, marca, modelo, anio, plazas, motor, kilometraje, precio_dia, descripcion, imagen_url) VALUES 

-- CATEGORÍA 1: FERRARI
(1, 'Ferrari', 'Purosangue', 2024, 4, '6.5 V12 Atmosférico', 1500.00, 250000.00, 'El primer cuatro puertas en la historia de Ferrari. No lo llaman SUV, sino una extensión de sus deportivos. Un motor V12 que ruge como pocos y puertas traseras suicidas.', 'ferrari_purosangue.jpg'),
(1, 'Ferrari', '812 Superfast', 2022, 2, '6.5 V12 Atmosférico', 6000.00, 220000.00, 'Motor delantero, tracción trasera y 800 caballos de fuerza de puro V12 italiano sin turbos. Un diseño clásico que ofrece una de las conducciones más puras y salvajes del mercado.', 'ferrari_812.jpg'),

-- CATEGORÍA 2: MERCEDES-BENZ
(2, 'Mercedes-Benz', 'S 63 E PERFORMANCE', 2024, 5, '4.0 V8 Híbrido', 2000.00, 190000.00, 'La Clase S llevada al límite por AMG. El sedán de lujo más avanzado del mundo ahora con tecnología híbrida derivada de F1, entregando 802 CV y confort de primera clase.', 'mercedes_s63.jpg'),

-- CATEGORÍA 3: ASTON MARTIN
(3, 'Aston Martin', 'DBX707', 2023, 5, '4.0 V8 Twin-Turbo', 8500.00, 200000.00, 'Considerado el SUV de lujo más potente del mundo. Aston Martin tomó su modelo familiar y le inyectó 707 caballos de fuerza, frenos carbono-cerámicos y una agresividad inigualable.', 'aston_dbx707.jpg'),

-- CATEGORÍA 4: MCLAREN
(4, 'McLaren', 'GT', 2022, 2, '4.0 V8 Twin-Turbo', 5000.00, 180000.00, 'El Gran Turismo redefinido por McLaren. Conserva la estructura de fibra de carbono ultraligera y el motor central, pero añade espacio para equipaje y una suspensión más suave para viajes largos.', 'mclaren_gt.jpg'),

-- CATEGORÍA 5: PORSCHE
(5, 'Porsche', '911 Turbo S (992)', 2023, 4, '3.8 Bóxer Biturbo', 4000.00, 240000.00, 'El mata-gigantes por excelencia. Tracción total, 650 CV y una aceleración que te deja pegado al asiento. Útil para ir al supermercado de lunes a viernes y destrozar récords en el circuito los domingos.', 'porsche_911_turbos.jpg'),
(5, 'Porsche', 'Cayenne Turbo GT', 2023, 4, '4.0 V8 Biturbo', 12000.00, 175000.00, 'El SUV enfocado puramente en la pista. Récord en Nürburgring, escapes de titanio centrales y un chasis tan afinado que te hace olvidar que estás manejando un vehículo de dos toneladas.', 'porsche_cayenne_gt.jpg'),

-- CATEGORÍA 6: KOENIGSEGG
(6, 'Koenigsegg', 'Jesko Absolut', 2024, 2, '5.0 V8 Twin-Turbo', 100.00, 800000.00, 'Diseñado con un solo objetivo en mente: ser el auto de producción más rápido de la historia. Aerodinámica alisada, 1600 CV con biocombustible y una transmisión de 9 marchas y 7 embragues que cambia a la velocidad de la luz.', 'koenigsegg_jesko.jpg'),

-- CATEGORÍA 7: BMW
(7, 'BMW', 'M3 Competition Touring', 2024, 5, '3.0 L6 TwinPower', 2500.00, 120000.00, 'La rural deportiva que los fanáticos pidieron durante décadas. Espacio para el perro en el baúl y 510 CV con tracción total para disfrutar en la montaña.', 'bmw_m3_touring.jpg'),
(7, 'BMW', 'M5 CS', 2022, 4, '4.4 V8 TwinPower', 7000.00, 160000.00, 'Una edición limitada del sedán legendario. Más ligero, más rígido, con acentos en bronce y cuatro asientos tipo baquet individuales. El pináculo de BMW M en sedanes.', 'bmw_m5_cs.jpg'),

-- CATEGORÍA 8: LAMBORGHINI
(8, 'Lamborghini', 'Revuelto', 2024, 2, '6.5 V12 Híbrido', 800.00, 380000.00, 'El sucesor del Aventador. El primer V12 híbrido enchufable de la marca (HPEV) con más de 1000 caballos de fuerza combinados. Un toro italiano salvaje modernizado para la nueva era.', 'lamborghini_revuelto.jpg'),
(8, 'Lamborghini', 'Aventador SVJ', 2021, 2, '6.5 V12 Atmosférico', 8000.00, 400000.00, 'Super Veloce Jota. El clímax del motor V12 puramente a combustión. Aerodinámica activa ALA 2.0, estética de nave espacial y un sonido de escape ensordecedor.', 'lamborghini_aventador_svj.jpg');