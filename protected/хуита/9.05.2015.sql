-- phpMyAdmin SQL Dump
-- version 4.3.0
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Май 09 2015 г., 18:00
-- Версия сервера: 5.6.22
-- Версия PHP: 5.4.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `koleso`
--

-- --------------------------------------------------------

--
-- Структура таблицы `attribute`
--

CREATE TABLE IF NOT EXISTS `attribute` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `attribute_type_id` smallint(5) unsigned NOT NULL,
  `multi` tinyint(1) NOT NULL DEFAULT '0',
  `list` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `attribute`
--

INSERT INTO `attribute` (`id`, `name`, `code`, `attribute_type_id`, `multi`, `list`) VALUES
(3, 'Код', 'code', 3, 0, 0),
(4, 'Заголовок', 'title', 3, 0, 0),
(5, 'Сверловка', NULL, 3, 1, 1),
(6, 'Модель Диска', NULL, 3, 0, 0),
(7, 'Ширина шины', NULL, 2, 0, 1),
(8, 'Профиль шины', NULL, 1, 0, 1),
(9, 'Посадочный диаметр', NULL, 3, 0, 1),
(10, 'Год выпуска шины', NULL, 1, 0, 1),
(11, 'Страна изготовитель шины', '123', 4, 0, 0),
(12, 'Остаток шины 1', NULL, 1, 0, 0),
(13, 'Остаток шины 2', NULL, 1, 0, 0),
(14, 'Остаток шины 3', NULL, 1, 0, 0),
(15, 'Остаток шины 4', NULL, 1, 0, 0),
(16, 'Марка шины', NULL, 3, 0, 1),
(17, 'Модель шины', NULL, 3, 0, 1),
(18, 'Индекс нагрузки шины', '129', 3, 0, 1),
(19, 'Индекс скорости шины', NULL, 3, 0, 1),
(20, 'Цена продажи', 'price', 1, 0, 0),
(21, 'Цена за плохую пару шин', NULL, 1, 0, 0),
(22, 'Цена за хорошую пару шин', NULL, 1, 0, 0),
(23, 'Сезонность шин', NULL, 3, 0, 1),
(26, 'Состояние товара', '125', 3, 0, 1),
(27, 'Город нахождения', '126', 3, 0, 1),
(28, 'Количество', '127', 1, 0, 0),
(29, 'Износ шины в %', '128', 1, 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `attribute_type`
--

CREATE TABLE IF NOT EXISTS `attribute_type` (
`id` smallint(5) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `attribute_type`
--

INSERT INTO `attribute_type` (`id`, `name`, `code`) VALUES
(1, 'Целое число', 'int'),
(2, 'Дробное число', 'float'),
(3, 'Строка', 'varchar'),
(4, 'Текст', 'text');

-- --------------------------------------------------------

--
-- Структура таблицы `attribute_variant`
--

CREATE TABLE IF NOT EXISTS `attribute_variant` (
`id` int(10) unsigned NOT NULL,
  `int_value` int(11) DEFAULT NULL,
  `varchar_value` varchar(255) DEFAULT NULL,
  `float_value` float DEFAULT NULL,
  `attribute_id` int(10) unsigned NOT NULL,
  `sort` smallint(5) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=705 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `attribute_variant`
--

INSERT INTO `attribute_variant` (`id`, `int_value`, `varchar_value`, `float_value`, `attribute_id`, `sort`) VALUES
(39, NULL, '98.00x3', NULL, 5, 10),
(40, NULL, '98.00x4', NULL, 5, 20),
(41, NULL, '98.00x5', NULL, 5, 30),
(42, NULL, '100.00x4', NULL, 5, 40),
(43, NULL, '100.00x5', NULL, 5, 50),
(44, NULL, '100.00x9', NULL, 5, 60),
(45, NULL, '105.00x5', NULL, 5, 70),
(46, NULL, '108.00x4', NULL, 5, 80),
(47, NULL, '108.00x5', NULL, 5, 90),
(48, NULL, '110.00x4', NULL, 5, 100),
(49, NULL, '110.00x5', NULL, 5, 110),
(50, NULL, '112.00x3', NULL, 5, 120),
(51, NULL, '112.00x5', NULL, 5, 130),
(52, NULL, '112.00x10', NULL, 5, 140),
(53, NULL, '114.30x4', NULL, 5, 150),
(54, NULL, '114.30x5', NULL, 5, 160),
(55, NULL, '114.30x6', NULL, 5, 170),
(56, NULL, '114.30x8', NULL, 5, 180),
(57, NULL, '114.30x9', NULL, 5, 190),
(58, NULL, '114.30x10', NULL, 5, 200),
(59, NULL, '115.00x5', NULL, 5, 210),
(60, NULL, '115.00x6', NULL, 5, 220),
(61, NULL, '115.00x10', NULL, 5, 230),
(62, NULL, '118.00x5', NULL, 5, 240),
(63, NULL, '120.00x5', NULL, 5, 250),
(64, NULL, '120.00x10', NULL, 5, 260),
(65, NULL, '120.60x5', NULL, 5, 270),
(66, NULL, '120.65x5', NULL, 5, 280),
(67, NULL, '120.70x5', NULL, 5, 290),
(68, NULL, '125.00x6', NULL, 5, 300),
(69, NULL, '127.00x5', NULL, 5, 310),
(70, NULL, '127.00x6', NULL, 5, 320),
(71, NULL, '130.00x4', NULL, 5, 330),
(72, NULL, '130.00x5', NULL, 5, 340),
(73, NULL, '130.00x6', NULL, 5, 350),
(74, NULL, '135.00x5', NULL, 5, 360),
(75, NULL, '135.00x6', NULL, 5, 370),
(76, NULL, '139.00x5', NULL, 5, 380),
(77, NULL, '139.70x5', NULL, 5, 390),
(78, NULL, '139.70x6', NULL, 5, 400),
(79, NULL, '140.00x6', NULL, 5, 410),
(80, NULL, '150.00x5', NULL, 5, 420),
(81, NULL, '150.10x5', NULL, 5, 430),
(82, NULL, '160.00x5', NULL, 5, 440),
(83, NULL, '165.00x5', NULL, 5, 450),
(84, NULL, '165.10x8', NULL, 5, 460),
(85, NULL, '170.00x6', NULL, 5, 470),
(86, NULL, '170.00x8', NULL, 5, 480),
(87, NULL, '180.00x6', NULL, 5, 490),
(88, NULL, '197.00х5', NULL, 5, 500),
(89, NULL, '200.00x6', NULL, 5, 510),
(90, NULL, '203.20x5', NULL, 5, 520),
(91, NULL, '205.00x6', NULL, 5, 530),
(92, NULL, '256.00x3', NULL, 5, 540),
(93, NULL, NULL, 155, 7, 10),
(94, NULL, NULL, 165, 7, 20),
(95, NULL, NULL, 175, 7, 30),
(96, NULL, NULL, 185, 7, 40),
(97, NULL, NULL, 195, 7, 50),
(98, NULL, NULL, 205, 7, 60),
(99, NULL, NULL, 215, 7, 70),
(100, NULL, NULL, 225, 7, 80),
(101, NULL, NULL, 235, 7, 90),
(102, NULL, NULL, 245, 7, 100),
(103, NULL, NULL, 255, 7, 110),
(104, NULL, NULL, 265, 7, 120),
(105, NULL, NULL, 275, 7, 130),
(106, NULL, NULL, 285, 7, 140),
(107, NULL, NULL, 295, 7, 150),
(108, NULL, NULL, 305, 7, 160),
(109, NULL, NULL, 315, 7, 170),
(110, NULL, NULL, 325, 7, 180),
(111, NULL, NULL, 335, 7, 190),
(112, NULL, NULL, 345, 7, 200),
(113, 30, NULL, NULL, 8, 10),
(114, 35, NULL, NULL, 8, 20),
(115, 40, NULL, NULL, 8, 30),
(116, 45, NULL, NULL, 8, 40),
(117, 50, NULL, NULL, 8, 50),
(118, 55, NULL, NULL, 8, 60),
(119, 60, NULL, NULL, 8, 70),
(120, 65, NULL, NULL, 8, 80),
(121, 70, NULL, NULL, 8, 90),
(122, 75, NULL, NULL, 8, 100),
(123, 80, NULL, NULL, 8, 110),
(124, 85, NULL, NULL, 8, 120),
(125, NULL, '13', NULL, 9, 10),
(126, NULL, '14', NULL, 9, 20),
(127, NULL, '15', NULL, 9, 30),
(128, NULL, '16', NULL, 9, 40),
(129, NULL, '17', NULL, 9, 50),
(130, NULL, '18', NULL, 9, 60),
(131, NULL, '19', NULL, 9, 70),
(132, NULL, '20', NULL, 9, 80),
(133, NULL, '21', NULL, 9, 90),
(134, NULL, '22', NULL, 9, 100),
(135, NULL, '23', NULL, 9, 110),
(136, NULL, '24', NULL, 9, 120),
(137, NULL, '25', NULL, 9, 130),
(138, 1997, NULL, NULL, 10, 10),
(139, 1998, NULL, NULL, 10, 20),
(140, 1999, NULL, NULL, 10, 30),
(141, 2000, NULL, NULL, 10, 40),
(142, 2001, NULL, NULL, 10, 50),
(143, 2002, NULL, NULL, 10, 60),
(144, 2003, NULL, NULL, 10, 70),
(145, 2004, NULL, NULL, 10, 80),
(146, 2005, NULL, NULL, 10, 90),
(147, 2006, NULL, NULL, 10, 100),
(148, 2007, NULL, NULL, 10, 110),
(149, 2008, NULL, NULL, 10, 120),
(150, 2009, NULL, NULL, 10, 130),
(151, 2010, NULL, NULL, 10, 140),
(152, 2011, NULL, NULL, 10, 150),
(153, 2012, NULL, NULL, 10, 160),
(154, 2013, NULL, NULL, 10, 170),
(155, 2014, NULL, NULL, 10, 180),
(156, 2015, NULL, NULL, 10, 190),
(157, NULL, 'Achilles', NULL, 16, 10),
(158, NULL, 'Barum', NULL, 16, 20),
(159, NULL, 'Bridgestone', NULL, 16, 30),
(160, NULL, 'Bridgestone ', NULL, 16, 40),
(161, NULL, 'Continental', NULL, 16, 50),
(162, NULL, 'Dunlop', NULL, 16, 60),
(163, NULL, 'Dunlop ', NULL, 16, 70),
(164, NULL, 'Falken', NULL, 16, 80),
(165, NULL, 'Firestone', NULL, 16, 90),
(166, NULL, 'Fullrun', NULL, 16, 100),
(167, NULL, 'General ', NULL, 16, 110),
(168, NULL, 'Goodyear', NULL, 16, 120),
(169, NULL, 'Hankook', NULL, 16, 130),
(170, NULL, 'Hankook ', NULL, 16, 140),
(171, NULL, 'Kumho', NULL, 16, 150),
(172, NULL, 'Kumho ', NULL, 16, 160),
(173, NULL, 'Maxgrade', NULL, 16, 170),
(174, NULL, 'Maxtrek', NULL, 16, 180),
(175, NULL, 'Michelin', NULL, 16, 190),
(176, NULL, 'Michelin ', NULL, 16, 200),
(177, NULL, 'Nankang', NULL, 16, 210),
(178, NULL, 'Nexen', NULL, 16, 220),
(179, NULL, 'Nokian', NULL, 16, 230),
(180, NULL, 'Pirelli ', NULL, 16, 240),
(181, NULL, 'Roadstone', NULL, 16, 250),
(182, NULL, 'Sport', NULL, 16, 260),
(183, NULL, 'Toyo', NULL, 16, 270),
(184, NULL, 'Triangle', NULL, 16, 280),
(185, NULL, 'Yokohama', NULL, 16, 290),
(186, NULL, '280', NULL, 17, 10),
(187, NULL, '8 SUV', NULL, 17, 20),
(188, NULL, 'Advan', NULL, 17, 30),
(189, NULL, 'Advan A10', NULL, 17, 40),
(190, NULL, 'Advan A-460', NULL, 17, 50),
(191, NULL, 'ATR Sport', NULL, 17, 60),
(192, NULL, 'ATR Sport 2', NULL, 17, 70),
(193, NULL, 'Azenis', NULL, 17, 80),
(194, NULL, 'BLIZZAK DM-Z3', NULL, 17, 90),
(195, NULL, 'Blizzak Revo1', NULL, 17, 100),
(196, NULL, 'Blizzak Spike-01', NULL, 17, 110),
(197, NULL, 'BluEarth', NULL, 17, 120),
(198, NULL, 'BluEarth A', NULL, 17, 130),
(199, NULL, 'Bravuris2', NULL, 17, 140),
(200, NULL, 'BStyle', NULL, 17, 150),
(201, NULL, 'ContiPremiumContact2', NULL, 17, 160),
(202, NULL, 'ContiSportContact', NULL, 17, 170),
(203, NULL, 'ContiSportContact3', NULL, 17, 180),
(204, NULL, 'db E70', NULL, 17, 190),
(205, NULL, 'DM-V1', NULL, 17, 200),
(206, NULL, 'DMZ-3', NULL, 17, 210),
(207, NULL, 'DNA', NULL, 17, 220),
(208, NULL, 'DNA DB', NULL, 17, 230),
(209, NULL, 'DNA Ecos ES300', NULL, 17, 240),
(210, NULL, 'DNA Grandmap', NULL, 17, 250),
(211, NULL, 'Dragon', NULL, 17, 260),
(212, NULL, 'DRB', NULL, 17, 270),
(213, NULL, 'DSX', NULL, 17, 280),
(214, NULL, 'DSX2', NULL, 17, 290),
(215, NULL, 'Dueler 684 II', NULL, 17, 300),
(216, NULL, 'Dueler H/L', NULL, 17, 310),
(217, NULL, 'Dueler H/P Sport', NULL, 17, 320),
(218, NULL, 'Dueler H/T 684', NULL, 17, 330),
(219, NULL, 'Dueler H/T 684 II', NULL, 17, 340),
(220, NULL, 'Eagle LS 2000 HybridII', NULL, 17, 350),
(221, NULL, 'Eagle LS EXE', NULL, 17, 360),
(222, NULL, 'Eagle LS2000 Hybrid', NULL, 17, 370),
(223, NULL, 'Eagle NCT5', NULL, 17, 380),
(224, NULL, 'Eagle RVS', NULL, 17, 390),
(225, NULL, 'Ecopia EX10', NULL, 17, 400),
(226, NULL, 'Ecopia PZ-X', NULL, 17, 410),
(227, NULL, 'Ecsta X3', NULL, 17, 420),
(228, NULL, 'Enasave', NULL, 17, 430),
(229, NULL, 'Espia EPZ', NULL, 17, 440),
(230, NULL, 'F107', NULL, 17, 450),
(231, NULL, 'F690', NULL, 17, 460),
(232, NULL, 'Firehawk', NULL, 17, 470),
(233, NULL, 'Formula', NULL, 17, 480),
(234, NULL, 'FR10', NULL, 17, 490),
(235, NULL, 'G5', NULL, 17, 500),
(236, NULL, 'Geolander', NULL, 17, 510),
(237, NULL, 'Geolander I/T-S', NULL, 17, 520),
(238, NULL, 'Geolendar H/T-S', NULL, 17, 530),
(239, NULL, 'Grabber', NULL, 17, 540),
(240, NULL, 'Grandtrek AT22', NULL, 17, 550),
(241, NULL, 'Grandtrek AT3', NULL, 17, 560),
(242, NULL, 'Graspic DS2', NULL, 17, 570),
(243, NULL, 'Guardex', NULL, 17, 580),
(244, NULL, 'H/P', NULL, 17, 590),
(245, NULL, 'H/P Sport', NULL, 17, 600),
(246, NULL, 'Hakka 7 SUV', NULL, 17, 610),
(247, NULL, 'Hakka R2 SUV', NULL, 17, 620),
(248, NULL, 'Hakka Sport Utility', NULL, 17, 630),
(249, NULL, 'Hakka SUV 5', NULL, 17, 640),
(250, NULL, 'Hakkapelita R sport utility', NULL, 17, 650),
(251, NULL, 'Hakkapelita sport utility 5', NULL, 17, 660),
(252, NULL, 'HU901', NULL, 17, 670),
(253, NULL, 'IC7000', NULL, 17, 680),
(254, NULL, 'Ice Zero', NULL, 17, 690),
(255, NULL, 'IceControl', NULL, 17, 700),
(256, NULL, 'IceCruiser5000', NULL, 17, 710),
(257, NULL, 'IceNavy', NULL, 17, 720),
(258, NULL, 'IceNavyZeaII', NULL, 17, 730),
(259, NULL, 'IG20', NULL, 17, 740),
(260, NULL, 'IG30', NULL, 17, 750),
(261, NULL, 'iMap', NULL, 17, 760),
(262, NULL, 'IXT', NULL, 17, 770),
(263, NULL, 'Kumho', NULL, 17, 780),
(264, NULL, 'Landair SL112', NULL, 17, 790),
(265, NULL, 'Latitude Cross', NULL, 17, 800),
(266, NULL, 'Latitude Sport', NULL, 17, 810),
(267, NULL, 'Latitude Sport3', NULL, 17, 820),
(268, NULL, 'Latitude Tour', NULL, 17, 830),
(269, NULL, 'Lemans LM702', NULL, 17, 840),
(270, NULL, 'Lemans LM703', NULL, 17, 850),
(271, NULL, 'Lemans LM704', NULL, 17, 860),
(272, NULL, 'LS 2000 Hybrid', NULL, 17, 870),
(273, NULL, 'N6000', NULL, 17, 880),
(274, NULL, 'N7000', NULL, 17, 890),
(275, NULL, 'N8000', NULL, 17, 900),
(276, NULL, 'Nextry', NULL, 17, 910),
(277, NULL, 'Nre', NULL, 17, 920),
(278, NULL, 'NS-20', NULL, 17, 930),
(279, NULL, 'NSII', NULL, 17, 940),
(280, NULL, 'Optimo K415', NULL, 17, 950),
(281, NULL, 'P7', NULL, 17, 960),
(282, NULL, 'Pilot', NULL, 17, 970),
(283, NULL, 'Pilot Sport2', NULL, 17, 980),
(284, NULL, 'Pilot Sport3', NULL, 17, 990),
(285, NULL, 'Playz', NULL, 17, 1000),
(286, NULL, 'Playz-PZ1', NULL, 17, 1010),
(287, NULL, 'Playz-PZX', NULL, 17, 1020),
(288, NULL, 'Playz-RPV', NULL, 17, 1030),
(289, NULL, 'Playz-RV', NULL, 17, 1040),
(290, NULL, 'Potenza', NULL, 17, 1050),
(291, NULL, 'Potenza RE01', NULL, 17, 1060),
(292, NULL, 'Potenza RE050', NULL, 17, 1070),
(293, NULL, 'Potenza RE050A', NULL, 17, 1080),
(294, NULL, 'Primacy HP', NULL, 17, 1090),
(295, NULL, 'Primacy LC', NULL, 17, 1100),
(296, NULL, 'Proxes', NULL, 17, 1110),
(297, NULL, 'Proxes CT01', NULL, 17, 1120),
(298, NULL, 'Proxes R34', NULL, 17, 1130),
(299, NULL, 'Proxes T1', NULL, 17, 1140),
(300, NULL, 'Proxes T1R', NULL, 17, 1150),
(301, NULL, 'PS91', NULL, 17, 1160),
(302, NULL, 'RE-01R', NULL, 17, 1170),
(303, NULL, 'Regno GR8000', NULL, 17, 1180),
(304, NULL, 'Regno GR9000', NULL, 17, 1190),
(305, NULL, 'Regno GR-XT', NULL, 17, 1200),
(306, NULL, 'Revo GZ', NULL, 17, 1210),
(307, NULL, 'RevSpec RS02', NULL, 17, 1220),
(308, NULL, 'Runsafa SH-1', NULL, 17, 1230),
(309, NULL, 'S001', NULL, 17, 1240),
(310, NULL, 'SDrive', NULL, 17, 1250),
(311, NULL, 'Sierra S6', NULL, 17, 1260),
(312, NULL, 'SIII', NULL, 17, 1270),
(313, NULL, 'SJ6', NULL, 17, 1280),
(314, NULL, 'SK10', NULL, 17, 1290),
(315, NULL, 'Sneaker', NULL, 17, 1300),
(316, NULL, 'Solus KH17', NULL, 17, 1310),
(317, NULL, 'SP Sport 270', NULL, 17, 1320),
(318, NULL, 'Sport', NULL, 17, 1330),
(319, NULL, 'Sport ATR', NULL, 17, 1340),
(320, NULL, 'SportContact2', NULL, 17, 1350),
(321, NULL, 'SS595', NULL, 17, 1360),
(322, NULL, 'ST10', NULL, 17, 1370),
(323, NULL, 'TR967', NULL, 17, 1380),
(324, NULL, 'Tranpath LU', NULL, 17, 1390),
(325, NULL, 'Tranpath MP4', NULL, 17, 1400),
(326, NULL, 'Tranpath R30', NULL, 17, 1410),
(327, NULL, 'TS02', NULL, 17, 1420),
(328, NULL, 'Turanza', NULL, 17, 1430),
(329, NULL, 'Ventus HR2', NULL, 17, 1440),
(330, NULL, 'Ventus ST', NULL, 17, 1450),
(331, NULL, 'Ventus V4 ES', NULL, 17, 1460),
(332, NULL, 'VentusV8RS', NULL, 17, 1470),
(333, NULL, 'Wide Oval', NULL, 17, 1480),
(334, NULL, 'X-Ice North', NULL, 17, 1490),
(335, NULL, 'Ziex ZE329', NULL, 17, 1500),
(336, NULL, 'Ziex ZE912', NULL, 17, 1510),
(337, NULL, 'K', NULL, 19, 10),
(338, NULL, 'L', NULL, 19, 20),
(339, NULL, 'M', NULL, 19, 30),
(340, NULL, 'N', NULL, 19, 40),
(341, NULL, 'O', NULL, 19, 50),
(342, NULL, 'P', NULL, 19, 60),
(343, NULL, 'Q', NULL, 19, 70),
(344, NULL, 'R', NULL, 19, 80),
(345, NULL, 'S', NULL, 19, 90),
(346, NULL, 'T', NULL, 19, 100),
(347, NULL, 'H', NULL, 19, 110),
(348, NULL, 'V', NULL, 19, 120),
(349, NULL, 'W', NULL, 19, 130),
(350, NULL, 'Y', NULL, 19, 140),
(351, NULL, 'VR', NULL, 19, 150),
(352, NULL, 'ZR', NULL, 19, 160),
(396, NULL, 'Зима', NULL, 23, 10),
(397, NULL, 'Лето', NULL, 23, 20),
(398, NULL, 'Новый', NULL, 26, 10),
(399, NULL, 'Б/п РФ', NULL, 26, 20),
(400, NULL, 'Б/у', NULL, 26, 30),
(401, NULL, 'Томск', NULL, 27, 10),
(402, NULL, 'Новосибирск', NULL, 27, 20),
(403, NULL, 'Кемерово', NULL, 27, 30),
(404, NULL, 'Белово', NULL, 27, 40),
(405, NULL, 'Красноярск', NULL, 27, 50),
(406, 5, NULL, NULL, 29, 10),
(407, 10, NULL, NULL, 29, 20),
(408, 20, NULL, NULL, 29, 30),
(409, 30, NULL, NULL, 29, 40),
(410, 40, NULL, NULL, 29, 50),
(411, 50, NULL, NULL, 29, 60),
(412, 60, NULL, NULL, 29, 70),
(413, 70, NULL, NULL, 29, 80),
(414, 80, NULL, NULL, 29, 90),
(415, 90, NULL, NULL, 29, 100),
(416, 100, NULL, NULL, 29, 110),
(417, 0, NULL, NULL, 29, 120),
(418, NULL, '78', NULL, 18, 10),
(419, NULL, '79', NULL, 18, 20),
(420, NULL, '80', NULL, 18, 30),
(421, NULL, '81', NULL, 18, 40),
(422, NULL, '82', NULL, 18, 50),
(423, NULL, '83', NULL, 18, 60),
(424, NULL, '84', NULL, 18, 70),
(425, NULL, '85', NULL, 18, 80),
(426, NULL, '86', NULL, 18, 90),
(427, NULL, '87', NULL, 18, 100),
(428, NULL, '88', NULL, 18, 110),
(429, NULL, '89', NULL, 18, 120),
(430, NULL, '90', NULL, 18, 130),
(431, NULL, '91', NULL, 18, 140),
(432, NULL, '92', NULL, 18, 150),
(433, NULL, '93', NULL, 18, 160),
(434, NULL, '94', NULL, 18, 170),
(435, NULL, '95', NULL, 18, 180),
(436, NULL, '96', NULL, 18, 190),
(437, NULL, '97', NULL, 18, 200),
(438, NULL, '98', NULL, 18, 210),
(439, NULL, '99', NULL, 18, 220),
(440, NULL, '100', NULL, 18, 230),
(441, NULL, '101', NULL, 18, 240),
(442, NULL, '102', NULL, 18, 250),
(443, NULL, '103', NULL, 18, 260),
(444, NULL, '104', NULL, 18, 270),
(445, NULL, '105', NULL, 18, 280),
(446, NULL, '106', NULL, 18, 290),
(447, NULL, '107', NULL, 18, 300),
(448, NULL, '108', NULL, 18, 310),
(449, NULL, '109', NULL, 18, 320),
(450, NULL, '110', NULL, 18, 330),
(451, NULL, '111', NULL, 18, 340),
(452, NULL, '112', NULL, 18, 350),
(453, NULL, '113', NULL, 18, 360),
(454, NULL, '114', NULL, 18, 370),
(455, NULL, '115', NULL, 18, 380),
(456, NULL, '116', NULL, 18, 390),
(457, NULL, '117', NULL, 18, 400),
(458, NULL, '118', NULL, 18, 410),
(459, NULL, '119', NULL, 18, 420),
(460, NULL, '120', NULL, 18, 430),
(461, NULL, 'ZR', NULL, 18, 440),
(462, NULL, 'б/п РФ', NULL, 26, 1000),
(463, NULL, 'Летние', NULL, 23, 1000),
(464, NULL, 'б/у', NULL, 26, 1000),
(465, NULL, 'Нешипованные', NULL, 23, 1000);

-- --------------------------------------------------------

--
-- Структура таблицы `good`
--

CREATE TABLE IF NOT EXISTS `good` (
`id` int(10) unsigned NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `good_type_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `good_attribute`
--

CREATE TABLE IF NOT EXISTS `good_attribute` (
`id` int(11) unsigned NOT NULL,
  `good_id` int(10) unsigned NOT NULL,
  `attribute_id` int(10) unsigned NOT NULL,
  `int_value` int(11) DEFAULT NULL,
  `varchar_value` varchar(255) DEFAULT NULL,
  `text_value` text,
  `float_value` float DEFAULT NULL,
  `variant_id` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `good_type`
--

CREATE TABLE IF NOT EXISTS `good_type` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `good_type`
--

INSERT INTO `good_type` (`id`, `name`) VALUES
(1, 'Шины'),
(2, 'Диски');

-- --------------------------------------------------------

--
-- Структура таблицы `good_type_attribute`
--

CREATE TABLE IF NOT EXISTS `good_type_attribute` (
  `good_type_id` int(10) unsigned NOT NULL,
  `attribute_id` int(10) unsigned NOT NULL,
  `sort` smallint(5) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `good_type_attribute`
--

INSERT INTO `good_type_attribute` (`good_type_id`, `attribute_id`, `sort`) VALUES
(1, 3, 10),
(1, 7, 90),
(1, 8, 80),
(1, 9, 70),
(1, 10, 130),
(1, 11, 190),
(1, 12, 140),
(1, 13, 150),
(1, 14, 160),
(1, 15, 170),
(1, 16, 50),
(1, 17, 60),
(1, 18, 110),
(1, 19, 120),
(1, 20, 200),
(1, 23, 30),
(1, 26, 20),
(1, 27, 40),
(1, 28, 100),
(1, 29, 180),
(2, 3, 20),
(2, 4, 10),
(2, 20, 30),
(4, 3, 30),
(4, 4, 20),
(4, 6, 10),
(5, 6, 10),
(6, 3, 10);

-- --------------------------------------------------------

--
-- Структура таблицы `model_names`
--

CREATE TABLE IF NOT EXISTS `model_names` (
`id` smallint(5) unsigned NOT NULL,
  `code` varchar(128) NOT NULL,
  `name` varchar(128) NOT NULL,
  `vin_name` varchar(128) NOT NULL,
  `rod_name` varchar(128) NOT NULL,
  `admin_menu` tinyint(1) NOT NULL DEFAULT '0',
  `sort` smallint(6) DEFAULT '9999'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `model_names`
--

INSERT INTO `model_names` (`id`, `code`, `name`, `vin_name`, `rod_name`, `admin_menu`, `sort`) VALUES
(1, 'goodType', 'Типы товаров', 'Тип товара', 'Типа товара', 1, 100),
(2, 'attribute', 'Атрибуты', 'Атрибут', 'Атрибута', 1, 200),
(3, 'import', 'Импорт', 'Импорта', 'Импорт', 1, 300);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`usr_id` int(11) NOT NULL,
  `usr_login` varchar(128) NOT NULL,
  `usr_password` varchar(128) NOT NULL,
  `usr_name` varchar(255) NOT NULL,
  `usr_email` varchar(128) NOT NULL,
  `usr_role` varchar(20) NOT NULL,
  `usr_state` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`usr_id`, `usr_login`, `usr_password`, `usr_name`, `usr_email`, `usr_role`, `usr_state`) VALUES
(1, 'root', 'eaaba36a95aedcfd1c21a0d011e12ecd', 'Китаев М.А.', 'beatbox787@gmail.com', 'root', 1),
(5, 'beatbox787', '5142e9696202a6b60769432067cf9f84', 'Китаев М.А.', 'beatbox787@yandex.ru', 'admin', 1),
(6, 'mikhkita', 'eaaba36a95aedcfd1c21a0d011e12ecd', 'Китаев М.А.', 'beatbox787@gmail.com', 'manager', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `attribute`
--
ALTER TABLE `attribute`
 ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `attribute_type`
--
ALTER TABLE `attribute_type`
 ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `attribute_variant`
--
ALTER TABLE `attribute_variant`
 ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `good`
--
ALTER TABLE `good`
 ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `good_attribute`
--
ALTER TABLE `good_attribute`
 ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `good_type`
--
ALTER TABLE `good_type`
 ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `good_type_attribute`
--
ALTER TABLE `good_type_attribute`
 ADD PRIMARY KEY (`good_type_id`,`attribute_id`);

--
-- Индексы таблицы `model_names`
--
ALTER TABLE `model_names`
 ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`usr_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `attribute`
--
ALTER TABLE `attribute`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT для таблицы `attribute_type`
--
ALTER TABLE `attribute_type`
MODIFY `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `attribute_variant`
--
ALTER TABLE `attribute_variant`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=705;
--
-- AUTO_INCREMENT для таблицы `good`
--
ALTER TABLE `good`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `good_attribute`
--
ALTER TABLE `good_attribute`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `good_type`
--
ALTER TABLE `good_type`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `model_names`
--
ALTER TABLE `model_names`
MODIFY `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
MODIFY `usr_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
