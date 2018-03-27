-- phpMyAdmin SQL Dump
-- version 4.2.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 04, 2017 at 11:37 AM
-- Server version: 5.5.39
-- PHP Version: 5.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `polokevalemvc`
--
CREATE DATABASE IF NOT EXISTS `polokevalemvc` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `polokevalemvc`;

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--
-- Creation: Dec 09, 2016 at 08:47 AM
--

DROP TABLE IF EXISTS `chats`;
CREATE TABLE IF NOT EXISTS `chats` (
`id_chat` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `id_requester` varchar(255) NOT NULL,
  `creationdate_chat` date DEFAULT NULL,
  `finished` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `chats`:
--   `id_product`
--       `products` -> `id_product`
--   `id_requester`
--       `users` -> `username`
--

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id_chat`, `id_product`, `id_requester`, `creationdate_chat`, `finished`) VALUES
(1, 5, 'Disi78', '2016-12-02', 1),
(2, 4, 'Disi78', '2016-12-03', 0),
(3, 6, 'LaraT55', '2016-12-04', 0),
(8, 2, 'LaraT55', '2016-12-05', 0);

-- --------------------------------------------------------

--
-- Table structure for table `messagetexts`
--
-- Creation: Dec 12, 2016 at 08:24 PM
--

DROP TABLE IF EXISTS `messagetexts`;
CREATE TABLE IF NOT EXISTS `messagetexts` (
  `id_chat` int(11) NOT NULL,
  `id_messagetext` int(11) NOT NULL,
  `messagetext_text` varchar(2000) DEFAULT NULL,
  `messagetext_date` timestamp NULL DEFAULT NULL,
  `type_message` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `messagetexts`:
--   `id_chat`
--       `chats` -> `id_chat`
--

--
-- Dumping data for table `messagetexts`
--

INSERT INTO `messagetexts` (`id_chat`, `id_messagetext`, `messagetext_text`, `messagetext_date`, `type_message`) VALUES
(2, 167606078, 'Soy Disi', '2017-01-04 10:34:05', 0),
(2, 356417203, 'Por supuesto! Además, el grabado no va a suponer coste adicional. ;)', '2016-12-12 20:47:21', 1),
(2, 912919300, 'Hola, soy Lara', '2016-12-12 20:09:14', 1),
(2, 1336289662, 'A ti!', '2016-12-12 21:05:25', 1),
(2, 1363435466, 'En que te puedo ayudar?', '2016-12-12 20:09:28', 1),
(2, 1398880767, 'Me lo quedo. Muchas gracias! :D', '2016-12-12 20:48:39', 0),
(2, 1571302631, 'Buenas tardes, Lara. El anillo se puede grabar un nombre o fecha?', '2016-12-12 20:11:00', 0),
(2, 1935815449, 'Soy Lara, encantada :I', '2017-01-04 10:34:57', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--
-- Creation: Dec 09, 2016 at 08:47 AM
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
`id_product` int(11) NOT NULL,
  `name_product` varchar(255) DEFAULT NULL,
  `category_product` varchar(255) DEFAULT NULL,
  `content_product` varchar(400) DEFAULT NULL,
  `price_product` int(11) DEFAULT NULL,
  `photo_product` varchar(500) DEFAULT NULL,
  `visitsnumber` int(11) DEFAULT NULL,
  `likesnumber` int(11) DEFAULT NULL,
  `creationdate_product` date DEFAULT NULL,
  `author` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `products`:
--   `author`
--       `users` -> `username`
--

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id_product`, `name_product`, `category_product`, `content_product`, `price_product`, `photo_product`, `visitsnumber`, `likesnumber`, `creationdate_product`, `author`) VALUES
(2, 'Peluche Doraemon', 'Peluches', 'Peluche de colección. Para fans de la mítica serie.', 10, 'd1fdc48be7ca49455148f0e508741a88.jpg', 26, 6, '2016-11-28', 'Disi78'),
(4, 'Anillo Céltico', 'Joya', 'Anillo Claddagh con nudo celta.', 12, '9c58965f2340d05182164ba4c272c583.jpg', 25, 1, '2016-11-28', 'LaraT55'),
(5, 'Botas sin tacón', 'Botas', 'Botas cómodas sin tacón para mujer.', 20, '7b4d4241265c62b60be11157da5c6a15.jpg', 13, 1, '2016-11-28', 'LaraT55'),
(6, 'Libro Casares', 'Lectura', 'Para amantes de la lectura. "Vento Ferido" de Carlos Casares es una de las joyas de este autor homenajeado en Letras Galegas 2017', 7, 'libro_1445414341.jpg', 18, 3, '2016-11-28', 'Disi78'),
(8, 'Camiseta FOB', 'Camiseta', 'Camiseta de la banda Fall Out Boy.', 9, '3b1dc2863d225332bb6d4eab217197eb.png', 10, 0, '2016-12-01', 'Disi78');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- Creation: Dec 09, 2016 at 08:47 AM
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(255) NOT NULL DEFAULT '',
  `name_user` varchar(350) DEFAULT NULL,
  `surname_user` varchar(350) DEFAULT NULL,
  `dni` varchar(9) DEFAULT NULL,
  `passwd` varchar(255) DEFAULT NULL,
  `province` varchar(350) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `name_user`, `surname_user`, `dni`, `passwd`, `province`) VALUES
('Disi78', 'Disidoro', 'Gomez', '22445678I', '12345**//', 'Ourense'),
('LaraT55', 'Lara', 'Gomez', '77660783Y', '23456**//', 'Pontevedra');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
 ADD PRIMARY KEY (`id_chat`), ADD KEY `id_product` (`id_product`), ADD KEY `id_requester` (`id_requester`);

--
-- Indexes for table `messagetexts`
--
ALTER TABLE `messagetexts`
 ADD PRIMARY KEY (`id_chat`,`id_messagetext`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
 ADD PRIMARY KEY (`id_product`), ADD KEY `author` (`author`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
MODIFY `id_chat` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`) ON DELETE CASCADE,
ADD CONSTRAINT `chats_ibfk_2` FOREIGN KEY (`id_requester`) REFERENCES `users` (`username`) ON DELETE CASCADE;

--
-- Constraints for table `messagetexts`
--
ALTER TABLE `messagetexts`
ADD CONSTRAINT `messagetexts_ibfk_1` FOREIGN KEY (`id_chat`) REFERENCES `chats` (`id_chat`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`author`) REFERENCES `users` (`username`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
