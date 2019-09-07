-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2019 at 01:44 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `counting_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `charity`
--

CREATE TABLE `charity` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `charity_payment`
--

CREATE TABLE `charity_payment` (
  `id` int(11) NOT NULL,
  `cid` int(20) NOT NULL,
  `amount` float NOT NULL,
  `date` date NOT NULL,
  `note` varchar(2500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `company_band`
--

CREATE TABLE `company_band` (
  `id` int(11) NOT NULL,
  `cid` int(20) NOT NULL,
  `first` mediumtext NOT NULL,
  `second` mediumtext NOT NULL,
  `third` mediumtext NOT NULL,
  `forth` mediumtext NOT NULL,
  `fifth` mediumtext NOT NULL,
  `sixth` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `company_contract`
--

CREATE TABLE `company_contract` (
  `cid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `note` varchar(2550) NOT NULL,
  `attachment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company_contract`
--

INSERT INTO `company_contract` (`cid`, `name`, `phone`, `email`, `address`, `date`, `note`, `attachment`) VALUES
(3, 'arethecat', '0289382983', 'aryan.lokar@gmail.com', 'monako', '2019-12-31', 'nis', ''),
(4, 'arethecat', '0289382983', 'aryan.lokar@gmail.com', 'monako', '2019-12-30', 'nia', '');

-- --------------------------------------------------------

--
-- Table structure for table `company_contract_section`
--

CREATE TABLE `company_contract_section` (
  `id` int(11) NOT NULL,
  `pid` int(20) NOT NULL,
  `job_type` varchar(255) NOT NULL,
  `yaka_type` varchar(255) NOT NULL,
  `yaka_cost` float NOT NULL,
  `yaka_amount` float NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `yaka_avg` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company_contract_section`
--

INSERT INTO `company_contract_section` (`id`, `pid`, `job_type`, `yaka_type`, `yaka_cost`, `yaka_amount`, `payment_type`, `yaka_avg`) VALUES
(3, 3, 'mobiliat', 'm2', 2, 400, 'qontarat', 800),
(4, 4, 'kashy', 'm2', 2, 1000, 'naqd', 2000);

-- --------------------------------------------------------

--
-- Table structure for table `employ_salary`
--

CREATE TABLE `employ_salary` (
  `id` int(12) NOT NULL,
  `pid` int(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `job_type` varchar(255) NOT NULL,
  `salary_type` varchar(255) NOT NULL,
  `salary_amount` float NOT NULL,
  `salary_avg` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employ_salary`
--

INSERT INTO `employ_salary` (`id`, `pid`, `name`, `job_type`, `salary_type`, `salary_amount`, `salary_avg`) VALUES
(1, 1, 'aryan niman', 'mobiliat', 'daily', 20, 100);

-- --------------------------------------------------------

--
-- Table structure for table `employ_salary_list`
--

CREATE TABLE `employ_salary_list` (
  `id` int(11) NOT NULL,
  `eid` int(20) NOT NULL,
  `amount` float NOT NULL,
  `type` varchar(255) NOT NULL,
  `pay_type` varchar(30) NOT NULL DEFAULT 'hourly',
  `pireod` int(20) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employ_salary_list`
--

INSERT INTO `employ_salary_list` (`id`, `eid`, `amount`, `type`, `pay_type`, `pireod`, `date`) VALUES
(1, 1, 20, 'save', 'daily', 10, '2019-09-01'),
(2, 1, 20, 'spend', 'daily', 5, '2019-09-02');

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avg` float NOT NULL,
  `type` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `note` varchar(2555) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `name`, `phone`, `address`, `email`, `avg`, `type`, `date`, `note`) VALUES
(1, 'arethecat', '0289382983', 'monako', 'aryan.lokar@gmail.com', 900000, 'spend', '2019-09-06', 'nia'),
(2, 'arethecat', '0289382983', 'monako', 'aryan.lokar@gmail.com', 8000, 'spend', '2019-09-07', 'nia');

-- --------------------------------------------------------

--
-- Table structure for table `loan_list`
--

CREATE TABLE `loan_list` (
  `id` int(11) NOT NULL,
  `lid` int(20) NOT NULL,
  `amount` float NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loan_list`
--

INSERT INTO `loan_list` (`id`, `lid`, `amount`, `date`) VALUES
(1, 1, 100000, '2019-09-06'),
(2, 2, 100, '2019-09-07');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `pid` int(20) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `offer_type` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `note` mediumtext NOT NULL,
  `attachment` varchar(2555) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `pid`, `project_name`, `offer_type`, `date`, `note`, `attachment`) VALUES
(1, 1, 'offer one', 'offery dare', '2017-08-06', 'nia', '');

-- --------------------------------------------------------

--
-- Table structure for table `offer_band`
--

CREATE TABLE `offer_band` (
  `id` int(11) NOT NULL,
  `oid` int(20) NOT NULL,
  `first` mediumtext NOT NULL,
  `second` mediumtext NOT NULL,
  `third` mediumtext NOT NULL,
  `forth` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `offer_section`
--

CREATE TABLE `offer_section` (
  `id` int(11) NOT NULL,
  `oid` int(20) NOT NULL,
  `job_type` varchar(255) NOT NULL,
  `yaka_type` varchar(255) NOT NULL,
  `yaka_cost` float NOT NULL,
  `yaka_amount` int(20) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `yaka_avg` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `offer_section`
--

INSERT INTO `offer_section` (`id`, `oid`, `job_type`, `yaka_type`, `yaka_cost`, `yaka_amount`, `payment_type`, `yaka_avg`) VALUES
(1, 1, 'mobiliat', 'm2', 2, 400, 'naqd', 800);

-- --------------------------------------------------------

--
-- Table structure for table `order_band`
--

CREATE TABLE `order_band` (
  `id` int(11) NOT NULL,
  `oid` int(20) NOT NULL,
  `first` mediumtext NOT NULL,
  `second` mediumtext NOT NULL,
  `third` mediumtext NOT NULL,
  `forth` mediumtext NOT NULL,
  `fifth` mediumtext NOT NULL,
  `sixth` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_pay_list`
--

CREATE TABLE `order_pay_list` (
  `id` int(11) NOT NULL,
  `oid` int(20) NOT NULL,
  `amount` float NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_pay_list`
--

INSERT INTO `order_pay_list` (`id`, `oid`, `amount`, `date`) VALUES
(1, 1, 100, '2019-09-04');

-- --------------------------------------------------------

--
-- Table structure for table `order_section`
--

CREATE TABLE `order_section` (
  `id` int(11) NOT NULL,
  `oid` int(20) NOT NULL,
  `item_type` varchar(255) NOT NULL,
  `yaka_type` varchar(255) NOT NULL,
  `yaka_cost` float NOT NULL,
  `yaka_amount` int(20) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `yaka_avg` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_section`
--

INSERT INTO `order_section` (`id`, `oid`, `item_type`, `yaka_type`, `yaka_cost`, `yaka_amount`, `payment_type`, `yaka_avg`) VALUES
(1, 1, 'yaqs', 'm2', 2, 400, 'naqd', 800);

-- --------------------------------------------------------

--
-- Table structure for table `oreders`
--

CREATE TABLE `oreders` (
  `id` int(12) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `country_name` varchar(255) NOT NULL,
  `order_date` date NOT NULL,
  `finish_date` date NOT NULL,
  `panalty_time` int(11) NOT NULL,
  `panalty_cost` float NOT NULL,
  `note` varchar(2555) NOT NULL,
  `attachment` varchar(2555) NOT NULL,
  `arrived` int(1) NOT NULL DEFAULT '0',
  `panalty` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oreders`
--

INSERT INTO `oreders` (`id`, `item_name`, `company_name`, `country_name`, `order_date`, `finish_date`, `panalty_time`, `panalty_cost`, `note`, `attachment`, `arrived`, `panalty`) VALUES
(1, 'kashy', 'dfs', 'United States', '2018-08-04', '0000-00-00', 0, 0, 'nia', '', 0, 0),
(3, 'laptop', 'nokan', 'United States', '2019-09-07', '0000-00-00', 0, 0, 'none', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `parts`
--

CREATE TABLE `parts` (
  `id` int(10) NOT NULL,
  `part` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parts`
--

INSERT INTO `parts` (`id`, `part`) VALUES
(1, 'mechanic'),
(2, 'electric'),
(3, 'civil'),
(4, 'architect');

-- --------------------------------------------------------

--
-- Table structure for table `payments_spend`
--

CREATE TABLE `payments_spend` (
  `id` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `amount` float NOT NULL,
  `panalty` int(20) NOT NULL DEFAULT '0',
  `yaka_amount` float NOT NULL,
  `yaka_type` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `avg` float NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payments_spend`
--

INSERT INTO `payments_spend` (`id`, `cid`, `amount`, `panalty`, `yaka_amount`, `yaka_type`, `date`, `avg`, `title`) VALUES
(1, 3, 1, 0, 400, 'm2', '2019-09-17', 400, 'ruby');

-- --------------------------------------------------------

--
-- Table structure for table `payment_get`
--

CREATE TABLE `payment_get` (
  `id` int(12) NOT NULL,
  `cid` int(11) NOT NULL,
  `amount` float NOT NULL,
  `yaka_amount` float NOT NULL,
  `yaka_type` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `avg` float NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment_get`
--

INSERT INTO `payment_get` (`id`, `cid`, `amount`, `yaka_amount`, `yaka_type`, `date`, `avg`, `title`) VALUES
(1, 4, 2, 20, 'm2', '2019-09-04', 40, 'kashy');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `pid` int(11) NOT NULL,
  `part` int(11) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`pid`, `part`, `project_name`, `date`) VALUES
(2, 1, 'another project', '2019-09-06'),
(3, 1, 'last one', '2019-09-06'),
(4, 1, 'prozhay nokan', '2019-09-07');

-- --------------------------------------------------------

--
-- Table structure for table `spend_count`
--

CREATE TABLE `spend_count` (
  `id` int(11) NOT NULL,
  `pid` int(20) NOT NULL,
  `buy` varchar(2555) NOT NULL,
  `amount` float NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `spend_count`
--

INSERT INTO `spend_count` (`id`, `pid`, `buy`, `amount`, `date`) VALUES
(2, 2, 'laptop', 1500, '2019-09-07');

-- --------------------------------------------------------

--
-- Table structure for table `spend_person`
--

CREATE TABLE `spend_person` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `spend_person`
--

INSERT INTO `spend_person` (`id`, `name`) VALUES
(2, 'aryan niman');

-- --------------------------------------------------------

--
-- Table structure for table `staff_band`
--

CREATE TABLE `staff_band` (
  `id` int(11) NOT NULL,
  `oid` int(20) NOT NULL,
  `first` mediumtext NOT NULL,
  `second` mediumtext NOT NULL,
  `third` mediumtext NOT NULL,
  `forth` mediumtext NOT NULL,
  `fifth` mediumtext NOT NULL,
  `sixth` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `staff_contract`
--

CREATE TABLE `staff_contract` (
  `cid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `note` varchar(2550) NOT NULL,
  `attachment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `staff_contract`
--

INSERT INTO `staff_contract` (`cid`, `name`, `phone`, `email`, `address`, `date`, `note`, `attachment`) VALUES
(3, 'arethecat', '0289382983', 'aryan.lokar@gmail.com', 'monako', '2019-12-31', 'nism', ''),
(4, 'suli workers', '0000000', 'aryan.lokar@gmail.com', 'monako', '2019-12-31', 'nis', '');

-- --------------------------------------------------------

--
-- Table structure for table `staff_contract_section`
--

CREATE TABLE `staff_contract_section` (
  `id` int(11) NOT NULL,
  `pid` int(20) NOT NULL,
  `job_type` varchar(255) NOT NULL,
  `yaka_type` varchar(255) NOT NULL,
  `yaka_cost` float NOT NULL,
  `yaka_amount` float NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `yaka_avg` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `staff_contract_section`
--

INSERT INTO `staff_contract_section` (`id`, `pid`, `job_type`, `yaka_type`, `yaka_cost`, `yaka_amount`, `payment_type`, `yaka_avg`) VALUES
(1, 3, 'mobiliat', 'm2', 2, 400, 'naqd', 800),
(2, 4, 'brik', 'q', 2, 10, 'naqd', 20),
(3, 4, 'pipes', 'm', 2, 400, 'naqd', 800);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `charity`
--
ALTER TABLE `charity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `charity_payment`
--
ALTER TABLE `charity_payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cid_charity_fk` (`cid`);

--
-- Indexes for table `company_band`
--
ALTER TABLE `company_band`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comp_fk_band` (`cid`);

--
-- Indexes for table `company_contract`
--
ALTER TABLE `company_contract`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `company_contract_section`
--
ALTER TABLE `company_contract_section`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid_pk` (`pid`);

--
-- Indexes for table `employ_salary`
--
ALTER TABLE `employ_salary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `part` (`pid`);

--
-- Indexes for table `employ_salary_list`
--
ALTER TABLE `employ_salary_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empfk` (`eid`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_list`
--
ALTER TABLE `loan_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lid_fk` (`lid`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `offer_band`
--
ALTER TABLE `offer_band`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oid_fk_band_offer` (`oid`);

--
-- Indexes for table `offer_section`
--
ALTER TABLE `offer_section`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offer_fk_section` (`oid`);

--
-- Indexes for table `order_band`
--
ALTER TABLE `order_band`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oid_fk_band` (`oid`);

--
-- Indexes for table `order_pay_list`
--
ALTER TABLE `order_pay_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oid_fk` (`oid`);

--
-- Indexes for table `order_section`
--
ALTER TABLE `order_section`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ord_fk_oid` (`oid`);

--
-- Indexes for table `oreders`
--
ALTER TABLE `oreders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parts`
--
ALTER TABLE `parts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments_spend`
--
ALTER TABLE `payments_spend`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sfk` (`cid`);

--
-- Indexes for table `payment_get`
--
ALTER TABLE `payment_get`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pfk` (`cid`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `project_fk` (`part`);

--
-- Indexes for table `spend_count`
--
ALTER TABLE `spend_count`
  ADD PRIMARY KEY (`id`),
  ADD KEY `person_fk` (`pid`);

--
-- Indexes for table `spend_person`
--
ALTER TABLE `spend_person`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_band`
--
ALTER TABLE `staff_band`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oid_staff_fk` (`oid`);

--
-- Indexes for table `staff_contract`
--
ALTER TABLE `staff_contract`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `staff_contract_section`
--
ALTER TABLE `staff_contract_section`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid_fk_staff` (`pid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `charity`
--
ALTER TABLE `charity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `charity_payment`
--
ALTER TABLE `charity_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `company_band`
--
ALTER TABLE `company_band`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `company_contract`
--
ALTER TABLE `company_contract`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `company_contract_section`
--
ALTER TABLE `company_contract_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `employ_salary`
--
ALTER TABLE `employ_salary`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `employ_salary_list`
--
ALTER TABLE `employ_salary_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `loan_list`
--
ALTER TABLE `loan_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `offer_band`
--
ALTER TABLE `offer_band`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `offer_section`
--
ALTER TABLE `offer_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `order_band`
--
ALTER TABLE `order_band`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order_pay_list`
--
ALTER TABLE `order_pay_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `order_section`
--
ALTER TABLE `order_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `oreders`
--
ALTER TABLE `oreders`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `parts`
--
ALTER TABLE `parts`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `payments_spend`
--
ALTER TABLE `payments_spend`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `payment_get`
--
ALTER TABLE `payment_get`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `spend_count`
--
ALTER TABLE `spend_count`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `spend_person`
--
ALTER TABLE `spend_person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `staff_band`
--
ALTER TABLE `staff_band`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `staff_contract`
--
ALTER TABLE `staff_contract`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `staff_contract_section`
--
ALTER TABLE `staff_contract_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `charity_payment`
--
ALTER TABLE `charity_payment`
  ADD CONSTRAINT `cid_charity_fk` FOREIGN KEY (`cid`) REFERENCES `charity` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `company_band`
--
ALTER TABLE `company_band`
  ADD CONSTRAINT `comp_fk_band` FOREIGN KEY (`cid`) REFERENCES `company_contract` (`cid`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `company_contract`
--
ALTER TABLE `company_contract`
  ADD CONSTRAINT `contract_fk` FOREIGN KEY (`cid`) REFERENCES `projects` (`pid`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `company_contract_section`
--
ALTER TABLE `company_contract_section`
  ADD CONSTRAINT `pid_pk` FOREIGN KEY (`pid`) REFERENCES `projects` (`pid`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `employ_salary`
--
ALTER TABLE `employ_salary`
  ADD CONSTRAINT `part` FOREIGN KEY (`pid`) REFERENCES `parts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `employ_salary_list`
--
ALTER TABLE `employ_salary_list`
  ADD CONSTRAINT `empfk` FOREIGN KEY (`eid`) REFERENCES `employ_salary` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `loan_list`
--
ALTER TABLE `loan_list`
  ADD CONSTRAINT `lid_fk` FOREIGN KEY (`lid`) REFERENCES `loans` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `pid` FOREIGN KEY (`pid`) REFERENCES `parts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `offer_band`
--
ALTER TABLE `offer_band`
  ADD CONSTRAINT `oid_fk_band_offer` FOREIGN KEY (`oid`) REFERENCES `offers` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `offer_section`
--
ALTER TABLE `offer_section`
  ADD CONSTRAINT `offer_fk_section` FOREIGN KEY (`oid`) REFERENCES `offers` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `order_band`
--
ALTER TABLE `order_band`
  ADD CONSTRAINT `oid_fk_band` FOREIGN KEY (`oid`) REFERENCES `oreders` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `order_pay_list`
--
ALTER TABLE `order_pay_list`
  ADD CONSTRAINT `oid_fk` FOREIGN KEY (`oid`) REFERENCES `oreders` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `order_section`
--
ALTER TABLE `order_section`
  ADD CONSTRAINT `ord_fk_oid` FOREIGN KEY (`oid`) REFERENCES `oreders` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `payments_spend`
--
ALTER TABLE `payments_spend`
  ADD CONSTRAINT `sfk` FOREIGN KEY (`cid`) REFERENCES `staff_contract` (`cid`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `payment_get`
--
ALTER TABLE `payment_get`
  ADD CONSTRAINT `pfk` FOREIGN KEY (`cid`) REFERENCES `company_contract` (`cid`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `project_fk` FOREIGN KEY (`part`) REFERENCES `parts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `spend_count`
--
ALTER TABLE `spend_count`
  ADD CONSTRAINT `person_fk` FOREIGN KEY (`pid`) REFERENCES `spend_person` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `staff_band`
--
ALTER TABLE `staff_band`
  ADD CONSTRAINT `oid_staff_fk` FOREIGN KEY (`oid`) REFERENCES `staff_contract` (`cid`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `staff_contract`
--
ALTER TABLE `staff_contract`
  ADD CONSTRAINT `staff_contract_fk` FOREIGN KEY (`cid`) REFERENCES `projects` (`pid`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `staff_contract_section`
--
ALTER TABLE `staff_contract_section`
  ADD CONSTRAINT `pid_fk_staff` FOREIGN KEY (`pid`) REFERENCES `projects` (`pid`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
