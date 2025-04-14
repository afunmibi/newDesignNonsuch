-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2025 at 12:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nonsuch_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `enrolment`
--

CREATE TABLE `enrolment` (
  `id` int(11) NOT NULL,
  `organization` varchar(100) NOT NULL,
  `sname` varchar(50) NOT NULL,
  `oname` varchar(50) NOT NULL,
  `policy_no` varchar(50) NOT NULL,
  `phone_no` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `e_provider` varchar(50) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `plan_type` enum('Gold','Silver','Platinum') NOT NULL,
  `e_location` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `no_of_dependant` int(11) NOT NULL,
  `reg_status` enum('active','inactive') NOT NULL,
  `alternate_no` varchar(20) DEFAULT NULL,
  `date_captured` datetime NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrolment`
--

INSERT INTO `enrolment` (`id`, `organization`, `sname`, `oname`, `policy_no`, `phone_no`, `email`, `e_provider`, `gender`, `plan_type`, `e_location`, `dob`, `no_of_dependant`, `reg_status`, `alternate_no`, `date_captured`, `photo`) VALUES
(3, 'Tedprime Hub Support Initiative', 'Adewale', 'Opeyemi', '89901', '08062328638', 'afunmibi@gmail.com', 'FMC Abeokuta', 'Male', 'Gold', 'Abeokuta', '2025-03-04', 1, 'active', '', '2025-03-04 11:27:48', 'IMG_20220524_181611.jpg'),
(4, 'Divine-Love Bags', 'Adewale', 'Opeyemi', '89901', '08132686523', 'fotyem@gmail.com', 'State hopstial Abeokuta', 'Female', 'Silver', 'Abeokuta', '2025-03-04', 3, 'active', '', '2025-03-04 11:29:16', 'IMG_20230221_072702.jpg'),
(5, 'Tedprime Hub Support Initiative', 'Adewale', 'Tabithat', '89900', '08062328638', 'afunmibi@gmail.com', 'FMC', 'Female', 'Silver', 'Abeokuta', '2025-03-04', 3, 'active', '', '2025-03-04 11:36:50', 'IMG_20230627_071623.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `e_drug_entry`
--

CREATE TABLE `e_drug_entry` (
  `id` int(11) NOT NULL,
  `enrollees_id` int(11) DEFAULT NULL,
  `name_of_services` varchar(255) DEFAULT NULL,
  `nhia_tariff` decimal(10,2) DEFAULT NULL,
  `hcf_amount_claimed` decimal(10,2) DEFAULT NULL,
  `amount_due` decimal(10,2) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_service_entry`
--

CREATE TABLE `e_service_entry` (
  `id` int(11) NOT NULL,
  `enrollees_id` int(11) DEFAULT NULL,
  `name_of_services` varchar(255) DEFAULT NULL,
  `nhia_tariff` decimal(10,2) DEFAULT NULL,
  `hcf_amount_claimed` decimal(10,2) DEFAULT NULL,
  `amount_due` decimal(10,2) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `total_hcf_claimed` decimal(10,2) NOT NULL,
  `total_amount_due` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `e_service_entry`
--

INSERT INTO `e_service_entry` (`id`, `enrollees_id`, `name_of_services`, `nhia_tariff`, `hcf_amount_claimed`, `amount_due`, `qty`, `remarks`, `total_hcf_claimed`, `total_amount_due`) VALUES
(15, NULL, 'Consultation', 1500.00, 2000.00, 1350.00, 1, '', 2000.00, 1350.00),
(16, NULL, 'nursing ', 1200.00, 1500.00, 1080.00, 1, '', 3500.00, 2430.00),
(17, NULL, 'Consultation', 1500.00, 2000.00, 1350.00, 1, '', 2000.00, 1350.00),
(18, NULL, 'nursing ', 1200.00, 1500.00, 1080.00, 1, '', 3500.00, 2430.00);

-- --------------------------------------------------------

--
-- Table structure for table `final_payment`
--

CREATE TABLE `final_payment` (
  `id` int(11) NOT NULL,
  `name_of_enrollee` varchar(30) NOT NULL,
  `nhis_no` varchar(30) NOT NULL,
  `pa_code` varchar(30) NOT NULL,
  `primary_hospital` varchar(30) NOT NULL,
  `primary_hospital_code` varchar(30) NOT NULL,
  `secondary_hospital` varchar(30) NOT NULL,
  `secondary_hospital_code` varchar(30) NOT NULL,
  `diagnosis` text NOT NULL,
  `procedure_text` text NOT NULL,
  `amount_claimed` decimal(10,2) NOT NULL,
  `amount_due` decimal(10,2) NOT NULL,
  `date_paid` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` enum('user','admin') NOT NULL,
  `staff_id` varchar(30) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`, `usertype`, `staff_id`, `photo`) VALUES
(1, 'Felix', '$2y$10$/mZlNfUviztZ75K86SR1U.DCQd.h2.QYELI1Meu3kt6T8iP0RIDwu', 'admin', '234', 'IMG_20220528_143014.jpg'),
(3, 'Felix1', '$2y$10$Kr5eXa0GfGeVxQzqSKroIOvIk7Yc31i7/ntLJ0vYrF1mSDtBVr/B.', 'user', '234', 'IMG_20220524_181611.jpg'),
(4, 'felix123', '$2y$10$QacVtFm3e.OrDkF9MtvxweGmTT6bVXxR8RBCPcRNBNT3SF5j0YbQq', 'user', '789', 'IMG_20220524_181611.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `log_enrollees_in`
--

CREATE TABLE `log_enrollees_in` (
  `id` int(11) NOT NULL,
  `name_of_enrollee` varchar(255) NOT NULL,
  `nhia_no` varchar(20) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `primary_hospital` varchar(255) DEFAULT NULL,
  `secondary_hospital` varchar(255) DEFAULT NULL,
  `status_position` varchar(20) DEFAULT NULL,
  `primary_hospital_code` varchar(20) DEFAULT NULL,
  `secondary_hospital_code` varchar(20) DEFAULT NULL,
  `diagnosis` text DEFAULT NULL,
  `procedure_text` text DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `further_diagnosis` text DEFAULT NULL,
  `pa_code` varchar(30) DEFAULT NULL,
  `staff_id` varchar(20) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `no_of_days_admission` varchar(11) NOT NULL,
  `bill_vetted_by` varchar(11) NOT NULL,
  `checked_by` varchar(11) NOT NULL,
  `re_checked_by` varchar(11) NOT NULL,
  `appoved_by` varchar(11) NOT NULL,
  `paid_by` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_enrollees_in`
--

INSERT INTO `log_enrollees_in` (`id`, `name_of_enrollee`, `nhia_no`, `sex`, `phone_no`, `primary_hospital`, `secondary_hospital`, `status_position`, `primary_hospital_code`, `secondary_hospital_code`, `diagnosis`, `procedure_text`, `dob`, `further_diagnosis`, `pa_code`, `staff_id`, `created_on`, `no_of_days_admission`, `bill_vetted_by`, `checked_by`, `re_checked_by`, `appoved_by`, `paid_by`) VALUES
(1, 'FUNMIBI ADEWALE', '87665', 'male', '08132686523', 'State hospital', 'state hospital', 'spouse', 'Og/0027', 'Og/0027', 'goood', '', '2025-03-10', 'jjdjdjd', '/03/234/25/1/03/234/25/1/03/23', NULL, '2025-03-26 14:25:08', '', '', '', '', '', ''),
(2, 'FUNMIBI ADEWALE', '87665', 'male', '08038', 'FMC', 'state hospital', 'child_1', 'Og/0001', 'Og/0027', 'goooooooooooooo', 'vvvvvvvvvvvvvv', '2025-03-27', 'ghhhhhhhhhhhhhhhh', '051//NHIA/392', '234', '2025-03-27 12:38:52', '', '', '', '', '', ''),
(3, 'FUNMIBI ADEWALE', '87665', 'male', '08038', 'State hospital', 'state hospital', 'child_1', 'Og/0001', 'Og/0027', 'goooooooooooooo', 'vvvvvvvvvvvvvv', '2025-03-27', 'ghhhhhhhhhhhhhhhh', '051//NHIA/8173', '234', '2025-03-27 16:25:59', '', '', '', '', '', ''),
(4, 'kosoro', '87665', 'male', '+2348132686523', 'FMC', 'FMC', 'spouse', 'Og/0027', 'Og/0027', 'halll', 'kkkkkkkk', '2025-03-29', 'yeeesss', '051//NHIA/6931', '234', '2025-03-29 12:37:06', '', '', '', '', '', ''),
(5, 'kosoro', '87665', 'male', '+2348132686523', 'FMC', 'FMC', 'spouse', 'Og/0027', 'Og/0027', 'halll', 'kkkkkkkk', '2025-03-29', 'yeeesss', '051//NHIA/9217/03/234/25/5/03/', '234', '2025-03-29 12:44:10', '', '', '', '', '', ''),
(6, 'Opeyemi Titilayo Adewale ', '87665', 'female', '09133393830', 'FMC', 'FMC', 'child_1', 'Og/0001', 'Og/0001', 'hhjsjsksks', 'jskkkwjms', '2025-03-29', 'skksksks', '051//NHIA/234/03/234/25/6/03/2', '234', '2025-03-29 12:55:54', '', '', '', '', '', ''),
(7, 'FUNMIBI ADEWALE', 'kksksk', 'male', '+2348132686523', 'kkks', 'FMC', 'child_1', 'ksksk', 'Og/0027', 'hhjhjsjsj', 'msksk', '2025-03-29', 'ksksksk', '051//NHIA/234', '234', '2025-03-29 13:58:48', '', '', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `enrolment`
--
ALTER TABLE `enrolment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `e_drug_entry`
--
ALTER TABLE `e_drug_entry`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enrollees_id` (`enrollees_id`);

--
-- Indexes for table `e_service_entry`
--
ALTER TABLE `e_service_entry`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enrollees_id` (`enrollees_id`);

--
-- Indexes for table `final_payment`
--
ALTER TABLE `final_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `log_enrollees_in`
--
ALTER TABLE `log_enrollees_in`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `enrolment`
--
ALTER TABLE `enrolment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `e_drug_entry`
--
ALTER TABLE `e_drug_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `e_service_entry`
--
ALTER TABLE `e_service_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `final_payment`
--
ALTER TABLE `final_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `log_enrollees_in`
--
ALTER TABLE `log_enrollees_in`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `e_drug_entry`
--
ALTER TABLE `e_drug_entry`
  ADD CONSTRAINT `e_drug_entry_ibfk_1` FOREIGN KEY (`enrollees_id`) REFERENCES `log_enrollees_in` (`id`);

--
-- Constraints for table `e_service_entry`
--
ALTER TABLE `e_service_entry`
  ADD CONSTRAINT `e_service_entry_ibfk_1` FOREIGN KEY (`enrollees_id`) REFERENCES `log_enrollees_in` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
