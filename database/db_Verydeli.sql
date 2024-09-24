-- Exported from QuickDBD: https://www.quickdatabasediagrams.com/
-- Link to schema: https://app.quickdatabasediagrams.com/?state=08knixjrx8ae&code=4%2F0AQlEd8z7H4bDZnXAaM25PgwBULZnXTolHmWcu5y8_ir9zTkugsExVTXLGeCVjLVULk_77Q&scope=email+profile+openid+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email&authuser=0&prompt=consent#/d/n4R4hi
-- NOTE! If you have used non-SQL datatypes in your design, you will have to change these here.

-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
-- Host: 127.0.0.1    Database: verydely
-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
-- Host: 127.0.0.1    Database: verydely
-- Server version	8.0.34
-- !40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT

-- !40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS
-- !40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION
-- !50503 SET NAMES utf8
-- !40103 SET @OLD_TIME_ZONE=@@TIME_ZONE
-- !40103 SET TIME_ZONE='+00:00'
-- !40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0
-- !40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0
-- !40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO'
-- !40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0
-- Table structure for table `usuarios`
-- !40101 SET @saved_cs_client     = @@character_set_client
-- !50503 SET character_set_client = utf8mb4
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
    `vehiculo_patente` varchar(10)  NOT NULL ,
    `vehiculo_tipoVehiculo` varchar(80)  NOT NULL ,
    `vehiculo_pesoSoportado` float  NOT NULL ,
    `vehiculo_volumenSoportado` float  NOT NULL ,
    `transportista_id` int  NOT NULL ,
    `vehiculo_estado` boolean  NOT NULL ,
    PRIMARY KEY (
        `vehiculo_id`
    )
);


CREATE TABLE `publicaciones` (
    `publicacion_id` int AUTO_INCREMENT NOT NULL ,
    `publicacion_fecha` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `publicacion_descr` varchar(500)  NOT NULL ,
    `publicacion_volumen` float  NOT NULL ,
    `publicacion_peso` float  NOT NULL ,
    `publicacion_nombreRecibe` varchar(100)  NOT NULL ,
    `publicacion_telefono` varchar(15)  NOT NULL ,
    `publicacion_origen` varchar(100)  NOT NULL ,
    `publicacion_destino` varchar(100)  NOT NULL ,
    `usuario_autor` int  NOT NULL ,
    `usuario_transportista` int  NOT NULL ,
    `publicacion_esActivo` tinyint(1)  NOT NULL ,
    PRIMARY KEY (
        `publicacion_id`
    )
);

CREATE TABLE `imagenes` (
    `imagen_url` varchar(255) NOT NULL ,
    `publicacion_id` int  NOT NULL 
);

CREATE TABLE `comentarios` (
    `comentario_id` int AUTO_INCREMENT NOT NULL ,
    `publicacion_id` int  NOT NULL ,
    `usuario_id` int  NOT NULL ,
    `comentario_mensaje` varchar(500)  NOT NULL ,
    `comentario_fecha` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (
        `comentario_id`
    )
);

CREATE TABLE `postulaciones` (
    `postulacion_id` int AUTO_INCREMENT NOT NULL ,
    `publicacion_id` int  NOT NULL ,
    `usuarios_postulante` int  NOT NULL ,
    `postulacion_precio` float  NOT NULL ,
    `postulacion_descr` varchar(500)  NOT NULL ,
    `postulacion_fecha` DATETIME DEFAULT CURRENT_TIMESTAMP,
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

ALTER TABLE `transportistas` ADD CONSTRAINT `fk_transportistas_transportista_id` FOREIGN KEY(`transportista_id`)
REFERENCES `usuarios` (`usuario_id`);

ALTER TABLE `vehiculos` ADD CONSTRAINT `fk_vehiculos_transportista_id` FOREIGN KEY(`transportista_id`)
REFERENCES `transportistas` (`transportista_id`);

ALTER TABLE `publicaciones` ADD CONSTRAINT `fk_publicaciones_usuario_autor` FOREIGN KEY(`usuario_autor`)
REFERENCES `usuarios` (`usuario_id`);

ALTER TABLE `publicaciones` ADD CONSTRAINT `fk_publicaciones_usuario_transportista` FOREIGN KEY(`usuario_transportista`)
REFERENCES `usuarios` (`usuario_id`);

ALTER TABLE `imagenes` ADD CONSTRAINT `fk_imagenes_publicacion_id` FOREIGN KEY(`publicacion_id`)
REFERENCES `publicaciones` (`publicacion_id`);

ALTER TABLE `comentarios` ADD CONSTRAINT `fk_comentarios_publicacion_id` FOREIGN KEY(`publicacion_id`)
REFERENCES `publicaciones` (`publicacion_id`);

ALTER TABLE `comentarios` ADD CONSTRAINT `fk_comentarios_usuario_id` FOREIGN KEY(`usuario_id`)
REFERENCES `usuarios` (`usuario_id`);

ALTER TABLE `postulaciones` ADD CONSTRAINT `fk_postulaciones_publicacion_id` FOREIGN KEY(`publicacion_id`)
REFERENCES `publicaciones` (`publicacion_id`);

ALTER TABLE `postulaciones` ADD CONSTRAINT `fk_postulaciones_usuarios_postulante` FOREIGN KEY(`usuarios_postulante`)
REFERENCES `usuarios` (`usuario_id`);

ALTER TABLE `calificaciones` ADD CONSTRAINT `fk_calificaciones_publicacion_id` FOREIGN KEY(`publicacion_id`)
REFERENCES `publicaciones` (`publicacion_id`);

ALTER TABLE `calificaciones` ADD CONSTRAINT `fk_calificaciones_usuario_calificado` FOREIGN KEY(`usuario_calificado`)
REFERENCES `usuarios` (`usuario_id`);

ALTER TABLE `calificaciones` ADD CONSTRAINT `fk_calificaciones_usuario_calificador` FOREIGN KEY(`usuario_calificador`)
REFERENCES `usuarios` (`usuario_id`);

ALTER TABLE `administradores` ADD CONSTRAINT `fk_administradores_administrador_id` FOREIGN KEY(`administrador_id`)
REFERENCES `usuarios` (`usuario_id`);

CREATE INDEX `idx_vehiculos_transportista_id`
ON `vehiculos` (`transportista_id`);

CREATE INDEX `idx_publicaciones_usuario_autor`
ON `publicaciones` (`usuario_autor`);

CREATE INDEX `idx_publicaciones_usuario_transportista`
ON `publicaciones` (`usuario_transportista`);

CREATE INDEX `idx_imagenes_imagen_url`
ON `imagenes` (`imagen_url`);

CREATE INDEX `idx_imagenes_publicacion_id`
ON `imagenes` (`publicacion_id`);

CREATE INDEX `idx_comentarios_publicacion_id`
ON `comentarios` (`publicacion_id`);

CREATE INDEX `idx_comentarios_usuario_id`
ON `comentarios` (`usuario_id`);

CREATE INDEX `idx_postulaciones_publicacion_id`
ON `postulaciones` (`publicacion_id`);

CREATE INDEX `idx_postulaciones_usuarios_postulante`
ON `postulaciones` (`usuarios_postulante`);

CREATE INDEX `idx_calificaciones_publicacion_id`
ON `calificaciones` (`publicacion_id`);

CREATE INDEX `idx_calificaciones_usuario_calificado`
ON `calificaciones` (`usuario_calificado`);

CREATE INDEX `idx_calificaciones_usuario_calificador`
ON `calificaciones` (`usuario_calificador`);