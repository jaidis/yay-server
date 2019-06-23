-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 10-06-2019 a las 18:22:41
-- Versión del servidor: 10.3.15-MariaDB
-- Versión de PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `yay`
--
-- DROP DATABASE IF EXISTS `yay`;
-- CREATE DATABASE `yay`;
USE `yay`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) unsigned NOT NULL,
  `logo` varchar(100) COLLATE utf8_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `categories` (id, logo, name, description)
VALUES (1, "https://i.imgur.com/heRdgVk.jpg", 'Asian', 'Asian food'),
(2, "https://i.imgur.com/pb0aKoX.jpg", 'Japanese', 'Japanese food'),
(3, "https://i.imgur.com/l9Xyg9O.jpg", 'Italian', 'Italian food'),
(4, "https://i.imgur.com/T0kor46.jpg", 'American', 'American food'),
(5, "https://i.imgur.com/mF42OaQ.jpg", 'Germany', 'German food'),
(6, "https://i.imgur.com/fdutBrD.jpg", 'Spain', 'Spain food');

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 6;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs`
--
DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id_event`          int(10) UNSIGNED NOT NULL,
  `event_name`        varchar(1000)    NULL,
  `event_description` varchar(65535)   NULL,
  `event_type`        varchar(100)     NULL,
  `event_date`        timestamp        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `event_ip`          varchar(20)      NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

--
-- Indices de la tabla `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id_event`),
  ADD UNIQUE KEY `id_event` (`id_event`);

--
-- AUTO_INCREMENT de la tabla `logs`
--
ALTER TABLE `logs`
  MODIFY `id_event` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restaurants`
--
DROP TABLE IF EXISTS `restaurants`;
CREATE TABLE `restaurants` (
  `id` int(11) unsigned NOT NULL,
  `logo` varchar(100) COLLATE utf8_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8_general_ci NOT NULL,
  `location` varchar(1000) COLLATE utf8_general_ci NOT NULL,
  `province` varchar(50) COLLATE utf8_general_ci NOT NULL,
  `coordenateX` varchar(12) COLLATE utf8_general_ci,
  `coordenateY` varchar(12) COLLATE utf8_general_ci,
  `transport_nearby` varchar(255) COLLATE utf8_general_ci,
  `maximum_capacity` int(11) unsigned NOT NULL,
  `price` float unsigned NOT NULL DEFAULT 0.0,
  `score` int(3) unsigned NOT NULL DEFAULT 0,
  `promoted_content` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `restaurants` (id, logo, name, description, location, province, coordenateX, coordenateY, transport_nearby, maximum_capacity, price, score, promoted_content)
VALUES (1, "https://i.imgur.com/heRdgVk.jpg", "Pijo's Restaurant", "Restaurante pijo que te cobra un dineral", "Calle de la Proximidad, Local 85, Granada", "Granada", "37.1492398", "-3.6075692", "Metropolitano: Parada parque tecnológico de la salud", 50, 19.99, 80, 1),
(2, "https://i.imgur.com/T0kor46.jpg", "Burguer's Restaurant", "Restaurante de hamburguesas que se derriten en la boca", "Calle de la Iluminación, Local 100, Granada", "Granada", "37.1492398", "-3.6075692", "Parada bus: 1, 5, 7", 50, 29.99, 90, 1),
(3, "https://i.imgur.com/iKwcMRI.jpg", "Casa di Pepe", "Platos elaborados de forma artesanal con recetas las mejores recetas de Modena", "Calle espiritual, Local 1, Granada", "Granada", "37.1492398", "-3.6075692", "Parada taxi a 100 metros", 30, 14.95, 70, 0);

--
-- Indices de la tabla `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de la tabla `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 2;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restaurants_categories`
--
DROP TABLE IF EXISTS `restaurants_categories`;
CREATE TABLE `restaurants_categories` (
  `id_auto` int(11) unsigned NOT NULL,
  `id_restaurant` int(11) unsigned NOT NULL,
  `id_category` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `restaurants_categories` (id_auto, id_restaurant, id_category)
VALUES (1, 3, 3),
  (2,1,6),
  (3,2,4);

--
-- Indices de la tabla `restaurants_categories`
--
ALTER TABLE `restaurants_categories`
  ADD PRIMARY KEY (`id_auto`);

--
-- AUTO_INCREMENT de la tabla `restaurants_categories`
--
ALTER TABLE `restaurants_categories`
  ADD CONSTRAINT `restaurants_categories_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `restaurants_categories_ibfk_2` FOREIGN KEY (`id_restaurant`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  MODIFY `id_auto` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restaurants_entrees`
--
DROP TABLE IF EXISTS `restaurants_entrees`;
CREATE TABLE `restaurants_entrees` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `price` float unsigned NOT NULL DEFAULT 0.0,
  `id_restaurant` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `restaurants_entrees` (id, name, price, id_restaurant)
VALUES
  (1, "jamon", 8.95, 1),
  (2, "queso", 7.95, 1),
  (3, "mixto", 14.95, 1),
  (4, "Patatas fritas", 4.95, 2),
  (5, "Patatas con salsa picante", 7.95, 2),
  (6, "Patatas con salsa barbacoa", 7.95, 2),
  (7, "Rabioli vegetal", 12.95, 3),
  (8, "Rabioli de carne", 12.95, 3),
  (9, "Tabla de quesos", 9.95, 3);

--
-- Indices de la tabla `restaurants_entrees`
--
ALTER TABLE `restaurants_entrees`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de la tabla `restaurants_entrees`
--
ALTER TABLE `restaurants_entrees`
  ADD CONSTRAINT `restaurants_entrees_ibfk_1` FOREIGN KEY (`id_restaurant`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 9;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restaurants_salads`
--
DROP TABLE IF EXISTS `restaurants_salads`;
CREATE TABLE `restaurants_salads` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `price` float unsigned NOT NULL DEFAULT 0.0,
  `id_restaurant` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `restaurants_salads` (id, name, price, id_restaurant)
VALUES
  (1, "Ensalada teriyaki con frutas del bosque", 49.99, 1),
  (2, "Ensala mixta", 8.95, 1),
  (3, "Ensalada de verano", 11.95, 1);

--
-- Indices de la tabla `restaurants_salads`
--
ALTER TABLE `restaurants_salads`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de la tabla `restaurants_salads`
--
ALTER TABLE `restaurants_salads`
  ADD CONSTRAINT `restaurants_salads_ibfk_1` FOREIGN KEY (`id_restaurant`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restaurants_soups`
--
DROP TABLE IF EXISTS `restaurants_soups`;
CREATE TABLE `restaurants_soups` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `price` float unsigned NOT NULL DEFAULT 0.0,
  `id_restaurant` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `restaurants_soups` (id, name, price, id_restaurant)
VALUES
  (1, "Sopa marisco", 8.95, 1),
  (2, "Sopa de cocido", 7.95, 1),
  (3, "Crema de verduras", 5.95, 1);

--
-- Indices de la tabla `restaurants_soups`
--
ALTER TABLE `restaurants_soups`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de la tabla `restaurants_soups`
--
ALTER TABLE `restaurants_soups`
  ADD CONSTRAINT `restaurants_soups_ibfk_1` FOREIGN KEY (`id_restaurant`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restaurants_meats`
--
DROP TABLE IF EXISTS `restaurants_meats`;
CREATE TABLE `restaurants_meats` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `price` float unsigned NOT NULL DEFAULT 0.0,
  `id_restaurant` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `restaurants_meats` (id, name, price, id_restaurant)
VALUES
  (1, "Carne de toro", 18.95, 1),
  (2, "Carne de caballo", 22.95, 1),
  (3, "Carne de venado", 25.95, 1);

--
-- Indices de la tabla `restaurants_meats`
--
ALTER TABLE `restaurants_meats`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de la tabla `restaurants_meats`
--
ALTER TABLE `restaurants_meats`
  ADD CONSTRAINT `restaurants_meats_ibfk_1` FOREIGN KEY (`id_restaurant`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restaurants_fishes`
--
DROP TABLE IF EXISTS `restaurants_fishes`;
CREATE TABLE `restaurants_fishes` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `price` float unsigned NOT NULL DEFAULT 0.0,
  `id_restaurant` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `restaurants_fishes` (id, name, price, id_restaurant)
VALUES
  (1, "Fritura de pescado", 18.95, 1),
  (2, "Salmón a la plancha con verduras", 19.95, 1),
  (3, "Bacalao con tomate", 15.95, 1);

--
-- Indices de la tabla `restaurants_fishes`
--
ALTER TABLE `restaurants_fishes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de la tabla `restaurants_fishes`
--
ALTER TABLE `restaurants_fishes`
  ADD CONSTRAINT `restaurants_fishes_ibfk_1` FOREIGN KEY (`id_restaurant`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restaurants_specialties`
--
DROP TABLE IF EXISTS `restaurants_specialties`;
CREATE TABLE `restaurants_specialties` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `price` float unsigned NOT NULL DEFAULT 0.0,
  `id_restaurant` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `restaurants_specialties` (id, name, price, id_restaurant)
VALUES
  (1, "Especial 1", 8.95, 1),
  (2, "Especial 2", 7.95, 1),
  (3, "Especial 3", 5.95, 1);

--
-- Indices de la tabla `restaurants_specialties`
--
ALTER TABLE `restaurants_specialties`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de la tabla `restaurants_specialties`
--
ALTER TABLE `restaurants_specialties`
  ADD CONSTRAINT `restaurants_specialties_ibfk_1` FOREIGN KEY (`id_restaurant`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restaurants_schedule`
--
DROP TABLE IF EXISTS `restaurants_schedule`;
CREATE TABLE `restaurants_schedule` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `id_restaurant` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `restaurants_schedule` (id, name, description, id_restaurant)
VALUES
  (1, "L-V", "08:00 - 24:00", 1),
  (2, "S", "12:00 - 02:00", 1);

--
-- Indices de la tabla `restaurants_schedule`
--
ALTER TABLE `restaurants_schedule`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de la tabla `restaurants_schedule`
--
ALTER TABLE `restaurants_schedule`
  ADD CONSTRAINT `restaurants_schedule_ibfk_1` FOREIGN KEY (`id_restaurant`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 2;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL,
  `email` varchar(100) COLLATE utf8_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8_general_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8_general_ci NOT NULL,
  `phone_number` varchar(100) COLLATE utf8_general_ci NOT NULL,
  `birth_date` varchar(10) COLLATE utf8_general_ci,
  `address` varchar(200) COLLATE utf8_general_ci,
  `address_locale` varchar(60) COLLATE utf8_general_ci,
  `address_province` varchar(60) COLLATE utf8_general_ci,
  `address_postal` int(5) COLLATE utf8_general_ci,
  `address_country` varchar(60) COLLATE utf8_general_ci,
  `token` varchar(50) COLLATE utf8_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `users` (id, email, password, first_name, last_name, phone_number, token)
VALUES
  (1, 'manmunlop@gmail.com', "$2y$10$9hV2lU0QUvPJKK9vfuiI0edGbZOk5LKR.Mf7dyzpYh8BQqZtX5lFi", "Manuel", "Muñoz", "+34640625633", "ec0fc94cae0e9f5c505951d140cdcb2a756af12f687c7a5bde");

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_favorites`
--
DROP TABLE IF EXISTS `users_favorites`;
CREATE TABLE `users_favorites` (
  `id` int(11) unsigned NOT NULL,
  `logo` varchar(100) COLLATE utf8_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `id_restaurant` int(11) unsigned NOT NULL,
  `id_user` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `users_favorites` (id, logo, name, id_restaurant, id_user)
VALUES
  (1, "https://i.imgur.com/heRdgVk.jpg", "Pijo's Restaurant", 1, 1),
  (2, "https://i.imgur.com/T0kor46.jpg", "Burguer's Restaurant", 2, 1);

--
-- Indices de la tabla `users_favorites`
--
ALTER TABLE `users_favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE `unique_favorites`(`id_restaurant`, `id_user`);

--
-- AUTO_INCREMENT de la tabla `users_favorites`
--
ALTER TABLE `users_favorites`
  ADD CONSTRAINT `users_favorites_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_favorites_ibfk_2` FOREIGN KEY (`id_restaurant`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 2;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_credit_card`
--
DROP TABLE IF EXISTS `users_credit_card`;
CREATE TABLE `users_credit_card` (
  `id` int(11) unsigned NOT NULL,
  `number` varchar(19) COLLATE utf8_general_ci NOT NULL,
  `expiry` varchar(5) COLLATE utf8_general_ci NOT NULL,
  `cvc` varchar(3) COLLATE utf8_general_ci NOT NULL,
  `type` varchar(20) COLLATE utf8_general_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_general_ci NOT NULL,
  `id_user` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `users_credit_card` (id, number, expiry, cvc, type, name, id_user)
VALUES
  (1, "4242 4242 4242 4242", "09/20", "300", "visa", "Manuel Muñoz", 1),
  (2, "5270 2700 0116 9342", "05/20", "070", "master-card", "Manuel Muñoz", 1);

--
-- Indices de la tabla `users_credit_card`
--
ALTER TABLE `users_credit_card`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de la tabla `users_credit_card`
--
ALTER TABLE `users_credit_card`
  ADD CONSTRAINT `users_credit_card_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 2;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restaurants_bookings`
--
DROP TABLE IF EXISTS `restaurants_bookings`;
CREATE TABLE `restaurants_bookings` (
  `id_auto` int(11) unsigned NOT NULL,
  `restaurant_logo` varchar(100) COLLATE utf8_general_ci NOT NULL,
  `restaurant_name` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `reserve_date` varchar(10) COLLATE utf8_general_ci NOT NULL,
  `reserve_time` varchar(10) COLLATE utf8_general_ci NOT NULL,
  `diners` int(11) unsigned NOT NULL,
  `id_restaurant` int(11) unsigned NOT NULL,
  `email` varchar(100) COLLATE utf8_general_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8_general_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8_general_ci NOT NULL,
  `phone_number` varchar(100) COLLATE utf8_general_ci NOT NULL,
  `id_user` int(11) unsigned NOT NULL,
  `id_credit_card` int(11) unsigned NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(100) COLLATE utf8_general_ci NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `restaurants_bookings` (id_auto, restaurant_logo, restaurant_name, reserve_date, reserve_time, diners, id_restaurant, email, first_name, last_name, phone_number, id_user, id_credit_card)
VALUES (1, "https://i.imgur.com/heRdgVk.jpg", "Pijo's Restaurant", "2019-06-20", "12:00", 2, 1, "manmunlop@gmail.com", "Manuel", "Muñoz", "+64640625633", 1, 1),
(2, "https://i.imgur.com/T0kor46.jpg", "Burguer's Restaurant", "2019-06-22", "14:00", 6, 2, "manmunlop@gmail.com", "Manuel", "Muñoz", "+64640625633", 1, 2);

--
-- Indices de la tabla `restaurants_bookings`
--
ALTER TABLE `restaurants_bookings`
  ADD PRIMARY KEY (`id_auto`);

--
-- AUTO_INCREMENT de la tabla `restaurants_bookings`
--
ALTER TABLE `restaurants_bookings`
  ADD CONSTRAINT `restaurants_bookings_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `restaurants_bookings_ibfk_2` FOREIGN KEY (`id_restaurant`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  MODIFY `id_auto` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 2;

-- --------------------------------------------------------

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
