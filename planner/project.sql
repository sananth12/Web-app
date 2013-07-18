-- phpMyAdmin SQL Dump
-- version 2.11.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 14, 2013 at 05:27 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `sananth12`
--

CREATE TABLE `sananth12` (
  `date` date default NULL,
  `1t` varchar(30) default NULL,
  `2t` varchar(30) default NULL,
  `3t` varchar(30) default NULL,
  `4t` varchar(30) default NULL,
  `5t` varchar(30) default NULL,
  `array` varchar(30) default NULL,
  `total` int(11) default NULL,
  `done` int(11) default NULL,
  `bmi` float default NULL,
  `phone` varchar(20) default '9442221004',
  UNIQUE KEY `date` (`date`),
  UNIQUE KEY `date_2` (`date`),
  UNIQUE KEY `date_3` (`date`),
  UNIQUE KEY `date_4` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sananth12`
--

INSERT INTO `sananth12` (`date`, `1t`, `2t`, `3t`, `4t`, `5t`, `array`, `total`, `done`, `bmi`, `phone`) VALUES
('2013-07-11', 'Graphs', 'Git Update', 'Delta Site project info add', '', '', '000', 3, 0, NULL, '9442221004'),
('2013-07-12', 'Appfrog', 'Graphs', 'Duplicate entrys', '', '', '000', 3, 0, 20.148, '9442221004'),
('2013-07-13', 'App frog', '', '', '', '', '0', 1, 0, 0, '9442221004'),
('2013-07-14', 'Upload site', 'Start packing', 'Start notes', '', '', '000', 3, 0, NULL, '9442221004'),
('2013-07-20', 'Meet Gopi', 'Bank', 'Spider', '', '', '000', 3, 0, NULL, '9442221004'),
('2013-07-15', 'SMS Check', '', '', '', '', '0', 1, 0, NULL, '9442221004'),
('2013-07-16', 'Unpacking', 'Cycle repair/air', '', '', '', '00', 2, 0, NULL, '9442221004'),
('2013-07-17', 'College Reopens!', '', '', '', '', '0', 1, 0, NULL, '9442221004'),
('2013-07-30', 'Play football!', 'IF?', '', '', '', '00', 2, 0, NULL, '9442221004'),
('2013-07-28', 'Sunday!', '', '', '', '', '0', 1, 0, NULL, '9442221004'),
('2013-07-18', 'Get timetable', '', '', '', '', '0', 1, 0, NULL, '9442221004'),
('2013-07-29', '', '', '', '', '', '', 0, 0, NULL, '9442221004'),
('2013-07-05', 'Gym', '', '', '', '', '0', 1, 0, NULL, '9442221004');

-- --------------------------------------------------------

--
-- Table structure for table `sgopi`
--

CREATE TABLE `sgopi` (
  `date` date default NULL,
  `1t` varchar(30) default NULL,
  `2t` varchar(30) default NULL,
  `3t` varchar(30) default NULL,
  `4t` varchar(30) default NULL,
  `5t` varchar(30) default NULL,
  `array` varchar(30) default NULL,
  `total` int(11) default NULL,
  `done` int(11) default NULL,
  `bmi` float default NULL,
  `phone` varchar(20) default '9444983664',
  UNIQUE KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sgopi`
--

INSERT INTO `sgopi` (`date`, `1t`, `2t`, `3t`, `4t`, `5t`, `array`, `total`, `done`, `bmi`, `phone`) VALUES
('2013-07-11', 'Call', '', '', '', '', '0', 1, 0, NULL, '9444983664'),
('2013-07-10', 'Done', 'planned', '', '', '', '10', 2, 1, NULL, '9444983664'),
('2013-07-17', 'College Reopens', '', '', '', '', '0', 1, 0, NULL, '9444983664'),
('2013-08-08', 'Plan Treat', '', '', '', '', '0', 1, 0, NULL, '9444983664'),
('2013-07-12', 'Go home??', '', '', '', '', '0', 1, 0, NULL, '9444983664'),
('2013-07-13', 'Appfrog linux', 'Check appfrog/heroku', '', '', '', '00', 2, 0, NULL, '9444983664'),
('2013-07-14', 'Call maybe?', '', '', '', '', '0', 1, 0, NULL, '9444983664'),
('2013-07-20', 'Leave !', '', '', '', '', '0', 1, 0, NULL, '9444983664'),
('2013-07-29', 'Study', '', '', '', '', '0', 1, 0, NULL, '9444983664'),
('2013-07-18', 'Start prep', '', '', '', '', '0', 1, 0, NULL, '9444983664'),
('2013-07-01', 'Old', '', '', '', '', '0', 1, 0, NULL, '9444983664'),
('2013-07-16', '?', '', '', '', '', '0', 1, 0, NULL, '9444983664');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `Name` varchar(25) NOT NULL,
  `Username` varchar(25) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Dob` date NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`Name`, `Username`, `Password`, `Dob`, `email`, `phone`) VALUES
('Ananthanatarajan.S', 'sananth12', 'sssss', '1994-08-13', 'sananthanatarajan12@gmail.com', '9442221004'),
('Gopikrishna.S', 'sgopi', 'sssss', '1997-09-25', 'sgopikrishna100@gmail.com', '9444983664');

-- --------------------------------------------------------

--
-- Table structure for table `user_msg`
--

CREATE TABLE `user_msg` (
  `date` date NOT NULL,
  `username` varchar(30) NOT NULL,
  `target` varchar(15) NOT NULL,
  `msg` varchar(130) NOT NULL,
  `sent` varchar(10) NOT NULL default 'no'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_msg`
--

INSERT INTO `user_msg` (`date`, `username`, `target`, `msg`, `sent`) VALUES
('2013-07-14', 'sananth12', '9442221004', '1.) Upload site 2.) Start packing 3.) Start notes', 'no');
