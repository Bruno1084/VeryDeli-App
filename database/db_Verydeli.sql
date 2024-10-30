
CREATE TABLE `usuarios` (
    `usuario_id` int AUTO_INCREMENT NOT NULL ,
    `usuario_nombre` varchar(65)  NOT NULL ,
    `usuario_apellido` varchar(65) NOT NULL,
    `usuario_localidad` varchar(65) NOT NULL,
    `usuario_correo` varchar(65) UNIQUE NOT NULL ,
    `usuario_usuario` varchar(65) UNIQUE NOT NULL, 
    `usuario_contraseña` varchar(255)  NOT NULL ,
    `usuario_esResponsable` tinyint(1)  NOT NULL ,
    `usuario_esActivo` tinyint(1)  NOT NULL ,
    PRIMARY KEY (
        `usuario_id`
    )
);

CREATE TABLE `transportistas` (
    `transportista_id` int  NOT NULL ,

    CONSTRAINT `uc_transportistas_transportista_id` UNIQUE (
        `transportista_id`
    )
);

CREATE TABLE `vehiculos` (
    `vehiculo_id` int AUTO_INCREMENT NOT NULL ,
    `vehiculo_patente` varchar(10)  NULL ,
    `vehiculo_tipoVehiculo` varchar(80)  NULL ,
    `vehiculo_pesoSoportado` float  NULL ,
    `vehiculo_volumenSoportado` float  NULL ,
    `transportista_id` int  NULL ,
    PRIMARY KEY (
        `vehiculo_id`
    )
);

CREATE TABLE `publicaciones` (
    `publicacion_id` int AUTO_INCREMENT NOT NULL ,
    `publicacion_titulo` varchar(500)  NOT NULL ,
    `publicacion_fecha` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `publicacion_descr` varchar(500)  NOT NULL ,
    `publicacion_volumen` float  NULL ,
    `publicacion_peso` float  NULL ,
    `publicacion_nombreRecibe` varchar(100)  NULL ,
    `publicacion_telefono` varchar(15)  NULL ,
    `ubicacion_origen` int NOT NULL ,
    `ubicacion_destino` int NOT NULL ,
    `usuario_autor` int  NOT NULL ,
    `usuario_transportista` int  NULL ,
    `publicacion_esActivo` enum('0','1','2','3')  NOT NULL ,
    PRIMARY KEY (
        `publicacion_id`
    )
);

CREATE TABLE `ubicaciones` (
    `ubicacion_id` int AUTO_INCREMENT NOT NULL ,
    `ubicacion_latitud` double NOT NULL ,
    `ubicacion_longitud` double NOT NULL ,
    `ubicacion_barrio` varchar(100) NOT NULL ,
    `ubicacion_manzana-piso` varchar(15) NOT NULL ,
    `ubicacion_casa-depto` varchar(15) NOT NULL ,
    PRIMARY KEY (
        `ubicacion_id`
    )
);

CREATE TABLE `imagenes` (
    `imagen_id` int AUTO_INCREMENT NOT NULL ,
    `imagen_url` varchar(255) NOT NULL ,
    `imagen_delete_url` varchar(255) NOT NULL ,
    `publicacion_id` int  NOT NULL, 
    PRIMARY KEY (
        `imagen_id`
    )
);

CREATE TABLE `comentarios` (
    `comentario_id` int AUTO_INCREMENT NOT NULL ,
    `publicacion_id` int  NOT NULL ,
    `usuario_id` int  NOT NULL ,
    `comentario_mensaje` varchar(500)  NOT NULL ,
    `comentario_fecha` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `comentario_esActivo` tinyint(1) NOT NULL,
    PRIMARY KEY (
        `comentario_id`
    )
);

CREATE TABLE `postulaciones` (
    `postulacion_id` int AUTO_INCREMENT NOT NULL ,
    `publicacion_id` int  NOT NULL ,
    `usuario_postulante` int  NOT NULL ,
    `postulacion_precio` float  NOT NULL ,
    `postulacion_descr` varchar(500)  NULL ,
    `postulacion_fecha` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `postulacion_estado` enum('0', '1', '2') NOT NULL DEFAULT '0'
    PRIMARY KEY (
        `postulacion_id`
    )
);

CREATE TABLE `calificaciones` (
    `calificacion_id` int AUTO_INCREMENT NOT NULL ,
    `publicacion_id` int  NOT NULL ,
    `usuario_calificado` int  NOT NULL ,
    `usuario_calificador` int  NOT NULL ,
    `calificacion_puntaje` enum('1','2','3','4','5')  NOT NULL ,
    `calificacion_fecha` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (
        `calificacion_id`
    )
);

CREATE TABLE `administradores` (
    `administrador_id` int  NOT NULL ,

    CONSTRAINT `uc_administradores_administrador_id` UNIQUE (
        `administrador_id`
    )
);

CREATE TABLE `verificaciones` (
    `verificacion_id` INT NOT NULL AUTO_INCREMENT ,
    `verificacion_foto-doc1` VARCHAR(255) NOT NULL ,
    `verificacion_foto-doc2` VARCHAR(255) NULL ,
    `verificacion_foto-boleta1` VARCHAR(255) NOT NULL ,
    `verificacion_foto-boleta2` VARCHAR(255) NULL ,
    `verificacion_tipo-doc` enum('1','2','3','4') NOT NULL ,
    `verificacion_tipo-boleta` enum('1','2','3','4') NOT NULL ,
    `verificacion_estado` BOOLEAN NOT NULL ,
    `usuario_id` INT NOT NULL ,
    PRIMARY KEY (
        `verificacion_id`
    )
);

CREATE TABLE `notificaciones` (
    `notificacion_id` INT NOT NULL AUTO_INCREMENT ,
    `notificacion_mensaje` VARCHAR(255) NOT NULL ,
    `notificacion_estado` BOOLEAN NOT NULL ,
    `usuario_id` INT NOT NULL ,
    `publicacion_id` INT NULL,
    PRIMARY KEY (
        `notificacion_id`
    )
);
CREATE TABLE `publicaciones_reportadas` (
    `reporte_id` int AUTO_INCREMENT NOT NULL ,
    `publicacion_id` int  NOT NULL ,
    `usuario_autor` int  NOT NULL ,
    `reporte_motivo` varchar(30)  NOT NULL ,
    `reporte_mensaje` varchar(255) NULL ,
    `reporte_fecha` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `reporte_activo` tinyint(1) DEFAULT 1 NOT NULL,
    PRIMARY KEY (
        `reporte_id`
    )
);

ALTER TABLE `transportistas` ADD CONSTRAINT `fk_transportistas_transportista_id` FOREIGN KEY(`transportista_id`)
REFERENCES `usuarios` (`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `vehiculos` ADD CONSTRAINT `fk_vehiculos_transportista_id` FOREIGN KEY(`transportista_id`)
REFERENCES `transportistas` (`transportista_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `publicaciones` ADD CONSTRAINT `fk_publicaciones_ubicacion_origen` FOREIGN KEY(`ubicacion_origen`)
REFERENCES `ubicaciones` (`ubicacion_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `publicaciones` ADD CONSTRAINT `fk_publicaciones_ubicacion_destino` FOREIGN KEY(`ubicacion_destino`)
REFERENCES `ubicaciones` (`ubicacion_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `publicaciones` ADD CONSTRAINT `fk_publicaciones_usuario_autor` FOREIGN KEY(`usuario_autor`)
REFERENCES `usuarios` (`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `publicaciones` ADD CONSTRAINT `fk_publicaciones_usuario_transportista` FOREIGN KEY(`usuario_transportista`)
REFERENCES `usuarios` (`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `imagenes` ADD CONSTRAINT `fk_imagenes_publicacion_id` FOREIGN KEY(`publicacion_id`)
REFERENCES `publicaciones` (`publicacion_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `comentarios` ADD CONSTRAINT `fk_comentarios_publicacion_id` FOREIGN KEY(`publicacion_id`)
REFERENCES `publicaciones` (`publicacion_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `comentarios` ADD CONSTRAINT `fk_comentarios_usuario_id` FOREIGN KEY(`usuario_id`)
REFERENCES `usuarios` (`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `postulaciones` ADD CONSTRAINT `fk_postulaciones_publicacion_id` FOREIGN KEY(`publicacion_id`)
REFERENCES `publicaciones` (`publicacion_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `postulaciones` ADD CONSTRAINT `fk_postulaciones_usuario_postulante` FOREIGN KEY(`usuario_postulante`)
REFERENCES `usuarios` (`usuario_id`);

ALTER TABLE `calificaciones` ADD CONSTRAINT `fk_calificaciones_publicacion_id` FOREIGN KEY(`publicacion_id`)
REFERENCES `publicaciones` (`publicacion_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `calificaciones` ADD CONSTRAINT `fk_calificaciones_usuario_calificado` FOREIGN KEY(`usuario_calificado`)
REFERENCES `usuarios` (`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `calificaciones` ADD CONSTRAINT `fk_calificaciones_usuario_calificador` FOREIGN KEY(`usuario_calificador`)
REFERENCES `usuarios` (`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `administradores` ADD CONSTRAINT `fk_administradores_administrador_id` FOREIGN KEY(`administrador_id`)
REFERENCES `usuarios` (`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `verificaciones` ADD CONSTRAINT `fk_verificaciones_usuario_id` FOREIGN KEY (`usuario_id`)
REFERENCES `usuarios`(`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `notificaciones` ADD CONSTRAINT `fk_notificaciones_usuario_id` FOREIGN KEY (`usuario_id`)
REFERENCES `usuarios`(`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `notificaciones` ADD CONSTRAINT `fk_notificaciones_publicacion_id` FOREIGN KEY (`publicacion_id`)
REFERENCES `publicaciones`(`publicacion_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `publicaciones_reportadas` ADD CONSTRAINT `fk_publicaciones_reportadas_publicacion_id` FOREIGN KEY(`publicacion_id`)
REFERENCES `publicaciones` (`publicacion_id`);

ALTER TABLE `publicaciones_reportadas` ADD CONSTRAINT `fk_publicaciones_reportadas_usuario_autor` FOREIGN KEY(`usuario_autor`)
REFERENCES `usuarios` (`usuario_id`);

CREATE INDEX `idx_vehiculos_transportista_id`
ON `vehiculos` (`transportista_id`);

CREATE INDEX `idx_publicaciones_usuario_autor`
ON `publicaciones` (`usuario_autor`);

CREATE INDEX `idx_publicaciones_usuario_transportista`
ON `publicaciones` (`usuario_transportista`);

CREATE INDEX `idx_comentarios_publicacion_id`
ON `comentarios` (`publicacion_id`);

CREATE INDEX `idx_comentarios_usuario_id`
ON `comentarios` (`usuario_id`);

CREATE INDEX `idx_postulaciones_publicacion_id`
ON `postulaciones` (`publicacion_id`);

CREATE INDEX `idx_postulaciones_usuario_postulante`
ON `postulaciones` (`usuario_postulante`);

CREATE INDEX `idx_calificaciones_publicacion_id`
ON `calificaciones` (`publicacion_id`);

CREATE INDEX `idx_calificaciones_usuario_calificado`
ON `calificaciones` (`usuario_calificado`);

CREATE INDEX `idx_calificaciones_usuario_calificador`
ON `calificaciones` (`usuario_calificador`);

CREATE INDEX `idx_publicaciones_reportadas_usuario_autor`
ON `publicaciones_reportadas` (`usuario_autor`);

CREATE INDEX `idx_publicaciones_reportadas_publicacion_id`
ON `publicaciones_reportadas` (`publicacion_id`);