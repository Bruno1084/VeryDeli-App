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
    `usuarios_id` int AUTO_INCREMENT NOT NULL ,
    `usuarios_nombre` varchar(65)  NOT NULL ,
    `usuarios_correo` varchar(65) UNIQUE NOT NULL ,
    `usuarios_contraseña` varchar(25)  NOT NULL ,
    `usuarios_esResponsable` tinyint(1)  NOT NULL ,
    `usuarios_esActivo` tinyint(1)  NOT NULL ,
    PRIMARY KEY (
        `usuarios_id`
    )
);

CREATE TABLE `transportistas` (
    `transportistas_id` int  NOT NULL ,

    CONSTRAINT `uc_transportistas_transportistas_id` UNIQUE (
        `transportistas_id`
    )
);

CREATE TABLE `vehiculos` (
    `vehiculos_id` int AUTO_INCREMENT NOT NULL ,
    `vehiculos_patente` varchar(10)  NULL ,
    `vehiculos_tipoVehiculo` varchar(80)  NULL ,
    `vehiculos_pesoSoportado` float  NULL ,
    `vehiculo_volumenSoportado` float  NULL ,
    `transportistas_id` int  NULL ,
    PRIMARY KEY (
        `vehiculos_id`
    )
);

CREATE TABLE `publicaciones` (
    `publicaciones_id` int AUTO_INCREMENT NOT NULL ,
    `publicaciones_fecha` date  NULL DEFAULT (curdate()),
    `publicaciones_descr` varchar(500)  NOT NULL ,
    `publicaciones_volumen` float  NULL ,
    `publicaciones_peso` float  NULL ,
    `publicaciones_nombreRecibe` varchar(100)  NULL ,
    `publicaciones_telefono` varchar(15)  NULL ,
    `publicaciones_origen` varchar(100)  NULL ,
    `publicaciones_destino` varchar(100)  NULL ,
    `usuarios_autor` int  NOT NULL ,
    `usuarios_transportista` int  NULL ,
    `publicaciones_esActivo` tinyint(1)  NOT NULL ,
    PRIMARY KEY (
        `publicaciones_id`
    )
);

CREATE TABLE `imagenes` (
    `imagenes_url` varchar  NULL ,
    `publicaciones_id` int  NOT NULL 
);

CREATE TABLE `comentarios` (
    `comentarios_id` int AUTO_INCREMENT NOT NULL ,
    `publicaciones_id` int  NOT NULL ,
    `usuarios_id` int  NOT NULL ,
    `comentarios_mensaje` varchar(500)  NOT NULL ,
    `comentarios_fecha` date  NULL DEFAULT (curdate()),
    PRIMARY KEY (
        `comentarios_id`
    )
);

CREATE TABLE `postulaciones` (
    `postulaciones_id` int AUTO_INCREMENT NOT NULL ,
    `publicaciones_id` int  NOT NULL ,
    `usuarios_postulante` int  NOT NULL ,
    `postulaciones_precio` float  NOT NULL ,
    `postulaciones_descr` varchar(500)  NULL ,
    `postulaciones_fecha` date  NULL DEFAULT (curdate()),
    PRIMARY KEY (
        `postulaciones_id`
    )
);

CREATE TABLE `calificaciones` (
    `calificacion_id` int AUTO_INCREMENT NOT NULL ,
    `publicaciones_id` int  NOT NULL ,
    `usuario_calificado` int  NOT NULL ,
    `usuario_calificador` int  NOT NULL ,
    `calificacion_puntaje` enum('1','2','3','4','5')  NOT NULL ,
    `calificacion_fecha` date  NOT NULL ,
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

ALTER TABLE `transportistas` ADD CONSTRAINT `fk_transportistas_transportistas_id` FOREIGN KEY(`transportistas_id`)
REFERENCES `usuarios` (`usuarios_id`);

ALTER TABLE `vehiculos` ADD CONSTRAINT `fk_vehiculos_transportistas_id` FOREIGN KEY(`transportistas_id`)
REFERENCES `transportistas` (`transportistas_id`);

ALTER TABLE `publicaciones` ADD CONSTRAINT `fk_publicaciones_usuarios_autor` FOREIGN KEY(`usuarios_autor`)
REFERENCES `usuarios` (`usuarios_id`);

ALTER TABLE `publicaciones` ADD CONSTRAINT `fk_publicaciones_usuarios_transportista` FOREIGN KEY(`usuarios_transportista`)
REFERENCES `usuarios` (`usuarios_id`);

ALTER TABLE `imagenes` ADD CONSTRAINT `fk_imagenes_publicaciones_id` FOREIGN KEY(`publicaciones_id`)
REFERENCES `publicaciones` (`publicaciones_id`);

ALTER TABLE `comentarios` ADD CONSTRAINT `fk_comentarios_publicaciones_id` FOREIGN KEY(`publicaciones_id`)
REFERENCES `publicaciones` (`publicaciones_id`);

ALTER TABLE `comentarios` ADD CONSTRAINT `fk_comentarios_usuarios_id` FOREIGN KEY(`usuarios_id`)
REFERENCES `usuarios` (`usuarios_id`);

ALTER TABLE `postulaciones` ADD CONSTRAINT `fk_postulaciones_publicaciones_id` FOREIGN KEY(`publicaciones_id`)
REFERENCES `publicaciones` (`publicaciones_id`);

ALTER TABLE `postulaciones` ADD CONSTRAINT `fk_postulaciones_usuarios_postulante` FOREIGN KEY(`usuarios_postulante`)
REFERENCES `usuarios` (`usuarios_id`);

ALTER TABLE `calificaciones` ADD CONSTRAINT `fk_calificaciones_publicaciones_id` FOREIGN KEY(`publicaciones_id`)
REFERENCES `publicaciones` (`publicaciones_id`);

ALTER TABLE `calificaciones` ADD CONSTRAINT `fk_calificaciones_usuario_calificado` FOREIGN KEY(`usuario_calificado`)
REFERENCES `usuarios` (`usuarios_id`);

ALTER TABLE `calificaciones` ADD CONSTRAINT `fk_calificaciones_usuario_calificador` FOREIGN KEY(`usuario_calificador`)
REFERENCES `usuarios` (`usuarios_id`);

ALTER TABLE `administradores` ADD CONSTRAINT `fk_administradores_administrador_id` FOREIGN KEY(`administrador_id`)
REFERENCES `usuarios` (`usuarios_id`);

CREATE INDEX `idx_vehiculos_transportistas_id`
ON `vehiculos` (`transportistas_id`);

CREATE INDEX `idx_publicaciones_usuarios_autor`
ON `publicaciones` (`usuarios_autor`);

CREATE INDEX `idx_publicaciones_usuarios_transportista`
ON `publicaciones` (`usuarios_transportista`);

CREATE INDEX `idx_imagenes_imagenes_url`
ON `imagenes` (`imagenes_url`);

CREATE INDEX `idx_imagenes_publicaciones_id`
ON `imagenes` (`publicaciones_id`);

CREATE INDEX `idx_comentarios_publicaciones_id`
ON `comentarios` (`publicaciones_id`);

CREATE INDEX `idx_comentarios_usuarios_id`
ON `comentarios` (`usuarios_id`);

CREATE INDEX `idx_postulaciones_publicaciones_id`
ON `postulaciones` (`publicaciones_id`);

CREATE INDEX `idx_postulaciones_usuarios_postulante`
ON `postulaciones` (`usuarios_postulante`);

CREATE INDEX `idx_calificaciones_publicaciones_id`
ON `calificaciones` (`publicaciones_id`);

CREATE INDEX `idx_calificaciones_usuario_calificado`
ON `calificaciones` (`usuario_calificado`);

CREATE INDEX `idx_calificaciones_usuario_calificador`
ON `calificaciones` (`usuario_calificador`);

