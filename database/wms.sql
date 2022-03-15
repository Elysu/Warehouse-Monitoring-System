-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2021 at 05:20 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wms`
--
CREATE DATABASE IF NOT EXISTS `wms` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `wms`;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `i_id` int(5) NOT NULL,
  `i_name` varchar(255) NOT NULL,
  `i_time_in` datetime DEFAULT NULL,
  `i_time_out` datetime DEFAULT NULL,
  `i_quantity` int(4) NOT NULL,
  `i_from` varchar(255) NOT NULL,
  `i_to` varchar(255) DEFAULT NULL,
  `i_status` varchar(255) NOT NULL,
  `i_dp` varchar(255) NOT NULL,
  `i_staff` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`i_id`, `i_name`, `i_time_in`, `i_time_out`, `i_quantity`, `i_from`, `i_to`, `i_status`, `i_dp`, `i_staff`) VALUES
(1, 'Coca-Cola', '2020-12-25 23:05:00', '2020-12-31 20:05:00', 50, 'Cheras', 'Penang', 'delivered', 'Raymund', 'john'),
(4, '100 Plus', '2020-12-03 18:56:00', '2020-12-12 17:58:00', 5, 'Perak', 'Kajang', 'delivered', 'af', 'larry'),
(5, 'tofu 60%', '2020-12-12 18:57:00', '2020-12-15 18:03:00', 10, 'Sweden', 'Holand', 'delivered', 'Ben', 'nicholas'),
(40, 'awd', '2020-12-30 21:57:00', NULL, 10, 'Cyberjaya', '', 'C2', 'dd', 'nicholas'),
(41, 'RTX 3080', '2020-12-30 22:07:00', '2020-12-31 23:00:00', 30, 'Nvidia USA', 'Kajang', 'delivered', 'Jeff', 'larry'),
(45, 'RTX 2080 TI', '2020-12-31 15:01:00', NULL, 40, 'PJ', '', 'C7', 'BAPAK', 'larry'),
(46, 'Ryzen 5 5600x', '2020-12-31 15:02:00', NULL, 90, 'Belakong', '', 'C5', 'bodoh', 'larry'),
(47, 'Corsair RM750x', '2020-12-31 15:05:00', '2020-12-31 10:55:00', 40, 'Cyberjaya', 'Bangi', 'delivered', 'cringe', 'john'),
(50, 'RTX 3060', '2020-12-31 16:48:00', NULL, 10, 'Puchong', '', 'C9', 'Dp', 'larry'),
(51, 'RTX3060TI', '2020-12-31 16:50:00', NULL, 50, 'Taiwan', '', 'C12', 'Johnson', 'larry');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `m_id` int(4) UNSIGNED ZEROFILL NOT NULL,
  `m_username` varchar(255) NOT NULL,
  `m_password` varchar(255) NOT NULL,
  `m_role` varchar(255) NOT NULL,
  `m_age` int(2) NOT NULL,
  `m_email` varchar(255) NOT NULL,
  `m_phoneNo` varchar(20) NOT NULL,
  `m_fullname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`m_id`, `m_username`, `m_password`, `m_role`, `m_age`, `m_email`, `m_phoneNo`, `m_fullname`) VALUES
(0002, 'larry', 'abc123', 'admin', 20, 'voon@gmail.com', '012-3456789', 'Wai Chun Voon'),
(0003, 'nicholas', 'abc123', 'admin', 20, 'nicholas@gmail.com', '012-3356789', 'Nicholas Y'),
(0004, 'john', 'abc123', 'staff', 21, 'abc1@gmail.com', '012-3336789', 'John Low');

-- --------------------------------------------------------

--
-- Table structure for table `slot`
--

DROP TABLE IF EXISTS `slot`;
CREATE TABLE `slot` (
  `s_id` int(5) NOT NULL,
  `s_name` varchar(20) NOT NULL,
  `s_i_id` int(5) DEFAULT NULL,
  `s_i_name` varchar(255) NOT NULL,
  `s_i_time` datetime DEFAULT NULL,
  `s_i_quantity` int(4) NOT NULL,
  `s_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `slot`
--

INSERT INTO `slot` (`s_id`, `s_name`, `s_i_id`, `s_i_name`, `s_i_time`, `s_i_quantity`, `s_status`) VALUES
(1, 'C1', NULL, '', NULL, 0, 0),
(2, 'C2', 40, 'awd', '2020-12-30 21:57:00', 10, 1),
(3, 'C3', NULL, '', NULL, 0, 0),
(4, 'C4', NULL, '', NULL, 0, 0),
(5, 'C5', 46, 'Ryzen 5 5600x', '2020-12-31 15:02:00', 90, 1),
(6, 'C6', NULL, '', NULL, 0, 0),
(7, 'C7', 45, 'RTX 2080 TI', '2020-12-31 15:01:00', 40, 1),
(8, 'C8', NULL, '', NULL, 0, 0),
(9, 'C9', 50, 'RTX 3060', '2020-12-31 16:48:00', 10, 1),
(10, 'C10', NULL, '', NULL, 0, 0),
(11, 'C11', NULL, '', NULL, 0, 0),
(12, 'C12', 51, 'RTX3060TI', '2020-12-31 16:50:00', 50, 1),
(13, 'C13', NULL, '', NULL, 0, 0),
(14, 'C14', NULL, '', NULL, 0, 0),
(15, 'C15', NULL, '', NULL, 0, 0),
(16, 'C16', NULL, '', NULL, 0, 0),
(17, 'C17', NULL, '', NULL, 0, 0),
(18, 'C18', NULL, '', NULL, 0, 0),
(19, 'C19', NULL, '', NULL, 0, 0),
(20, 'C20', NULL, '', NULL, 0, 0),
(21, 'C21', NULL, '', NULL, 0, 0),
(22, 'C22', NULL, '', NULL, 0, 0),
(23, 'C23', NULL, '', NULL, 0, 0),
(24, 'C24', NULL, '', NULL, 0, 0),
(25, 'C25', NULL, '', NULL, 0, 0),
(26, 'C26', NULL, '', NULL, 0, 0),
(27, 'C27', NULL, '', NULL, 0, 0),
(28, 'C28', NULL, '', NULL, 0, 0),
(29, 'C29', NULL, '', NULL, 0, 0),
(30, 'C30', NULL, '', NULL, 0, 0),
(31, 'C31', NULL, '', NULL, 0, 0),
(32, 'C32', NULL, '', NULL, 0, 0),
(33, 'C33', NULL, '', NULL, 0, 0),
(34, 'C34', NULL, '', NULL, 0, 0),
(35, 'C35', NULL, '', NULL, 0, 0),
(36, 'C36', NULL, '', NULL, 0, 0),
(37, 'C37', NULL, '', NULL, 0, 0),
(38, 'C38', NULL, '', NULL, 0, 0),
(39, 'C39', NULL, '', NULL, 0, 0),
(40, 'C40', NULL, '', NULL, 0, 0),
(41, 'C41', NULL, '', NULL, 0, 0),
(42, 'C42', NULL, '', NULL, 0, 0),
(43, 'C43', NULL, '', NULL, 0, 0),
(44, 'C44', NULL, '', NULL, 0, 0),
(45, 'C45', NULL, '', NULL, 0, 0),
(46, 'C46', NULL, '', NULL, 0, 0),
(47, 'C47', NULL, '', NULL, 0, 0),
(48, 'C48', NULL, '', NULL, 0, 0),
(49, 'C49', NULL, '', NULL, 0, 0),
(50, 'C50', NULL, '', NULL, 0, 0),
(51, 'C51', NULL, '', NULL, 0, 0),
(52, 'C52', NULL, '', NULL, 0, 0),
(53, 'C53', NULL, '', NULL, 0, 0),
(54, 'C54', NULL, '', NULL, 0, 0),
(55, 'C55', NULL, '', NULL, 0, 0),
(56, 'C56', NULL, '', NULL, 0, 0),
(57, 'C57', NULL, '', NULL, 0, 0),
(58, 'C58', NULL, '', NULL, 0, 0),
(59, 'C59', NULL, '', NULL, 0, 0),
(60, 'C60', NULL, '', NULL, 0, 0),
(61, 'C61', NULL, '', NULL, 0, 0),
(62, 'C62', NULL, '', NULL, 0, 0),
(63, 'C63', NULL, '', NULL, 0, 0),
(64, 'C64', NULL, '', NULL, 0, 0),
(65, 'C65', NULL, '', NULL, 0, 0),
(66, 'C66', NULL, '', NULL, 0, 0),
(67, 'C67', NULL, '', NULL, 0, 0),
(68, 'C68', NULL, '', NULL, 0, 0),
(69, 'C69', NULL, '', NULL, 0, 0),
(70, 'C70', NULL, '', NULL, 0, 0),
(71, 'C71', NULL, '', NULL, 0, 0),
(72, 'C72', NULL, '', NULL, 0, 0),
(73, 'C73', NULL, '', NULL, 0, 0),
(74, 'C74', NULL, '', NULL, 0, 0),
(75, 'C75', NULL, '', NULL, 0, 0),
(76, 'C76', NULL, '', NULL, 0, 0),
(77, 'C77', NULL, '', NULL, 0, 0),
(78, 'C78', NULL, '', NULL, 0, 0),
(79, 'C79', NULL, '', NULL, 0, 0),
(80, 'C80', NULL, '', NULL, 0, 0),
(81, 'C81', NULL, '', NULL, 0, 0),
(82, 'C82', NULL, '', NULL, 0, 0),
(83, 'C83', NULL, '', NULL, 0, 0),
(84, 'C84', NULL, '', NULL, 0, 0),
(85, 'C85', NULL, '', NULL, 0, 0),
(86, 'C86', NULL, '', NULL, 0, 0),
(87, 'C87', NULL, '', NULL, 0, 0),
(88, 'C88', NULL, '', NULL, 0, 0),
(89, 'C89', NULL, '', NULL, 0, 0),
(90, 'C90', NULL, '', NULL, 0, 0),
(91, 'C91', NULL, '', NULL, 0, 0),
(92, 'C92', NULL, '', NULL, 0, 0),
(93, 'C93', NULL, '', NULL, 0, 0),
(94, 'C94', NULL, '', NULL, 0, 0),
(95, 'C95', NULL, '', NULL, 0, 0),
(96, 'C96', NULL, '', NULL, 0, 0),
(97, 'C97', NULL, '', NULL, 0, 0),
(98, 'C98', NULL, '', NULL, 0, 0),
(99, 'C99', NULL, '', NULL, 0, 0),
(100, 'C100', NULL, '', NULL, 0, 0),
(101, 'C101', NULL, '', NULL, 0, 0),
(102, 'C102', NULL, '', NULL, 0, 0),
(103, 'C103', NULL, '', NULL, 0, 0),
(104, 'C104', NULL, '', NULL, 0, 0),
(105, 'C105', NULL, '', NULL, 0, 0),
(106, 'C106', NULL, '', NULL, 0, 0),
(107, 'C107', NULL, '', NULL, 0, 0),
(108, 'C108', NULL, '', NULL, 0, 0),
(109, 'C109', NULL, '', NULL, 0, 0),
(110, 'C110', NULL, '', NULL, 0, 0),
(111, 'C111', NULL, '', NULL, 0, 0),
(112, 'C112', NULL, '', NULL, 0, 0),
(113, 'C113', NULL, '', NULL, 0, 0),
(114, 'C114', NULL, '', NULL, 0, 0),
(115, 'C115', NULL, '', NULL, 0, 0),
(116, 'C116', NULL, '', NULL, 0, 0),
(117, 'C117', NULL, '', NULL, 0, 0),
(118, 'C118', NULL, '', NULL, 0, 0),
(119, 'C119', NULL, '', NULL, 0, 0),
(120, 'C120', NULL, '', NULL, 0, 0),
(121, 'C121', NULL, '', NULL, 0, 0),
(122, 'C122', NULL, '', NULL, 0, 0),
(123, 'C123', NULL, '', NULL, 0, 0),
(124, 'C124', NULL, '', NULL, 0, 0),
(125, 'C125', NULL, '', NULL, 0, 0),
(126, 'C126', NULL, '', NULL, 0, 0),
(127, 'C127', NULL, '', NULL, 0, 0),
(128, 'C128', NULL, '', NULL, 0, 0),
(129, 'C129', NULL, '', NULL, 0, 0),
(130, 'C130', NULL, '', NULL, 0, 0),
(131, 'C131', NULL, '', NULL, 0, 0),
(132, 'C132', NULL, '', NULL, 0, 0),
(133, 'C133', NULL, '', NULL, 0, 0),
(134, 'C134', NULL, '', NULL, 0, 0),
(135, 'C135', NULL, '', NULL, 0, 0),
(136, 'C136', NULL, '', NULL, 0, 0),
(137, 'C137', NULL, '', NULL, 0, 0),
(138, 'C138', NULL, '', NULL, 0, 0),
(139, 'C139', NULL, '', NULL, 0, 0),
(140, 'C140', NULL, '', NULL, 0, 0),
(141, 'C141', NULL, '', NULL, 0, 0),
(142, 'C142', NULL, '', NULL, 0, 0),
(143, 'C143', NULL, '', NULL, 0, 0),
(144, 'C144', NULL, '', NULL, 0, 0),
(145, 'C145', NULL, '', NULL, 0, 0),
(146, 'C146', NULL, '', NULL, 0, 0),
(147, 'C147', NULL, '', NULL, 0, 0),
(148, 'C148', NULL, '', NULL, 0, 0),
(149, 'C149', NULL, '', NULL, 0, 0),
(150, 'C150', NULL, '', NULL, 0, 0),
(151, 'C151', NULL, '', NULL, 0, 0),
(152, 'C152', NULL, '', NULL, 0, 0),
(153, 'C153', NULL, '', NULL, 0, 0),
(154, 'C154', NULL, '', NULL, 0, 0),
(155, 'C155', NULL, '', NULL, 0, 0),
(156, 'C156', NULL, '', NULL, 0, 0),
(157, 'C157', NULL, '', NULL, 0, 0),
(158, 'C158', NULL, '', NULL, 0, 0),
(159, 'C159', NULL, '', NULL, 0, 0),
(160, 'C160', NULL, '', NULL, 0, 0),
(161, 'C161', NULL, '', NULL, 0, 0),
(162, 'C162', NULL, '', NULL, 0, 0),
(163, 'C163', NULL, '', NULL, 0, 0),
(164, 'C164', NULL, '', NULL, 0, 0),
(165, 'C165', NULL, '', NULL, 0, 0),
(166, 'C166', NULL, '', NULL, 0, 0),
(167, 'C167', NULL, '', NULL, 0, 0),
(168, 'C168', NULL, '', NULL, 0, 0),
(169, 'C169', NULL, '', NULL, 0, 0),
(170, 'C170', NULL, '', NULL, 0, 0),
(171, 'C171', NULL, '', NULL, 0, 0),
(172, 'C172', NULL, '', NULL, 0, 0),
(173, 'C173', NULL, '', NULL, 0, 0),
(174, 'C174', NULL, '', NULL, 0, 0),
(175, 'C175', NULL, '', NULL, 0, 0),
(176, 'C176', NULL, '', NULL, 0, 0),
(177, 'C177', NULL, '', NULL, 0, 0),
(178, 'C178', NULL, '', NULL, 0, 0),
(179, 'C179', NULL, '', NULL, 0, 0),
(180, 'C180', NULL, '', NULL, 0, 0),
(181, 'C181', NULL, '', NULL, 0, 0),
(182, 'C182', NULL, '', NULL, 0, 0),
(183, 'C183', NULL, '', NULL, 0, 0),
(184, 'C184', NULL, '', NULL, 0, 0),
(185, 'C185', NULL, '', NULL, 0, 0),
(186, 'C186', NULL, '', NULL, 0, 0),
(187, 'C187', NULL, '', NULL, 0, 0),
(188, 'C188', NULL, '', NULL, 0, 0),
(189, 'C189', NULL, '', NULL, 0, 0),
(190, 'C190', NULL, '', NULL, 0, 0),
(191, 'C191', NULL, '', NULL, 0, 0),
(192, 'C192', NULL, '', NULL, 0, 0),
(193, 'C193', NULL, '', NULL, 0, 0),
(194, 'C194', NULL, '', NULL, 0, 0),
(195, 'C195', NULL, '', NULL, 0, 0),
(196, 'C196', NULL, '', NULL, 0, 0),
(197, 'C197', NULL, '', NULL, 0, 0),
(198, 'C198', NULL, '', NULL, 0, 0),
(199, 'C199', NULL, '', NULL, 0, 0),
(200, 'C200', NULL, '', NULL, 0, 0),
(201, 'C201', NULL, '', NULL, 0, 0),
(202, 'C202', NULL, '', NULL, 0, 0),
(203, 'C203', NULL, '', NULL, 0, 0),
(204, 'C204', NULL, '', NULL, 0, 0),
(205, 'C205', NULL, '', NULL, 0, 0),
(206, 'C206', NULL, '', NULL, 0, 0),
(207, 'C207', NULL, '', NULL, 0, 0),
(208, 'C208', NULL, '', NULL, 0, 0),
(209, 'C209', NULL, '', NULL, 0, 0),
(210, 'C210', NULL, '', NULL, 0, 0),
(211, 'C211', NULL, '', NULL, 0, 0),
(212, 'C212', NULL, '', NULL, 0, 0),
(213, 'C213', NULL, '', NULL, 0, 0),
(214, 'C214', NULL, '', NULL, 0, 0),
(215, 'C215', NULL, '', NULL, 0, 0),
(216, 'C216', NULL, '', NULL, 0, 0),
(217, 'C217', NULL, '', NULL, 0, 0),
(218, 'C218', NULL, '', NULL, 0, 0),
(219, 'C219', NULL, '', NULL, 0, 0),
(220, 'C220', NULL, '', NULL, 0, 0),
(221, 'C221', NULL, '', NULL, 0, 0),
(222, 'C222', NULL, '', NULL, 0, 0),
(223, 'C223', NULL, '', NULL, 0, 0),
(224, 'C224', NULL, '', NULL, 0, 0),
(225, 'C225', NULL, '', NULL, 0, 0),
(226, 'C226', NULL, '', NULL, 0, 0),
(227, 'C227', NULL, '', NULL, 0, 0),
(228, 'C228', NULL, '', NULL, 0, 0),
(229, 'C229', NULL, '', NULL, 0, 0),
(230, 'C230', NULL, '', NULL, 0, 0),
(231, 'C231', NULL, '', NULL, 0, 0),
(232, 'C232', NULL, '', NULL, 0, 0),
(233, 'C233', NULL, '', NULL, 0, 0),
(234, 'C234', NULL, '', NULL, 0, 0),
(235, 'C235', NULL, '', NULL, 0, 0),
(236, 'C236', NULL, '', NULL, 0, 0),
(237, 'C237', NULL, '', NULL, 0, 0),
(238, 'C238', NULL, '', NULL, 0, 0),
(239, 'C239', NULL, '', NULL, 0, 0),
(240, 'C240', NULL, '', NULL, 0, 0),
(241, 'C241', NULL, '', NULL, 0, 0),
(242, 'C242', NULL, '', NULL, 0, 0),
(243, 'C243', NULL, '', NULL, 0, 0),
(244, 'C244', NULL, '', NULL, 0, 0),
(245, 'C245', NULL, '', NULL, 0, 0),
(246, 'C246', NULL, '', NULL, 0, 0),
(247, 'C247', NULL, '', NULL, 0, 0),
(248, 'C248', NULL, '', NULL, 0, 0),
(249, 'C249', NULL, '', NULL, 0, 0),
(250, 'C250', NULL, '', NULL, 0, 0),
(251, 'C251', NULL, '', NULL, 0, 0),
(252, 'C252', NULL, '', NULL, 0, 0),
(253, 'C253', NULL, '', NULL, 0, 0),
(254, 'C254', NULL, '', NULL, 0, 0),
(255, 'C255', NULL, '', NULL, 0, 0),
(256, 'C256', NULL, '', NULL, 0, 0),
(257, 'C257', NULL, '', NULL, 0, 0),
(258, 'C258', NULL, '', NULL, 0, 0),
(259, 'C259', NULL, '', NULL, 0, 0),
(260, 'C260', NULL, '', NULL, 0, 0),
(261, 'C261', NULL, '', NULL, 0, 0),
(262, 'C262', NULL, '', NULL, 0, 0),
(263, 'C263', NULL, '', NULL, 0, 0),
(264, 'C264', NULL, '', NULL, 0, 0),
(265, 'C265', NULL, '', NULL, 0, 0),
(266, 'C266', NULL, '', NULL, 0, 0),
(267, 'C267', NULL, '', NULL, 0, 0),
(268, 'C268', NULL, '', NULL, 0, 0),
(269, 'C269', NULL, '', NULL, 0, 0),
(270, 'C270', NULL, '', NULL, 0, 0),
(271, 'C271', NULL, '', NULL, 0, 0),
(272, 'C272', NULL, '', NULL, 0, 0),
(273, 'C273', NULL, '', NULL, 0, 0),
(274, 'C274', NULL, '', NULL, 0, 0),
(275, 'C275', NULL, '', NULL, 0, 0),
(276, 'C276', NULL, '', NULL, 0, 0),
(277, 'C277', NULL, '', NULL, 0, 0),
(278, 'C278', NULL, '', NULL, 0, 0),
(279, 'C279', NULL, '', NULL, 0, 0),
(280, 'C280', NULL, '', NULL, 0, 0),
(281, 'C281', NULL, '', NULL, 0, 0),
(282, 'C282', NULL, '', NULL, 0, 0),
(283, 'C283', NULL, '', NULL, 0, 0),
(284, 'C284', NULL, '', NULL, 0, 0),
(285, 'C285', NULL, '', NULL, 0, 0),
(286, 'C286', NULL, '', NULL, 0, 0),
(287, 'C287', NULL, '', NULL, 0, 0),
(288, 'C288', NULL, '', NULL, 0, 0),
(289, 'C289', NULL, '', NULL, 0, 0),
(290, 'C290', NULL, '', NULL, 0, 0),
(291, 'C291', NULL, '', NULL, 0, 0),
(292, 'C292', NULL, '', NULL, 0, 0),
(293, 'C293', NULL, '', NULL, 0, 0),
(294, 'C294', NULL, '', NULL, 0, 0),
(295, 'C295', NULL, '', NULL, 0, 0),
(296, 'C296', NULL, '', NULL, 0, 0),
(297, 'C297', NULL, '', NULL, 0, 0),
(298, 'C298', NULL, '', NULL, 0, 0),
(299, 'C299', NULL, '', NULL, 0, 0),
(300, 'C300', NULL, '', NULL, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`i_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `slot`
--
ALTER TABLE `slot`
  ADD PRIMARY KEY (`s_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `i_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `m_id` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `slot`
--
ALTER TABLE `slot`
  MODIFY `s_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
