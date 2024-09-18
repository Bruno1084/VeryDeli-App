-- Usuarios de ejemplo
INSERT INTO `usuarios` (`usuario_nombre`, `usuario_apellido`, `usuario_localidad`, `usuario_correo`, `usuario_usuario`, `usuario_contraseña`, `usuario_esResponsable`, `usuario_esActivo`)
VALUES 
('Juan', 'Perez', 'Buenos Aires', 'juan.perez@example.com', 'juanperez', 'password123', 1, 1),
('Maria', 'Gonzalez', 'Cordoba', 'maria.gonzalez@example.com', 'mariagonzalez', 'mypass456', 0, 1);


-- Transportistas de ejemplo
INSERT INTO `transportistas` (`transportista_id`)
VALUES 
(2);  -- assuming this transportista is a user with usuario_id = 2


-- Administradores de ejemplo
INSERT INTO `administradores` (`administrador_id`)
VALUES 
(1);  -- assuming this admin is a user with usuario_id = 1


-- Vehículos de ejemplo
INSERT INTO `vehiculos` (`vehiculo_patente`, `vehiculo_tipoVehiculo`, `vehiculo_pesoSoportado`, `vehiculo_volumenSoportado`, `transportista_id`)
VALUES 
('ABC123', 'Camion', 2000.5, 50.75, 1),
('XYZ789', 'Furgoneta', 1000.0, 25.0, 2);


-- Publicaciones de ejemplo
INSERT INTO `publicaciones` (`publicacion_descr`, `publicacion_volumen`, `publicacion_peso`, `publicacion_nombreRecibe`, `publicacion_telefono`, `publicacion_origen`, `publicacion_destino`, `usuario_autor`, `usuario_transportista`, `publicacion_esActivo`)
VALUES 
('Entrega de muebles', 30.5, 120.0, 'Carlos Lopez', '123456789', 'Mendoza', 'San Juan', 1, 1, 1),
('Transporte de alimentos', 50.0, 500.0, 'Ana Diaz', '987654321', 'Rosario', 'Santa Fe', 2, 2, 1);


-- Comentarios de ejemplo
INSERT INTO `comentarios` (`publicacion_id`, `usuario_id`, `comentario_mensaje`)
VALUES 
(1, 2, 'Excelente servicio!'),
(2, 1, 'Muy satisfecho con el transporte.');


-- Postulaciones de ejemplo
INSERT INTO `postulaciones` (`publicacion_id`, `usuarios_postulante`, `postulacion_precio`, `postulacion_descr`)
VALUES 
(1, 2, 1500.0, 'Puedo hacer el trabajo por $1500.'),
(2, 1, 2000.0, 'Estoy disponible para esta entrega por $2000.');


-- Calificaciones de ejemplo
INSERT INTO `calificaciones` (`publicacion_id`, `usuario_calificado`, `usuario_calificador`, `calificacion_puntaje`)
VALUES 
(1, 1, 2, '5'),
(2, 2, 1, '4');