-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2020 at 07:46 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tr_hertronic`
--

-- --------------------------------------------------------

--
-- Table structure for table `academicdegrees`
--

CREATE TABLE `academicdegrees` (
  `pkAcd` int(11) NOT NULL,
  `acd_Uid` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `acd_AcademicDegreeName_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acd_AcademicDegreeName_sr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acd_AcademicDegreeName_ba` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acd_AcademicDegreeName_hr` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `acd_AcademicDegreeName_Hn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acd_Notes` text CHARACTER SET latin1,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `academicdegrees`
--

INSERT INTO `academicdegrees` (`pkAcd`, `acd_Uid`, `acd_AcademicDegreeName_en`, `acd_AcademicDegreeName_sr`, `acd_AcademicDegreeName_ba`, `acd_AcademicDegreeName_hr`, `acd_AcademicDegreeName_Hn`, `acd_Notes`, `deleted_at`) VALUES
(1, 'EDU1', 'BE', NULL, NULL, NULL, NULL, 'Engineering', '2020-04-27 18:06:09'),
(2, 'EDU2', 'M.Tech', 'M.Tech', 'M.Tech', 'M.Tech', NULL, 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Cicero\'s De Finibus Bonorum et Malorum for use in a type specimen book. It usually begins with:  “Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.” The purpose of lorem ipsum is to create a natural looking block of text (sentence, paragraph, page, etc.) that doesn\'t distract from the layout. A practice not without controversy, laying out pages with meaningless filler text can be very useful when the focus is meant to be on design, not content.', NULL),
(3, 'EDU3', 'B.Tech', 'B.Tech', 'B.Tech', 'B.Tech', NULL, 'Masters', NULL),
(4, 'EDU4', 'Tools', 'Herramientas', 'Werkzeuge', 'alat', NULL, 'test the daaata', '2020-06-03 14:12:21');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `fkAdmCny` int(11) DEFAULT NULL,
  `fkAdmCan` int(11) DEFAULT NULL,
  `adm_Uid` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adm_Name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adm_Photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adm_Title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adm_Phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adm_GovId` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adm_Gender` enum('Male','Female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `adm_DOB` datetime DEFAULT NULL,
  `adm_Address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verification_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `adm_Status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `type` enum('HertronicAdmin','MinistryAdmin','MinistrySubAdmin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `fkAdmCny`, `fkAdmCan`, `adm_Uid`, `adm_Name`, `adm_Photo`, `email`, `password`, `remember_token`, `adm_Title`, `adm_Phone`, `adm_GovId`, `adm_Gender`, `adm_DOB`, `adm_Address`, `email_verification_key`, `email_verified_at`, `adm_Status`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, NULL, 0, 'HSA1', 'Bruce wayne', '1592544937.jpg', 'admin@hertronic.com', '$2y$10$h7YOLYtz908im66Wxq8gd.Hm3GyE2wsvnqacDJ7s7XM4tGqGAE/ya', NULL, 'Hertronic Super Admin', '94846846477', 'AXV1234NO324122', 'Male', '1994-10-02 12:00:00', NULL, NULL, '2020-04-15 22:15:16', 'Active', 'HertronicAdmin', NULL, '2020-04-08 16:26:04', '2020-06-19 09:35:37'),
(3, NULL, 1, 'MSA3', 'Tom holland', '1587728273.jpeg', 'tom786@mailinator.com', '$2y$10$lxTPpjTRNeIQy4bYyTlCgeOpHMNGCS8v7rwU.RpoHnUlgXh4ziOVy', NULL, 'Ministry Admin', '9894948948', 'XIUE86676CVDEE', 'Male', '1989-07-05 12:00:00', '102, Lorem street', '1ecf0d6d7456514db3a25019b3f27325', NULL, 'Active', 'MinistryAdmin', NULL, '2020-04-24 11:11:49', '2020-06-11 15:19:04'),
(4, NULL, 1, 'MSA4', 'jerry maguire', '1587735633.jpg', 'jerry786@mailinator.com', '$2y$10$n7eDBmbg/CaHOCYuBb1zYuFeGac3XX0G6mfFVQDbWsM72QNpMn7Hy', NULL, 'Ministry Admin', '4949849498', 'AUYYI765665', 'Male', '2020-04-12 12:00:00', 'A-395, sto', '0a55114a8f6a88c048bc8a5d4392c985', NULL, 'Inactive', 'MinistryAdmin', NULL, '2020-04-24 16:55:45', '2020-04-24 17:40:33'),
(5, NULL, 0, 'HSA5', 'Davor Simic', '1587737233.jpg', 'hertronicadmin@mailinator.com', '$2y$10$Vt3iSOOri3USuTwvboc9eOdRYxOosjuDE14PiZhsvv57JdeT8ZQP2', NULL, 'Hertronic Super Admin', '94846846477', 'YTAXV12433', 'Male', '2000-12-15 12:00:00', NULL, NULL, '2020-04-15 22:15:16', 'Active', 'HertronicAdmin', NULL, '2020-04-08 16:26:04', '2020-05-08 17:15:01'),
(6, NULL, 3, 'MSA6', 'daniel craig', '1588223197.jpg', 'dani786@mailinator.com', '$2y$10$tH7qOXHmCzP60XG1ISvajOvFsN6dJ1IdCP0nC9gyF55uDr9U91NDu', NULL, NULL, '446846464684', 'YIOHE3744BUUG', 'Male', '1970-01-01 12:00:00', NULL, '205fc28442bf98c3826f5f1bdee03550', NULL, 'Active', 'MinistryAdmin', NULL, '2020-04-30 08:59:35', '2020-05-08 15:39:49'),
(7, NULL, 1, 'MSA7', 'Sanjay Rajpurohit', '1588568188.png', 'technourceceo@gmail.com', '$2y$10$RyPxuSeXDiBoMHZBDrCBYOJXQSPVFnRCwFfyB93/w6cZQUGU2FtYG', NULL, 'Mr', '8238605801', 'GUID123456789', 'Male', '1970-01-01 12:00:00', 'Technource, B 401, Ahmedabad', '8ce6a79aa3a41d39909ba7df8d76ea9a', NULL, 'Active', 'MinistryAdmin', NULL, '2020-05-04 08:56:28', '2020-05-04 08:56:28'),
(11, NULL, 3, 'SBA11', 'arnold hox', NULL, 'arnold786@mailinator.com', NULL, NULL, 'sub', '6848978777', 'IBGYF76755', 'Male', '1989-06-06 12:00:00', NULL, 'dd25c2f7ef0cd4225a9d36fc138f780b', NULL, 'Active', 'MinistrySubAdmin', NULL, '2020-05-05 15:57:24', '2020-05-05 15:57:24'),
(12, NULL, 2, 'SBA12', 'fiona pears', NULL, 'fiona786@mailinator.com', NULL, NULL, NULL, '68468684', 'BUTRREE65646', 'Female', '1970-01-01 12:00:00', NULL, '1f2b3573bce79f39373b3e9c4c744a8e', NULL, 'Active', 'MinistrySubAdmin', NULL, '2020-05-05 16:35:31', '2020-05-05 16:37:41'),
(10, NULL, 1, 'MSA10', 'terry james', '1593061633.jpeg', 'terry786@mailinator.com', '$2y$10$XctNSS1hS4.oevPg.GEQM.22NucZDTBEwNDbVBW2pisIjgfRzXwBa', NULL, 'Hertronic Ministry Admin', '48468468468', 'HHETT865566RR', 'Male', '2020-01-05 12:00:00', 'sdf', '09cbda9494184932202701d9203315af', '2020-05-21 14:23:27', 'Active', 'MinistryAdmin', NULL, '2020-05-04 13:18:21', '2020-06-25 09:07:13'),
(13, NULL, 3, 'MSA13', 'Dominic cooper', NULL, 'ministryAdmin@mailinator.com', '$2y$10$Vt3iSOOri3USuTwvboc9eOdRYxOosjuDE14PiZhsvv57JdeT8ZQP2', NULL, 'Ministry Admin', '84849498484', 'BUFF7654', 'Male', '1994-06-22 12:00:00', NULL, '942cafc7a01d364989db3bf8733a84f7', '2020-05-08 15:58:25', 'Active', 'MinistryAdmin', NULL, '2020-05-08 15:53:37', '2020-05-08 16:36:41'),
(14, NULL, 4, 'SBA14', 'Tom hardy', NULL, 'hardy786@mailinator.com', NULL, NULL, 'Sub Admin', '6848468468', 'OHF85557', 'Male', '1970-01-01 12:00:00', NULL, '480325120bf1fbc274b22e843f6c2ab8', NULL, 'Active', 'MinistrySubAdmin', NULL, '2020-05-08 16:08:12', '2020-05-08 16:08:12'),
(18, NULL, 1, 'MSA18', 'Hardik Joshi', NULL, 'hardik123@mailinator.com', '$2y$10$vOeBy/WJ5wnQ/e7jgYRyTuEV5WFDF8vHwtFhJVSPzUQIO0QsoNVw.', NULL, 'My Hertronic', '1234567890', '12345678911', 'Male', '2000-01-02 12:00:00', 'Ahmedabad, India', '5d48425b32b43188079da9d357dc37e8', '2020-05-14 18:51:18', 'Active', 'MinistryAdmin', NULL, '2020-05-14 18:50:17', '2020-05-14 18:52:25'),
(17, NULL, 1, 'MSA17', 'Hardik Joshi', NULL, 'hardik121@mailinator.com', NULL, NULL, 'My Title', '12345678', '1234567890', 'Male', '2014-11-19 12:00:00', 'My address line', '31b640eccce0a254f06e2d1ed36e4fe4', NULL, 'Active', 'MinistryAdmin', NULL, '2020-05-11 19:30:59', '2020-05-11 19:30:59'),
(19, NULL, 1, 'MSA19', 'Tanveer Khan', '1590133577.jpg', 'tanveerk@yopmail.com', '$2y$10$JgnavXZVqWHZ.M.6.FcIt.RvmIntjHLn/g0qDk21ujrOJg0Q7sXFa', NULL, 'fghfg', '4343434343', 'fghgfhfg', 'Male', '2020-01-14 12:00:00', 'gfh fgh hgfh fgh', 'cc4dd473b24020aa79dd8a0ab05330ef', NULL, 'Active', 'MinistryAdmin', NULL, '2020-05-22 11:46:17', '2020-05-22 11:49:29'),
(20, NULL, 4, 'MSA20', 'VishalMA Chaudhari', NULL, 'vishalma@mailinator.com', '$2y$10$6gMAdKrd0olYfiFQlq7.UOZRNZmK3p/eMq/88Q2I3j7TU9mZoWJXO', NULL, 'QA', '8055063747', 'ABCD1234', 'Male', '2020-06-01 12:00:00', 'Delaware, 43015, OH', '975fd32e0696481ac6b60a4e3fe706c7', '2020-06-03 12:20:04', 'Active', 'MinistryAdmin', NULL, '2020-06-03 12:11:44', '2020-06-03 12:25:15');

-- --------------------------------------------------------

--
-- Table structure for table `cantons`
--

CREATE TABLE `cantons` (
  `pkCan` int(11) NOT NULL,
  `fkCanSta` int(11) NOT NULL,
  `can_Uid` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `can_CantonName_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `can_CantonName_sr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `can_CantonName_ba` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `can_CantonName_hr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `can_CantonName_Hn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `can_CantonNameGenitive` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `can_Note` text COLLATE utf8mb4_unicode_ci,
  `can_Status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cantons`
--

INSERT INTO `cantons` (`pkCan`, `fkCanSta`, `can_Uid`, `can_CantonName_en`, `can_CantonName_sr`, `can_CantonName_ba`, `can_CantonName_hr`, `can_CantonName_Hn`, `can_CantonNameGenitive`, `can_Note`, `can_Status`, `deleted_at`) VALUES
(1, 1, 'CAN1', 'Ahmedabad', 'Ahmedabad 1', 'Ahmedabad 2', 'Ahmedabad 3', NULL, 'Ahmedabad', 'note1', 'Active', NULL),
(2, 5, 'CAN2', 'Cypress', 'kfg', 'lijfdlj', 'igfidfi', NULL, 'Cypress', 'Lorem ipsum, or lipsum as it is sometimes known', 'Active', NULL),
(3, 3, 'CAN3', 'Central Coast', 'Central Coast', 'Central Coast', 'Central Coast', NULL, 'Central Coast', NULL, 'Inactive', NULL),
(4, 4, 'CAN4', 'West Herzegovina Canton', 'West Herzegovina Canton', 'West Herzegovina Canton', 'West Herzegovina Canton', NULL, 'West Herzegovina Canton', NULL, 'Active', NULL),
(5, 1, 'CAN5', 'ENGs', 'SPA', 'GERs', 'CRO', NULL, 'COs', 'EDEDE', 'Inactive', NULL),
(6, 4, 'CAN6', 'TestCan', 'Tetcanton', 'dsjkhjdskhl', 'kjkdsh lskgh', NULL, 'kjdslfk', 'sdjfhkdsjshdgjsk', 'Active', '2020-06-04 10:33:23'),
(7, 1, 'CAN7', 'kjfhKJHKDFJF', 'ksdfjh', 'lkfd', 'lkfj', NULL, 'lkhf', 'fdshj', 'Inactive', NULL),
(8, 4, 'CAN8', 'Cypress', 'Cipréss', 'Zypresse', 'Čempres', NULL, 'Cypress11', 'Test the data', 'Active', '2020-06-30 17:34:09'),
(9, 1, 'CAN9', 'test', 'test', 'test', 'testtet', NULL, 'tet', 'kjsdfhkdsg', 'Active', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `citizenships`
--

CREATE TABLE `citizenships` (
  `pkCtz` int(11) NOT NULL,
  `fkCtzCny` int(11) DEFAULT NULL,
  `ctz_Uid` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `ctz_CitizenshipName_en` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ctz_CitizenshipName_sr` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ctz_CitizenshipName_ba` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ctz_CitizenshipName_hr` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ctz_CitizenshipName_Hn` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ctz_Notes` text CHARACTER SET latin1,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `citizenships`
--

INSERT INTO `citizenships` (`pkCtz`, `fkCtzCny`, `ctz_Uid`, `ctz_CitizenshipName_en`, `ctz_CitizenshipName_sr`, `ctz_CitizenshipName_ba`, `ctz_CitizenshipName_hr`, `ctz_CitizenshipName_Hn`, `ctz_Notes`, `deleted_at`) VALUES
(2, 1, 'CIZ2', 'Indian', 'spa', 's', 'a', NULL, 'ctz', NULL),
(3, 4, 'CIZ3', 'EnglishLang', 'EnglishSp', 'EnglishGer', 'EnglishCro', NULL, 'Test the Language in Country', NULL),
(4, 7, 'CIZ4', 'test123', 'test123', 'test122', 'Test1111222233', NULL, 'test the name12121', '2020-06-01 13:43:53'),
(5, 5, 'CIZ5', 'test2', 'test2', 'test2', 'test2', NULL, 'tt222', '2020-06-01 13:44:50'),
(6, 7, 'CIZ6', 'test111222333', 'test11122333', 'test111222222', 'test11122', NULL, 'test11112233', NULL),
(7, 2, 'CIZ7', 'test', 'tet', 'test', 'tet', NULL, 'fdsjh', NULL),
(8, 1, 'CIZ8', 'dsfjk', 'fdsjh', 'fdsjk', 'fdsjk', NULL, 'dsfjkdg', NULL),
(9, 1, 'CIZ9', 'CityE', 'CityS', 'CityG', 'CityC', NULL, 'tyersxcvbk/,n', '2020-06-29 15:39:51');

-- --------------------------------------------------------

--
-- Table structure for table `classcreation`
--

CREATE TABLE `classcreation` (
  `pkClr` int(11) NOT NULL,
  `fkClrSye` int(11) DEFAULT NULL,
  `fkClrCla` int(11) DEFAULT NULL,
  `fkClrSch` int(11) DEFAULT NULL,
  `fkClrVsc` int(11) DEFAULT NULL,
  `fkClrCsa` int(11) DEFAULT NULL,
  `fkClrCsat` int(11) DEFAULT NULL,
  `fkClrEdp` int(11) DEFAULT NULL,
  `clr_Status` enum('Pending','Publish') NOT NULL DEFAULT 'Pending',
  `clr_Notes` text,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classcreation`
--

INSERT INTO `classcreation` (`pkClr`, `fkClrSye`, `fkClrCla`, `fkClrSch`, `fkClrVsc`, `fkClrCsa`, `fkClrCsat`, `fkClrEdp`, `clr_Status`, `clr_Notes`, `deleted_at`) VALUES
(7, 4, 3, 8, NULL, NULL, NULL, 1, 'Pending', NULL, NULL),
(6, 4, 3, 3, NULL, 17, 15, 5, 'Pending', 'class creation', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `classcreationgrades`
--

CREATE TABLE `classcreationgrades` (
  `pkCcg` int(11) NOT NULL,
  `fkCcgClr` int(11) DEFAULT NULL,
  `fkCcgGra` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classcreationgrades`
--

INSERT INTO `classcreationgrades` (`pkCcg`, `fkCcgClr`, `fkCcgGra`, `deleted_at`) VALUES
(74, 7, 5, NULL),
(73, 7, 4, NULL),
(72, 7, 3, NULL),
(71, 6, 3, NULL),
(70, 6, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `pkCla` int(11) NOT NULL,
  `cla_Uid` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `cla_ClassName_en` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cla_ClassName_sr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cla_ClassName_ba` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cla_ClassName_hr` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `cla_ClassName_Hn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cla_Notes` text CHARACTER SET latin1,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`pkCla`, `cla_Uid`, `cla_ClassName_en`, `cla_ClassName_sr`, `cla_ClassName_ba`, `cla_ClassName_hr`, `cla_ClassName_Hn`, `cla_Notes`, `deleted_at`) VALUES
(3, 'CLA3', 'A', 'a', 'a', 'a', NULL, 'note for A', NULL),
(4, 'CLA4', 'B', 'bsdfilj', 'fdjdl;fdj', 'l;dfk;g', NULL, 'hfg', NULL),
(5, 'CLA5', 'Project', 'Proyecto', 'Projekt', 'Projekttt', NULL, 'testt hedataaaalkdfjlkgd', '2020-06-03 14:18:48'),
(6, 'CLA6', 'test', 'tet1', 'test2', 'tets3', NULL, 'l;fdk;lg', '2020-06-03 14:19:37');

-- --------------------------------------------------------

--
-- Table structure for table `classstudentsallocation`
--

CREATE TABLE `classstudentsallocation` (
  `pkCsa` int(11) NOT NULL,
  `fkCsaClr` int(11) DEFAULT NULL,
  `fkCsaSen` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classstudentsallocation`
--

INSERT INTO `classstudentsallocation` (`pkCsa`, `fkCsaClr`, `fkCsaSen`, `deleted_at`) VALUES
(54, 6, 15, NULL),
(53, 6, 21, NULL),
(52, 6, 19, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `classteachersandcourseallocation`
--

CREATE TABLE `classteachersandcourseallocation` (
  `pkCtc` int(11) NOT NULL,
  `fkCtcClr` int(11) DEFAULT NULL,
  `fkCtcEmc` int(11) DEFAULT NULL,
  `fkCtcEeg` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classteachersandcourseallocation`
--

INSERT INTO `classteachersandcourseallocation` (`pkCtc`, `fkCtcClr`, `fkCtcEmc`, `fkCtcEeg`, `deleted_at`) VALUES
(98, 6, 2, 7, NULL),
(97, 6, 1, 81, NULL),
(96, 6, 3, 41, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `colleges`
--

CREATE TABLE `colleges` (
  `pkCol` int(11) NOT NULL,
  `fkColUni` int(11) DEFAULT NULL,
  `fkColCny` int(11) DEFAULT NULL,
  `fkColOty` int(11) DEFAULT NULL,
  `col_Uid` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `col_CollegeName_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `col_CollegeName_sr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `col_CollegeName_ba` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `col_CollegeName_hr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `col_CollegeName_Hn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `col_YearStartedFounded` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `col_BelongsToUniversity` enum('Yes','No') CHARACTER SET latin1 NOT NULL DEFAULT 'No',
  `col_PicturePath` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `col_Notes` text CHARACTER SET latin1,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colleges`
--

INSERT INTO `colleges` (`pkCol`, `fkColUni`, `fkColCny`, `fkColOty`, `col_Uid`, `col_CollegeName_en`, `col_CollegeName_sr`, `col_CollegeName_ba`, `col_CollegeName_hr`, `col_CollegeName_Hn`, `col_YearStartedFounded`, `col_BelongsToUniversity`, `col_PicturePath`, `col_Notes`, `deleted_at`) VALUES
(4, 1, 1, 1, 'COL4', 'AITS', NULL, NULL, NULL, NULL, '2006', 'Yes', NULL, NULL, NULL),
(3, NULL, 1, 2, 'COL3', 'IIT Kanpur', 'IIT Kanpur 1', 'IIT Kanpur 2', 'IIT Kanpur 3', NULL, '2018', 'No', NULL, 'note 2132', NULL),
(5, 3, 4, 1, 'COL5', 'Kemal Kapetanović', 'Kemal Kapetanović', 'Kemal Kapetanović', 'Kemal Kapetanović', NULL, '2008', 'Yes', '1588165005.jpg', NULL, NULL),
(7, 5, 2, 1, 'COL7', 'test', 'hjgjhqjkhjk', 'kjljlkjlh', 'jhlklh', NULL, '2014', 'Yes', '1591181055.png', 'fyr', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `pkCny` int(11) NOT NULL,
  `cny_Uid` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cny_CountryName_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cny_CountryName_sr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cny_CountryName_ba` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cny_CountryName_hr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cny_CountryName_Hn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cny_CountryNameGenitive` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cny_CountryNameDative` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cny_CountryNameAdjective` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cny_Note` text COLLATE utf8mb4_unicode_ci,
  `cny_Status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`pkCny`, `cny_Uid`, `cny_CountryName_en`, `cny_CountryName_sr`, `cny_CountryName_ba`, `cny_CountryName_hr`, `cny_CountryName_Hn`, `cny_CountryNameGenitive`, `cny_CountryNameDative`, `cny_CountryNameAdjective`, `cny_Note`, `cny_Status`, `deleted_at`) VALUES
(1, 'CON1', 'India', 'India 1', 'India 2', 'India 3', NULL, 'Indian', 'Indian', 'Indian', 'note for india', 'Active', NULL),
(2, 'CON2', 'Canada', 'Canada1s', 'Canada1c', 'Canada1cc', NULL, 'Canadian', 'Canadian', 'Canadians', 'test note', 'Inactive', NULL),
(3, 'CON3', 'Croatia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Note', 'Active', '2020-04-26 06:02:42'),
(4, 'CON4', 'Bosnia and Herzegovina', 'Bosnia and Herzegovina', 'Bosnia and Herzegovina', 'Bosnia and Herzegovina', NULL, 'Bosnia and Herzegovina', 'Bosnia and Herzegovina', 'Bosnia and Herzegovina', 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Cicero\'s De Finibus Bonorum et Malorum for use in a type specimen book. It usually begins with:  “Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.” The purpose of lorem ipsum is to create a natural looking block of text (sentence, paragraph, page, etc.) that doesn\'t distract from the layout. A practice not without controversy, laying out pages with meaningless filler text can be very useful when the focus is meant to be on design, not content.', 'Active', NULL),
(5, 'CON5', 'Australia', 'Australia', 'Australia', 'Australia', NULL, 'Australian', 'Australian', 'Australian', 'note here', 'Active', NULL),
(7, 'CON7', 'USA', 'Estados Unidos', 'USA', 'SAD', NULL, 'USA', 'USA', 'USA', 'This countrys', 'Inactive', NULL),
(8, 'CON8', 'United Kingdom', 'United Kingdom', 'United Kingdom', 'United Kingdom', NULL, 'United Kingdom', 'United Kingdom', 'United Kingdom', 'Note here...', 'Active', '2020-06-01 13:35:35');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `pkCrs` int(11) NOT NULL,
  `crs_Uid` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `crs_CourseName_en` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crs_CourseName_sr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crs_CourseName_ba` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crs_CourseName_hr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crs_CourseName_Hn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crs_CourseAlternativeName` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `crs_CourseType` enum('General','Specialization','DummyOptionalCourse','DummyForeignCourse') CHARACTER SET latin1 DEFAULT 'General',
  `crs_IsForeignLanguage` enum('Yes','No') CHARACTER SET latin1 DEFAULT 'No',
  `crs_Notes` text CHARACTER SET latin1,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`pkCrs`, `crs_Uid`, `crs_CourseName_en`, `crs_CourseName_sr`, `crs_CourseName_ba`, `crs_CourseName_hr`, `crs_CourseName_Hn`, `crs_CourseAlternativeName`, `crs_CourseType`, `crs_IsForeignLanguage`, `crs_Notes`, `deleted_at`) VALUES
(1, 'COU454', 'Physics', 'Física', 'Physik', 'Fizika', NULL, 'Physics-1', 'General', 'Yes', 'note', NULL),
(2, 'COU554', 'Chemistry', 'Química', 'Chemie', 'Kemija', NULL, 'chemist', 'General', 'No', NULL, NULL),
(3, 'CO123', 'Maths', 'Matemáticas', 'Mathe', 'Matematika', NULL, 'MC', 'General', 'Yes', NULL, NULL),
(4, 'ABCD', 'CoursesE', 'CoursesSss', 'CoursesG', 'CoursesC', NULL, 'Test the Cource', 'General', 'Yes', 'Test the dataaaa', '2020-06-04 16:46:14'),
(5, 'sdfsj', 'kfdj', 'lkfjd', 'lkfdlk', 'kldsfklFDLKJ', NULL, 'dflk', 'Specialization', 'Yes', 'dfklsnlg', '2020-06-04 12:51:22'),
(6, 'gfj', 'bjllkfdj', 'gfjkl', 'gdkl', 'qkldg', NULL, 'fdjk', 'Specialization', 'No', 'fkjh', '2020-06-04 12:51:39'),
(7, 'OC1', 'Optional Course - 1', 'Curso opcional - 1', 'Wahlkurs - 1', 'Fakultativni tečaj - 1', NULL, 'Optional Courses - 1', 'DummyOptionalCourse', 'No', NULL, NULL),
(8, 'OC2', 'Optional Course - 2', 'Curso opcional - 2', 'Wahlkurs - 2', 'Fakultativni tečaj - 2', NULL, 'Optional Courses - 2', 'DummyOptionalCourse', 'No', NULL, NULL),
(9, 'OC3', 'Optional Course - 3', 'Curso opcional - 3', 'Wahlkurs - 3', 'Fakultativni tečaj - 3', NULL, 'Optional Courses - 3', 'DummyOptionalCourse', 'No', NULL, NULL),
(10, 'OC4', 'Optional Course - 4', 'Curso opcional - 4', 'Wahlkurs - 4', 'Fakultativni tečaj - 4', NULL, 'Optional Courses - 4', 'DummyOptionalCourse', 'No', NULL, NULL),
(11, 'FC1', 'Foreign Language Course - 1', 'Curso de idioma extranjero - 1', 'Fremdsprachenkurs - 1', 'Tečaj stranih jezika - 1', NULL, 'Foreign Language Course - 1', 'DummyForeignCourse', 'No', NULL, NULL),
(12, 'FC2', 'Foreign Language Course - 2', 'Curso de idioma extranjero - 2', 'Fremdsprachenkurs - 2', 'Tečaj stranih jezika - 2', NULL, 'Foreign Language Course - 2\r\n', 'DummyForeignCourse', 'No', NULL, NULL),
(13, 'FC2', 'Foreign Language Course - 3', 'Curso de idioma extranjero - 3', 'Fremdsprachenkurs - 3', 'Tečaj stranih jezika - 3', NULL, 'Foreign Language Course - 3\r\n', 'DummyForeignCourse', 'No', NULL, NULL),
(14, 'FC4', 'Foreign Language Course - 4', 'Foreign Language Course - 4', 'Foreign Language Course - 4', 'Foreign Language Course - 4', NULL, 'Foreign Language Course - 4', 'DummyForeignCourse', 'No', NULL, NULL),
(15, 'COU12', 'Biology', 'Biology', 'Biology', 'Biology', NULL, 'Biology', 'General', 'No', NULL, NULL),
(16, 'COU1234', 'Croatian', 'Hrvatski', 'Hrvatski', 'Hrvatski', NULL, 'Hrvatski', 'General', 'No', '', NULL),
(17, 'aasdff4', 'test course', 'test course', 'test course', 'test course', NULL, 'test course', 'General', 'No', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `educationperiods`
--

CREATE TABLE `educationperiods` (
  `pkEdp` int(11) UNSIGNED NOT NULL,
  `edp_Uid` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edp_EducationPeriodName_en` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edp_EducationPeriodName_sr` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edp_EducationPeriodName_ba` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edp_EducationPeriodName_hr` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edp_EducationPeriodName_Hn` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edp_EducationPeriodNameAdjective` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `educationperiods`
--

INSERT INTO `educationperiods` (`pkEdp`, `edp_Uid`, `edp_EducationPeriodName_en`, `edp_EducationPeriodName_sr`, `edp_EducationPeriodName_ba`, `edp_EducationPeriodName_hr`, `edp_EducationPeriodName_Hn`, `edp_EducationPeriodNameAdjective`, `deleted_at`) VALUES
(1, 'EDP1', '6th Semesters', '6th Semesters sp', '6th Semesters de', '6th Semesters hr', NULL, '6th_Semesters.', NULL),
(2, 'EDP2', '6th Semesters', '', '', '', NULL, '6th_Semesters', '2020-05-13 02:38:00'),
(3, 'EDP3', '5th Semeste', '', '', '', NULL, '5_fdg dfg dg', '2020-05-13 03:18:25'),
(4, 'EDP4', '3th Semesters', '', '', '', NULL, 'The above', '2020-05-13 04:16:56'),
(5, 'EDP5', '2th Semesters', '2th Semesters', '2th Semesters', '2th Semesters', NULL, 'Semestersdd', NULL),
(6, 'EDP6', 'Education Period 21', 'Education Period 21', 'Education Period 21', 'Education Period 21', NULL, 'EDU21', NULL),
(7, 'EDP7', 'ddd', '', '', '', NULL, 'dd', '2020-05-20 16:26:42'),
(8, 'EDP8', 'Cypress', 'Ciprés', 'Zypresse', 'Čempres', NULL, 'hjgh', NULL),
(9, 'EDP9', 'kdxjklfsh', 'jdsfjkj', 'kdslfhl', 'dslkhfdsklh', NULL, 'sdfkhlf', '2020-06-04 11:15:40'),
(10, 'EDP10', 'kfllk', 'lkfjdkl', 'klfdsj', 'kljfdlk', NULL, 'lkgdflkfdjl', '2020-06-04 11:16:18'),
(11, 'EDP11', 'fkdjgfkl', 'jkfjk', 'dfkghlk', 'gdfkll', NULL, 'kjsdfhk', '2020-06-04 11:56:17'),
(12, 'EDP12', 'kdg', 'lkjdfkljkl', 'fdsklfjl', 'fdslkj', NULL, 'fgjkljhjkh', '2020-06-04 11:56:37'),
(13, 'EDP13', 'Cypress Education periods', 'Ciprés Education periods', 'Zypresse Education periods', 'Čempres Education periods', NULL, 'Test the data', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `educationplans`
--

CREATE TABLE `educationplans` (
  `pkEpl` int(11) NOT NULL,
  `fkEplEdp` int(11) DEFAULT NULL,
  `fkEplNep` int(11) DEFAULT NULL,
  `fkEplEpr` int(11) DEFAULT NULL,
  `fkEplQde` int(11) DEFAULT NULL,
  `fkEplGra` int(11) DEFAULT NULL,
  `epl_Uid` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `epl_EducationPlanName_en` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `epl_EducationPlanName_sr` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `epl_EducationPlanName_ba` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `epl_EducationPlanName_hr` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `epl_EducationPlanName_Hn` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `educationplans`
--

INSERT INTO `educationplans` (`pkEpl`, `fkEplEdp`, `fkEplNep`, `fkEplEpr`, `fkEplQde`, `fkEplGra`, `epl_Uid`, `epl_EducationPlanName_en`, `epl_EducationPlanName_sr`, `epl_EducationPlanName_ba`, `epl_EducationPlanName_hr`, `epl_EducationPlanName_Hn`, `deleted_at`) VALUES
(9, 2, 2, 2, 2, 1, 'EPL9', 'Summer education plan', 'Plan educativo de verano', 'Sommerbildungsplan', 'Plan ljetnog obrazovanja', NULL, NULL),
(10, 2, 3, 1, 4, 1, 'EPL10', 'Web developer plan', 'Plan de desarrollador web', 'Webentwicklerplan', 'Plan web programera', NULL, NULL),
(6, 4, 2, 2, 3, 1, 'EPL6', 'Education Programming Plan', 'Plan de programación educativa', 'Bildungsprogrammplan', 'Plan programiranja obrazovanja', NULL, NULL),
(11, 2, 1, 2, 1, 1, 'EPL11', 'Education', 'Educación', 'Bildung', 'Obrazovanje', NULL, NULL),
(12, 5, 2, 1, 2, 1, 'EPL12', 'Secondary School plan EEE', 'Secondary School plan SS', 'Secondary School plan GG', 'Secondary School plan CC', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `educationplansforeignlanguage`
--

CREATE TABLE `educationplansforeignlanguage` (
  `pkEfl` int(11) NOT NULL,
  `fkEflEpl` int(11) DEFAULT NULL,
  `fkEflCrs` int(11) DEFAULT NULL,
  `efc_hours` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `educationplansforeignlanguage`
--

INSERT INTO `educationplansforeignlanguage` (`pkEfl`, `fkEflEpl`, `fkEflCrs`, `efc_hours`, `deleted_at`) VALUES
(62, 11, 13, '9', NULL),
(51, 10, 12, '4', NULL),
(50, 10, 11, '2', NULL),
(49, 9, 11, '1', NULL),
(74, 6, 11, '2', NULL),
(29, 5, 3, '8', NULL),
(73, 6, 12, '3', NULL),
(72, 6, 13, '6', NULL),
(71, 12, 11, '15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `educationplansmandatorycourses`
--

CREATE TABLE `educationplansmandatorycourses` (
  `pkEmc` int(11) NOT NULL,
  `fkEmcEpl` int(11) DEFAULT NULL,
  `fkEplCrs` int(11) DEFAULT NULL,
  `emc_hours` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `educationplansmandatorycourses`
--

INSERT INTO `educationplansmandatorycourses` (`pkEmc`, `fkEmcEpl`, `fkEplCrs`, `emc_hours`, `deleted_at`) VALUES
(52, 9, 1, '3', NULL),
(51, 9, 2, '4', NULL),
(50, 8, 1, '3', NULL),
(49, 8, 2, '4', NULL),
(48, 7, 1, '3', NULL),
(33, 5, 3, '2', NULL),
(47, 7, 2, '4', NULL),
(101, 6, 3, '4', NULL),
(53, 10, 3, '6', NULL),
(64, 11, 1, '9', NULL),
(100, 12, 1, '3', NULL),
(99, 12, 2, '4', NULL),
(98, 12, 3, '2', NULL),
(97, 12, 15, '3', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `educationplansoptionalcourses`
--

CREATE TABLE `educationplansoptionalcourses` (
  `pkEoc` int(11) NOT NULL,
  `fkEocEpl` int(11) DEFAULT NULL,
  `fkEocCrs` int(11) DEFAULT NULL,
  `eoc_hours` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `educationplansoptionalcourses`
--

INSERT INTO `educationplansoptionalcourses` (`pkEoc`, `fkEocEpl`, `fkEocCrs`, `eoc_hours`, `deleted_at`) VALUES
(64, 11, 8, '9', NULL),
(53, 10, 8, '5', NULL),
(52, 10, 7, '3', NULL),
(84, 6, 7, '3', NULL),
(50, 9, 8, '2', NULL),
(33, 5, 6, '5', NULL),
(51, 9, 7, '5', NULL),
(83, 6, 9, '2', NULL),
(82, 12, 7, '2', NULL),
(81, 12, 8, '1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `educationprofiles`
--

CREATE TABLE `educationprofiles` (
  `pkEpr` int(11) NOT NULL,
  `epr_Uid` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `epr_EducationProfileName_en` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `epr_EducationProfileName_sr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `epr_EducationProfileName_ba` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `epr_EducationProfileName_hr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `epr_EducationProfileName_Hn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `epr_Notes` text CHARACTER SET latin1,
  `epr_Status` enum('Active','Inactive') CHARACTER SET latin1 NOT NULL DEFAULT 'Active',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `educationprofiles`
--

INSERT INTO `educationprofiles` (`pkEpr`, `epr_Uid`, `epr_EducationProfileName_en`, `epr_EducationProfileName_sr`, `epr_EducationProfileName_ba`, `epr_EducationProfileName_hr`, `epr_EducationProfileName_Hn`, `epr_Notes`, `epr_Status`, `deleted_at`) VALUES
(1, 'EDP1', 'B', 'B', 'B', 'B', NULL, 'note for B', 'Inactive', NULL),
(2, 'EDP2', 'A', 'A', 'A', 'A', NULL, NULL, 'Active', NULL),
(3, 'EDP3', 'Ds', 'D\'s', 'DS', 'D', NULL, 'DDs', 'Active', NULL),
(4, 'EDP4', 'Jobs', 'Trabajos', 'Arbeitsplätze', 'Posao', NULL, 'jkhdgkjfhjdfsfh', 'Inactive', '2020-06-03 14:24:38'),
(5, 'EDP5', 'EEEE', 'SSSS', 'GGG', 'CCC', NULL, 'Checking notes', 'Active', '2020-06-29 13:42:07');

-- --------------------------------------------------------

--
-- Table structure for table `educationprograms`
--

CREATE TABLE `educationprograms` (
  `pkEdp` int(11) UNSIGNED NOT NULL,
  `edp_Uid` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edp_Name_en` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edp_Name_sr` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edp_Name_ba` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edp_Name_hr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edp_Name_Hn` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edp_ParentId` int(11) NOT NULL,
  `edp_Notes` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `educationprograms`
--

INSERT INTO `educationprograms` (`pkEdp`, `edp_Uid`, `edp_Name_en`, `edp_Name_sr`, `edp_Name_ba`, `edp_Name_hr`, `edp_Name_Hn`, `edp_ParentId`, `edp_Notes`, `deleted_at`) VALUES
(2, 'EPR2', 'Web Developers', 'Web Developers spanish', 'Web Developers german', 'Web Developers Croatian', NULL, 0, 'i am developer', NULL),
(3, 'EPR3', 'HTML', NULL, NULL, NULL, NULL, 2, NULL, '2020-06-01 13:02:44'),
(4, 'EPR4', 'CSS', 'CSS', 'CSS', 'CSS', NULL, 2, NULL, NULL),
(5, 'EPR5', 'Web Designer', 'Web Designer', 'Web Designer', 'Web Designer', NULL, 0, NULL, NULL),
(6, 'EPR6', 'CSS3', 'CSS3', 'CSS3', 'CSS3', NULL, 5, NULL, NULL),
(7, 'EPR7', 'Coding', NULL, NULL, NULL, NULL, 3, NULL, '2020-06-01 13:02:44'),
(8, 'EPR8', 'Debuging', NULL, NULL, NULL, NULL, 3, NULL, '2020-06-01 13:02:44'),
(9, 'EPR9', 'CCD', NULL, NULL, NULL, NULL, 7, NULL, '2020-06-05 17:24:49'),
(10, 'EPR10', 'PPD', NULL, NULL, NULL, NULL, 8, NULL, '2020-06-05 17:24:59'),
(11, 'EPR11', 'V2.1', 'V2.1', 'V2.1', 'V2.1', NULL, 4, NULL, NULL),
(12, 'EPR12', 'sadsadasd', NULL, NULL, NULL, NULL, 7, NULL, '2020-06-05 17:25:05'),
(13, 'EPR13', 'Job', 'Job', 'Job', 'Job', NULL, 10, NULL, '2020-06-05 17:24:59'),
(14, 'EPR14', 'New', NULL, NULL, NULL, NULL, 0, NULL, '2020-06-01 13:02:40'),
(15, 'EPR15', 'New1', NULL, NULL, NULL, NULL, 14, NULL, '2020-06-01 13:02:40'),
(16, 'EPR16', 'New11', 'NewSpa', 'NewGER', 'NewCro', NULL, 15, 'new', '2020-06-01 12:51:41'),
(17, 'EPR17', 'test', 'tes1', 'test2', 'test3', NULL, 7, 'test the data', '2020-06-01 12:39:26'),
(18, 'EPR18', 'test2222', 'test22222', 'test22222', 'test32222', NULL, 0, 'test the record in tableeeeeeeee', '2020-06-04 14:30:37'),
(19, 'EPR19', 'Also', 'también', 'Ebenfalls', 'Takođerrrrrr', NULL, 0, 'dsjsfkhfksfhshfsdfl', NULL),
(20, 'EPR20', 'Alsoo', 'también', 'Ebenfalls', 'Također', NULL, 2, 'tets the data', NULL),
(21, 'EPR21', 'Secondary education program', 'Secondary education program', 'Secondary education program', 'Secondary education program', NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employeedesignations`
--

CREATE TABLE `employeedesignations` (
  `pkEde` int(11) NOT NULL,
  `ede_EmployeeDesignationName_en` varchar(255) DEFAULT NULL,
  `ede_EmployeeDesignationName_sp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ede_EmployeeDesignationName_de` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ede_EmployeeDesignationName_hr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ede_Notes` text,
  `ede_Status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employeedesignations`
--

INSERT INTO `employeedesignations` (`pkEde`, `ede_EmployeeDesignationName_en`, `ede_EmployeeDesignationName_sp`, `ede_EmployeeDesignationName_de`, `ede_EmployeeDesignationName_hr`, `ede_Notes`, `ede_Status`, `deleted_at`) VALUES
(1, 'Professor', 'Profesor', 'Professor', 'Profesor', NULL, 'Active', NULL),
(2, 'Teacher', 'Profesor', 'Lehrer', 'Učitelj', NULL, 'Active', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `fkEmpMun` int(11) DEFAULT NULL,
  `fkEmpPof` int(11) DEFAULT NULL,
  `fkEmpCny` int(11) DEFAULT NULL,
  `fkEmpNat` int(11) DEFAULT NULL,
  `fkEmpRel` int(11) DEFAULT NULL,
  `fkEmpCtz` int(11) DEFAULT NULL,
  `emp_EmployeeID` varchar(13) DEFAULT NULL,
  `emp_EmployeeName` varchar(200) DEFAULT NULL,
  `emp_TempCitizenId` varchar(100) DEFAULT NULL,
  `emp_DateOfBirth` datetime DEFAULT NULL,
  `emp_PlaceOfBirth` varchar(255) DEFAULT NULL,
  `emp_EmployeeGender` enum('Male','Female') DEFAULT NULL,
  `emp_Address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verification_key` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `emp_PhoneNumber` varchar(255) DEFAULT NULL,
  `emp_MobilePhoneNumber` varchar(255) DEFAULT NULL,
  `emp_PicturePath` varchar(255) DEFAULT NULL,
  `emp_Notes` text,
  `emp_Status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `fkEmpMun`, `fkEmpPof`, `fkEmpCny`, `fkEmpNat`, `fkEmpRel`, `fkEmpCtz`, `emp_EmployeeID`, `emp_EmployeeName`, `emp_TempCitizenId`, `emp_DateOfBirth`, `emp_PlaceOfBirth`, `emp_EmployeeGender`, `emp_Address`, `email`, `email_verification_key`, `email_verified_at`, `password`, `remember_token`, `emp_PhoneNumber`, `emp_MobilePhoneNumber`, `emp_PicturePath`, `emp_Notes`, `emp_Status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 1, 7, 1, 2, 3, 'YYIU786755', 'jimmy shery', 'BFLIH896675', '1994-07-12 12:00:00', 'Petersberg', 'Male', 'Lorem ipsum street', 'shery786@mailinator.com', NULL, '2020-06-11 09:39:25', '$2y$10$HiZzAQ705RNe6N01g4ErTuKAQHzoDKPoTen/4oPNiD8Fz4xvOm4uC', NULL, '84468464848', NULL, '1592544815.jpeg', 'we', 'Inactive', NULL, NULL, NULL),
(2, 1, 2, 1, 1, 2, 2, 'YYIU786756', 'Emma thomas', 'BFLIH896676', '1990-08-13 12:00:00', 'Delhi', 'Male', '14, Golf course', 'emma786@mailinator.com', '7347d0c87bd70d0a72a08148183aef7f', NULL, NULL, NULL, '68468486489', NULL, '1592378199.jpeg', NULL, 'Inactive', NULL, NULL, NULL),
(3, 1, 1, 1, 1, 1, 3, 'KATII876', 'Katie holmes', NULL, '1970-01-01 12:00:00', 'Delhi', 'Female', NULL, 'HeonicSC@mailinator.com', '0ae9e28377c1db63d897c01730567345', NULL, '$2y$10$Vt3iSOOri3USuTwvboc9eOdRYxOosjuDE14PiZhsvv57JdeT8ZQP2', NULL, '1212121212', NULL, NULL, NULL, 'Active', NULL, NULL, NULL),
(4, 1, 2, 1, 1, 1, 3, 'THOM67J', 'thomas Jones', 'THOM67JO', '1970-01-01 12:00:00', 'Delhi', 'Male', NULL, 'thomsa786@mailinator.com', '2ac705086ec2561b460f2f186d5aba03', NULL, NULL, NULL, '2323443434', NULL, NULL, NULL, 'Active', NULL, NULL, NULL),
(5, 2, 2, 7, 2, 2, 3, 'UIUT9786656', 'Jamie', 'RTE9787656OIN', '1984-12-19 12:00:00', 'ohio', 'Male', NULL, 'abc456@mailinator.com', 'c5691574a768161c7dbacbf4271528bd', NULL, NULL, NULL, '84868484878', NULL, NULL, NULL, 'Active', NULL, NULL, NULL),
(6, 1, 4, 1, 1, 1, 2, 'ENP ID', 'Vishal Chaudhari', 'TEMP CITY ID', '2020-07-06 12:00:00', 'Dharangaon', 'Male', 'Delaware USA', 'vishsh116@mailinator.com', NULL, '2020-07-09 14:03:16', '$2y$10$hwc9KrdX938HgCruFWkHLOIVNqbgFPIrnzPtLHQt1nZBsN3f1kKKe', NULL, '80544546542', NULL, '1595915089.png', 'test the dsjkh', 'Active', NULL, NULL, NULL),
(14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'kenny', NULL, NULL, NULL, NULL, NULL, 'jenny786@mailinator.com', '1b0b32dedcbd5f53532128ccaae0b138', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL),
(18, 2, 1, 5, 2, 1, 2, 'Berta123', 'Berta', NULL, '1970-01-01 12:00:00', 'Delhi', 'Male', 'JJ MM YY', 'bert786@mailinator.com', 'e5b9a3dbd28fdc5e876aa3adbe7a7a1a', NULL, NULL, NULL, '1234561234', NULL, NULL, 'test', 'Active', NULL, NULL, NULL),
(19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vishal new', NULL, NULL, NULL, NULL, NULL, 'vishal@mailinator.com', '6575d4ca13645ab2792850dac9fb1548', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL),
(23, NULL, NULL, 2, NULL, NULL, NULL, 'BFEEF332', 'Gerard Butler', NULL, '1994-07-12 12:00:00', 'Petersberg', 'Male', 'Lorem ipsum street', 'ghawk786@mailinator.com', 'cb6e43ba021f4df5eb4a3fd2d6408afd', NULL, '$2y$10$evCHaMMoVVJGZOCGXg.67uQWhWnr6d.tkW6pN9oSubIbqPDFFd8pu', NULL, '9846864646', NULL, '1593062067.jpg', 'dfg', 'Active', NULL, NULL, NULL),
(26, NULL, NULL, 5, NULL, NULL, NULL, 'POJGY75655', 'Sean Connor', NULL, '1990-08-23 12:00:00', 'Petersberg', 'Male', 'Lorem ipsum street', 'ShoolSubAdmin@mailinator.com', NULL, '2020-06-26 11:39:36', '$2y$10$Vt3iSOOri3USuTwvboc9eOdRYxOosjuDE14PiZhsvv57JdeT8ZQP2', NULL, '464648646848', NULL, '1593157111.jpg', 'df', 'Active', NULL, NULL, NULL),
(29, 3, 2, 7, 2, 2, 3, 'OIYF87575', 'berry allen', NULL, '2003-05-13 12:00:00', 'Florida', 'Female', 'Lorem ipsum street', 'HertronicTeacher@mailinator.com', '5b75ccc7b4f8e59f901beaff5a9f2d06', '2020-07-22 22:16:51', '$2y$10$Vt3iSOOri3USuTwvboc9eOdRYxOosjuDE14PiZhsvv57JdeT8ZQP2', NULL, '6848446464', NULL, '1593590239.png', 'sdf', 'Active', NULL, NULL, NULL),
(30, NULL, NULL, 1, NULL, NULL, NULL, 'SUBADMIN121', 'Nikhil', 'INDIA121', '1992-04-27 12:00:00', 'Dharangaon', 'Male', 'Navegaon Near Teli Talav', 'vishalnewsubadmin@mailinator.com', '7a1bf3a0430f3158b4ec87ee67f59fe8', NULL, NULL, NULL, '8489797979787', NULL, '1593528708.pdf', 'Checking this record', 'Inactive', NULL, NULL, NULL),
(31, NULL, NULL, 1, NULL, NULL, NULL, 'Vishl12212', 'Vishalcheck', 'Vishal14121', '2020-06-18 12:00:00', 'Dharangaon', 'Male', 'Maharashtra', 'vishal@technource.in', '4be4e42453873bdc5196ceb56e1d31d6', NULL, NULL, NULL, '10652313132', NULL, NULL, 'Checking the record in the table', 'Active', NULL, NULL, '2020-06-30 18:50:29'),
(32, NULL, NULL, 1, NULL, NULL, NULL, 'ds2d132', 'check', '23131cc31s', '2020-06-24 12:00:00', 'ksdfsjflkfhslhg', 'Male', 'Maharashtra', 'newbuyervishal@mailinator.com', 'acbc9575bd965e1cc42ed17a2b747bce', NULL, NULL, NULL, '8453213213', NULL, NULL, 'checking the records', 'Active', NULL, NULL, NULL),
(33, 3, 4, 7, 2, 2, 3, 'KHVIU7875', 'Christy marks', NULL, '1996-03-15 12:00:00', 'kansas', 'Female', 'Lorem ipsum street', 'christymarks786@mailinator.com', 'cc7e598bffff913456208af417dd8de7', '2020-07-15 23:42:29', '$2y$10$h7YOLYtz908im66Wxq8gd.Hm3GyE2wsvnqacDJ7s7XM4tGqGAE/ya', NULL, '68464849434', NULL, '1593672899.png', 'test note', 'Active', NULL, NULL, NULL),
(34, 1, 3, 2, 2, 2, 3, 'BIUE75758', 'Selena kyle', NULL, '1993-12-23 12:00:00', 'kansas', 'Female', 'Lorem ipsum street', 'skyle786@mailinator.com', NULL, '2020-07-03 10:11:45', '$2y$10$RKieZoGxDdFtqPBJxsINiOv37H9QRIu.udQhY/.zQNmzpmgOKj.jm', NULL, '98484846848', NULL, '1593674376.jpg', 'test note', 'Active', NULL, NULL, NULL),
(35, 1, 1, 1, 1, 1, 2, 'TEACHER121', 'EEEEEEEEE', 'Vishal141', '2020-07-01 12:00:00', 'Dharangaon', 'Male', 'ahmedabad', 'teacher@mailinator.com', NULL, '2020-07-17 15:03:05', '$2y$10$GMt66n8KfA9YFNg45VDHIedh5cG3ZpUGsxMQarF6WjUYT7BWlnnnC', NULL, '842313212312', NULL, '1595227237.png', 'tfty', 'Active', NULL, NULL, NULL),
(36, 3, 4, 1, 1, 3, 2, 'VishEmp001', 'VishalNewEMPppp', 'TEMP IDDD', '2020-07-09 12:00:00', 'Dharangaonnn', 'Male', 'Dharangaon, Maharashtraaa', 'vishalemp@mailinator.com', NULL, '2020-07-10 12:31:19', '$2y$10$CY8gvarejmE1tH6oXt..XuqSwrvry3SYqlL30TBrfx7MtZohayshW', NULL, '8887878788', NULL, '1594814897.pdf', 'Checing thecode', 'Active', NULL, NULL, NULL),
(37, NULL, NULL, 1, NULL, NULL, NULL, 'VishSubAdmin', 'VishalSubAdmin', 'SubAdmin', '2020-07-14 12:00:00', 'Dharangaonn', 'Male', 'Dharangaon Jalgaonn', 'vishalsubadmin@mailinator.com', '4d43f372836a0fd793f173e813c4737a', NULL, NULL, NULL, '84132131323', NULL, '1594813340.jpg', 'Checking the resultttt', 'Active', NULL, NULL, '2020-07-16 13:06:12'),
(38, 2, 4, 5, 2, 2, 3, 'SDKU6846468', 'adam sandlar', NULL, '2002-03-27 12:00:00', 'Petersberg', 'Male', 'Lorem ipsum street', 'adam786@mailinator.com', '13096afd173261fb91df15ff1f36879d', NULL, NULL, NULL, '8499994949', NULL, NULL, 'sdfsdf', 'Inactive', NULL, NULL, NULL),
(39, 1, 2, 2, 1, 1, 3, 'Ravish123', 'Ravish', NULL, '1970-01-01 12:00:00', 'Delhi', 'Male', NULL, 'Ravish@gmial.com', 'aa87b696414e71946d73c154879b6d8b', NULL, NULL, NULL, '8967452345', NULL, '1594797595.jpg', NULL, 'Active', NULL, NULL, NULL),
(40, 3, 4, 2, 1, 1, 2, 'EMP1212', 'VishalNewTeacher', 'CITIZENIDD', '2020-07-14 12:00:00', 'Dharangaonnn', 'Male', 'Dharangaon, Maharashtra, India', 'vishteacher@mailinator.com', NULL, '2020-07-21 13:48:05', '$2y$10$ygt2fCCDu1Npk5ArBJZ6UeBU8hYp.9aJOLV2h28LHcJPTgTXOezye', NULL, '8745132132', NULL, '1595595402.png', 'Checking the record in the tableeeee', 'Active', NULL, NULL, NULL),
(41, 1, 4, 1, 1, 1, 2, 'VISHPRINCIPAL', 'VishalPrincipal', 'TEMPCITY', '2020-07-06 12:00:00', 'Bhusawal, Maharashtra', 'Male', NULL, 'vishalprincipal@mailinator.com', 'b2a64e755f8df77d747c0254cfe3d196', NULL, NULL, NULL, '56321332164', NULL, '1594977110.png', 'cheking the principal', 'Inactive', NULL, NULL, NULL),
(42, 3, 1, 4, 1, 1, 3, '641532154', 'Vishemp', '461321348466', '2020-07-09 12:00:00', 'Bhusawal, Maharashtra', 'Female', 'ahmedabad', 'vishemp@mailinator.com', '6b5e6fda1312e54424a249c6f87d9347', NULL, NULL, NULL, '845613214613', NULL, NULL, 'jkdfnjkd', 'Active', NULL, NULL, NULL),
(43, NULL, NULL, 1, NULL, NULL, NULL, 'VishalEmpId', 'VishalAdminStaff', NULL, '1970-01-01 12:00:00', 'Dharangaonn', 'Male', 'Pastaneee, Maharashtra', 'vishaladminstaff@mailinator.com', 'ee996b5a7738e00cc223824831c7ecaf', NULL, NULL, NULL, '74561321321', NULL, '1595322827.png', 'checking the result for the testing.', 'Active', NULL, NULL, NULL),
(44, NULL, NULL, 2, NULL, NULL, NULL, '9999999999999', 'Testing999', NULL, '2020-07-14 12:00:00', 'Delhi', 'Male', 'kk colony', '99999@gmail.com', '1ba9a0aa8425d0ba8710ed7fb29570c0', NULL, NULL, NULL, '08949452149', NULL, NULL, NULL, 'Active', NULL, NULL, NULL),
(45, NULL, NULL, 2, NULL, NULL, NULL, 'Jong2345', 'Kim', NULL, '2020-07-28 12:00:00', 'USAjjj', 'Male', 'jj kk mm', 'Jong@gmail.vom', '8f509857abbe80145557599adc2cc991', NULL, NULL, NULL, '23445788997', NULL, NULL, 'test', 'Active', NULL, NULL, NULL),
(46, NULL, NULL, 1, NULL, NULL, NULL, 'roky1237623', 'Kimaa', NULL, '2020-07-15 12:00:00', 'Delhi', 'Male', 'mm kk jj', 'kimaa@gmail.com', '9e7a3d9905e941e8e49a185e9ed7a4dd', NULL, NULL, NULL, '0894945213', NULL, NULL, NULL, 'Active', NULL, NULL, NULL),
(47, 1, 1, 1, 1, 1, 2, 'EMPTemp1212', 'VishalNewEmp1', '7846645132', '2020-07-07 12:00:00', 'Bhusawal, Maharashtraa', 'Female', 'Jalgaoonn', 'vishalemp1@mailinator.com', '964b499d8d9f2f0f1f69f230754d853b', NULL, NULL, NULL, '89746132846', NULL, '1595398271.png', 'checking the result', 'Active', NULL, NULL, NULL),
(48, NULL, NULL, 4, NULL, NULL, NULL, 'STAFF101', 'VishalAdmins', 'STAFFTEMP121', '2020-07-11 12:00:00', 'Bhusawal, Maharashtra', 'Male', 'ahmedabad', 'vishadminst@mailinator.com', '84efc8f6163f4d7055fc57f3458fccfe', NULL, NULL, NULL, '51322132264', NULL, '1595398969.png', 'checking the result for the testing.', 'Active', NULL, NULL, NULL),
(49, NULL, NULL, 1, NULL, NULL, NULL, 'SUB147', 'VishalSub', 'Sub1478', '2020-07-22 12:00:00', 'Dharangaonnnn', 'Male', 'Pastaneee, Maharashtra', 'vishalsub@mailinator.com', '2b0101f36b15696aefd89702d6342478', NULL, NULL, NULL, '846513213216', NULL, '1595404531.png', 'cheking the principal', 'Active', NULL, NULL, NULL),
(50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'testtest', NULL, NULL, NULL, NULL, NULL, 'testtest@test.com', '161a8549be475af868391dcb35c72765', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL),
(51, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fsagfsdhdfgjhdfh', NULL, NULL, NULL, NULL, NULL, 'davor.simic2@gmail.com', 'ceca4903639750e7eb7dc3c719f60a8c', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL),
(52, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'dthdghsdgdhfh', NULL, NULL, NULL, NULL, NULL, 'ghdfhd@fjfjh.vgj', 'e14c2b500a23f9080127000d4b05a967', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL),
(53, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'zaefgsdfgsdfhs', NULL, NULL, NULL, NULL, NULL, 'dsfghsdhgf@ghsdfhfg.chgf', '088d512d83cec7903d94b999d5886dea', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL),
(54, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sdfggxfghfd', NULL, NULL, NULL, NULL, NULL, 'fghdghdfg@fghdf', 'a87ae2379886337552b12b452dc8fd5e', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL),
(55, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sejutgnjdcf', NULL, NULL, NULL, NULL, NULL, 'dghdfgh@gfhsfh', '1c13e8a9277c0b084de11e54927a7248', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL),
(56, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'dfhxfgjcbfg', NULL, NULL, NULL, NULL, NULL, 'fghdsfgjhdgj@dfghs', '4d8ff405a69aa470f82fa80b40257077', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL),
(57, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sdyrtfasdf', NULL, NULL, NULL, NULL, NULL, 'hedgdfg@dxygdf', '58ed09c2fd4e12c51b052ca9eddf787f', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL),
(58, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'cfgydsfgas', NULL, NULL, NULL, NULL, NULL, 'sdfgsd@dfghsdfghfshjjk', '247346c543f204f7ac6887c0939e0168', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL),
(59, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'cxfgdsyfgsdfgsd', NULL, NULL, NULL, NULL, NULL, 'xcghsdfg@sfg', 'd1eaa402b57db1c2c5a45f62133344f1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL),
(60, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'cfbcghdfh', NULL, NULL, NULL, NULL, NULL, 'dfhsfdg@dghdsh', '14fc3b93b0525dd4dcee04fa2bfb55a4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL),
(61, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fghdzae', NULL, NULL, NULL, NULL, NULL, 'ertdszr@cfhdr', '620b755f7ece2ff60c81518b070e171f', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL),
(62, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fgxhsydfgas', NULL, NULL, NULL, NULL, NULL, 'fghedg@dxfgsd', 'cd9f055fb92075177a0befa04397a79d', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL),
(63, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'aserfasgsfdh', NULL, NULL, NULL, NULL, NULL, 'fxthdf@xdfhsf', 'e4c902fe0915ad24a55792e8a219a23e', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL),
(64, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'cfgysdgfsd', NULL, NULL, NULL, NULL, NULL, 'dghdfhg@fxdhsf', '92b8c78e45134b0e2986f75922850389', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL),
(65, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'drtgsadfgass', NULL, NULL, NULL, NULL, NULL, 'dfghsfjggjd@ydfgdas', '8cabf9040f37f59b64c27d38afcebdbb', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employeeseducationdetails`
--

CREATE TABLE `employeeseducationdetails` (
  `pkEed` int(11) NOT NULL,
  `fkEedEmp` int(11) DEFAULT NULL,
  `fkEedCol` int(11) DEFAULT NULL,
  `fkEedUni` int(11) DEFAULT NULL,
  `fkEedAcd` int(11) DEFAULT NULL,
  `fkEedQde` int(11) DEFAULT NULL,
  `fkEedEde` int(11) DEFAULT NULL,
  `eed_Notes` text,
  `eed_ShortTitle` varchar(255) DEFAULT NULL,
  `eed_SemesterNumbers` tinyint(5) DEFAULT NULL,
  `eed_EctsPoints` int(11) DEFAULT NULL,
  `eed_YearsOfPassing` varchar(50) DEFAULT NULL,
  `eed_PicturePath` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employeeseducationdetails`
--

INSERT INTO `employeeseducationdetails` (`pkEed`, `fkEedEmp`, `fkEedCol`, `fkEedUni`, `fkEedAcd`, `fkEedQde`, `fkEedEde`, `eed_Notes`, `eed_ShortTitle`, `eed_SemesterNumbers`, `eed_EctsPoints`, `eed_YearsOfPassing`, `eed_PicturePath`, `deleted_at`) VALUES
(1, 1, 4, 1, 2, 2, 1, NULL, 'Pr', 6, 344, '2014', '15923139021.pdf', '2020-06-17 12:03:39'),
(2, 1, 4, 1, 3, 1, 2, NULL, 'Er', 8, 234, '2019', '15923139022.pdf', '2020-06-17 12:03:39'),
(3, 1, 4, 1, 2, 2, 1, 'detail 1', 'Pr', 6, 344, '2014', '15923139021.pdf', '2020-06-17 12:04:00'),
(4, 1, 4, 1, 3, 1, 2, 'detail 2', 'Er', 8, 234, '2019', '15923810192.pdf', '2020-06-17 12:04:00'),
(5, 1, 4, 1, 2, 2, 1, 'detail 1', 'Pr', 6, 344, '2014', '15923139021.pdf', '2020-06-17 12:53:52'),
(6, 1, 4, 1, 3, 1, 2, 'detail 2', 'Er', 8, 234, '2019', '15923810192.pdf', '2020-06-17 12:53:52'),
(7, 1, 4, 1, 2, 2, 1, 'detail 1', 'Pr', 6, 344, '2014', '15923139021.pdf', '2020-06-17 12:54:50'),
(8, 1, 4, 1, 3, 1, 2, 'detail 2', 'Er', 8, 234, '2019', '15923810192.pdf', '2020-06-17 12:54:50'),
(9, 1, 5, 3, 2, 3, 2, 'detail 3', 'Pr', 4, 244, '1994', '15923840323.pdf', '2020-06-17 12:54:50'),
(10, 1, 4, 1, 2, 2, 1, 'detail 1', 'Pr', 6, 344, '2014', '15923139021.pdf', '2020-06-17 13:00:45'),
(11, 1, 4, 1, 3, 1, 2, 'detail 2', 'Er', 8, 234, '2019', '15923810192.pdf', '2020-06-17 13:00:45'),
(12, 1, 5, 3, 2, 3, 2, 'detail 3', 'Pr', 4, 256, '1994', '15923840323.pdf', '2020-06-17 13:00:45'),
(13, 1, 4, 1, 2, 2, 1, 'detail 1', 'Pr', 6, 344, '2014', '15923139021.pdf', '2020-06-17 13:05:48'),
(14, 1, 4, 1, 3, 1, 2, 'detail 2', 'Er', 8, 234, '2013', '15923810192.pdf', '2020-06-17 13:05:48'),
(15, 1, 5, 3, 2, 3, 2, 'detail 3', 'Pr', 3, 256, '1993', '15923840323.pdf', '2020-06-17 13:05:48'),
(16, 1, 4, 1, 2, 2, 1, 'detail 1', 'Pr', 6, 344, '2014', '15923139021.pdf', '2020-06-17 13:07:27'),
(17, 1, 4, 1, 3, 1, 2, 'detail 2', 'Er', 8, 234, '2013', '15923810192.pdf', '2020-06-17 13:07:27'),
(18, 1, 5, 3, 2, 3, 2, 'detail 3', 'Pr', 3, 256, '1993', '15923840323.pdf', '2020-06-17 13:07:27'),
(19, 1, 4, 1, 2, 2, 1, 'detail 1', 'Pr', 6, 344, '2014', '15923139021.pdf', '2020-06-17 13:11:05'),
(20, 1, 4, 1, 3, 1, 2, 'detail 2', 'Er', 8, 234, '2013', '15923810192.pdf', '2020-06-17 13:11:05'),
(21, 1, 5, 3, 2, 3, 2, 'detail 3', 'Pr', 3, 256, '1993', '15923840323.pdf', '2020-06-17 13:11:05'),
(22, 1, 4, 1, 2, 2, 1, 'detail 1', 'Pr', 6, 344, '2014', '15923139021.pdf', '2020-06-17 13:12:43'),
(23, 1, 4, 1, 3, 1, 2, 'detail 2', 'Er', 8, 234, '2012', '15923810192.pdf', '2020-06-17 13:12:43'),
(24, 1, 5, 3, 2, 3, 2, 'detail 3', 'Pr', 3, 256, '1993', '15923840323.pdf', '2020-06-17 13:12:43'),
(25, 1, 4, 1, 2, 2, 1, 'detail 1', 'Pr', 6, 344, '2010', '15923139021.pdf', '2020-06-17 13:14:09'),
(26, 1, 4, 1, 3, 1, 2, 'detail 2', 'Er', 8, 234, '2012', '15923810192.pdf', '2020-06-17 13:14:09'),
(27, 1, 5, 3, 2, 3, 2, 'detail 3', 'Pr', 3, 256, '1993', '15923840323.pdf', '2020-06-17 13:14:09'),
(28, 1, 4, 1, 2, 2, 1, 'detail 1', 'Pr', 6, 344, '2010', '15923139021.pdf', '2020-06-17 13:24:17'),
(29, 1, 4, 1, 3, 1, 2, 'detail 2', 'Er', 8, 234, '2012', '15923810192.pdf', '2020-06-17 13:24:17'),
(30, 1, 5, 3, 2, 3, 2, 'detail 3', 'Pr', 3, 256, '1993', '15923840323.pdf', '2020-06-17 13:24:17'),
(31, 1, 4, 1, 2, 2, 1, 'detail 1', 'Pr', 6, 344, '2010', '15923139021.pdf', '2020-06-17 13:25:58'),
(32, 1, 4, 1, 3, 1, 2, 'detail 2', 'Er', 8, 234, '2012', '15923810192.pdf', '2020-06-17 13:25:58'),
(33, 1, 5, 3, 2, 3, 2, 'detail 3', 'Pr', 3, 256, '1993', '15923840323.pdf', '2020-06-17 13:25:58'),
(34, 1, 4, 1, 2, 2, 1, 'detail 1', 'Pr', 6, 344, '2010', '15923139021.pdf', '2020-06-19 09:13:19'),
(35, 1, 4, 1, 3, 1, 2, 'detail 2', 'Er', 8, 234, '2012', '15923810192.pdf', '2020-06-19 09:13:19'),
(36, 1, 5, 3, 2, 3, 2, 'detail 3', 'Pr', 3, 256, '1993', '15923840323.pdf', '2020-06-19 09:13:19'),
(37, 1, 4, 1, 3, 1, 2, 'detail 2', 'Er', 8, 234, '2012', '15923810192.pdf', '2020-06-19 14:52:05'),
(38, 1, 5, 3, 2, 3, 2, 'detail 3', 'Pr', 3, 256, '1993', '15923840323.pdf', '2020-06-19 14:52:05'),
(39, 5, 4, 1, 2, 1, 1, 'detail 1', 'Pr', 7, 34, '1965', '15925623441.pdf', '2020-06-19 14:26:30'),
(40, 5, 7, 5, 2, 2, 1, 'detail 2', 'Er', 8, 456, '1987', '15925623442.pdf', '2020-06-19 14:26:30'),
(41, 5, 7, 5, 2, 2, 1, 'detail 2', 'Er', 8, 456, '1987', '15925623442.pdf', NULL),
(42, 5, 5, 3, 2, 2, 1, 'detail 2', 'Er', 9, 455, '1992', '15925623902.pdf', NULL),
(43, 1, 4, 1, 3, 2, 2, 'detail 1', 'Pr', 7, 445, '2001', '15925639251.pdf', '2020-06-19 14:53:53'),
(44, 1, 4, 1, 3, 2, 2, 'detail 1', 'Pr', 7, 445, '2001', '15925640331.pdf', '2020-07-10 13:34:49'),
(45, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 10:57:46'),
(46, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 10:57:46'),
(47, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 10:59:38'),
(48, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 10:59:38'),
(49, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:04:40'),
(50, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:04:40'),
(51, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:05:45'),
(52, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:05:45'),
(53, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:08:00'),
(54, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:08:00'),
(55, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:08:22'),
(56, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:08:22'),
(57, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:10:01'),
(58, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:10:01'),
(59, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:10:44'),
(60, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:10:44'),
(61, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:12:53'),
(62, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:12:53'),
(63, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:13:17'),
(64, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:13:17'),
(65, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:13:41'),
(66, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:13:41'),
(67, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:15:17'),
(68, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:15:17'),
(69, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:16:45'),
(70, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:16:45'),
(71, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:20:44'),
(72, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:20:44'),
(73, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:22:06'),
(74, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:22:06'),
(75, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:25:12'),
(76, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:25:12'),
(77, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:25:51'),
(78, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:25:51'),
(79, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:27:14'),
(80, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:27:14'),
(81, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:27:50'),
(82, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:27:50'),
(83, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:30:29'),
(84, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:30:29'),
(85, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:31:58'),
(86, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:31:58'),
(87, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:33:11'),
(88, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:33:11'),
(89, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:34:02'),
(90, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:34:02'),
(91, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:34:15'),
(92, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:34:15'),
(93, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:35:14'),
(94, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:35:14'),
(95, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:39:17'),
(96, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:39:17'),
(97, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:41:12'),
(98, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:41:12'),
(99, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:41:35'),
(100, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:41:35'),
(101, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:41:49'),
(102, 29, 5, 3, 2, 4, 1, 'detail 1', 'sr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:42:02'),
(103, 29, 5, 3, 2, 4, 1, 'detail 1', 'sr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:44:08'),
(104, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:44:28'),
(105, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:44:28'),
(106, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:48:12'),
(107, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:48:12'),
(108, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:48:24'),
(109, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:48:24'),
(110, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:48:41'),
(111, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:48:41'),
(112, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:48:50'),
(113, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:48:50'),
(114, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:49:22'),
(115, 29, 4, 1, 2, 3, 1, 'detail 2', 'Er', 6, 444, '2006', '15931683052.pdf', '2020-07-01 11:49:22'),
(116, 29, 5, 3, 2, 4, 1, 'detail 1', 'Pr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:49:47'),
(117, 29, 5, 3, 2, 4, 1, 'detail 1', 'Sr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:49:56'),
(118, 29, 5, 3, 2, 4, 1, 'detail 1', 'Sr', 5, 343, '1992', '15931683051.pdf', '2020-07-01 11:50:33'),
(119, 29, 5, 3, 2, 4, 1, 'detail 1', 'Sr', 6, 343, '1992', '15931683051.pdf', '2020-07-01 11:53:30'),
(120, 29, 5, 3, 2, 4, 1, 'detail 1', 'Sr', 6, 343, '1992', '15931683051.pdf', '2020-07-01 11:57:19'),
(121, 29, 5, 3, 2, 4, 1, 'detail 1', 'Sr', 6, 343, '1992', '15931683051.pdf', '2020-07-01 13:53:40'),
(122, 29, 5, 3, 2, 4, 1, 'detail 1', 'Sr', 6, 343, '1992', '15931683051.pdf', '2020-07-06 10:49:42'),
(123, 33, 7, 5, 2, 5, 1, 'detail 1', 'Pr', 2, 433, '2020', '15936728581.pdf', '2020-07-02 10:54:59'),
(124, 33, 7, 5, 2, 5, 1, 'detail 1', 'Pr', 2, 433, '2020', '15936728581.pdf', NULL),
(125, 34, 5, 3, 2, 2, 1, 'detail 1', 'Pr', 4, 221, '2004', '15936743761.pdf', '2020-07-02 14:22:34'),
(126, 34, 5, 3, 2, 2, 1, 'detail 1', 'Pr', 4, 221, '2004', '15936743761.pdf', '2020-07-02 14:22:57'),
(127, 34, 5, 3, 2, 2, 1, 'detail 1', 'Pr', 4, 221, '2004', '15936743761.pdf', '2020-07-02 14:24:23'),
(128, 34, 5, 3, 2, 2, 1, 'detail 1', 'Pr', 4, 221, '2004', '15936743761.pdf', '2020-07-10 17:35:01'),
(129, 29, 5, 3, 2, 4, 1, 'detail 1', 'Sr', 6, 343, '1992', '15931683051.pdf', '2020-07-06 10:50:36'),
(130, 29, 5, 3, 2, 3, 1, 'detail 1', 'Sr', 6, 343, '1992', '15931683051.pdf', '2020-07-06 11:01:51'),
(131, 29, 5, 3, 2, 4, 1, 'detail 1', 'Sr', 6, 343, '1992', '15931683051.pdf', '2020-07-06 11:02:03'),
(132, 29, 5, 3, 2, 4, 1, 'detail 1', 'Sr', 6, 343, '1992', '15931683051.pdf', NULL),
(133, 6, 7, 5, 3, 3, 1, 'checking is the pop up', 'MCAA', 5, 541221, '2019', '15942905781.pdf', '2020-07-09 14:31:09'),
(134, 6, 4, 1, 3, 3, 1, 'checking is the pop up', 'MCAA', 5, 541221, '2019', '15942905781.pdf', '2020-07-10 10:49:32'),
(135, 35, 4, 1, 2, 1, 1, NULL, 'RES', 4, 455, '2020', '15942939981.pdf', '2020-07-17 15:39:18'),
(136, 6, 5, 3, 3, 2, 2, 'test rhe', 'MDA', 6, 450, '2014', '15943637711.pdf', '2020-07-17 14:16:57'),
(137, 36, 7, 5, 2, 4, 2, 'test rhe', 'MCAA', 8, 450, '2015', '15943664781.png', '2020-07-10 11:59:09'),
(138, 36, 7, 5, 2, 2, 2, 'test the', 'MDAA', 5, 5623, '2020', '15943679491.png', '2020-07-10 12:14:40'),
(139, 2, 4, 1, 2, 3, 2, 'test rhe', 'MDAA', 6, 455, '2020', '15943685421.png', '2020-07-10 12:09:29'),
(140, 2, 4, 1, 2, 3, 2, 'test rhe', 'MDAA', 6, 455, '2020', '15943685421.png', '2020-07-13 08:02:59'),
(141, 36, 7, 5, 2, 2, 2, 'test the', 'MDAA', 5, 5623, '2020', '15943679491.png', '2020-07-10 12:31:53'),
(142, 36, 7, 5, 2, 2, 2, 'test the', 'MDAA', 5, 5623, '2020', '15943679491.png', '2020-07-10 12:34:31'),
(143, 36, 7, 5, 2, 2, 2, 'test the', 'MDAA', 5, 5623, '2020', '15943679491.png', '2020-07-10 16:06:42'),
(144, 1, 4, 1, 3, 2, 2, 'detail 1', 'Pr', 7, 445, '2001', '15925640331.pdf', '2020-07-10 13:35:08'),
(145, 1, 4, 1, 3, 2, 2, 'detail 1', 'Pr', 7, 445, '2001', '15925640331.pdf', '2020-07-10 17:42:31'),
(146, 36, 7, 5, 2, 2, 2, 'test the', 'MDAA', 5, 5623, '2020', '15943679491.png', '2020-07-10 16:08:43'),
(147, 36, 7, 5, 2, 2, 2, 'test the', 'MDAA', 5, 5623, '2020', '15943679491.png', '2020-07-10 17:33:44'),
(148, 38, 4, 1, 3, 3, 1, 'df', 'ER', 5, 344, '2011', '15943835241.pdf', '2020-07-20 10:36:31'),
(149, 36, 7, 5, 2, 2, 2, 'test the', 'MDAA', 5, 5623, '2020', '15943679491.png', '2020-07-10 17:33:54'),
(150, 36, 7, 5, 2, 2, 2, 'test the', 'MDAA', 5, 5623, '2020', '15943679491.png', '2020-07-10 17:34:04'),
(151, 36, 7, 5, 2, 2, 2, 'test the', 'MDAA', 5, 5623, '2020', '15943679491.png', '2020-07-10 17:34:22'),
(152, 36, 7, 5, 2, 2, 2, 'test the', 'MDAA', 5, 5623, '2020', '15943679491.png', '2020-07-10 18:10:03'),
(153, 34, 5, 3, 2, 2, 1, 'detail 1', 'Pr', 4, 221, '2004', '15936743761.pdf', NULL),
(154, 1, 4, 1, 3, 2, 2, 'detail 1', 'Pr', 7, 445, '2001', '15925640331.pdf', '2020-07-17 12:05:24'),
(155, 36, 7, 5, 2, 2, 2, 'test the', 'MDAA', 5, 5623, '2020', '15943679491.png', '2020-07-15 16:04:10'),
(156, 2, 4, 1, 2, 3, 2, 'test rhe', 'MDAA', 6, 455, '2020', '15943685421.png', '2020-07-20 10:17:43'),
(157, 39, 4, 1, 2, 2, 1, NULL, 'Er', 12, 12, '2019', '15947975951.pdf', NULL),
(158, 18, 4, 1, 3, 2, 1, 'detail 2', 'Er', 12, 12, '2019', '15947979741.jpg', NULL),
(159, 36, 7, 5, 2, 2, 2, 'test the', 'MDAA', 5, 5623, '2020', '15943679491.png', '2020-07-15 16:08:17'),
(160, 36, 7, 5, 2, 2, 2, 'test the resultt', 'MDAA', 6, 5623, '2020', '15943679491.png', '2020-07-15 16:12:19'),
(161, 36, 7, 5, 2, 2, 2, 'test the resultt', 'MDAA', 6, 5623, '2020', '15943679491.png', NULL),
(162, 40, 7, 5, 2, 1, 2, 'Checking the rescords', 'MDAAA', 6, 25, '2019', '15948157951.pdf', NULL),
(163, 1, 4, 1, 3, 2, 2, 'detail 1', 'Pr', 7, 445, '2001', '15925640331.pdf', '2020-07-17 12:06:39'),
(164, 1, 4, 1, 3, 2, 2, 'detail 1', 'Pr', 7, 445, '2001', '15925640331.pdf', '2020-07-17 12:07:02'),
(165, 1, 4, 1, 3, 2, 2, 'detail 1', 'Pr', 7, 445, '2001', '15925640331.pdf', '2020-07-17 12:08:36'),
(166, 1, 4, 1, 3, 2, 2, 'detail 1', 'Pr', 7, 445, '2001', '15925640331.pdf', '2020-07-17 12:10:40'),
(167, 1, 4, 1, 3, 2, 2, 'detail 1', 'Pr', 7, 445, '2001', '15925640331.pdf', NULL),
(168, 41, 4, 1, 2, 1, 1, 'chcking the principal', 'MDD', 4, 25, '2019', '15949744241.png', '2020-07-17 13:11:50'),
(169, 41, 4, 1, 2, 1, 1, 'chcking the principal', 'MDD', 4, 25, '2019', '15949744241.png', '2020-07-17 13:15:38'),
(170, 41, 4, 1, 2, 1, 1, 'chcking the principal', 'MDD', 4, 25, '2019', '15949744241.png', '2020-07-17 13:16:56'),
(171, 41, 7, 5, 2, 1, 1, 'noyte', 'DRD', 6, 44, '2010', '15949773382.png', '2020-07-17 13:16:56'),
(172, 41, 4, 1, 2, 1, 1, 'chcking the principal', 'MDD', 4, 25, '2019', '15949744241.png', NULL),
(173, 41, 7, 5, 2, 1, 1, 'noyte', 'DRD', 6, 44, '2010', '15949773382.png', NULL),
(174, 6, 5, 3, 3, 2, 2, 'test rhe', 'MDA', 7, 450, '2014', '15943637711.pdf', '2020-07-17 15:36:38'),
(175, 6, 5, 3, 2, 3, 2, 'test rhe', 'MDA', 7, 450, '2014', '15943637711.pdf', '2020-07-17 15:36:54'),
(176, 6, 5, 3, 2, 3, 2, 'test rhe', 'MDA', 10, 450, '2014', '15943637711.pdf', '2020-07-17 15:38:27'),
(177, 6, 5, 3, 2, 3, 2, 'test rhe', 'MDA', 10, 450, '2014', '15943637711.pdf', NULL),
(178, 6, 4, 1, 2, 4, 1, NULL, 'MHS', 12, 2222, '2004', '15949859072.png', NULL),
(179, 35, 4, 1, 2, 1, 1, 'cheijnk', 'RES', 45, 8000, '2020', '15942939981.pdf', '2020-07-17 16:38:18'),
(180, 35, 4, 1, 2, 1, 1, 'cheijnk', 'RES', 45, 8000, '2020', '15942939981.pdf', '2020-07-20 10:40:37'),
(181, 2, 4, 1, 2, 3, 2, 'test rhe', 'MDAA', 6, 455, '2020', '15943685421.png', '2020-07-21 13:56:05'),
(182, 38, 4, 1, 3, 3, 1, 'df', 'ER', 5, 344, '2011', '15943835241.pdf', NULL),
(183, 35, 4, 1, 2, 1, 2, 'cheijnk', 'RES', 45, 8000, '2010', '15942939981.pdf', '2020-07-21 11:44:14'),
(184, 4, 4, 1, 2, 1, 1, NULL, 'Er', 12, 12, '2019', '15952481851.png', NULL),
(185, 3, 4, 1, 3, 1, 1, NULL, 'Er', 11, 22, '2019', '15952484191.png', NULL),
(186, 35, 4, 1, 2, 1, 2, 'cheijnk', 'RES', 45, 80000, '2010', '15942939981.pdf', NULL),
(187, 42, 4, 1, 2, 2, 2, NULL, 'MDA', 5, 6, '2020', '15953176271.pdf', NULL),
(188, 2, 4, 1, 2, 3, 2, 'test rhe', 'MDAA', 6, 455, '2020', '15943685421.png', NULL),
(189, 47, 4, 1, 2, 2, 1, 'chcking the principal', 'MDSA', 5, 5, '2019', '15953982711.pdf', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employeesengagement`
--

CREATE TABLE `employeesengagement` (
  `pkEen` int(11) NOT NULL,
  `fkEenSch` int(11) DEFAULT NULL,
  `fkEenEmp` int(11) DEFAULT NULL,
  `fkEenEty` int(11) DEFAULT NULL,
  `fkEenEpty` int(11) DEFAULT NULL,
  `een_Intern` enum('Yes','No') NOT NULL DEFAULT 'No',
  `een_DateOfEngagement` datetime DEFAULT NULL,
  `een_DateOfFinishEngagement` datetime DEFAULT NULL,
  `een_WeeklyHoursRate` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `een_Notes` text,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employeesengagement`
--

INSERT INTO `employeesengagement` (`pkEen`, `fkEenSch`, `fkEenEmp`, `fkEenEty`, `fkEenEpty`, `een_Intern`, `een_DateOfEngagement`, `een_DateOfFinishEngagement`, `een_WeeklyHoursRate`, `een_Notes`, `deleted_at`) VALUES
(1, 3, 1, 2, 2, 'No', '2020-06-09 12:00:00', NULL, '0', NULL, NULL),
(2, 4, 2, 1, 4, 'No', '2020-06-10 12:00:00', NULL, NULL, 'qqqdd', NULL),
(3, 5, 3, 1, 2, 'No', '2020-06-12 08:51:08', NULL, NULL, NULL, NULL),
(4, 6, 4, 1, NULL, 'No', '2020-06-15 12:00:00', NULL, NULL, NULL, NULL),
(5, 7, 5, 1, 2, 'No', '2020-06-15 10:12:41', NULL, NULL, NULL, NULL),
(6, 8, 6, 1, 2, 'No', '2020-06-16 14:31:29', NULL, NULL, NULL, NULL),
(7, 3, 2, 1, 4, 'No', '2020-06-10 12:00:00', NULL, '5.5', 'teacher', NULL),
(24, 3, 14, 1, 1, 'No', '2020-06-19 12:00:00', '2020-07-22 12:00:00', NULL, NULL, NULL),
(25, 3, 2, 1, 1, 'No', '2020-06-06 12:00:00', '2020-07-22 12:00:00', NULL, NULL, NULL),
(29, 3, 18, 1, 1, 'No', '2020-06-23 12:00:00', '2020-07-22 12:00:00', NULL, NULL, NULL),
(30, 8, 6, 1, 1, 'No', '1990-06-11 12:00:00', '2020-07-31 12:00:00', NULL, NULL, NULL),
(31, 8, 19, 1, 1, 'No', '2020-06-18 12:00:00', '2020-07-31 12:00:00', NULL, NULL, NULL),
(32, 8, 6, 1, 1, 'No', '2020-06-16 12:00:00', '2020-07-31 12:00:00', '5.5', 'checing thi field is working or not', NULL),
(35, 3, 23, 1, 3, 'No', '2020-06-25 12:00:00', '2020-07-22 12:00:00', NULL, NULL, NULL),
(38, 3, 26, 1, 3, 'No', '2020-06-20 12:00:00', '2020-07-30 12:00:00', NULL, NULL, NULL),
(41, 3, 29, 1, 4, 'No', '2000-03-15 12:00:00', NULL, '38', NULL, NULL),
(42, 8, 30, 1, 3, 'No', '2020-06-30 12:00:00', '2020-06-30 12:00:00', '56', NULL, NULL),
(43, 8, 31, 1, 3, 'No', '2020-06-15 12:00:00', '2020-06-22 12:00:00', NULL, NULL, '2020-06-30 18:50:29'),
(44, 8, 32, 1, 3, 'No', '2020-06-10 12:00:00', '2020-06-15 12:00:00', '505', NULL, NULL),
(45, 4, 33, 1, 4, 'No', '2020-07-01 12:00:00', NULL, '41', NULL, NULL),
(46, 4, 34, 2, 4, 'No', '2020-07-02 12:00:00', NULL, '33', NULL, NULL),
(49, 3, 1, 1, 1, 'No', '2020-07-09 12:00:00', '2020-07-22 12:00:00', '81', 'principal', NULL),
(48, 3, 29, 1, 1, 'No', '2020-07-03 12:00:00', '2020-07-22 12:00:00', '66', NULL, NULL),
(52, 3, 1, 2, 1, 'No', '2020-07-14 12:00:00', '2020-07-22 12:00:00', '39', NULL, NULL),
(53, 3, 29, 1, 1, 'No', '2020-07-30 12:00:00', '2020-07-22 12:00:00', '44', 'new principal', NULL),
(54, 8, 6, 2, 1, 'No', '2020-07-10 12:00:00', '2020-07-31 12:00:00', '6.5', 'part time checking', NULL),
(55, 8, 6, 2, 1, 'No', '2020-07-31 12:00:00', '2020-07-31 12:00:00', '4', 'part time checking', NULL),
(56, 8, 6, 1, 1, 'No', '2020-07-21 12:00:00', '2020-07-31 12:00:00', '4.8', NULL, NULL),
(57, 3, 2, 1, 1, 'No', '2020-07-09 12:00:00', '2020-07-22 12:00:00', '5', 'pricipal', NULL),
(58, 8, 35, 1, 4, 'No', '2020-06-17 12:00:00', '2020-07-17 12:00:00', '44', NULL, NULL),
(59, 8, 6, 1, 4, 'No', '2020-07-15 12:00:00', '2020-07-12 12:00:00', '4.8', 'part time checking', NULL),
(60, 3, 36, 1, 4, 'No', '1990-06-05 12:00:00', '2020-07-17 12:00:00', '99', 'Test', NULL),
(61, 3, 37, 1, 3, 'No', '2020-07-02 12:00:00', '2020-07-31 12:00:00', NULL, NULL, '2020-07-16 13:06:12'),
(62, 3, 36, 1, 1, 'No', '2020-07-22 12:00:00', '2020-07-22 12:00:00', '5.5', 'checking the date', NULL),
(63, 3, 36, 1, 1, 'No', '2020-07-14 12:00:00', '2020-07-22 12:00:00', '5.5', 'checking the resullttt', NULL),
(64, 3, 36, 2, 1, 'No', '2020-07-16 12:00:00', '2020-07-22 12:00:00', '58', 'checking the resilt', NULL),
(65, 3, 38, 2, 4, 'No', '2020-07-23 12:00:00', NULL, '21', 'teacher notes', NULL),
(66, 3, 1, 1, 1, 'No', '2020-07-24 12:00:00', '2020-07-22 12:00:00', '88', 'principal assign', NULL),
(67, 3, 1, 1, 1, 'No', '2020-07-18 12:00:00', '2020-07-22 12:00:00', '89', NULL, NULL),
(68, 3, 38, 1, 1, 'No', '2020-07-25 12:00:00', '2020-07-22 12:00:00', '14', 'note for principal', NULL),
(69, 3, 36, 1, 1, 'No', '2020-07-17 12:00:00', '2020-07-22 12:00:00', '355', 'note for principal', NULL),
(70, 3, 2, 1, 1, 'No', '2020-07-16 12:00:00', '2020-07-22 12:00:00', '44', NULL, NULL),
(71, 3, 39, 1, 1, 'No', '2020-06-05 12:00:00', '2020-07-22 12:00:00', '2', 'This', NULL),
(72, 8, 1, 1, 4, 'No', '2020-07-21 12:00:00', NULL, '44', NULL, NULL),
(73, 3, 40, 1, 4, 'No', '2020-07-16 12:00:00', '2020-07-21 12:00:00', '6.6', NULL, NULL),
(74, 8, 41, 1, 1, 'No', '2020-07-01 12:00:00', '2020-07-31 12:00:00', '10', 'chekcing the Princiaplll', NULL),
(75, 8, 40, 1, 1, 'No', '2020-07-17 12:00:00', '2020-07-31 12:00:00', '5.5', 'checkkking', NULL),
(76, 8, 40, 1, 1, 'No', '2020-07-21 12:00:00', '2020-07-31 12:00:00', '5.5', NULL, NULL),
(77, 8, 35, 1, 4, 'No', '2020-07-17 12:00:00', NULL, '125', NULL, NULL),
(78, 8, 38, 1, 4, 'No', '2020-07-21 12:00:00', NULL, '8.8', NULL, NULL),
(79, 8, 6, 1, 1, 'No', '2020-07-23 12:00:00', '2020-07-31 12:00:00', '555', NULL, NULL),
(80, 3, 1, 1, 1, 'No', '2020-07-23 12:00:00', '2020-07-22 12:00:00', '10', NULL, NULL),
(81, 3, 40, 1, 4, 'No', '2020-07-21 12:00:00', NULL, '7.7', NULL, NULL),
(82, 3, 3, 1, 4, 'No', '2020-07-28 12:00:00', NULL, '44', NULL, NULL),
(83, 8, 42, 1, 1, 'No', '2020-07-08 12:00:00', '2020-07-31 12:00:00', '5.5', 'kjdfhkhkg', NULL),
(84, 8, 42, 1, 1, 'No', '2020-07-21 12:00:00', '2020-07-31 12:00:00', '7.8', NULL, NULL),
(85, 8, 36, 1, 1, 'No', '2020-07-22 12:00:00', '2020-07-31 12:00:00', '7.6', NULL, NULL),
(86, 8, 40, 1, 1, 'No', '2020-07-24 12:00:00', '2020-07-31 12:00:00', '5.6', NULL, NULL),
(87, 8, 43, 1, 3, 'No', '1970-01-01 12:00:00', NULL, '5.55', NULL, NULL),
(88, 3, 44, 2, 3, 'No', '2020-07-31 12:00:00', '2020-07-31 12:00:00', '44', NULL, NULL),
(89, 3, 45, 1, 5, 'No', '2020-07-16 12:00:00', '2020-08-28 12:00:00', '44', 'test', NULL),
(90, 3, 23, 1, 1, 'No', '2020-07-22 12:00:00', '2020-07-23 12:00:00', '2', NULL, NULL),
(91, 3, 4, 1, 4, 'No', '2020-07-29 12:00:00', '2020-07-22 12:00:00', '44', NULL, NULL),
(92, 3, 46, 1, 5, 'No', '2020-07-23 12:00:00', '2020-07-24 12:00:00', '44', NULL, NULL),
(93, 8, 47, 1, 1, 'No', '2020-07-15 12:00:00', '2020-07-31 12:00:00', '5.55', 'checking the rsilttt', NULL),
(94, 8, 43, 1, 1, 'No', '2020-07-22 12:00:00', '2020-07-31 12:00:00', '7.88', 'cheomhthe entry in the Empployee', NULL),
(95, 8, 48, 1, 3, 'No', '2020-07-14 12:00:00', '2020-07-24 12:00:00', '22.22', 'checking the result.', NULL),
(96, 8, 39, 1, 1, 'No', '2020-07-22 12:00:00', '2020-07-31 12:00:00', '55', 'chekinh', NULL),
(97, 8, 36, 1, 1, 'No', '2020-07-23 12:00:00', '2020-07-31 12:00:00', '8.8', NULL, NULL),
(98, 8, 36, 1, 1, 'No', '2020-07-31 12:00:00', NULL, '99', NULL, NULL),
(99, 8, 49, 1, 3, 'No', '2020-07-09 12:00:00', '2020-07-14 12:00:00', '888', 'checking the rsilt', NULL),
(100, 9, 50, 1, 2, 'No', '2020-07-22 09:00:28', NULL, NULL, NULL, NULL),
(101, 10, 51, 1, 2, 'No', '2020-07-22 09:03:28', NULL, NULL, NULL, NULL),
(102, 11, 52, 1, 2, 'No', '2020-07-22 09:04:57', NULL, NULL, NULL, NULL),
(103, 12, 53, 1, 2, 'No', '2020-07-22 09:06:18', NULL, NULL, NULL, NULL),
(104, 13, 54, 1, 2, 'No', '2020-07-22 09:15:10', NULL, NULL, NULL, NULL),
(105, 14, 55, 1, 2, 'No', '2020-07-22 09:16:02', NULL, NULL, NULL, NULL),
(106, 15, 56, 1, 2, 'No', '2020-07-22 09:16:45', NULL, NULL, NULL, NULL),
(107, 16, 57, 1, 2, 'No', '2020-07-22 09:17:32', NULL, NULL, NULL, NULL),
(108, 17, 58, 1, 2, 'No', '2020-07-22 09:18:08', NULL, NULL, NULL, NULL),
(109, 18, 59, 1, 2, 'No', '2020-07-22 09:19:28', NULL, NULL, NULL, NULL),
(110, 19, 60, 1, 2, 'No', '2020-07-22 09:20:19', NULL, NULL, NULL, NULL),
(111, 20, 61, 1, 2, 'No', '2020-07-22 09:20:59', NULL, NULL, NULL, NULL),
(112, 21, 62, 1, 2, 'No', '2020-07-22 09:21:33', NULL, NULL, NULL, NULL),
(113, 22, 63, 1, 2, 'No', '2020-07-22 09:22:23', NULL, NULL, NULL, NULL),
(114, 23, 64, 1, 2, 'No', '2020-07-22 09:22:59', NULL, NULL, NULL, NULL),
(115, 24, 65, 1, 2, 'No', '2020-07-22 09:23:36', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employeetypes`
--

CREATE TABLE `employeetypes` (
  `pkEpty` int(11) NOT NULL,
  `epty_Name` enum('Teacher','Principal','SchoolCoordinator','SchoolSubAdmin') NOT NULL,
  `epty_ParentId` int(11) DEFAULT NULL,
  `epty_subCatName` varchar(255) DEFAULT NULL,
  `epty_Notes` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employeetypes`
--

INSERT INTO `employeetypes` (`pkEpty`, `epty_Name`, `epty_ParentId`, `epty_subCatName`, `epty_Notes`, `deleted_at`) VALUES
(1, 'Principal', NULL, NULL, NULL, NULL),
(2, 'SchoolCoordinator', NULL, NULL, NULL, NULL),
(3, 'SchoolSubAdmin', NULL, NULL, NULL, NULL),
(4, 'Teacher', NULL, NULL, NULL, NULL),
(5, 'SchoolSubAdmin', NULL, 'Clerk', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `engagementtypes`
--

CREATE TABLE `engagementtypes` (
  `pkEty` int(11) NOT NULL,
  `ety_EngagementTypeName_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ety_EngagementTypeName_sp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ety_EngagementTypeName_ba` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ety_EngagementTypeName_hr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ety_Notes` text,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `engagementtypes`
--

INSERT INTO `engagementtypes` (`pkEty`, `ety_EngagementTypeName_en`, `ety_EngagementTypeName_sp`, `ety_EngagementTypeName_ba`, `ety_EngagementTypeName_hr`, `ety_Notes`, `deleted_at`) VALUES
(1, 'Full Time', 'Tiempo completo', 'Vollzeit', 'Puno vrijeme', '', NULL),
(2, 'Part Time', 'Medio tiempo', 'Teilzeit', 'Honorarno', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `extracurricuralactivitytypes`
--

CREATE TABLE `extracurricuralactivitytypes` (
  `pkSat` int(11) UNSIGNED NOT NULL,
  `sat_Uid` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sat_StudentExtracurricuralActivityName_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sat_StudentExtracurricuralActivityName_sr` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sat_StudentExtracurricuralActivityName_ba` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sat_StudentExtracurricuralActivityName_hr` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sat_StudentExtracurricuralActivityName_Hn` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sat_Notes` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `extracurricuralactivitytypes`
--

INSERT INTO `extracurricuralactivitytypes` (`pkSat`, `sat_Uid`, `sat_StudentExtracurricuralActivityName_en`, `sat_StudentExtracurricuralActivityName_sr`, `sat_StudentExtracurricuralActivityName_ba`, `sat_StudentExtracurricuralActivityName_hr`, `sat_StudentExtracurricuralActivityName_Hn`, `sat_Notes`, `deleted_at`) VALUES
(2, 'SAT2', 'This dfg df gdf', '', '', '', NULL, 'is dfgdfgdf gdf', '2020-05-14 05:05:33'),
(3, 'SAT3', 'Sports Week', '', '', '', NULL, 'Participation', '2020-05-20 16:25:30'),
(4, 'SAT4', 'House Meeting', '', '', '', NULL, 'School divided into multi. parts gg', '2020-05-20 16:25:33'),
(5, 'ECA5', 'House Meeting', 'House Meeting sp', 'House Meeting de', 'House Meeting hr', NULL, 'sdsd', NULL),
(6, 'ECA6', 'Cypress', 'Ciprés', 'Zypresse', 'Čempres', NULL, 'tst thd data sdffsfdsfhfks', NULL),
(7, 'ECA7', 'dfh', 'ihf', 'hfdshk', 'hkflhk', NULL, 'fdhkl', '2020-06-04 11:07:48');

-- --------------------------------------------------------

--
-- Table structure for table `facultativecoursesgroups`
--

CREATE TABLE `facultativecoursesgroups` (
  `pkFcg` int(10) UNSIGNED NOT NULL,
  `fcg_Uid` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fcg_Name_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fcg_Name_sr` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fcg_Name_ba` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fcg_Name_hr` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fcg_Name_Hn` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fcg_Notes` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `facultativecoursesgroups`
--

INSERT INTO `facultativecoursesgroups` (`pkFcg`, `fcg_Uid`, `fcg_Name_en`, `fcg_Name_sr`, `fcg_Name_ba`, `fcg_Name_hr`, `fcg_Name_Hn`, `fcg_Notes`, `deleted_at`) VALUES
(1, 'FCG1', 'FCG_Trevor', '', '', '', NULL, 'SCIENCE FACa', '2020-06-05 13:07:03'),
(2, 'FCG2', 'FCG Faculty', 'Facultad FCG', 'FCG-Fakultät', 'FCG fakultet', NULL, 'Maths Fac', NULL),
(3, 'FCG3', 'Facultative Courses Groups - 2', 'Cursos Facultativos Grupos - 2', 'Fakultativkursgruppen - 2', 'Fakultativni tečajevi Grupe - 2', NULL, 'Test the dataaa', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `foreignlanguagegroups`
--

CREATE TABLE `foreignlanguagegroups` (
  `pkFon` int(10) UNSIGNED NOT NULL,
  `fon_Uid` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fon_Name_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fon_Name_sr` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fon_Name_ba` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fon_Name_hr` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fon_Name_Hn` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fon_Notes` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `foreignlanguagegroups`
--

INSERT INTO `foreignlanguagegroups` (`pkFon`, `fon_Uid`, `fon_Name_en`, `fon_Name_sr`, `fon_Name_ba`, `fon_Name_hr`, `fon_Name_Hn`, `fon_Notes`, `deleted_at`) VALUES
(1, 'FLG1', 'CHINESE', '', '', '', NULL, 'language will help you lot', '2020-05-19 15:39:02'),
(2, 'FLG2', 'Foreign Language Courses - 1', 'Cursos de idiomas extranjeros - 1', 'Fremdsprachenkurse - 1', 'Tečajevi stranih jezika - 1', NULL, 'ALL OVER WORLD WILL HELP YOU', NULL),
(3, 'FLG3', 'Foreign Language Courses - 2', 'Cursos de idiomas extranjeros - 2', 'Fremdsprachenkurse - 2', 'Tečajevi stranih jezika - 2', NULL, 'Help', NULL),
(4, 'FLG4', 'Foreign Language Courses - 3', 'Cursos de idiomas extranjeros - 3', 'Fremdsprachenkurse - 3', 'Tečajevi stranih jezika - 3', NULL, 'testjf', NULL),
(5, 'FLG5', 'ksdjEE', 'hjdgSS', 'GGggGGG', 'CCCCccccc', NULL, 'dfligil', '2020-06-05 13:01:38'),
(6, 'FLG6', 'Foreign Language Groups - 4', 'Grupos de idiomas extranjeros - 4', 'Fremdsprachengruppen - 4', 'Grupe stranih jezika - 4', NULL, 'Test the jkf', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `generalpurposegroups`
--

CREATE TABLE `generalpurposegroups` (
  `pkGpg` int(10) UNSIGNED NOT NULL,
  `gpg_Uid` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gpg_Name_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gpg_Name_sr` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gpg_Name_ba` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gpg_Name_hr` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gpg_Name_Hn` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gpg_Notes` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `generalpurposegroups`
--

INSERT INTO `generalpurposegroups` (`pkGpg`, `gpg_Uid`, `gpg_Name_en`, `gpg_Name_sr`, `gpg_Name_ba`, `gpg_Name_hr`, `gpg_Name_Hn`, `gpg_Notes`, `deleted_at`) VALUES
(1, 'GPG1', 'GPG_name', '', '', '', NULL, 'DEsc', '2020-06-05 13:07:34'),
(2, 'GPG2', 'GPG_Test', '', '', '', NULL, 'TEST', '2020-06-05 13:10:21'),
(3, 'GPG3', 'General Purpose Group 1', 'Propósito general Grupo 1', 'Allzweckgruppe 1', 'Grupa 1 opće namjene', NULL, 'chek', NULL),
(4, 'GPG4', 'General Purpose Groups - 2', 'Grupos de uso general - 2', 'Allzweckgruppen - 2', 'Grupe opće namjene - 2', NULL, 'Test the data', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `pkGra` int(11) NOT NULL,
  `gra_Uid` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `gra_GradeName_en` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gra_GradeName_sr` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gra_GradeName_ba` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gra_GradeName_hr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gra_GradeName_Hn` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gra_GradeNameRoman` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `gra_Notes` text CHARACTER SET latin1,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`pkGra`, `gra_Uid`, `gra_GradeName_en`, `gra_GradeName_sr`, `gra_GradeName_ba`, `gra_GradeName_hr`, `gra_GradeName_Hn`, `gra_GradeNameRoman`, `gra_Notes`, `deleted_at`) VALUES
(1, 'GRD1', '1', 'r', 'p', 't', NULL, 'I', 'note for 1', NULL),
(2, 'GRD2', 'GradesssE', 'GradesS', 'GradesG', 'GradesC', NULL, 'III', 'test rhe dsjkdfskfhj', '2020-06-03 13:23:18'),
(3, 'GRD3', '2', '2', '2', '2', NULL, 'II', 'Testen Sie die Daten', NULL),
(4, 'GRD4', '3', '3', '3', '3', NULL, 'III', 'ddf', NULL),
(5, 'GRD5', '4', '4', '4', '4', NULL, 'IV', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `homeroomteacher`
--

CREATE TABLE `homeroomteacher` (
  `pkHrt` int(11) NOT NULL,
  `fkHrtEmp` int(11) DEFAULT NULL,
  `fkHrtClr` int(11) DEFAULT NULL,
  `fkHrtEty` int(11) DEFAULT NULL,
  `hrt_WeeklyHoursRate` varchar(50) DEFAULT NULL,
  `hrt_DateOfEngagement` datetime DEFAULT NULL,
  `hrt_DateOfFinishEngagement` datetime DEFAULT NULL,
  `hrt_Notes` text,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `homeroomteacher`
--

INSERT INTO `homeroomteacher` (`pkHrt`, `fkHrtEmp`, `fkHrtClr`, `fkHrtEty`, `hrt_WeeklyHoursRate`, `hrt_DateOfEngagement`, `hrt_DateOfFinishEngagement`, `hrt_Notes`, `deleted_at`) VALUES
(1, 2, 6, 2, '67', '2020-07-29 12:00:00', NULL, 'sdf wer ewr', NULL),
(2, 3, 3, 1, '222', '2020-07-28 12:00:00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobandwork`
--

CREATE TABLE `jobandwork` (
  `pkJaw` int(11) NOT NULL,
  `jaw_Uid` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `jaw_Name_en` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `jaw_Name_sr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jaw_Name_ba` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jaw_Name_hr` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `jaw_Name_Hn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jaw_Name_trr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jaw_Name_Te` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jaw_Name_tes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jaw_Notes` text CHARACTER SET latin1,
  `jaw_Status` enum('Active','Inactive') CHARACTER SET latin1 NOT NULL DEFAULT 'Active',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobandwork`
--

INSERT INTO `jobandwork` (`pkJaw`, `jaw_Uid`, `jaw_Name_en`, `jaw_Name_sr`, `jaw_Name_ba`, `jaw_Name_hr`, `jaw_Name_Hn`, `jaw_Name_trr`, `jaw_Name_Te`, `jaw_Name_tes`, `jaw_Notes`, `jaw_Status`, `deleted_at`) VALUES
(1, 'JOB1', 'Teacher', 'Profesor', 'Lehrer', 'Teachercccc', NULL, NULL, NULL, NULL, 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Cicero\'s De Finibus Bonorum et Malorum for use in a type specimen book. It usually begins with:  “Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.” The purpose of lorem ipsum is to create a natural looking block of text (sentence, paragraph, page, etc.) that doesn\'t distract from the layout. A practice not without controversy, laying out pages with meaningless filler text can be very useful when the focus is meant to be on design, not content.', 'Active', NULL),
(2, 'JOB2', 'Businessman', 'Businessman spanish', 'Businessman German', 'Businessman Croatian', NULL, NULL, NULL, NULL, 'sdf', 'Active', NULL),
(3, 'JOB3', 'Lecturer', 'Lecturer', 'Lecturer', 'Lecturer', NULL, NULL, NULL, NULL, 'dsfsdf', 'Active', NULL),
(4, 'JOB4', 'Hardik EN', 'Hardik Spa', 'Hardik Ger', 'Hardik c', NULL, NULL, NULL, NULL, 'My notes', 'Active', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `language_key` varchar(10) NOT NULL,
  `language_name` varchar(50) NOT NULL,
  `flag` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `language_key`, `language_name`, `flag`, `deleted_at`) VALUES
(1, 'en', 'English', '1589366213.png', NULL),
(2, 'sr', 'Serbian', '1589366704.png', NULL),
(15, 'ba', 'Bosnian', '1589795434.png', NULL),
(14, 'cr', 'Croatian', NULL, '2020-05-14 11:50:18'),
(16, 'hr', 'Croatian', '1589796165.png', NULL),
(22, 'tes', 'res', NULL, '2020-05-28 16:51:49'),
(23, 'Te', 'Hindi', NULL, '2020-06-03 15:09:18'),
(24, 'trr', 'hindi', NULL, '2020-06-04 11:36:21'),
(25, 'Hn', 'Hindi', NULL, '2020-06-23 14:04:28');

-- --------------------------------------------------------

--
-- Table structure for table `mainbooks`
--

CREATE TABLE `mainbooks` (
  `pkMbo` int(11) NOT NULL,
  `fkMboSch` int(11) DEFAULT NULL,
  `mbo_Uid` varchar(30) DEFAULT NULL,
  `mbo_MainBookNameRoman` varchar(255) DEFAULT NULL,
  `mbo_OpeningDate` datetime DEFAULT NULL,
  `mbo_Notes` text,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mainbooks`
--

INSERT INTO `mainbooks` (`pkMbo`, `fkMboSch`, `mbo_Uid`, `mbo_MainBookNameRoman`, `mbo_OpeningDate`, `mbo_Notes`, `deleted_at`) VALUES
(1, 3, 'MBN1', '112019', '2020-06-18 12:00:00', 'df', NULL),
(2, 3, 'MBN2', '112020', '2020-06-24 12:00:00', NULL, NULL),
(3, 4, 'MBN8', '112022', '2020-06-24 12:00:00', NULL, NULL),
(4, 3, 'MBN4', '112021', '2020-06-12 12:00:00', NULL, '2020-06-26 15:29:10'),
(5, 8, 'MBN5', 'Checking Mainmm', '2020-06-03 12:00:00', 'checking in edit', NULL),
(6, 8, 'MBN6', 'Checking EEE', '2020-02-10 12:00:00', 'checking the records  checking the records checking the records checking the records checking the records checking the records checking the records', NULL),
(7, 8, 'MBN7', 'Checking EEEEEE', '2020-07-08 12:00:00', 'checking in edittttt', NULL),
(8, 8, 'MBN8', 'Checking', '2020-07-05 12:00:00', 'checking the daya', NULL),
(9, 8, 'MBN9', 'vishalmain', '2020-07-15 12:00:00', 'checking please', NULL),
(10, 3, 'MBN10', 'Main Book1', '2020-07-15 12:00:00', 'Cheking the MAin Book', '2020-07-17 16:11:42');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(71, '2014_10_12_000000_create_users_table', 1),
(72, '2014_10_12_100000_create_password_resets_table', 1),
(73, '2020_04_14_104044_create_admin_table', 1),
(74, '2020_04_22_123523_create_country_table', 1),
(75, '2020_04_22_125446_create_state_table', 1),
(76, '2020_04_24_050206_create_canton_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `municipalities`
--

CREATE TABLE `municipalities` (
  `pkMun` int(11) NOT NULL,
  `fkMunCan` int(11) DEFAULT NULL,
  `mun_Uid` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `mun_MunicipalityName_en` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `mun_MunicipalityName_sr` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mun_MunicipalityName_ba` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mun_MunicipalityName_hr` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `mun_MunicipalityName_Hn` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mun_MunicipalityNameGenitive` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `mun_Notes` text CHARACTER SET latin1,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `municipalities`
--

INSERT INTO `municipalities` (`pkMun`, `fkMunCan`, `mun_Uid`, `mun_MunicipalityName_en`, `mun_MunicipalityName_sr`, `mun_MunicipalityName_ba`, `mun_MunicipalityName_hr`, `mun_MunicipalityName_Hn`, `mun_MunicipalityNameGenitive`, `mun_Notes`, `deleted_at`) VALUES
(1, 1, 'MUN1', 'AMC', 'AMC', 'AMC', 'AMC', NULL, 'AMC', 'note for AMC', NULL),
(2, 2, 'MUN2', 'Cm munic', 'Cm munic', 'Cm munic', 'Cm munic', NULL, 'Cm munic', NULL, NULL),
(3, 2, 'MUN3', 'CK Municipalities', 'CK Municipalities', 'CK Municipalities', 'CK Municipalities', NULL, 'CK Municipalities', 'note for AMC', NULL),
(4, 4, 'MUN4', 'Test1213', 'tstndfjhd', 'khdgdsklgh', 'lkxfhkl', NULL, 'qlkgdfklkfjl', 'fdsf,hfkdsfjg', '2020-06-30 17:38:22');

-- --------------------------------------------------------

--
-- Table structure for table `nationaleducationplans`
--

CREATE TABLE `nationaleducationplans` (
  `pkNep` int(11) NOT NULL,
  `nep_Uid` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `nep_NationalEducationPlanName_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nep_NationalEducationPlanName_sr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nep_NationalEducationPlanName_ba` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nep_NationalEducationPlanName_hr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nep_NationalEducationPlanName_Hn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nep_Notes` text CHARACTER SET latin1,
  `nep_Status` enum('Active','Inactive') CHARACTER SET latin1 NOT NULL DEFAULT 'Active',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nationaleducationplans`
--

INSERT INTO `nationaleducationplans` (`pkNep`, `nep_Uid`, `nep_NationalEducationPlanName_en`, `nep_NationalEducationPlanName_sr`, `nep_NationalEducationPlanName_ba`, `nep_NationalEducationPlanName_hr`, `nep_NationalEducationPlanName_Hn`, `nep_Notes`, `nep_Status`, `deleted_at`) VALUES
(1, 'NEP1', 'Serbians', 'Serbians', 'Serbians', 'Serbians', NULL, 'Lorem ipsum dolor sit', 'Inactive', NULL),
(2, 'NEP2', 'Bosnian', 'Bosnian 1', 'Bosnian 2', 'Bosnian 3', NULL, 'Lorem ipsum dolor sit amet', 'Active', NULL),
(3, 'NEP3', 'ENGs', 'SPA', 'GERs', 'CRO', NULL, 'Thiss', 'Active', NULL),
(4, 'NEP4', 'Educationee', 'Educationsssss', 'Educationggg', 'Eductaionccc', NULL, 'Tst the data', 'Inactive', '2020-06-03 13:19:38');

-- --------------------------------------------------------

--
-- Table structure for table `nationalities`
--

CREATE TABLE `nationalities` (
  `pkNat` int(11) NOT NULL,
  `nat_Uid` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `nat_NationalityName_en` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nat_NationalityName_sr` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nat_NationalityName_ba` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nat_NationalityName_hr` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nat_NationalityName_Hn` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nat_NationalityNameMale` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `nat_NationalityNameFemale` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `nat_Notes` text CHARACTER SET latin1,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nationalities`
--

INSERT INTO `nationalities` (`pkNat`, `nat_Uid`, `nat_NationalityName_en`, `nat_NationalityName_sr`, `nat_NationalityName_ba`, `nat_NationalityName_hr`, `nat_NationalityName_Hn`, `nat_NationalityNameMale`, `nat_NationalityNameFemale`, `nat_Notes`, `deleted_at`) VALUES
(1, 'NTL1', 'Indian', 'indiana', 'a', 'a', NULL, 'Indian1', 'Indian 2', 'note for nation', NULL),
(2, 'NTL2', 'Australian', 'Australian', 'Australian', 'Australian', NULL, 'Australian', 'Australian', 'df', NULL),
(3, 'NTL3', 'Nation1', 'Nación1', 'Nation1', 'Nation1', NULL, 'Vishal', 'Krantii', 'test the data', '2020-06-03 14:00:36'),
(4, 'NTL4', 'Nation', 'Nación1', 'Nation', 'Narod', NULL, 'Vishal', 'Vidha', 'sdjkfhkj', '2020-06-03 14:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `optionalcoursesgroups`
--

CREATE TABLE `optionalcoursesgroups` (
  `pkOcg` int(11) UNSIGNED NOT NULL,
  `ocg_Uid` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ocg_Name_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ocg_Name_sr` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ocg_Name_ba` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ocg_Name_hr` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ocg_Name_Hn` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ocg_Notes` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `optionalcoursesgroups`
--

INSERT INTO `optionalcoursesgroups` (`pkOcg`, `ocg_Uid`, `ocg_Name_en`, `ocg_Name_sr`, `ocg_Name_ba`, `ocg_Name_hr`, `ocg_Name_Hn`, `ocg_Notes`, `deleted_at`) VALUES
(1, 'SMT1', 'GK Trainings', '', '', '', NULL, 'all covers', '2020-05-20 16:24:31'),
(2, 'SMT2', 'Artificial Intelligence', '', '', '', NULL, 'all coversed', '2020-05-20 16:24:28'),
(3, 'SMT3', 'GK Trainingsss', '', '', '', NULL, 'skjd ghdfjk', '2020-05-20 16:24:25'),
(4, 'OCG4', 'Optional Courses - 1', 'Cursos opcionales - 1', 'Optionale Kurse - 1', 'Fakultativni tečajevi - 1', NULL, 'dd', NULL),
(5, 'OCG5', 'Optional Courses - 2', 'Cursos opcionales - 2', 'Optionale Kurse - 2', 'Fakultativni tečajevi - 2', NULL, NULL, NULL),
(6, 'OCG6', 'Optional Courses - 3', 'Cursos opcionales - 3', 'Optionale Kurse - 3', 'Fakultativni tečajevi - 3', NULL, NULL, NULL),
(7, 'OCG7', 'testEE', 'TestSS', 'Test GGfff', 'Twst CC', NULL, '231311dkfjdl', '2020-06-05 13:00:13'),
(8, 'OCG8', 'jdskKJVFK', 'DFKSFJG', ';sdkfo', 'ksdnvkl', NULL, 'lkdfhdf', '2020-06-05 13:00:16');

-- --------------------------------------------------------

--
-- Table structure for table `ownershiptypes`
--

CREATE TABLE `ownershiptypes` (
  `pkOty` int(11) NOT NULL,
  `oty_OwnershipTypeName_en` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `oty_OwnershipTypeName_sr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oty_OwnershipTypeName_ba` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oty_OwnershipTypeName_hr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oty_OwnershipTypeName_Hn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oty_OwnershipTypeName_trr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oty_OwnershipTypeName_Te` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oty_OwnershipTypeName_tes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oty_Uid` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `oty_Notes` text CHARACTER SET latin1,
  `oty_Status` enum('Active','Inactive') CHARACTER SET latin1 NOT NULL DEFAULT 'Active',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ownershiptypes`
--

INSERT INTO `ownershiptypes` (`pkOty`, `oty_OwnershipTypeName_en`, `oty_OwnershipTypeName_sr`, `oty_OwnershipTypeName_ba`, `oty_OwnershipTypeName_hr`, `oty_OwnershipTypeName_Hn`, `oty_OwnershipTypeName_trr`, `oty_OwnershipTypeName_Te`, `oty_OwnershipTypeName_tes`, `oty_Uid`, `oty_Notes`, `oty_Status`, `deleted_at`) VALUES
(1, 'Semi Government', 'Semigobierno', 'Halbregierung', 'Poluvladina', NULL, NULL, NULL, NULL, '	OWN1', 'note', 'Inactive', NULL),
(2, 'Government', 'Gobierno', 'Regierung', 'Vlada', NULL, NULL, NULL, NULL, 'OWN2', 'dsf', 'Active', NULL),
(3, 'Private', 'Privado', 'Privat', 'Privatna', NULL, NULL, NULL, NULL, 'OWN3', NULL, 'Active', NULL),
(4, 'Partnership  EE', 'camaradería ssss', 'Partnerschaft   GG', 'partnerstvo  CC', NULL, NULL, NULL, NULL, 'OWN4', 'testfdnndfhkljhq', 'Active', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `postoffices`
--

CREATE TABLE `postoffices` (
  `pkPof` int(11) NOT NULL,
  `fkPofMun` int(11) DEFAULT NULL,
  `pof_Uid` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `pof_PostOfficeName_en` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pof_PostOfficeName_sr` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pof_PostOfficeName_ba` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pof_PostOfficeName_hr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pof_PostOfficeName_Hn` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pof_PostOfficeNumber` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `pof_Notes` text CHARACTER SET latin1,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `postoffices`
--

INSERT INTO `postoffices` (`pkPof`, `fkPofMun`, `pof_Uid`, `pof_PostOfficeName_en`, `pof_PostOfficeName_sr`, `pof_PostOfficeName_ba`, `pof_PostOfficeName_hr`, `pof_PostOfficeName_Hn`, `pof_PostOfficeNumber`, `pof_Notes`, `deleted_at`) VALUES
(1, 1, 'ZIP1', 'Link Road', 'Link Road', 'Link Road', 'Link Road', NULL, '34234234', 'sdf', NULL),
(2, 1, 'ZIP2', 'University', 'University', 'University', 'University', NULL, '846846', NULL, NULL),
(3, 2, 'ZIP3', 'Mansrover', 'Mansrovers', 'Mansrove', 'Mansrover', NULL, '2121212', NULL, NULL),
(4, 1, 'ZIP4', 'PostalEee', 'PostalSsss', 'PostalGee', 'PostalCccc', NULL, '425105', 'Test the data', NULL),
(5, 3, 'ZIP5', 'Check Municipalities', 'Check Municipalities SS', 'Check Municipalities GG', 'Check Municipalities CC', NULL, '43015', 'checking delete or not', '2020-06-30 17:40:11'),
(6, 3, 'ZIP6', 'PostCode EE', 'PostCode SS', 'PostCode GG', 'PostCode CC', NULL, '43018', 'Checking the result', '2020-06-30 17:49:54'),
(7, 3, 'ZIP7', 'Postal Code EE', 'PostCode SS', 'PostCode GG', 'PostCode CC', NULL, '430188', 'checking in Village', '2020-06-30 17:51:17');

-- --------------------------------------------------------

--
-- Table structure for table `qualificationsdegrees`
--

CREATE TABLE `qualificationsdegrees` (
  `pkQde` int(11) NOT NULL,
  `qde_Uid` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `qde_QualificationDegreeName_en` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qde_QualificationDegreeName_sr` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qde_QualificationDegreeName_ba` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qde_QualificationDegreeName_hr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qde_QualificationDegreeName_Hn` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qde_QualificationDegreeNameGenitive` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `qde_QualificationDegreeNameRoman` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `qde_QualificationDegreeNameNumeric` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `qde_Notes` text CHARACTER SET latin1,
  `qde_Status` enum('Active','Inactive') CHARACTER SET latin1 NOT NULL DEFAULT 'Active',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `qualificationsdegrees`
--

INSERT INTO `qualificationsdegrees` (`pkQde`, `qde_Uid`, `qde_QualificationDegreeName_en`, `qde_QualificationDegreeName_sr`, `qde_QualificationDegreeName_ba`, `qde_QualificationDegreeName_hr`, `qde_QualificationDegreeName_Hn`, `qde_QualificationDegreeNameGenitive`, `qde_QualificationDegreeNameRoman`, `qde_QualificationDegreeNameNumeric`, `qde_Notes`, `qde_Status`, `deleted_at`) VALUES
(1, 'QUD1', 'First', 'First 1', 'First 2', 'First 3', NULL, 'first 12', 'I', '1', 'note 1', 'Active', NULL),
(2, 'QUD2', 'Second', 'Second', 'Second', 'Second', NULL, 'Second', 'II', '2', 'note for second', 'Inactive', NULL),
(3, 'QUD3', 'Third', 'Third', 'Third', 'Third', NULL, 'Third', 'III', '3', NULL, 'Active', NULL),
(4, 'QUD4', 'MCA', 'mCas', 'mc', 'mc', NULL, 'mc', 'mc', 'mm', 'bb', 'Active', NULL),
(5, 'QUD5', 'Fourth', 'Fourth 1', 'Fourth 2', 'Fourth 3', NULL, 'Fourth', 'IV', '4', NULL, 'Active', NULL),
(6, 'QUD6', 'Master of Computerrrr', 'Maestro de la computadora', 'Master of Computer', 'Master of Computer', NULL, 'Master of Sccience', 'VII', '2', 'Test the data for this', 'Active', '2020-06-03 13:39:51');

-- --------------------------------------------------------

--
-- Table structure for table `religions`
--

CREATE TABLE `religions` (
  `pkRel` int(11) NOT NULL,
  `rel_Uid` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `rel_ReligionName_en` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rel_ReligionName_sr` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rel_ReligionName_ba` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rel_ReligionName_hr` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rel_ReligionName_Hn` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rel_ReligionNameAdjective` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `rel_Notes` text CHARACTER SET latin1,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `religions`
--

INSERT INTO `religions` (`pkRel`, `rel_Uid`, `rel_ReligionName_en`, `rel_ReligionName_sr`, `rel_ReligionName_ba`, `rel_ReligionName_hr`, `rel_ReligionName_Hn`, `rel_ReligionNameAdjective`, `rel_Notes`, `deleted_at`) VALUES
(1, 'REL1', 'Hindu', 'Hindu', 'Hindu', 'Hindu', NULL, 'hinduism', 'note for h', NULL),
(2, 'REL2', 'Christian', 'Christian', 'Christian', 'Christian', NULL, 'Christian', NULL, NULL),
(3, 'REL3', 'ReligionsEE', 'ReligionsSSsss', 'ReligionsGG', 'ReligionsCC', NULL, 'sdfhksdj', 'sdjbsfjk', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schooleducationplanassignment`
--

CREATE TABLE `schooleducationplanassignment` (
  `pkSep` int(11) NOT NULL,
  `fkSepSch` int(11) DEFAULT NULL,
  `fkSepEdp` int(11) DEFAULT NULL,
  `fkSepEpl` int(11) DEFAULT NULL,
  `sep_DateOfAccreditation` datetime DEFAULT NULL,
  `sep_Status` enum('Active','Inactive') NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schooleducationplanassignment`
--

INSERT INTO `schooleducationplanassignment` (`pkSep`, `fkSepSch`, `fkSepEdp`, `fkSepEpl`, `sep_DateOfAccreditation`, `sep_Status`, `deleted_at`) VALUES
(127, 3, 2, 10, NULL, 'Active', NULL),
(126, 3, 2, 9, NULL, 'Active', NULL),
(125, 3, 5, 12, NULL, 'Inactive', NULL),
(116, 8, 4, 6, NULL, 'Active', NULL),
(118, 7, 2, 9, NULL, 'Active', NULL),
(117, 7, 4, 6, NULL, 'Inactive', NULL),
(120, 6, 4, 6, NULL, 'Inactive', NULL),
(119, 6, 2, 9, NULL, 'Active', NULL),
(123, 5, 4, 6, NULL, 'Active', NULL),
(122, 5, 2, 9, NULL, 'Active', NULL),
(121, 5, 5, 12, NULL, 'Active', NULL),
(115, 4, 4, 6, NULL, 'Active', NULL),
(114, 4, 2, 9, NULL, 'Active', NULL),
(113, 4, 2, 11, NULL, 'Inactive', NULL),
(124, 3, 4, 6, NULL, 'Inactive', NULL),
(128, 9, 2, 9, NULL, 'Inactive', NULL),
(129, 10, 2, 9, NULL, 'Inactive', NULL),
(130, 11, 4, 6, NULL, 'Inactive', NULL),
(131, 12, 2, 9, NULL, 'Inactive', NULL),
(132, 13, 4, 6, NULL, 'Inactive', NULL),
(133, 14, 2, 11, NULL, 'Inactive', NULL),
(134, 15, 4, 6, NULL, 'Inactive', NULL),
(135, 16, 5, 12, NULL, 'Inactive', NULL),
(136, 17, 5, 12, NULL, 'Inactive', NULL),
(137, 18, 4, 6, NULL, 'Inactive', NULL),
(138, 18, 5, 12, NULL, 'Inactive', NULL),
(139, 19, 2, 9, NULL, 'Inactive', NULL),
(140, 20, 4, 6, NULL, 'Inactive', NULL),
(141, 21, 4, 6, NULL, 'Inactive', NULL),
(142, 22, 2, 9, NULL, 'Inactive', NULL),
(143, 23, 2, 9, NULL, 'Inactive', NULL),
(144, 24, 2, 10, NULL, 'Inactive', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schoolphotos`
--

CREATE TABLE `schoolphotos` (
  `pkSph` int(11) NOT NULL,
  `fkSphSch` int(11) DEFAULT NULL,
  `sph_SchoolPhoto` varchar(100) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schoolphotos`
--

INSERT INTO `schoolphotos` (`pkSph`, `fkSphSch`, `sph_SchoolPhoto`, `deleted_at`) VALUES
(49, 8, '15929125970.png', NULL),
(37, 3, '15925746310.jpg', NULL),
(38, 3, '15928132380.jpg', NULL),
(34, 3, '15925631641.jpg', NULL),
(33, 3, '15925631640.jpg', NULL),
(29, 6, '15925607331.jpg', NULL),
(26, 6, '15925607062.jpg', NULL),
(28, 6, '15925607330.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schoolprincipals`
--

CREATE TABLE `schoolprincipals` (
  `pkScp` int(11) NOT NULL,
  `fkScpEmp` int(11) DEFAULT NULL,
  `fkScpSch` int(11) DEFAULT NULL,
  `scp_StartDate` datetime DEFAULT NULL,
  `scp_EndDate` datetime DEFAULT NULL,
  `scp_ActingPrincipal` enum('Yes','No') NOT NULL DEFAULT 'No',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `pkSch` int(11) NOT NULL,
  `fkSchPof` int(11) DEFAULT NULL,
  `fkSchOty` int(11) DEFAULT NULL,
  `sch_Uid` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `sch_SchoolLogo` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `sch_SchoolName_en` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sch_SchoolName_sr` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sch_SchoolName_ba` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sch_SchoolName_hr` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sch_SchoolName_Hn` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sch_SchoolId` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `sch_SchoolEmail` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `sch_Founder` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `sch_FoundingDate` datetime DEFAULT NULL,
  `sch_Address` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `sch_PhoneNumber` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `sch_MinistryApprovalCertificate` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `sch_AboutSchool` text CHARACTER SET latin1,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`pkSch`, `fkSchPof`, `fkSchOty`, `sch_Uid`, `sch_SchoolLogo`, `sch_SchoolName_en`, `sch_SchoolName_sr`, `sch_SchoolName_ba`, `sch_SchoolName_hr`, `sch_SchoolName_Hn`, `sch_SchoolId`, `sch_SchoolEmail`, `sch_Founder`, `sch_FoundingDate`, `sch_Address`, `sch_PhoneNumber`, `sch_MinistryApprovalCertificate`, `sch_AboutSchool`, `deleted_at`) VALUES
(4, NULL, NULL, 'SCH4', NULL, 'St Pauls school', 'St Pauls school', 'St Pauls school', 'St Pauls school', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IUYTE98655', NULL, NULL),
(3, 2, 3, 'SCH3', '1592478096.png', 'Prva osnovna škola Široki Brijeg', 'Prva osnovna škola Široki Brijeg', 'Prva osnovna škola Široki Brijeg', 'Prva osnovna škola Široki Brijeg', NULL, 'UIU7656HGH', 'stmem786@mailinator.com', 'Berry hill', '2010-05-11 12:00:00', '123, lorem ipsum, norway street', '6846848495', 'sdhkuk989879', 'The purpose of lorem ipsum is to create a natural looking block of text (sentence, paragraph, page, etc.) that doesn\'t distract from the layout. A practice not without controversy, laying out pages with meaningless filler text can be very useful when the focus is meant to be on design, not content.', NULL),
(5, NULL, NULL, 'SCH5', NULL, 'Srednja strukovna škola Posušje', 'Srednja strukovna škola Posušje', 'Srednja strukovna škola Posušje', 'Srednja strukovna škola Posušje', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NDUYD64645', NULL, NULL),
(6, NULL, NULL, 'SCH6', NULL, 'Srednja strukovna škola Ruđera Boškovića Ljubuški', 'Srednja strukovna škola Ruđera Boškovića Ljubuški', 'Srednja strukovna škola Ruđera Boškovića Ljubuški', 'Srednja strukovna škola Ruđera Boškovića Ljubuški', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IOIHUGY785785', NULL, NULL),
(7, 4, 4, 'SCH7', '1592562475.webp', 'Srednja strukovna škola Široki Brijeg', 'Srednja strukovna škola Široki Brijeg', 'Srednja strukovna škola Široki Brijeg', 'Srednja strukovna škola Široki Brijeg', NULL, 'MBK86967756', 'abcSchool786@mailinator.com', 'Tim cook', '2013-10-29 12:00:00', NULL, '868468484844', 'IOH8785', 'Lorem ipsum', NULL),
(8, 1, 2, 'SCH8', '1592913381.png', 'Srednja škola Antuna Branka Šimića Grude', 'Srednja škola Antuna Branka Šimića Grude', 'Srednja škola Antuna Branka Šimića Grude', 'Srednja škola Antuna Branka Šimića Grude', NULL, 'VishalSchoolIDDD', 'vishchecking@mailinator.com', 'V S Chaudhari', '1990-06-06 12:00:00', '37 Ohio, OH', '453213111', '131AMCQ', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.', NULL),
(9, NULL, NULL, 'SCH9', NULL, 'Osnovna škola Vranić', 'Osnovna škola Vranić', 'Osnovna škola Vranić', 'Osnovna škola Vranić', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DGHDFBCVNFDH', NULL, NULL),
(10, NULL, NULL, 'SCH10', NULL, 'Osnovna škola Tina Ujevića Vitina', 'Osnovna škola Tina Ujevića Vitina', 'Osnovna škola Tina Ujevića Vitina', 'Osnovna škola Tina Ujevića Vitina', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gasdfgasfgxb', NULL, NULL),
(11, NULL, NULL, 'SCH11', NULL, 'Osnovna škola Ruđera Boškovića Grude', 'Osnovna škola Ruđera Boškovića Grude', 'Osnovna škola Ruđera Boškovića Grude', 'Osnovna škola Ruđera Boškovića Grude', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'asdgdasfgsdva', NULL, NULL),
(12, NULL, NULL, 'SCH12', NULL, 'Osnovna škola Marka Marulića Ljubuški', 'Osnovna škola Marka Marulića Ljubuški', 'Osnovna škola Marka Marulića Ljubuški', 'Osnovna škola Marka Marulića Ljubuški', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'hsdfgasgdshsd', NULL, NULL),
(13, NULL, NULL, 'SCH13', NULL, 'Osnovna škola Kočerin', 'Osnovna škola Kočerin', 'Osnovna škola Kočerin', 'Osnovna škola Kočerin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sfgsdfasdfsd', NULL, NULL),
(14, NULL, NULL, 'SCH14', NULL, 'Osnovna škola Ivane Brlić-Mažuranić Humac', 'Osnovna škola Ivane Brlić-Mažuranić Humac', 'Osnovna škola Ivane Brlić-Mažuranić Humac', 'Osnovna škola Ivane Brlić-Mažuranić Humac', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sdfsgjjhuc', NULL, NULL),
(15, NULL, NULL, 'SCH15', NULL, 'Osnovna škola Ivana Mažuranića Posušje', 'Osnovna škola Ivana Mažuranića Posušje', 'Osnovna škola Ivana Mažuranića Posušje', 'Osnovna škola Ivana Mažuranića Posušje', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sdfgsdfgjd', NULL, NULL),
(16, NULL, NULL, 'SCH16', NULL, 'Osnovna škola Franice Dall\'era Vir', 'Osnovna škola Franice Dall\'era Vir', 'Osnovna škola Franice Dall\'era Vir', 'Osnovna škola Franice Dall\'era Vir', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'afsgsadfghfg', NULL, NULL),
(17, NULL, NULL, 'SCH17', NULL, 'Osnovna škola fra Stipana Vrljića Sovići', 'Osnovna škola fra Stipana Vrljića Sovići', 'Osnovna škola fra Stipana Vrljića Sovići', 'Osnovna škola fra Stipana Vrljića Sovići', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'afdssdfsfgd', NULL, NULL),
(18, NULL, NULL, 'SCH18', NULL, 'Osnovna škola Biograci', 'Osnovna škola Biograci', 'Osnovna škola Biograci', 'Osnovna škola Biograci', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sdfahfhjfdbd', NULL, NULL),
(19, NULL, NULL, 'SCH19', NULL, 'Osnovna škola Antuna Branka i Stanislava Šimića Drinovci', 'Osnovna škola Antuna Branka i Stanislava Šimića Drinovci', 'Osnovna škola Antuna Branka i Stanislava Šimića Drinovci', 'Osnovna škola Antuna Branka i Stanislava Šimića Drinovci', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'afsagsdfjhmnbfv', NULL, NULL),
(20, NULL, NULL, 'SCH20', NULL, 'Osnovna škola Ante Brune Bušića Rakitno', 'Osnovna škola Ante Brune Bušića Rakitno', 'Osnovna škola Ante Brune Bušića Rakitno', 'Osnovna škola Ante Brune Bušića Rakitno', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'saddhjgfcsdhh', NULL, NULL),
(21, NULL, NULL, 'SCH21', NULL, 'Gimnazija Ljubuški', 'Gimnazija Ljubuški', 'Gimnazija Ljubuški', 'Gimnazija Ljubuški', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sfhjgfzidsvndf', NULL, NULL),
(22, NULL, NULL, 'SCH22', NULL, 'Gimnazija fra Grge Martića Posušje', 'Gimnazija fra Grge Martića Posušje', 'Gimnazija fra Grge Martića Posušje', 'Gimnazija fra Grge Martića Posušje', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sadfsdfhigsm', NULL, NULL),
(23, NULL, NULL, 'SCH23', NULL, 'Gimnazija fra Dominika Mandića Široki Brijeg', 'Gimnazija fra Dominika Mandića Široki Brijeg', 'Gimnazija fra Dominika Mandića Široki Brijeg', 'Gimnazija fra Dominika Mandića Široki Brijeg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'asdfsagsdhgs', NULL, NULL),
(24, NULL, NULL, 'SCH24', NULL, 'Druga osnovna škola Široki Brijeg', 'Druga osnovna škola Široki Brijeg', 'Druga osnovna škola Široki Brijeg', 'Druga osnovna škola Široki Brijeg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fgsdfhgfdsjd', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schoolyears`
--

CREATE TABLE `schoolyears` (
  `pkSye` int(11) UNSIGNED NOT NULL,
  `sye_Uid` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sye_NameCharacter_en` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sye_NameCharacter_sr` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sye_NameCharacter_ba` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sye_NameCharacter_hr` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sye_NameCharacter_Hn` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sye_NameNumeric` year(4) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schoolyears`
--

INSERT INTO `schoolyears` (`pkSye`, `sye_Uid`, `sye_NameCharacter_en`, `sye_NameCharacter_sr`, `sye_NameCharacter_ba`, `sye_NameCharacter_hr`, `sye_NameCharacter_Hn`, `sye_NameNumeric`, `deleted_at`) VALUES
(1, 'SYE1', 'Tanveer', '', '', '', NULL, 1994, '2020-05-13 00:08:09'),
(2, 'SYE2', 'Tanveer', '', '', '', NULL, 2019, '2020-05-13 02:18:58'),
(3, 'SYE3', 'Tanvee', '', '', '', NULL, 2020, '2020-05-13 07:37:02'),
(4, 'SYE4', 'test1', 'test1', 'test1', 'test1', NULL, 2022, NULL),
(5, 'SYE5', 'Tanveer', '', '', '', NULL, 2028, '2020-05-14 09:51:57'),
(6, 'SYE6', 'test2', 'test2', 'test2', 'test2', NULL, 2025, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `pkSta` int(11) NOT NULL,
  `fkStaCny` int(11) NOT NULL,
  `sta_Uid` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sta_StateName_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sta_StateName_sr` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sta_StateName_ba` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sta_StateName_hr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sta_StateName_Hn` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sta_StateNameGenitive` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sta_Note` text COLLATE utf8mb4_unicode_ci,
  `sta_Status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`pkSta`, `fkStaCny`, `sta_Uid`, `sta_StateName_en`, `sta_StateName_sr`, `sta_StateName_ba`, `sta_StateName_hr`, `sta_StateName_Hn`, `sta_StateNameGenitive`, `sta_Note`, `sta_Status`, `deleted_at`) VALUES
(1, 1, 'STA1', 'Gujarat', 'Gujarat', 'Gujarat', 'Gujarat', NULL, 'Gujarati', 'note', 'Active', NULL),
(2, 2, 'STA2', 'Alberta', 'Alberta 1', 'Alberta 2', 'Alberta 3', NULL, 'Alberta', 'note', 'Active', NULL),
(3, 2, 'STA3', 'British Columbia', 'British Columbia', 'British Columbia', 'British Columbia', NULL, 'British Columbias', 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Cicero\'s De Finibus Bonorum et Malorum for use in a type specimen book. It usually begins with:  “Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.” The purpose of lorem ipsum is to create a natural looking block of text (sentence, paragraph, page, etc.) that doesn\'t distract from the layout. A practice not without controversy, laying out pages with meaningless filler text can be very useful when the focus is meant to be on design, not content.', 'Inactive', NULL),
(4, 4, 'STA4', 'Federation of Bosnia and Herzegovina', 'Federation of Bosnia and Herzegovina', 'Federation of Bosnia and Herzegovina', 'Federation of Bosnia and Herzegovina', NULL, 'Federation of Bosnia and Herzegovina', NULL, 'Active', NULL),
(5, 2, 'STA5', 'RAJASTHAN', 'RAJASTHAN', 'RAJASTHAN', 'RAJASTHAN', NULL, 'RAJASTHAN', NULL, 'Inactive', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `studentbehaviours`
--

CREATE TABLE `studentbehaviours` (
  `pkSbe` int(11) UNSIGNED NOT NULL,
  `sbe_Uid` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sbe_BehaviourName_en` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sbe_BehaviourName_sr` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sbe_BehaviourName_ba` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sbe_BehaviourName_hr` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sbe_BehaviourName_Hn` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sbe_Notes` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `studentbehaviours`
--

INSERT INTO `studentbehaviours` (`pkSbe`, `sbe_Uid`, `sbe_BehaviourName_en`, `sbe_BehaviourName_sr`, `sbe_BehaviourName_ba`, `sbe_BehaviourName_hr`, `sbe_BehaviourName_Hn`, `sbe_Notes`, `deleted_at`) VALUES
(1, 'SYE1', 'Excelent Behaviour', '', '', '', NULL, 'It belongs to those student who pay attentions in every activity', '2020-05-20 16:24:44'),
(2, 'SYE2', 'BAD', '', '', '', NULL, 'thui vfdh d', '2020-05-20 16:24:47'),
(3, 'SBE3', 'Excellent Behaviour', 'Excelente comportamiento', 'Exzellentes Verhalten', 'Izvrsno ponašanje', NULL, 'It belongs to those student who pay attentions', NULL),
(4, 'SBE4', 'Cypress', 'Cipréssss', 'Zypresse', 'Čempres', NULL, 'fdskkhdsfkjf', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `studentdisciplinemeasuretypes`
--

CREATE TABLE `studentdisciplinemeasuretypes` (
  `pkSmt` int(10) UNSIGNED NOT NULL,
  `smt_Uid` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `smt_DisciplineMeasureName_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `smt_DisciplineMeasureName_sr` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smt_DisciplineMeasureName_ba` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smt_DisciplineMeasureName_hr` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `smt_DisciplineMeasureName_Hn` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smt_Notes` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `studentdisciplinemeasuretypes`
--

INSERT INTO `studentdisciplinemeasuretypes` (`pkSmt`, `smt_Uid`, `smt_DisciplineMeasureName_en`, `smt_DisciplineMeasureName_sr`, `smt_DisciplineMeasureName_ba`, `smt_DisciplineMeasureName_hr`, `smt_DisciplineMeasureName_Hn`, `smt_Notes`, `deleted_at`) VALUES
(1, 'SMT1', 'Proper Dressss', '', '', '', NULL, 'Dres', '2020-05-20 16:25:52'),
(2, 'SMT2', 'dffdgfd', '', '', '', NULL, 'dfgfdg', '2020-05-20 16:25:56'),
(3, 'DMT3', 'Proper Dressss', 'Proper Dressss', 'Proper Dressss', 'Proper Dressss', NULL, 'ddd', NULL),
(4, 'DMT4', 'Well Behaved', 'bien portado', 'gut erzogen', 'dobro se ponašao', NULL, NULL, NULL),
(5, 'DMT5', 'TestEE', 'TestSS', 'teskldfjlkjgkljg', 'testCC', NULL, 'jksdhlgkkjdfhkj', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `studentenrollments`
--

CREATE TABLE `studentenrollments` (
  `pkSte` int(11) NOT NULL,
  `fkSteStu` int(11) DEFAULT NULL,
  `fkSteSch` int(11) DEFAULT NULL,
  `fkSteMbo` int(11) DEFAULT NULL,
  `fkSteGra` int(11) DEFAULT NULL,
  `fkSteEdp` int(11) DEFAULT NULL,
  `fkSteEpl` int(11) DEFAULT NULL,
  `fkSteSye` int(11) DEFAULT NULL,
  `ste_DistanceInKilometers` varchar(30) DEFAULT NULL,
  `ste_MainBookOrderNumber` int(11) DEFAULT NULL,
  `ste_EnrollmentDate` datetime DEFAULT NULL,
  `ste_EnrollBasedOn` text,
  `ste_Reason` text,
  `ste_FinishingDate` datetime DEFAULT NULL,
  `ste_BreakingDate` datetime DEFAULT NULL,
  `ste_ExpellingDate` datetime DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `studentenrollments`
--

INSERT INTO `studentenrollments` (`pkSte`, `fkSteStu`, `fkSteSch`, `fkSteMbo`, `fkSteGra`, `fkSteEdp`, `fkSteEpl`, `fkSteSye`, `ste_DistanceInKilometers`, `ste_MainBookOrderNumber`, `ste_EnrollmentDate`, `ste_EnrollBasedOn`, `ste_Reason`, `ste_FinishingDate`, `ste_BreakingDate`, `ste_ExpellingDate`, `deleted_at`) VALUES
(1, 1, 0, 3, 1, 2, 9, NULL, '', 121, '2020-07-21 12:00:00', 'College', 'Not Listd', '2020-07-22 12:00:00', NULL, NULL, NULL),
(2, 1, 0, 2, 1, 2, 9, NULL, '', 4, '2020-06-30 12:00:00', 'test', 'sdf', NULL, NULL, NULL, NULL),
(3, 2, 0, 2, 1, 2, 9, NULL, '5.55', 4, '2020-06-30 12:00:00', 'test', 'sdf', NULL, NULL, NULL, NULL),
(5, 11, 0, 2, 1, 2, 9, NULL, '', 6, '2020-07-09 12:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 6, 0, 2, 1, 2, 9, NULL, '', 1211, '2020-07-13 12:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(19, 15, 3, 3, 1, 2, 10, 4, '33km', 121, '2020-07-13 12:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(18, 12, 3, 1, 1, 2, 9, 4, '', 776756787, '2020-07-08 12:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(17, 5, 3, 3, 1, 2, 9, 4, '', 2, '2020-07-09 12:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(16, 5, NULL, 2, 1, 2, 9, 4, '', 6, '2020-07-01 12:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(11, 6, NULL, 3, 1, 2, 9, 4, '', 121, '2020-07-16 12:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(12, 5, NULL, 3, 1, 2, 9, 4, '', 12, '2020-07-23 12:00:00', 'JJ UNi', 'NO', '2020-07-16 12:00:00', '2020-07-08 12:00:00', NULL, NULL),
(13, 6, NULL, 3, 1, 4, 6, 4, '', 1, '2020-07-22 12:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(14, 1, NULL, 1, 1, 4, 6, 4, '', 121, '2020-07-21 12:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(15, 6, 3, 2, 1, 2, 9, 4, '', 7, '2020-07-02 12:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(20, 12, 3, 5, 1, 2, 9, 4, '', 121, '2020-07-06 12:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(21, 11, 3, 2, 1, 2, 9, 4, '5', 1212, '2020-07-21 12:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(22, 20, 8, 3, 1, 4, 6, 6, '487', 89748, '2020-07-14 12:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(23, 22, 8, 9, 1, 4, 6, 6, '88', 89465, '2020-07-20 12:00:00', 'loream ipsum for the testing the records.', NULL, NULL, NULL, NULL, NULL),
(24, 16, 8, 9, 1, 4, 6, 6, '66', 97846, '2020-07-14 12:00:00', 'jhg ukhgkg kj hkj j', 'kjhkuhkhkjhkj hkhk', '2020-07-14 12:00:00', NULL, NULL, NULL),
(25, 16, 3, 2, 3, 2, 9, 4, '66', 121, '2020-07-21 12:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(26, 27, 8, 9, 1, 4, 6, 4, '55', 45645, '2020-07-13 12:00:00', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `fkStuMun` int(11) DEFAULT NULL,
  `fkStuPof` int(11) DEFAULT NULL,
  `fkStuNat` int(11) DEFAULT NULL,
  `fkStuRel` int(11) DEFAULT NULL,
  `fkStuCtz` int(11) DEFAULT NULL,
  `fkStuFatherJaw` int(11) DEFAULT NULL,
  `fkStuMotherJaw` int(11) DEFAULT NULL,
  `stu_StudentID` varchar(13) DEFAULT NULL,
  `stu_TempCitizenId` varchar(13) DEFAULT NULL,
  `stu_StudentName` varchar(255) DEFAULT NULL,
  `stu_StudentSurname` varchar(255) DEFAULT NULL,
  `stu_DateOfBirth` datetime DEFAULT NULL,
  `stu_PlaceOfBirth` varchar(255) DEFAULT NULL,
  `stu_StudentGender` enum('Male','Female','Other') NOT NULL DEFAULT 'Other',
  `stu_Address` varchar(255) DEFAULT NULL,
  `stu_DistanceInKilometers` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email_verification_key` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `stu_PhoneNumber` varchar(255) DEFAULT NULL,
  `stu_MobilePhoneNumber` varchar(255) DEFAULT NULL,
  `stu_FatherName` varchar(255) DEFAULT NULL,
  `stu_MotherName` varchar(255) DEFAULT NULL,
  `stu_ParentsEmail` varchar(255) DEFAULT NULL,
  `stu_ParantsPhone` varchar(100) DEFAULT NULL,
  `stu_SpecialNeed` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `stu_PicturePath` varchar(255) DEFAULT NULL,
  `stu_Notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `fkStuMun`, `fkStuPof`, `fkStuNat`, `fkStuRel`, `fkStuCtz`, `fkStuFatherJaw`, `fkStuMotherJaw`, `stu_StudentID`, `stu_TempCitizenId`, `stu_StudentName`, `stu_StudentSurname`, `stu_DateOfBirth`, `stu_PlaceOfBirth`, `stu_StudentGender`, `stu_Address`, `stu_DistanceInKilometers`, `email`, `password`, `email_verification_key`, `email_verified_at`, `stu_PhoneNumber`, `stu_MobilePhoneNumber`, `stu_FatherName`, `stu_MotherName`, `stu_ParentsEmail`, `stu_ParantsPhone`, `stu_SpecialNeed`, `stu_PicturePath`, `stu_Notes`, `created_at`, `deleted_at`) VALUES
(1, 2, 2, 1, 2, 2, 3, 2, 'STU123', 'STUPPA1', 'Jimmyss', 'Mr', '2020-07-13 12:00:00', 'Melborn', 'Female', 'JJ 129 street', NULL, 'jchris12@mailinator.com', NULL, NULL, NULL, '08949452149', NULL, 'Father', 'Mother', 'Sam@gmail.com', '08949452149', 'Yes', '1593779457.png', 'This is going to laal', NULL, NULL),
(2, 1, 2, 1, 1, 2, 4, 3, 'VishNew12', 'STUPPA111', 'Viral', 'Chaudharu', '2020-07-01 12:00:00', 'Dharangaon', 'Male', 'Dharangona', '5.55', 'admin@mailinator1.com', NULL, 'e1c1aeffdf00f1faab3c61d07fcc2c26', NULL, '845132132321', '8453221321', 'Shantaram', 'Pushpa', 'Sa11m@gmail.com', '0894944343', 'Yes', '', 'This is going to laal', NULL, '2020-07-15 16:35:53'),
(3, 2, 1, 1, 1, 2, 1, 4, 'vishal12', 'EMPID11', 'Vishal', 'Chaudharo', '2020-07-01 12:00:00', 'Dharangaonn', 'Male', 'Dharangaonnn', '88.55', 'vishalnewstudent@mailinator.com', NULL, NULL, NULL, '461532132133231313', '56132135461531135', 'dh', NULL, 'hjdsg@mailinator.com', '9846532132132', 'No', '1594386064.jpeg', NULL, NULL, '2020-07-15 16:36:00'),
(4, 1, 2, 2, 2, 3, 1, 3, NULL, 'POH98233', 'Yennifer', 'lawrence', '2000-05-21 12:00:00', 'dolce', 'Female', '12 Lorem street', NULL, 'brad786@mailinator.com', NULL, '9e399cb6c890ed627ba7f9ca6bb32322', NULL, '8484684648', NULL, 'James', 'Monica', 'jab67@mailinator.com', '8646844848', 'No', '', NULL, NULL, NULL),
(5, 3, 4, 2, 2, 3, NULL, NULL, 'PONH343', 'PONH343', 'maria', 'bose', '2003-04-07 12:00:00', 'havana', 'Female', '23 lorem ipsum', NULL, 'maria23@gmail.com', NULL, '26b4c3d564a97427ffa214eff2129eee', NULL, '68684684864', NULL, 'Barathean', 'kelly', 'oiyy76@mailinator.com', '68468484878', 'No', '', 'This is goinga', NULL, NULL),
(6, 1, 3, 1, 3, 6, 3, 3, NULL, 'OIHIOH8757', 'brain', 'conner', '2002-12-31 12:00:00', 'dolce', 'Male', 'df street', NULL, 'HertStudent@mailinator.com', '$2y$10$Vt3iSOOri3USuTwvboc9eOdRYxOosjuDE14PiZhsvv57JdeT8ZQP2', NULL, '2020-07-08 23:03:53', '44384834834', NULL, 'Mark strong', 'sherly', 'yut@mailinator.com', '8648484848', 'Yes', '', NULL, NULL, NULL),
(7, 2, 1, 2, 1, 3, 2, 3, 'Bill123', 'Bill123', 'Bill', 'Clinten', '2020-07-10 12:00:00', 'Dharangaon', 'Female', 'New Street Melborn, JS', '5.55', 'rohit@gmail.com', NULL, NULL, NULL, '0894945232', '08949452233', 'Shantaram', 'Pushpa', 'Sa11m@gmail.com', '0894945222', 'Yes', '', 'This is going to', NULL, NULL),
(11, 2, 2, 2, 2, 6, 2, 2, 'OIHGD767', NULL, 'katya', 'perry', '1991-07-22 12:00:00', 'havana', 'Female', '344 street', '5', 'katy786@gmail.com', NULL, 'af148cf0e1496b4f44686a136cf42d90', NULL, '6846846498', NULL, 'Ron', 'henna', 'katparent786@mailinator.com', '68468484884', 'Yes', '1594975616.png', 'test', NULL, NULL),
(12, 1, 4, 1, 1, 7, 1, 1, 'test', 'EMP1212', 'VishalStud', 'Student', '2020-07-07 12:00:00', 'Dharangaonn', 'Male', 'Dharangaon, Maharashtra, India', NULL, 'vishdharangaon@mailinator.com', NULL, 'c4892d918eacc258f6b69abb2b544a63', NULL, '987451321231', NULL, 'Shantarammm', 'Pushpabai', 'shantaram@mailinator.com', '321613212', 'Yes', '1594976278.png', NULL, NULL, NULL),
(13, 2, 2, 2, 2, 7, 2, 3, 'OIIHH989', NULL, 'dan', 'steven', '2001-09-14 12:00:00', 'dolce', 'Male', '344 street', NULL, 'dansteve786@mailinator.com', '$2y$10$t3A3t9lD6CMXe1tr6IQnle4u3W4NWhziDQawbpcFwe3Oc.vFhXuWq', NULL, '2020-07-17 09:23:47', '6884864848', NULL, 'Brad', 'Miley', 'bradparent@mailinator.com', '88464684848', 'Yes', '1594961150.png', NULL, NULL, NULL),
(14, 1, 2, 1, 1, 3, NULL, NULL, 'Mili123', NULL, 'Jhon Mili', 'Mili', '2020-07-19 12:00:00', 'Melborn', 'Male', 'JJ MiliStrete', '22km', 'Mili@hertronic.com', NULL, NULL, NULL, '8967452345', NULL, NULL, NULL, 'Sam@gmail.com', '9078563456', 'Yes', '', NULL, NULL, NULL),
(15, 1, 1, 1, 2, 3, NULL, NULL, 'malk1234', 'malk1234', 'Juni', 'malk', '2020-07-06 12:00:00', 'Melborn', 'Male', 'No Add', '33km', 'malk1234@gmail.com', NULL, NULL, NULL, '756454545', NULL, NULL, NULL, 'oiyy76@mailinator.com', '8877665544', 'Yes', '', NULL, NULL, NULL),
(16, 1, 4, 1, 1, 2, 1, 1, 'Vishal121', NULL, 'VishalScholl', 'chaudhari', '2020-07-16 12:00:00', 'Dharangaon', 'Male', 'Pastane, Maharashtra', '66', 'vishalstud@mailinator.com', NULL, NULL, NULL, '8461328613', '6451322338', 'Stantaram', 'Pushpabai', 'vishalstudent@mailinator.com', '46153213232', 'Yes', '1595232485.png', NULL, NULL, NULL),
(17, 3, 3, 2, 3, 6, 2, 2, 'StudentIDdd', NULL, 'Vishalst', 'Chaudhari', '2020-07-02 12:00:00', 'Jalgaon', 'Male', 'Jalgaon, Maharashtra', '77', 'student@mailinator.com', NULL, NULL, NULL, '461531221', '461321321', 'Stantarammm', 'Pushpabaiii', 'studentstantaram@mailinator.com', '8465132121', 'Yes', '', NULL, NULL, NULL),
(18, 2, 2, 1, 1, 2, NULL, NULL, 'Rock123', NULL, 'Rock', 'Balateli', '2020-07-04 12:00:00', 'eed', 'Male', 'dds', '5.55', 'Rock123@gmail.com', NULL, NULL, NULL, '3434343434', NULL, NULL, NULL, 'Rock@gmail.com', '1234123423', 'Yes', '', NULL, NULL, NULL),
(19, 2, 1, 1, 2, 6, NULL, NULL, 'NwewM112', NULL, 'NwewM', 'NwewM', '2020-07-07 12:00:00', 'havana', 'Female', '223 ffgg', NULL, 'NwewM@mailinator.com', NULL, NULL, NULL, '2233443233', NULL, NULL, NULL, 'Sam@gmail.com', '08949452133', 'No', '', NULL, NULL, NULL),
(20, 1, 4, 1, 1, 2, 1, 1, 'Vishal121222', 'TEmpStud21', 'VishalNewStudent1', 'Ch', '2020-07-09 12:00:00', 'Dharangaon', 'Male', 'Pastane, Maharashtra', '487', 'vishalstudent@mailinator.com', NULL, NULL, NULL, '84132132231', '4613132615', 'Test1', 'Test11', 'shant@mailinator.com', '89465132231', 'Yes', '1595311231.png', NULL, NULL, NULL),
(21, 3, 1, 2, 3, 6, 2, 2, 'StudnMainBook', NULL, 'VishalMainBook', 'ch', '2020-07-15 12:00:00', 'Pachora, Mahrashtra', 'Male', 'Chalisgaon, Maharashtra', '66', 'studentmainbook@mailinator.com', NULL, NULL, NULL, '4651321186451', '641532164153', 'MainBookFT', 'MainBookMT', 'mainbookft@mailinator.com', '84651321321', 'Yes', '1595316117.png', NULL, NULL, NULL),
(22, 2, 2, 2, 2, 3, 2, 2, NULL, 'Prashant1234', 'Prashant', 'Chaudhari', '2020-07-10 12:00:00', 'Bhone, Maharashtra', 'Male', 'Paldhi Maharashtra', '88', 'prashantmainbook@mailinator.com', NULL, NULL, NULL, '415321321231', '641321221323', 'MainBookFtt', 'MainBookMtt', 'mainbookftt@mailinator.com', '451321321', 'Yes', '', NULL, NULL, NULL),
(23, 1, 1, 1, 1, 2, NULL, NULL, 'JonyD32', NULL, 'Jony D', 'D', '2020-07-15 12:00:00', 'Dharangaon', 'Male', 'JonyD32', NULL, 'JonyD32@gmail.com', NULL, NULL, NULL, '9898765467', NULL, NULL, NULL, 'oiyy76@mailinator.com', '089494524444', 'Yes', '', NULL, NULL, NULL),
(24, 2, 2, 1, 1, 3, NULL, NULL, 'NewTest232', NULL, 'NewTest', 'NewTest', '2020-07-10 12:00:00', 'havana', 'Female', 'hgjdg b hjd', NULL, 'NewTest@hertronic.com', NULL, NULL, NULL, '8877665544', NULL, NULL, NULL, 'oiyy76@mailinator.com', '9988776655', 'Yes', '', NULL, NULL, NULL),
(25, 1, 3, 1, 2, 3, 2, 2, NULL, 'Jhon8989', 'Jhon j', 'Jhon j', '2020-07-10 12:00:00', 'Melborn', 'Male', 'JJ tret', '33km', 'Jhonj@hertronic.com', NULL, NULL, NULL, '8899776653', '889977665', 'Barathean', 'Mother', 'Sam@gmail.com', '08949452149', 'Yes', '', NULL, NULL, NULL),
(26, 2, 1, 1, 1, 3, 1, 2, 'Hank123', NULL, 'Hank', 'Ha', '2020-07-10 12:00:00', 'havana', 'Male', 'df street', '33km', 'Hank@mailinator.com', NULL, NULL, NULL, '08949452144', '08949452144', 'Mark strong', 'Mother', 'yut@mailinator.com', '08949452149', 'Yes', '', NULL, NULL, NULL),
(27, 1, 2, 1, 2, 6, NULL, NULL, 'Vishal12111', 'STUDENT1200', 'VishalLa', 'Chaudhari', '2020-07-10 12:00:00', 'Pachora, Mahrashtra', 'Male', 'Pastane, Maharashtraaa', '65', 'vishalstudent11@mailinator.com', NULL, 'a4bc83200ae34ae2a9900469d18ddc19', NULL, '8946321321', NULL, NULL, NULL, 'shant11@mailinator.com', '99999945412', 'Yes', '1595396905.png', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` bigint(20) NOT NULL,
  `section` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `value_en` text COLLATE utf8mb4_unicode_ci,
  `value_sr` text COLLATE utf8mb4_unicode_ci,
  `value_ba` text COLLATE utf8mb4_unicode_ci,
  `value_hr` text COLLATE utf8mb4_unicode_ci,
  `value_Hn` text COLLATE utf8mb4_unicode_ci,
  `value_trr` text COLLATE utf8mb4_unicode_ci,
  `value_Te` text COLLATE utf8mb4_unicode_ci,
  `value_tes` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`id`, `section`, `key`, `value_en`, `value_sr`, `value_ba`, `value_hr`, `value_Hn`, `value_trr`, `value_Te`, `value_tes`, `deleted_at`) VALUES
(1, 'general', 'gn_first_name', 'First Name', 'Nombre de pila', 'Vorname', 'Ime', NULL, NULL, NULL, NULL, NULL),
(2, 'signup', 'sign_first_name', 'first name', 'first name in spanish', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'sidebar', 'sidebar_nav_dasbhoard', 'Dashboard', 'Tablero', 'Instrumententafel', 'Kontrolna ploča', NULL, NULL, NULL, NULL, NULL),
(4, 'sidebar', 'sidebar_nav_classes', 'Classes', 'Clases', 'Klassen', 'klase', NULL, NULL, NULL, NULL, NULL),
(5, 'sidebar', 'sidebar_nav_user_management', 'User Management', 'Gestión de usuarios', 'Benutzerverwaltung', 'Upravljanje korisnicima', NULL, NULL, NULL, NULL, NULL),
(6, 'sidebar', 'sidebar_nav_masters', 'Masters', 'Maestros', 'Meister', 'Majstori', NULL, NULL, NULL, NULL, NULL),
(7, 'sidebar', 'sidebar_nav_ministry_masters', 'Ministry Masters', 'Maestros del ministerio', 'Ministerialmeister', 'Gospodari ministarstava', NULL, NULL, NULL, NULL, NULL),
(8, 'sidebar', 'sidebar_nav_report', 'Report', 'Reporte', 'Bericht', 'izvješ?e', NULL, NULL, NULL, NULL, NULL),
(9, 'sidebar', 'sidebar_nav_ministry_super_admin', 'Ministry Super Admin', 'Ministry Super Admin', 'Ministerium Super Admin', 'Ministarstvo Super Admin', NULL, NULL, NULL, NULL, NULL),
(10, 'sidebar', 'sidebar_nav_login_as', 'Login as', 'Iniciar sesión como', 'Anmelden als', 'Prijavite se kao', NULL, NULL, NULL, NULL, NULL),
(11, 'sidebar', 'sidebar_nav_countries', 'Countries', 'Países', 'Länder', 'Zemlje', NULL, NULL, NULL, NULL, NULL),
(12, 'sidebar', 'sidebar_nav_states', 'States', 'Estados', 'Zustände', 'Države', NULL, NULL, NULL, NULL, NULL),
(13, 'sidebar', 'sidebar_nav_cantons', 'Cantons', 'Cantones', 'Kantone', 'kantona', NULL, NULL, NULL, NULL, NULL),
(14, 'sidebar', 'sidebar_nav_municipalities', 'Municipalities', 'Municipios', 'Gemeinden', 'Općine', NULL, NULL, NULL, NULL, NULL),
(15, 'sidebar', 'sidebar_nav_colleges', 'Colleges', 'Colegios', 'Hochschulen', 'Fakulteti', NULL, NULL, NULL, NULL, NULL),
(16, 'sidebar', 'sidebar_nav_postal_code', 'Postal Code', 'Código postal', 'Postleitzahl', 'Poštanski broj', NULL, NULL, NULL, NULL, NULL),
(17, 'sidebar', 'sidebar_nav_academic_degree', 'Education & Academic Degree', 'Educación y grado académico', 'Bildung & akademischer Abschluss', 'Obrazovanje i akademski stupanj', NULL, NULL, NULL, NULL, NULL),
(18, 'sidebar', 'sidebar_nav_job_work', 'Job & Work', 'Trabajo Empleo', 'Job & Arbeit', 'Posao', NULL, NULL, NULL, NULL, NULL),
(19, 'sidebar', 'sidebar_nav_languages', 'Languages', 'Idiomas', 'Sprachen', 'Jezici', NULL, NULL, NULL, NULL, NULL),
(20, 'sidebar', 'sidebar_nav_translations', 'Translations', 'Traducciones', 'Übersetzungen', 'Prijevodi', NULL, NULL, NULL, NULL, NULL),
(21, 'sidebar', 'sidebar_nav_universities', 'Universities', 'Universidades', 'Universitäten', 'Sveučilišta', NULL, NULL, NULL, NULL, NULL),
(22, 'sidebar', 'sidebar_nav_ownership_types', 'Ownership Types', 'Tipos de propiedad', 'Eigentumsarten', 'Vrste vlasništva', NULL, NULL, NULL, NULL, NULL),
(23, 'sidebar', 'sidebar_nav_schools', 'Schools', 'Escuelas', 'Schulen', 'škole', NULL, NULL, NULL, NULL, NULL),
(24, 'sidebar', 'sidebar_nav_teachers', 'Teachers', 'Maestros', 'Lehrer', 'Nastavnici', NULL, NULL, NULL, NULL, NULL),
(25, 'sidebar', 'sidebar_nav_students', 'Students', 'Estudiantes', 'Studenten', 'Studenti', NULL, NULL, NULL, NULL, NULL),
(26, 'sidebar', 'sidebar_nav_education_plan', 'Education Plan', 'Plan Educativo', 'Bildungsplan', 'Plan obrazovanja', NULL, NULL, NULL, NULL, NULL),
(27, 'sidebar', 'sidebar_nav_grades', 'Grades', 'Los grados', 'Noten', 'Razreda', NULL, NULL, NULL, NULL, NULL),
(28, 'sidebar', 'sidebar_nav_courses', 'Courses', 'Cursos', 'Kurse', 'Tečajevi', NULL, NULL, NULL, NULL, NULL),
(29, 'sidebar', 'sidebar_nav_village_schools', 'Village Schools', 'Escuelas del pueblo', 'Dorfschulen', 'Seoske škole', NULL, NULL, NULL, NULL, NULL),
(30, 'sidebar', 'sidebar_nav_national_education_plan', 'National Education Plan', 'Plan nacional de educación', 'Nationaler Bildungsplan', 'Nacionalni obrazovni plan', NULL, NULL, NULL, NULL, NULL),
(31, 'sidebar', 'sidebar_nav_education_profile', 'Education Profile', 'Perfil Educativo', 'Bildungsprofil', 'Profil obrazovanja', NULL, NULL, NULL, NULL, NULL),
(32, 'sidebar', 'sidebar_nav_qualification_degree', 'Qualification Degree', 'Grado de calificación', 'Qualifikationsgrad', 'Stupanj Kvalifikacije', NULL, NULL, NULL, NULL, NULL),
(33, 'login', 'ln_login', 'Login', 'Iniciar sesión', 'Anmeldung', 'Prijaviti se', NULL, NULL, NULL, NULL, NULL),
(34, 'login', 'ln_enter_password', 'Enter Password', 'Introducir la contraseña', 'Passwort eingeben', 'Upišite lozinku', NULL, NULL, NULL, NULL, NULL),
(35, 'login', 'ln_enter_email', 'Enter Email', 'Ingrese correo electrónico', 'Email eingeben', 'Unesite e-poštu', NULL, NULL, NULL, NULL, NULL),
(36, 'login', 'ln_email', 'Email', 'Correo electrónico', 'Email', 'E-mail', NULL, NULL, NULL, NULL, NULL),
(37, 'login', 'ln_password', 'Password', 'Contraseña', 'Passwort', 'Lozinka', NULL, NULL, NULL, NULL, NULL),
(38, 'login', 'ln_forgot_password', 'Forgot Password', 'Se te olvidó tu contraseña', 'Passwort vergessen', 'Zaboravili ste lozinku', NULL, NULL, NULL, NULL, NULL),
(39, 'forgot', 'fp_forgot_password', 'Forgot Password', 'Se te olvidó tu contraseña', 'Passwort vergessen', 'Zaboravili ste lozinku', NULL, NULL, NULL, NULL, NULL),
(40, 'forgot', 'fp_enter_email', 'Enter Email', 'Ingrese correo electrónico', 'Email eingeben', 'Unesite e-poštu', NULL, NULL, NULL, NULL, NULL),
(41, 'forgot', 'fp_email', 'Email', 'Correo electrónico', 'Email', 'E-mail', NULL, NULL, NULL, NULL, NULL),
(42, 'forgot', 'fp_login', 'Login', 'Iniciar sesión', 'Anmeldung', 'Prijaviti se', NULL, NULL, NULL, NULL, NULL),
(43, 'general', 'gn_submit', 'Submit', 'Enviar', 'Einreichen', 'Podnijeti', NULL, NULL, NULL, NULL, NULL),
(44, 'forgot', 'fp_sub_heading', 'Please enter your registered Email address.', 'Por favor ingrese su dirección de correo electrónico registrada.', 'Bitte geben Sie Ihre registrierte E-Mail-Adresse ein.', 'Unesite svoju registriranu adresu e-pošte.', NULL, NULL, NULL, NULL, NULL),
(45, 'Reset Password', 'rp_reset_password', 'Reset Password', 'Restablecer la contraseña', 'Passwort zurücksetzen', 'Resetiranje lozinke', NULL, NULL, NULL, NULL, NULL),
(46, 'Reset Password', 'rp_password', 'Password', 'Contraseña', 'Passwort', 'Lozinka', NULL, NULL, NULL, NULL, NULL),
(47, 'general', 'gn_confirm', 'Confirm', 'Confirmar', 'Bestätigen', 'Potvrda', NULL, NULL, NULL, NULL, NULL),
(48, 'general', 'gn_new_password', 'New Password', 'Nueva contraseña', 'Neues Kennwort', '\r\nNova lozinka', NULL, NULL, NULL, NULL, NULL),
(49, 'general', 'gn_confirm_password', 'Confirm Password', '\r\nConfirmar contraseña', 'Kennwort bestätigen', '\r\nPotvrdi lozinku', NULL, NULL, NULL, NULL, NULL),
(50, 'general', 'gn_login', 'Login', 'Iniciar sesión', 'Anmeldung', 'Prijaviti se', NULL, NULL, NULL, NULL, NULL),
(51, 'general', 'gn_logout', 'Logout', 'Cerrar sesión', 'Ausloggen', 'Odjavite se', NULL, NULL, NULL, NULL, NULL),
(52, 'general', 'gn_profile', 'Profile', 'Perfil', 'Profil', 'Profil', NULL, NULL, NULL, NULL, NULL),
(53, 'general', 'gn_setting', 'Setting', 'Ajuste', 'Rahmen', 'Postavljanje', NULL, NULL, NULL, NULL, NULL),
(54, 'general', 'gn_my_profile', 'My Profile', 'Mi perfil', 'Mein Profil', 'Moj profil', NULL, NULL, NULL, NULL, NULL),
(55, 'general', 'gn_general_information', 'General Information', 'Información general', 'Allgemeine Information', 'Op?e informacije\r\n', NULL, NULL, NULL, NULL, NULL),
(56, 'general', 'gn_note', 'Note', 'Nota', 'Hinweis', 'Bilješka', NULL, NULL, NULL, NULL, NULL),
(57, 'general', 'gn_yes', 'Yes', 'si', 'Ja', 'Da', NULL, NULL, NULL, NULL, NULL),
(58, 'general', 'gn_no', 'No', 'No', 'Nein', 'Ne', NULL, NULL, NULL, NULL, NULL),
(59, 'general', 'gn_delete', 'Delete', 'Eliminar', 'Löschen', 'Izbrisati', NULL, NULL, NULL, NULL, NULL),
(60, 'general', 'gn_delete_prompt', 'Are you sure you want to delete', '¿Estás segura de que quieres eliminar', '\r\nSind Sie sicher, dass Sie löschen möchten', 'Jeste li sigurni da želite izbrisati', NULL, NULL, NULL, NULL, NULL),
(61, 'general', 'gn_status', 'Status', 'Estado', 'Status', 'Status', NULL, NULL, NULL, NULL, NULL),
(62, 'general', 'gn_select', 'Select', 'Seleccione', 'Wählen', 'Odaberi', NULL, NULL, NULL, NULL, NULL),
(63, 'general', 'gn_active', 'Active', 'Activo', 'Aktiv', 'Aktivan', NULL, NULL, NULL, NULL, NULL),
(64, 'general', 'gn_inactive', 'Inactive', 'Inactivo', 'Inaktiv', 'Neaktivan', NULL, NULL, NULL, NULL, NULL),
(65, 'general', 'gn_name', 'Name', 'Nombre', 'Name', 'Ime', NULL, NULL, NULL, NULL, NULL),
(66, 'general', 'gn_search', 'Search', 'Buscar', 'Suche', 'Traži', NULL, NULL, NULL, NULL, NULL),
(67, 'general', 'gn_add_new', 'Add New', 'Agregar nuevo', 'Neue hinzufügen', 'Dodaj novi', NULL, NULL, NULL, NULL, NULL),
(68, 'general', 'gn_actions', 'Actions', 'Comportamiento', 'Aktionen', 'Akcije', NULL, NULL, NULL, NULL, NULL),
(69, 'general', 'gn_notes', 'Notes', 'Notas', 'Anmerkungen', 'Bilješke', NULL, NULL, NULL, NULL, NULL),
(70, 'general', 'gn_title', 'Title', 'Título', 'Titel', 'Titula', NULL, NULL, NULL, NULL, NULL),
(71, 'general', 'gn_phone', 'Phone', 'Teléfono', 'Telefon', 'Telefon', NULL, NULL, NULL, NULL, NULL),
(72, 'general', 'gn_gender', 'Gender', 'Género', 'Geschlecht', 'Rod', NULL, NULL, NULL, NULL, NULL),
(73, 'general', 'gn_edit_profile', 'Edit Profile', 'Editar perfil', 'Profil bearbeiten', 'Uredi profil', NULL, NULL, NULL, NULL, NULL),
(74, 'general', 'gn_change_password', 'Change Password', 'Cambia la contraseña', '\r\nPasswort ändern', 'Promijenite lozinku', NULL, NULL, NULL, NULL, NULL),
(75, 'general', 'gn_cancel', 'Cancel', 'Cancelar', 'Stornieren', 'Otkazati', NULL, NULL, NULL, NULL, NULL),
(76, 'general', 'gn_dob', 'Date of Birth', 'Fecha de nacimiento', 'Geburtsdatum', 'Datum rođenja', NULL, NULL, NULL, NULL, NULL),
(77, 'general', 'gn_old_password', 'Old Password', 'Contraseña anterior', 'Altes Kennwort', 'Stara lozinka', NULL, NULL, NULL, NULL, NULL),
(78, 'general', 'gn_government', 'Government', 'Gobierno', 'Regierung', 'Vlada', NULL, NULL, NULL, NULL, NULL),
(79, 'general', 'gn_last_name', 'Last Name', 'Apellido', 'Nachname', 'Prezime', NULL, NULL, NULL, NULL, NULL),
(80, 'general', 'gn_export', 'Export', 'Exportar', 'Export', 'Izvoz', NULL, NULL, NULL, NULL, NULL),
(81, 'general', 'gn_details', 'Details', 'Detalles', 'Einzelheiten', 'Detalji', NULL, NULL, NULL, NULL, NULL),
(82, 'general', 'gn_country', 'Country', 'País', 'Land', 'Zemlja', NULL, NULL, NULL, NULL, NULL),
(83, 'general', 'gn_state', 'State', 'Estado', 'Zustand', 'Država', NULL, NULL, NULL, NULL, NULL),
(84, 'general', 'gn_canton', 'Canton', 'Cantón', 'Kanton', 'Kanton', NULL, NULL, NULL, NULL, NULL),
(85, 'general', 'gn_address', 'Address', 'Habla a', 'Adresse', 'Adresa', NULL, NULL, NULL, NULL, NULL),
(86, 'general', 'gn_male', 'Male', 'Masculino', 'Männlich', 'Muški', NULL, NULL, NULL, NULL, NULL),
(87, 'general', 'gn_female', 'Female', 'Hembra', 'Weiblich', 'Žena', NULL, NULL, NULL, NULL, NULL),
(88, 'general', 'gn_edit', 'Edit', 'Editar', 'Bearbeiten', 'Uredi', NULL, NULL, NULL, NULL, NULL),
(89, 'general', 'gn_update', 'Update', 'Actualizar', 'Aktualisieren', 'Ažuriraj', NULL, NULL, NULL, NULL, NULL),
(90, 'general', 'gn_upload_photo', 'Upload Photo', 'Subir foto', 'Foto hochladen', 'Prenesite fotografiju', NULL, NULL, NULL, NULL, NULL),
(91, 'general', 'gn_add', 'Add', 'Añadir', 'Hinzufügen', 'Dodati', NULL, NULL, NULL, NULL, NULL),
(92, 'general', 'gn_enter', 'Enter', 'Entrar', 'Eingeben', 'Unesi', NULL, NULL, NULL, NULL, NULL),
(93, 'general', 'gn_genitive_name', 'Genitive Name', 'Nombre genitivo', 'Genitiv Name', 'Genitivno ime', NULL, NULL, NULL, NULL, NULL),
(94, 'general', 'gn_dative_name', 'Dative Name', 'Nombre dativo', 'Dativname', 'Ime dativa', NULL, NULL, NULL, NULL, NULL),
(95, 'general', 'gn_adjective_name', 'Adjective Name', 'Nombre Adjetivo', 'Adjektiv Name', 'Ime pridjeva', NULL, NULL, NULL, NULL, NULL),
(96, 'general', 'gn_town', 'Town', 'Pueblo', 'Stadt', 'Grad', NULL, NULL, NULL, NULL, NULL),
(97, 'general', 'gn_post_office', 'Post Office', 'Oficina postal', 'Post', 'Poštanski ured', NULL, NULL, NULL, NULL, NULL),
(98, 'general', 'gn_ownership_type', 'Ownership Type', 'Tipo de Propiedad', 'Eigentumstyp', 'Vrsta vlasništva', NULL, NULL, NULL, NULL, NULL),
(99, 'general', 'gn_started_year', 'Started Year', 'Año de inicio', 'Begonnenes Jahr', 'Počela godina', NULL, NULL, NULL, NULL, NULL),
(100, 'general', 'gn_year', 'Year', 'Año', 'Jahr', 'Godina', NULL, NULL, NULL, NULL, NULL),
(101, 'general', 'sidebar_nav_keywords', 'Keywords', 'Palabras clave', 'Schlüsselwörter', 'Ključne riječi', NULL, NULL, NULL, NULL, NULL),
(102, 'general', 'gn_university', 'University', 'Universidad', 'Universität', 'Sveučilište', NULL, NULL, NULL, NULL, NULL),
(103, 'general', 'gn_founded', 'Founded', 'Fundado', 'Gegründet', 'Osnovan', NULL, NULL, NULL, NULL, NULL),
(104, 'general', 'gn_belongs_to_university', 'Belongs to University', 'Pertenece a la universidad', 'Gehört zur Universität', 'Pripada Sveučilištu', NULL, NULL, NULL, NULL, NULL),
(105, 'general', 'gn_name_roman', 'Name Roman', 'Nombre romano', 'Name Roman', 'Ime Roman', NULL, NULL, NULL, NULL, NULL),
(106, 'general', 'gn_name_numeric', 'Name Numeric', 'Nombre romano', 'Name Numerisch', 'Ime brojčano', NULL, NULL, NULL, NULL, NULL),
(107, 'general', 'gn_language_key', 'Language Key', 'Clave de idioma', 'Sprachschlüssel', 'Jezični ključ', NULL, NULL, NULL, NULL, NULL),
(108, 'general', 'gn_language_name', 'Language Name', 'Nombre del lenguaje', 'Sprache Name', 'Naziv jezika', NULL, NULL, NULL, NULL, NULL),
(109, 'general', 'gn_section', 'Section', 'Sección', 'Sektion', 'Odjeljak', NULL, NULL, NULL, NULL, NULL),
(110, 'general', 'gn_translation_key', 'Translation Key', 'Clave de traducción', 'Übersetzungsschlüssel', 'Prijevodni ključ', NULL, NULL, NULL, NULL, NULL),
(111, 'general', 'sidebar_nav_logs', 'Logs', 'Registros', 'Protokolle', 'Drva', NULL, NULL, NULL, NULL, NULL),
(112, 'general', 'gn_help', 'Help', 'Ayuda', 'Hilfe', 'Pomozite', NULL, NULL, NULL, NULL, NULL),
(113, 'general', 'gn_parents', 'Parents', 'Padres', 'Eltern', 'Roditelji', NULL, NULL, NULL, NULL, NULL),
(114, 'general', 'gn_super_admin', 'Super Admin', 'Super Administrador', 'Höchster Vorgesetzter', 'Super Admin', NULL, NULL, NULL, NULL, NULL),
(115, 'sidebar', 'sidebar_nav_nationalities', 'Nationalities', 'Nacionalidades', 'Nationalitäten', 'Nacionalnosti', NULL, NULL, NULL, NULL, NULL),
(116, 'sidebar', 'sidebar_nav_religions', 'Religions', 'Religiones', 'Religionen', 'Religije', NULL, NULL, NULL, NULL, NULL),
(117, 'sidebar', 'sidebar_nav_vocations', 'Vocations', 'Vocaciones', 'Berufungen', 'Zvanja', NULL, NULL, NULL, NULL, NULL),
(118, 'general', 'sidebar_nav_country_citizenship', 'Country Name & Citizenship', 'Nombre del país y ciudadanía', 'Ländername & Staatsbürgerschaft', 'Naziv države i državljanstvo', NULL, NULL, NULL, NULL, NULL),
(119, 'sidebar', 'sidebar_nav_school_year', 'School Year', 'Año escolar', 'Schuljahr', 'Školska godina', NULL, NULL, NULL, NULL, NULL),
(120, 'sidebar', 'sidebar_nav_education_periods', 'Education Periods', 'Periodos Educativos', 'Bildungsperioden', 'Razdoblje obrazovanja', NULL, NULL, NULL, NULL, NULL),
(121, 'sidebar', 'sidebar_nav_student_masters', 'Student Masters', 'Maestros estudiantes', 'Student Masters', 'Student Masters', NULL, NULL, NULL, NULL, NULL),
(122, 'sidebar', 'sidebar_nav_behaviour', 'Behaviour', 'Comportamiento', 'Verhalten', 'Ponašanje', NULL, NULL, NULL, NULL, NULL),
(123, 'sidebar', 'sidebar_nav_ecat', 'Extracurricular Activity Type', 'Tipo de actividad extracurricular', 'Art der außerschulischen Aktivität', 'Vrsta izvannastavne aktivnosti', NULL, NULL, NULL, NULL, NULL),
(124, 'sidebar', 'sidebar_nav_dmt', 'Discipline Measure Types', 'Tipos de medidas disciplinarias', 'Arten von Disziplinarmaßnahmen', 'Vrste disciplinskih mjera', NULL, NULL, NULL, NULL, NULL),
(125, 'sidebar', 'sidebar_nav_course_groups', 'Student Teaching Groups', 'Grupos de cursos', 'Kursgruppen', 'Učeničke skupine', NULL, NULL, NULL, NULL, NULL),
(126, 'sidebar', 'sidebar_nav_flg', 'Foreign Language Groups', 'Grupos de lenguas extranjeras', 'Fremdsprachengruppen', 'Grupe stranih jezika', NULL, NULL, NULL, NULL, NULL),
(127, 'sidebar', 'sidebar_nav_ocg', 'Optional Courses Groups', 'Cursos opcionales Grupos', 'Optionale Kursgruppen', 'Izborni tečajevi grupe', NULL, NULL, NULL, NULL, NULL),
(128, 'sidebar', 'sidebar_nav_fcg', 'Facultative Courses Groups', 'Cursos Facultativos Grupos', 'Fakultativkursgruppen', 'Fakultativni tečajevi grupe', NULL, NULL, NULL, NULL, NULL),
(129, 'sidebar', 'sidebar_nav_gpg', 'General Purpose Groups', 'Grupos de uso general', 'Allzweckgruppen', 'Grupe opće namjene', NULL, NULL, NULL, NULL, NULL),
(130, 'sidebar', 'sidebar_nav_education_program', 'Education Program', 'Programa educativo', 'Erziehungsprogramm', 'Obrazovni program', NULL, NULL, NULL, NULL, NULL),
(131, 'sidebar', 'sidebar_nav_school_management', 'School Management', 'Gerencia escolar', 'Schulverwaltung', 'Uprava škole', NULL, NULL, NULL, NULL, NULL),
(132, 'sidebar', 'sidebar_nav_attendance', 'Attendance', 'Asistencia', 'Teilnahme', 'Pohađanje', NULL, NULL, NULL, NULL, NULL),
(133, 'general', 'gn_privilages', 'Privilages', 'Privilegios', 'Privilegien', 'Privilegije', NULL, NULL, NULL, NULL, NULL),
(134, 'general', 'gn_sub_admin', 'Sub Admin', 'Subadministrador', 'Sub Admin', 'Pod Administrator', NULL, NULL, NULL, NULL, NULL),
(135, 'general', 'gn_name_of_males', 'Name of Males', 'Nombre de los hombres', 'Name der Männer', 'Ime mužjaka', NULL, NULL, NULL, NULL, NULL),
(136, 'general', 'gn_name_of_females', 'Name of Females', 'Nombre de las hembras', 'Name der Frauen', 'Ime ženki', NULL, NULL, NULL, NULL, NULL),
(137, 'general', 'gn_citizenships', 'Citizenships', 'Ciudadanías', 'Staatsbürgerschaften', 'Državljanstva', NULL, NULL, NULL, NULL, NULL),
(138, 'general', 'gn_name_character', 'Name Character', 'Nombre Carácter', 'Name Zeichen', 'Znak znaka', NULL, NULL, NULL, NULL, NULL),
(139, 'general', 'gn_alternative_name', 'Alternative Name', 'Nombre alternativo', 'Alternativer Name', 'Alternativno ime', NULL, NULL, NULL, NULL, NULL),
(140, 'general', 'gn_general', 'General', 'General', 'Allgemeines', 'Općenito', NULL, NULL, NULL, NULL, NULL),
(141, 'general', 'gn_specialization', 'Specialization', 'Especialización', 'Spezialisierung', 'Specijalizacija', NULL, NULL, NULL, NULL, NULL),
(142, 'general', 'gn_is_foreign_language', 'Is it a Foreign Language', '¿Es un idioma extranjero?', 'Ist es eine Fremdsprache?', 'Je li to strana jezik', NULL, NULL, NULL, NULL, NULL),
(143, 'sidebar', 'sidebar_nav_student_behaviour', 'Student Behaviour', 'Comportamiento estudiantil', 'Verhalten der Schüler', 'Ponašanje učenika', NULL, NULL, NULL, NULL, NULL),
(144, 'message', 'msg_email_not_verified', 'Your email is not verified, a verification link has been sent to your email', 'Su correo electrónico no está verificado, se ha enviado un enlace de verificación a su correo electrónico', 'Ihre E-Mail wird nicht verifiziert, ein Bestätigungslink wurde an Ihre E-Mail gesendet', 'Vaša e-pošta nije potvrđena, na vašu e-poštu poslana je veza za potvrdu', NULL, NULL, NULL, NULL, NULL),
(145, 'message', 'msg_account_inactive', 'Your account is inactive, please try again after sometime', 'Su cuenta está inactiva, intente nuevamente después de un tiempo', 'Ihr Konto ist inaktiv. Bitte versuchen Sie es nach einiger Zeit erneut', 'Vaš je račun neaktivan. Pokušajte ponovo nešto kasnije', NULL, NULL, NULL, NULL, NULL),
(146, 'validation', 'msg_invalid_password', 'Please enter a valid password', 'Por favor ingrese una contraseña válida', 'Bitte geben Sie ein gültiges Passwort ein', 'Molimo unesite važeću lozinku', NULL, NULL, NULL, NULL, NULL),
(147, 'message', 'msg_email_verify_success', 'Thank you, your email has been verified', 'Gracias, tu email ha sido verificado', 'Vielen Dank, Ihre E-Mail wurde bestätigt', 'Hvala, potvrđena je adresa e-pošte', NULL, NULL, NULL, NULL, NULL),
(148, 'message', 'msg_email_already_verify', 'Your email is already verified. You can login at', 'Tu correo electrónico ya está verificado. Puedes iniciar sesión en', 'Ihre E-Mail-Adresse wurde bereits überprüft. Sie können sich unter anmelden', 'Vaša je e-pošta već potvrđena. Možete se prijaviti na', NULL, NULL, NULL, NULL, NULL),
(149, 'message', 'msg_reset_pass_link_expire', 'Sorry, the reset password link is expired please try again', 'Lo sentimos, el enlace para restablecer contraseña ha caducado, por favor intente nuevamente', 'Entschuldigung, der Link zum Zurücksetzen des Passworts ist abgelaufen. Bitte versuchen Sie es erneut', 'Nažalost, veza za resetiranje zaporke je istekla, pokušajte ponovo', NULL, NULL, NULL, NULL, NULL),
(150, 'message', 'msg_forgot_pass_success', 'A password reset link has been sent on your registered Email address', 'Se ha enviado un enlace de restablecimiento de contraseña a su dirección de correo electrónico registrada', 'Ein Link zum Zurücksetzen des Passworts wurde an Ihre registrierte E-Mail-Adresse gesendet', 'Veza na poništavanje zaporke poslana je na vašu registriranu adresu e-pošte', NULL, NULL, NULL, NULL, NULL),
(151, 'message', 'msg_forgot_pass_fail', 'Sorry, we can not find this email id the system. Please try again later', 'Lo sentimos, no podemos encontrar este correo electrónico en el sistema. Por favor, inténtelo de nuevo más tarde', 'Leider können wir diese E-Mail-ID im System nicht finden. Bitte versuchen Sie es später noch einmal', 'Nažalost, ne možemo pronaći ovaj sustav e-pošte. Molimo pokušajte ponovo kasnije', NULL, NULL, NULL, NULL, NULL),
(152, 'general', 'gn_next', 'Next', 'Próxima', 'Nächster', 'Sljedeći', NULL, NULL, NULL, NULL, NULL),
(153, 'general', 'gn_previous', 'Previous', 'Previo', 'Bisherige', 'Prijašnji', NULL, NULL, NULL, NULL, NULL),
(154, 'general', 'gn_showing', 'Showing', 'Demostración', 'Zeigen', 'Pokazivanje', NULL, NULL, NULL, NULL, NULL),
(155, 'general', 'gn_entries', 'entries', 'entradas', 'einträge', 'unosi', NULL, NULL, NULL, NULL, NULL),
(156, 'general', 'gn_to', 'to', 'a', 'zu', 'do', NULL, NULL, NULL, NULL, NULL),
(157, 'general', 'gn_of', 'of', 'de', 'von', 'od', NULL, NULL, NULL, NULL, NULL),
(158, 'general', 'gn_show', 'Show', 'Show', 'Show', 'Pokazati', NULL, NULL, NULL, NULL, NULL),
(159, 'general', 'gn_access', 'Access', 'Acceso', 'Zugriff', 'Pristup', NULL, NULL, NULL, NULL, NULL),
(160, 'general', 'gn_grade', 'Grade', 'Grado', 'Klasse', 'Razred', NULL, NULL, NULL, NULL, NULL),
(161, 'general', 'gn_mandatory_courses', 'Mandatory Courses', 'Cursos obligatorios', 'Pflichtkurse', 'Obvezni tečajevi', NULL, NULL, NULL, NULL, NULL),
(162, 'general', 'gn_courses', 'Courses', 'Cursos', 'Kurse', 'Tečajevi', NULL, NULL, NULL, NULL, NULL),
(163, 'general', 'gn_hours', 'Hours', 'Horas', 'Std', 'Sati', NULL, NULL, NULL, NULL, NULL),
(164, 'general', 'gn_for', 'for', 'para', 'zum', 'za', NULL, NULL, NULL, NULL, NULL),
(165, 'general', 'gn_optional_courses', 'Optional Courses', 'Cursos opcionales', 'Optionale Kurse', 'Fakultativni tečajevi', NULL, NULL, NULL, NULL, NULL),
(166, 'general', 'gn_mandatory_foreign_language_courses', 'Mandatory Foreign Language Courses', 'Cursos obligatorios de lenguas extranjeras', 'Obligatorische Fremdsprachenkurse', 'Obvezni tečajevi stranih jezika', NULL, NULL, NULL, NULL, NULL),
(167, 'general', 'gn_action', 'Action', 'Acción', 'Aktion', 'Radnja', NULL, NULL, NULL, NULL, NULL),
(168, 'validation', 'validate_hours', 'Please add hours', 'Por favor agregue horas', 'Bitte Stunden hinzufügen', 'Dodajte radno vrijeme', NULL, NULL, NULL, NULL, NULL),
(169, 'validation', 'validate_OCG', 'Please select an Optional Language Course', 'Por favor seleccione un curso de idiomas opcional', 'Bitte wählen Sie einen optionalen Sprachkurs', 'Odaberite izborni jezični tečaj', NULL, NULL, NULL, NULL, NULL),
(170, 'validation', 'validate_FCG', 'Please select a Foreign Language Course', 'Por favor seleccione un curso de idioma extranjero', 'Bitte wählen Sie einen Fremdsprachenkurs', 'Odaberite tečaj stranih jezika', NULL, NULL, NULL, NULL, NULL),
(171, 'validation', 'validate_MCG', 'Please select a Mandatory Language Course', 'Por favor seleccione un curso de idioma obligatorio', 'Bitte wählen Sie einen obligatorischen Sprachkurs', 'Odaberite obavezni tečaj jezika', NULL, NULL, NULL, NULL, NULL),
(172, 'general', 'gn_view_courses', 'View Courses', 'Ver cursos', 'Kurse anzeigen', 'Pogledajte tečajeve', NULL, NULL, NULL, NULL, NULL),
(173, 'message', 'msg_education_plan_update_success', 'Education Plan Successfully Updated', 'Plan educativo actualizado con éxito', 'Bildungsplan erfolgreich aktualisiert', 'Obrazovni plan uspješno je ažuriran', NULL, NULL, NULL, NULL, NULL),
(174, 'message', 'msg_education_plan_add_success', 'Education Plan Successfully Added', 'Plan de educación agregado con éxito', 'Bildungsplan erfolgreich hinzugefügt', 'Obrazovni plan uspješno je dodan', NULL, NULL, NULL, NULL, NULL),
(175, 'message', 'msg_something_wrong', 'Something Wrong Please try again Later', 'Algo está mal. Por favor, intente nuevamente más tarde.', 'Etwas falsch Bitte versuchen Sie es später erneut', 'Nešto nije u redu. Pokušajte ponovo kasnije', NULL, NULL, NULL, NULL, NULL),
(176, 'validation', 'validate_field_required', 'This field is required', 'este campo es requerido', 'Dieses Feld wird benötigt', 'ovo polje je obavezno', NULL, NULL, NULL, NULL, NULL),
(177, 'validation', 'validate_email_field', 'Please enter a valid email address.', 'Por favor, introduce una dirección de correo electrónico válida', 'Bitte geben Sie eine gültige E-Mail-Adresse ein.', 'Unesite valjanu adresu e-pošte.', NULL, NULL, NULL, NULL, NULL),
(178, 'validation', 'validate_minlength', 'Please enter at least {0} characters.', 'Ingrese al menos {0} caracteres.', 'Bitte geben Sie mindestens {0} Zeichen ein.', 'Unesite najmanje {0} znakova.', NULL, NULL, NULL, NULL, NULL),
(179, 'validation', 'validate_maxlength', 'Please enter no more than {0} characters.', 'Ingrese no más de {0} caracteres.', 'Bitte geben Sie nicht mehr als {0} Zeichen ein.', 'Unesite najviše {0} znakova.', NULL, NULL, NULL, NULL, NULL),
(180, 'validation', 'validate_password', 'The password must be a combination of characters, numbers, one uppercase letter and special characters', 'La contraseña debe ser una combinación de caracteres, números, una letra mayúscula y caracteres especiales.', 'Das Passwort muss eine Kombination aus Zeichen, Zahlen, einem Großbuchstaben und Sonderzeichen sein', 'Zaporka mora biti kombinacija znakova, brojeva, jednog velikog slova i posebnih znakova', NULL, NULL, NULL, NULL, NULL),
(181, 'validation', 'validate_password_equalto', 'New password and Confirm password does not match', 'Nueva contraseña y Confirmar contraseña no coincide', 'Neues Passwort und Passwort bestätigen stimmen nicht überein', 'Nova lozinka i Potvrdi zaporku ne odgovaraju', NULL, NULL, NULL, NULL, NULL),
(182, 'validation', 'validate_equalto', 'Please enter the same value again', 'Por favor, introduzca el mismo valor de nuevo', 'Bitte geben Sie den gleichen Wert erneut ein', 'Molimo unesite istu vrijednost ponovo', NULL, NULL, NULL, NULL, NULL),
(183, 'message', 'msg_name_already_exist', 'already exists with this name', 'ya existe con este nombre', 'existiert bereits mit diesem Namen', 'već postoji s tim imenom', NULL, NULL, NULL, NULL, NULL),
(184, 'general', 'gn_school', 'School', 'Colegio', 'Schule', 'Škola', NULL, NULL, NULL, NULL, NULL),
(185, 'general', 'gn_ministry_license_number', 'Ministry License Number', 'Número de licencia del ministerio', 'Lizenznummer des Ministeriums', 'Broj licence Ministarstva', NULL, NULL, NULL, NULL, NULL),
(186, 'general', 'gn_parent_category', 'Parent Category', 'Categoría principal', 'Eltern-Kategorie', 'Kategorija roditelja', NULL, NULL, NULL, NULL, NULL),
(187, 'general', 'gn_child_category', 'Child Category', 'Categoría infantil', 'Untergeordnete Kategorie', 'Dječja kategorija', NULL, NULL, NULL, NULL, NULL),
(188, 'general', 'gn_education_plan', 'Education Plan', 'Plan Educativo', 'Bildungsplan', 'Plan obrazovanja', NULL, NULL, NULL, NULL, NULL),
(189, 'general', 'gn_school_coordinator', 'School Coordinator', 'Coordinador escolar', 'Schulkoordinator', 'Koordinator škole', NULL, NULL, NULL, NULL, NULL),
(190, 'message', 'msg_email_already_registered', 'The email is already registered in the system', 'El correo electrónico ya está registrado en el sistema.', 'Die E-Mail ist bereits im System registriert', 'E-adresa je već registrirana u sustavu', NULL, NULL, NULL, NULL, NULL),
(191, 'message', 'msg_email_already_exist', 'already exists with this email', 'ya existe con este correo electrónico', 'existiert bereits mit dieser E-Mail', 'već postoji s ovom e-poštom', NULL, NULL, NULL, NULL, NULL),
(192, 'message', 'msg_school_add_success', 'School Successfully Added', 'Escuela agregada exitosamente', 'Schule erfolgreich hinzugefügt', 'Škola je uspješno dodana', NULL, NULL, NULL, NULL, NULL),
(193, 'general', 'gn_roles', 'Roles', 'Roles', 'Rollen', 'Uloge', NULL, NULL, NULL, NULL, NULL),
(194, 'general', 'gn_ministry_super_admin', 'Ministry Super Admin', 'Ministry Super Admin', 'Ministerium Super Admin', 'Ministarstvo Super Admin', NULL, NULL, NULL, NULL, NULL),
(195, 'general', 'gn_teacher', 'Teacher', 'Profesor', 'Lehrer', 'Učitelj', NULL, NULL, NULL, NULL, NULL),
(196, 'general', 'gn_logged_in_as', 'You are logged in as', 'Has iniciado sesión como', 'Du bist eingeloggt als', 'Prijavljeni ste kao', NULL, NULL, NULL, NULL, NULL),
(197, 'message', 'msg_ministry_add_success', 'Ministry Successfully Added', 'Ministerio agregado con éxito', 'Ministerium erfolgreich hinzugefügt', 'Ministarstvo uspješno je dodano', NULL, NULL, NULL, NULL, NULL),
(198, 'message', 'msg_govt_id_exist', 'The Government Id already exists, Please try with a different Government Id', 'El ID de gobierno ya existe. Intente con un ID de gobierno diferente.', 'Die Regierungs-ID ist bereits vorhanden. Bitte versuchen Sie es mit einer anderen Regierungs-ID', 'ID vlade već postoji, pokušajte drugi vladin identitet', NULL, NULL, NULL, NULL, NULL),
(199, 'message', 'msg_email_exist', 'Email already exists, please try a different email', 'El correo electrónico ya existe, intente con un correo electrónico diferente', 'E-Mail existiert bereits, bitte versuchen Sie es mit einer anderen E-Mail', 'E-pošta već postoji, pokušajte s drugom e-poštom', NULL, NULL, NULL, NULL, NULL),
(200, 'message', 'msg_ministry_admin_exist', 'Ministry Admin already exists with this name', 'El administrador del ministerio ya existe con este nombre', 'Der Ministerialadministrator existiert bereits mit diesem Namen', 'Ministarstvo Admin već postoji s ovim imenom', NULL, NULL, NULL, NULL, NULL),
(201, 'message', 'msg_ministry_update_success', 'Ministry Successfully Updated', 'Ministerio actualizado con éxito', 'Ministerium erfolgreich aktualisiert', 'Ministarstvo je uspješno ažurirano', NULL, NULL, NULL, NULL, NULL),
(202, 'message', 'msg_academic_degree_update_success', 'Academic Degree Successfully Updated', 'Título académico actualizado con éxito', 'Akademischer Abschluss erfolgreich aktualisiert', 'Akademska diploma uspješno je ažurirana', NULL, NULL, NULL, NULL, NULL),
(203, 'message', 'msg_academic_degree_add_success', 'Academic Degree Successfully Added', 'Título académico agregado con éxito', 'Akademischer Abschluss erfolgreich hinzugefügt', 'Uspješno dodan akademski stupanj', NULL, NULL, NULL, NULL, NULL),
(204, 'message', 'msg_academic_degree_exist', 'Academic Degree already exists with this name', 'El título académico ya existe con este nombre', 'Mit diesem Namen existiert bereits ein akademischer Abschluss', 'Akademska diploma već postoji s ovim nazivom', NULL, NULL, NULL, NULL, NULL),
(205, 'message', 'msg_profile_update_success', 'Profile Successfully updated', 'Perfil actualizado con éxito', 'Profil erfolgreich aktualisiert', 'Profil je uspješno ažuriran', NULL, NULL, NULL, NULL, NULL),
(206, 'message', 'msg_canton_exist', 'Canton already exists with this name', 'Canton ya existe con este nombre', 'Kanton existiert bereits mit diesem Namen', 'Kanton već postoji s ovim imenom', NULL, NULL, NULL, NULL, NULL),
(207, 'message', 'msg_canton_add_success', 'Canton Successfully Added', 'Cantón agregado con éxito', 'Kanton erfolgreich hinzugefügt', 'Kanton je uspješno dodan', NULL, NULL, NULL, NULL, NULL),
(208, 'message', 'msg_citizenship_exist', 'Citizenship already exists with this name', 'La ciudadanía ya existe con este nombre', 'Die Staatsbürgerschaft besteht bereits unter diesem Namen', 'Državljanstvo već postoji s tim imenom', NULL, NULL, NULL, NULL, NULL),
(209, 'message', 'msg_citizenship_update_success', 'Citizenship Successfully Updated', 'Ciudadanía actualizada con éxito', 'Staatsbürgerschaft erfolgreich aktualisiert', 'Državljanstvo je uspješno ažurirano', NULL, NULL, NULL, NULL, NULL),
(210, 'message', 'msg_citizenship_add_success', 'Citizenship Successfully Added', 'Ciudadanía agregada exitosamente', 'Staatsbürgerschaft erfolgreich hinzugefügt', 'Državljanstvo je uspješno dodano', NULL, NULL, NULL, NULL, NULL),
(211, 'message', 'msg_class_exist', 'Class already exists with this name', 'La clase ya existe con este nombre', 'Klasse existiert bereits mit diesem Namen', 'Klasa već postoji s ovim nazivom', NULL, NULL, NULL, NULL, NULL),
(212, 'message', 'msg_class_add_success', 'Class Successfully Added', 'Clase agregada exitosamente', 'Klasse erfolgreich hinzugefügt', 'Klasa uspješno dodana', NULL, NULL, NULL, NULL, NULL),
(213, 'message', 'msg_class_update_success', 'Class Successfully Updated', 'Clase actualizada con éxito', 'Klasse erfolgreich aktualisiert', 'Klasa uspješno ažurirana', NULL, NULL, NULL, NULL, NULL),
(214, 'message', 'msg_college_add_success', 'College Successfully Added', 'Colegio agregado con éxito', 'College erfolgreich hinzugefügt', 'Fakultet je uspješno dodan', NULL, NULL, NULL, NULL, NULL),
(215, 'message', 'msg_college_update_success', 'College Successfully Updated', 'Colegio actualizado con éxito', 'College erfolgreich aktualisiert', 'Koledž je uspješno ažuriran', NULL, NULL, NULL, NULL, NULL),
(216, 'message', 'msg_college_exist', 'College already exists with this name', 'La universidad ya existe con este nombre', 'College existiert bereits mit diesem Namen', 'Fakultet već postoji s ovim imenom', NULL, NULL, NULL, NULL, NULL),
(217, 'message', 'msg_country_exist', 'Country already exists with this name', 'País ya existe con este nombre', 'Land existiert bereits mit diesem Namen', 'Država već postoji s ovim imenom', NULL, NULL, NULL, NULL, NULL),
(218, 'message', 'msg_country_add_success', 'Country Successfully Added', 'País agregado con éxito', 'Land erfolgreich hinzugefügt', 'Država je uspješno dodana', NULL, NULL, NULL, NULL, NULL),
(219, 'message', 'msg_country_update_success', 'Country Successfully Updated', 'País actualizado con éxito', 'Land erfolgreich aktualisiert', 'Država je uspješno ažurirana', NULL, NULL, NULL, NULL, NULL),
(220, 'message', 'msg_course_exist', 'Course already exists with this name', 'El curso ya existe con este nombre', 'Kurs existiert bereits mit diesem Namen', 'Kurs već postoji s ovim imenom', NULL, NULL, NULL, NULL, NULL),
(221, 'message', 'msg_course_uid_exist', 'Course already exists with this UID', 'El curso ya existe con este UID', 'Kurs existiert bereits mit dieser UID', 'Tečaj već postoji s ovim UID-om', NULL, NULL, NULL, NULL, NULL),
(222, 'message', 'msg_course_add_success', 'Course Successfully Added', 'Curso agregado con éxito', 'Kurs erfolgreich hinzugefügt', 'Tečaj je uspješno dodan', NULL, NULL, NULL, NULL, NULL),
(223, 'message', 'msg_course_update_success', 'Course Successfully Updated', 'Curso actualizado con éxito', 'Kurs erfolgreich aktualisiert', 'Tečaj je uspješno ažuriran', NULL, NULL, NULL, NULL, NULL),
(224, 'general', 'gn_type', 'Type', 'Tipo', 'Art', 'Tip', NULL, NULL, NULL, NULL, NULL),
(225, 'message', 'msg_education_period_exist', 'Education Period already exists with this name', 'El período de educación ya existe con este nombre', 'Ausbildungszeit besteht bereits mit diesem Namen', 'Obrazovno razdoblje već postoji s ovim nazivom', NULL, NULL, NULL, NULL, NULL),
(226, 'message', 'msg_education_period_add_success', 'Education Period Successfully Added', 'Período de educación agregado con éxito', 'Ausbildungszeit erfolgreich hinzugefügt', 'Razdoblje obrazovanja uspješno je dodano', NULL, NULL, NULL, NULL, NULL),
(227, 'message', 'msg_education_period_update_success', 'Education Period Successfully Updated', 'Período de educación actualizado con éxito', 'Ausbildungszeit erfolgreich aktualisiert', 'Razdoblje obrazovanja uspješno je ažurirano', NULL, NULL, NULL, NULL, NULL),
(228, 'message', 'msg_education_program_exist', 'Education Program already exists with this name', 'El programa educativo ya existe con este nombre', 'Bildungsprogramm existiert bereits mit diesem Namen', 'Obrazovni program već postoji s ovim nazivom', NULL, NULL, NULL, NULL, NULL),
(229, 'message', 'msg_education_program_add_success', 'Education Program Successfully Added', 'Programa educativo agregado con éxito', 'Bildungsprogramm erfolgreich hinzugefügt', 'Obrazovni program uspješno je dodan', NULL, NULL, NULL, NULL, NULL),
(230, 'message', 'msg_education_program_update_success', 'Education Program Successfully Updated', 'Programa educativo actualizado con éxito', 'Bildungsprogramm erfolgreich aktualisiert', 'Obrazovni program uspješno je ažuriran', NULL, NULL, NULL, NULL, NULL),
(231, 'message', 'msg_extracurricular_add_success', 'Extracurricular Activity Successfully Added', 'Actividad extracurricular agregada con éxito', 'Außerschulische Aktivität erfolgreich hinzugefügt', 'Izvannastavne aktivnosti uspješno su dodane', NULL, NULL, NULL, NULL, NULL),
(232, 'message', 'msg_extracurricular_update_success', 'Extracurricular Activity Successfully Updated', 'Actividad extracurricular actualizada con éxito', 'Außerschulische Aktivität erfolgreich aktualisiert', 'Izvannastavne aktivnosti uspješno su ažurirane', NULL, NULL, NULL, NULL, NULL),
(233, 'message', 'msg_extracurricular_exist', 'Extracurricular activity already exists with this name', 'La actividad extracurricular ya existe con este nombre.', 'Unter diesem Namen gibt es bereits außerschulische Aktivitäten', 'Izvannastavne aktivnosti već postoje s ovim nazivom', NULL, NULL, NULL, NULL, NULL),
(234, 'message', 'msg_vocation_exist', 'Vocation already exists with this name', 'La vocación ya existe con este nombre', 'Berufung existiert bereits mit diesem Namen', 'Zvanje već postoji s tim imenom', NULL, NULL, NULL, NULL, NULL),
(235, 'message', 'msg_vocation_add_success', 'Vocation Successfully Added', 'Vocación añadida con éxito', 'Berufung erfolgreich hinzugefügt', 'Zvanje je uspješno dodano', NULL, NULL, NULL, NULL, NULL),
(236, 'message', 'msg_vocation_update_success', 'Vocation Successfully Updated', 'Vocación actualizada con éxito', 'Berufung erfolgreich aktualisiert', 'Zvanje je uspješno ažurirano', NULL, NULL, NULL, NULL, NULL),
(237, 'message', 'msg_fcg_exist', 'Facultative Courses Group already exists with this name', 'El grupo de cursos facultativos ya existe con este nombre', 'Die Fakultätskursgruppe existiert bereits mit diesem Namen', 'Grupa fakultativnih tečajeva već postoji s ovim nazivom', NULL, NULL, NULL, NULL, NULL),
(238, 'message', 'msg_fcg_add_success', 'Facultative Courses Group Successfully Added', 'Grupo de cursos facultativos agregado con éxito', 'Fakultativkursgruppe erfolgreich hinzugefügt', 'Skupina fakultativnih tečajeva uspješno je dodana', NULL, NULL, NULL, NULL, NULL),
(239, 'message', 'msg_fcg_update_success', 'Facultative Courses Group Successfully Updated', 'Grupo de cursos facultativos actualizado con éxito', 'Fakultativkursgruppe erfolgreich aktualisiert', 'Grupa fakultativnih tečajeva uspješno je ažurirana', NULL, NULL, NULL, NULL, NULL),
(240, 'message', 'msg_gpg_exist', 'General Purpose Group already exists with this name', 'El grupo de propósito general ya existe con este nombre', 'Die Allzweckgruppe existiert bereits mit diesem Namen', 'Grupa s općom namjenom već postoji s ovim nazivom', NULL, NULL, NULL, NULL, NULL),
(241, 'message', 'msg_gpg_add_success', 'General Purpose Group Successfully Added', 'Grupo de propósito general agregado con éxito', 'Allzweckgruppe erfolgreich hinzugefügt', 'Grupa opće namjene uspješno je dodana', NULL, NULL, NULL, NULL, NULL),
(242, 'message', 'msg_gpg_update_success', 'General Purpose Group Successfully Updated', 'Grupo de propósito general actualizado con éxito', 'Allzweckgruppe erfolgreich aktualisiert', 'Grupa opće namjene uspješno je ažurirana', NULL, NULL, NULL, NULL, NULL),
(243, 'message', 'msg_ocg_exist', 'Optional Courses Group already exists with this name', 'El grupo de cursos opcionales ya existe con este nombre', 'Die optionale Kursgruppe existiert bereits mit diesem Namen', 'Grupa neobaveznih tečajeva već postoji s ovim nazivom', NULL, NULL, NULL, NULL, NULL),
(244, 'message', 'msg_ocg_add_success', 'General Purpose Group Successfully Added', 'Cursos opcionales Grupo agregado con éxito', 'Optionale Kursgruppe erfolgreich hinzugefügt', 'Grupa sa dodatnim predmetima uspješno dodana', NULL, NULL, NULL, NULL, NULL),
(245, 'message', 'msg_ocg_update_success', 'Optional Courses Group Successfully Updated', 'Grupo de cursos opcionales actualizado con éxito', 'Optionale Kursgruppe erfolgreich aktualisiert', 'Grupa neobaveznih tečajeva uspješno je ažurirana', NULL, NULL, NULL, NULL, NULL),
(246, 'message', 'msg_flg_exist', 'Foreign Language Group already exists with this name', 'El grupo de idiomas extranjeros ya existe con este nombre', 'Unter diesem Namen existiert bereits eine Fremdsprachengruppe', 'Grupa stranih jezika već postoji s ovim nazivom', NULL, NULL, NULL, NULL, NULL),
(247, 'message', 'msg_flg_add_success', 'Foreign Language Group Successfully Added', 'Grupo de idiomas extranjeros agregado con éxito', 'Fremdsprachengruppe erfolgreich hinzugefügt', 'Grupa stranih jezika uspješno je dodana', NULL, NULL, NULL, NULL, NULL),
(248, 'message', 'msg_flg_update_success', 'Foreign Language Group Successfully Updated', 'Grupo de idiomas extranjeros actualizado con éxito', 'Fremdsprachengruppe erfolgreich aktualisiert', 'Grupa stranih jezika uspješno je ažurirana', NULL, NULL, NULL, NULL, NULL),
(249, 'message', 'msg_behaviour_exist', 'Student Behavior already exists with this name', 'El comportamiento del estudiante ya existe con este nombre', 'Schülerverhalten existiert bereits mit diesem Namen', 'Ponašanje učenika već postoji s ovim imenom', NULL, NULL, NULL, NULL, NULL),
(250, 'message', 'msg_behaviour_update_success', 'Student Behavior Successfully Updated', 'Comportamiento del estudiante actualizado con éxito', 'Schülerverhalten erfolgreich aktualisiert', 'Ponašanje učenika uspješno je ažurirano', NULL, NULL, NULL, NULL, NULL),
(251, 'message', 'msg_behaviour_add_success', 'Student Behavior Successfully Added', 'Comportamiento del estudiante agregado con éxito', 'Schülerverhalten erfolgreich hinzugefügt', 'Ponašanje učenika uspješno je dodano', NULL, NULL, NULL, NULL, NULL),
(252, 'message', 'msg_dmt_exist', 'Discipline Measures Type Successfully Added', 'Tipo de medidas disciplinarias agregadas con éxito', 'Typ der Disziplinarmaßnahmen erfolgreich hinzugefügt', 'Vrsta disciplinskih mjera uspješno je dodana', NULL, NULL, NULL, NULL, NULL),
(253, 'message', 'msg_dmt_add_success', 'Discipline Measures Type Successfully Added', 'Tipo de medidas disciplinarias agregadas con éxito', 'Typ der Disziplinarmaßnahmen erfolgreich hinzugefügt', 'Vrsta disciplinskih mjera uspješno je dodana', NULL, NULL, NULL, NULL, NULL),
(254, 'message', 'msg_dmt_update_success', 'Discipline Measures Type Successfully Updated', 'Tipo de medidas disciplinarias actualizado con éxito', 'Typ der Disziplinarmaßnahmen erfolgreich aktualisiert', 'Vrsta disciplinskih mjera uspješno je ažurirana', NULL, NULL, NULL, NULL, NULL),
(255, 'general', 'gn_dummy_optional_course', 'Dummy Optional Course', 'Curso opcional ficticio', 'Dummy Optionaler Kurs', 'Glupi izborni tečaj', NULL, NULL, NULL, NULL, NULL),
(256, 'general', 'gn_dummy_foreign_course', 'Dummy Foreign Course', 'Curso Extranjero Ficticio', 'Dummy Foreign Course', 'Tečaj stranog lutke', NULL, NULL, NULL, NULL, NULL),
(257, 'message', 'msg_ownership_type_exist', 'Ownership Type already exists with this name', 'El tipo de propiedad ya existe con este nombre', 'Der Besitzertyp existiert bereits mit diesem Namen', 'Vrsta vlasništva već postoji s ovim nazivom', NULL, NULL, NULL, NULL, NULL),
(258, 'message', 'msg_ownership_type_add_success', 'Ownership Type Successfully Added', 'Tipo de propiedad agregado con éxito', 'Eigentümertyp erfolgreich hinzugefügt', 'Vrsta vlasništva uspješno je dodana', NULL, NULL, NULL, NULL, NULL),
(259, 'message', 'msg_ownership_type_update_success', 'Ownership Type Successfully Updated', 'Tipo de propiedad actualizado con éxito', 'Eigentümertyp Erfolgreich aktualisiert', 'Vrsta vlasništva uspješno je ažurirana', NULL, NULL, NULL, NULL, NULL),
(260, 'message', 'msg_grade_exist', 'Grade already exists with this name', 'El grado ya existe con este nombre', 'Note existiert bereits mit diesem Namen', 'Ocjena već postoji s ovim imenom', NULL, NULL, NULL, NULL, NULL),
(261, 'message', 'msg_grade_add_success', 'Grade Successfully Added', 'Calificación agregada exitosamente', 'Note erfolgreich hinzugefügt', 'Ocjena je uspješno dodana', NULL, NULL, NULL, NULL, NULL),
(262, 'message', 'msg_grade_update_success', 'Grade Successfully Updated', 'Calificación actualizada con éxito', 'Note erfolgreich aktualisiert', 'Ocjena je uspješno ažurirana', NULL, NULL, NULL, NULL, NULL),
(263, 'message', 'msg_job_work_exist', 'Job work already exists with this name', 'El trabajo de trabajo ya existe con este nombre', 'Unter diesem Namen gibt es bereits eine Arbeit', 'Posao već postoji s ovim imenom', NULL, NULL, NULL, NULL, NULL),
(264, 'message', 'msg_job_work_add_success', 'Job Work Successfully Added', 'Trabajo trabajo agregado con éxito', 'Jobarbeit erfolgreich hinzugefügt', 'Posao je uspješno dodan', NULL, NULL, NULL, NULL, NULL),
(265, 'message', 'msg_job_work_update_success', 'Job Work Successfully Updated', 'Trabajo trabajo actualizado con éxito', 'Jobarbeit erfolgreich aktualisiert', 'Posao je uspješno ažuriran', NULL, NULL, NULL, NULL, NULL),
(266, 'message', 'msg_state_exist', 'State already exists with this name', 'El estado ya existe con este nombre', 'Staat existiert bereits mit diesem Namen', 'Država već postoji s ovim imenom', NULL, NULL, NULL, NULL, NULL),
(267, 'message', 'msg_state_add_success', 'State Successfully Added', 'Estado agregado con éxito', 'Status erfolgreich hinzugefügt', 'Država je uspješno dodana', NULL, NULL, NULL, NULL, NULL),
(268, 'message', 'msg_state_update_success', 'State Successfully Updated', 'Estado actualizado con éxito', 'Status erfolgreich aktualisiert', 'Država je uspješno ažurirana', NULL, NULL, NULL, NULL, NULL),
(269, 'message', 'msg_municipality_add_success', 'Municipality Successfully Added', 'Municipio agregado con éxito', 'Gemeinde erfolgreich hinzugefügt', 'Općina uspješno dodana', NULL, NULL, NULL, NULL, NULL),
(270, 'message', 'msg_municipality_update_success', 'Municipality Successfully Updated', 'Municipio actualizado con éxito', 'Gemeinde erfolgreich aktualisiert', 'Općina je uspješno ažurirana', NULL, NULL, NULL, NULL, NULL),
(271, 'message', 'msg_municipality_exist', 'Municipality already exists with this name', 'Municipio ya existe con este nombre', 'Gemeinde existiert bereits mit diesem Namen', 'Općina već postoji s ovim imenom', NULL, NULL, NULL, NULL, NULL),
(272, 'message', 'msg_postal_code_add_success', 'Postal Code Successfully Added', 'Código postal agregado con éxito', 'Postleitzahl erfolgreich hinzugefügt', 'Poštanski broj uspješno dodan', NULL, NULL, NULL, NULL, NULL),
(273, 'message', 'msg_postal_code_update_success', 'Postal Code Successfully Updated', 'Código postal actualizado con éxito', 'Postleitzahl erfolgreich aktualisiert', 'Poštanski broj uspješno ažuriran', NULL, NULL, NULL, NULL, NULL),
(274, 'message', 'msg_postal_code_exist', 'Postal Code already exists with this code', 'El código postal ya existe con este código', 'Die Postleitzahl existiert bereits mit dieser Code', 'Poštanski kod već postoji s ovim kodom', NULL, NULL, NULL, NULL, NULL),
(275, 'message', 'msg_postal_name_exist', 'Postal Code already exists with this name', 'Código postal ya existe con este nombre', 'Postleitzahl existiert bereits mit diesem Namen', 'Već postoji poštanski broj s ovim nazivom', NULL, NULL, NULL, NULL, NULL),
(276, 'message', 'msg_university_exist', 'University already exists with this name', 'Universidad agregada exitosamente', 'Universität erfolgreich hinzugefügt', 'Sveučilište je uspješno dodano', NULL, NULL, NULL, NULL, NULL),
(277, 'message', 'msg_university_add_success', 'University Successfully Added', 'Universidad agregada exitosamente', 'Universität erfolgreich hinzugefügt', 'Sveučilište je uspješno dodano', NULL, NULL, NULL, NULL, NULL),
(278, 'message', 'msg_university_update_success', 'University Successfully Updated', 'Universidad actualizada con éxito', 'Universität erfolgreich aktualisiert', 'Sveučilište je uspješno ažurirano', NULL, NULL, NULL, NULL, NULL),
(279, 'message', 'msg_canton_update_success', 'Canton Successfully Updated', 'Canton actualizado con éxito', 'Kanton erfolgreich aktualisiert', 'Kanton je uspješno ažuriran', NULL, NULL, NULL, NULL, NULL),
(280, 'message', 'msg_nep_exist', 'National Education Plan already exists with this name', 'El Plan Nacional de Educación ya existe con este nombre', 'Nationaler Bildungsplan existiert bereits mit diesem Namen', 'Nacionalni plan obrazovanja već postoji s ovim nazivom', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `translations` (`id`, `section`, `key`, `value_en`, `value_sr`, `value_ba`, `value_hr`, `value_Hn`, `value_trr`, `value_Te`, `value_tes`, `deleted_at`) VALUES
(281, 'message', 'msg_nep_update_success', 'National Education Plan Successfully Updated', 'Plan nacional de educación actualizado con éxito', 'Nationaler Bildungsplan erfolgreich aktualisiert', 'Nacionalni obrazovni plan uspješno je ažuriran', NULL, NULL, NULL, NULL, NULL),
(282, 'message', 'msg_nep_add_success', 'National Education Plan Successfully Added', 'Plan nacional de educación agregado con éxito', 'Nationaler Bildungsplan erfolgreich hinzugefügt', 'Uspješno dodan nacionalni obrazovni plan', NULL, NULL, NULL, NULL, NULL),
(283, 'message', 'msg_education_profile_exist', 'Education Profile already exists with this name', 'El perfil educativo ya existe con este nombre', 'Das Bildungsprofil existiert bereits mit diesem Namen', 'Profil obrazovanja već postoji s ovim imenom', NULL, NULL, NULL, NULL, NULL),
(284, 'message', 'msg_education_profile_add_success', 'Education Profile Successfully Added', 'Perfil educativo agregado con éxito', 'Bildungsprofil erfolgreich hinzugefügt', 'Profil obrazovanja uspješno je dodan', NULL, NULL, NULL, NULL, NULL),
(285, 'message', 'msg_education_profile_update_success', 'Education Profile Successfully Updated', 'Perfil educativo actualizado con éxito', 'Bildungsprofil erfolgreich aktualisiert', 'Obrazovni profil uspješno je ažuriran', NULL, NULL, NULL, NULL, NULL),
(286, 'message', 'msg_qd_exists', 'Qualification Degree already exists with this name', 'El título de calificación ya existe con este nombre', 'Qualifikationsgrad existiert bereits mit diesem Namen', 'Stupanj kvalifikacije već postoji s ovim nazivom', NULL, NULL, NULL, NULL, NULL),
(287, 'message', 'msg_qd_add_success', 'Qualification Degree Successfully Added', 'Título de calificación agregado con éxito', 'Qualifikationsgrad erfolgreich hinzugefügt', 'Stupanj kvalifikacije uspješno je dodan', NULL, NULL, NULL, NULL, NULL),
(288, 'message', 'msg_qd_update_success', 'Qualification Degree Successfully Updated', 'Título de calificación actualizado con éxito', 'Qualifikationsgrad erfolgreich aktualisiert', 'Stupanj kvalifikacije uspješno je ažuriran', NULL, NULL, NULL, NULL, NULL),
(289, 'message', 'msg_language_add_success', 'Language Successfully Added', 'Idioma agregado con éxito', 'Sprache erfolgreich hinzugefügt', 'Jezik je uspješno dodan', NULL, NULL, NULL, NULL, NULL),
(290, 'message', 'msg_language_update_success', 'Language Successfully Updated', 'Idioma actualizado con éxito', 'Sprache erfolgreich aktualisiert', 'Jezik je uspješno ažuriran', NULL, NULL, NULL, NULL, NULL),
(291, 'message', 'msg_language_exists', 'Language already exists with this name', 'El idioma ya existe con este nombre', 'Sprache existiert bereits mit diesem Namen', 'Jezik već postoji s tim imenom', NULL, NULL, NULL, NULL, NULL),
(292, 'message', 'msg_language_key_exists', 'Language already exists with this key', 'El idioma ya existe con esta clave', 'Mit diesem Schlüssel existiert bereits eine Sprache', 'Jezik već postoji s ovim tipkom', NULL, NULL, NULL, NULL, NULL),
(293, 'message', 'msg_translation_exists', 'Translation already exists with this key', 'La traducción ya existe con esta clave', 'Mit diesem Schlüssel ist bereits eine Übersetzung vorhanden', 'Prijevod s ovim ključem već postoji', NULL, NULL, NULL, NULL, NULL),
(294, 'message', 'msg_translation_add_success', 'Translation Successfully Added', 'Traducción añadida correctamente', 'Übersetzung erfolgreich hinzugefügt', 'Prijevod je uspješno dodan', NULL, NULL, NULL, NULL, NULL),
(295, 'message', 'msg_translation_update_success', 'Translation Successfully Updated', 'Traducción actualizada correctamente', 'Übersetzung erfolgreich aktualisiert', 'Prijevod je uspješno ažuriran', NULL, NULL, NULL, NULL, NULL),
(296, 'message', 'msg_nationality_add_success', 'Nationality Successfully Added', 'Nacionalidad añadida con éxito', 'Nationalität erfolgreich hinzugefügt', 'Nacionalnost je uspješno dodana', NULL, NULL, NULL, NULL, NULL),
(297, 'message', 'msg_nationality_update_success', 'Nationality Successfully Updated', 'Nacionalidad actualizada con éxito', 'Nationalität erfolgreich aktualisiert', 'Nacionalnost je uspješno ažurirana', NULL, NULL, NULL, NULL, NULL),
(298, 'message', 'msg_nationality_exists', 'Nationality already exists with this name', 'La nacionalidad ya existe con este nombre.', 'Die Nationalität existiert bereits mit diesem Namen', 'Nacionalnost s tim imenom već postoji', NULL, NULL, NULL, NULL, NULL),
(299, 'message', 'msg_religion_exists', 'Religion already exists with this name', 'La religión ya existe con este nombre.', 'Religion existiert bereits mit diesem Namen', 'Religija već postoji s tim imenom', NULL, NULL, NULL, NULL, NULL),
(300, 'message', 'msg_religion_add_success', 'Religion Successfully Added', 'Religión añadida con éxito', 'Religion erfolgreich hinzugefügt', 'Religija je uspješno dodana', NULL, NULL, NULL, NULL, NULL),
(301, 'message', 'msg_religion_update_success', 'Religion Successfully Updated', 'Religión actualizada con éxito', 'Religion erfolgreich aktualisiert', 'Religija je uspješno ažurirana', NULL, NULL, NULL, NULL, NULL),
(302, 'message', 'msg_school_year_exists', 'School Year already exists with this name', 'El año escolar ya existe con este nombre', 'Das Schuljahr existiert bereits mit diesem Namen', 'Školska godina već postoji s ovim imenom', NULL, NULL, NULL, NULL, NULL),
(303, 'message', 'msg_school_year_add_success', 'School Year Successfully Added', 'Año escolar agregado con éxito', 'Schuljahr erfolgreich hinzugefügt', 'Školska godina uspješno dodana', NULL, NULL, NULL, NULL, NULL),
(304, 'message', 'msg_school_year_update_success', 'School Year Successfully Updated', 'Año escolar actualizado con éxito', 'Schuljahr erfolgreich aktualisiert', 'Školska godina uspješno je ažurirana', NULL, NULL, NULL, NULL, NULL),
(305, 'message', 'msg_school_exists', 'School already exists with this name', 'La escuela ya existe con este nombre', 'Die Schule existiert bereits mit diesem Namen', 'Škola već postoji s ovim imenom', NULL, NULL, NULL, NULL, NULL),
(306, 'message', 'msg_school_coordinator_exists', 'School Coordinator already exists with this name', 'El coordinador escolar ya existe con este nombre', 'Schulkoordinator existiert bereits mit diesem Namen', 'Koordinator škole već postoji s ovim imenom', NULL, NULL, NULL, NULL, NULL),
(307, 'message', 'msg_school_coordinator_email_exists', 'School Coordinator already exist with this email', 'El coordinador escolar ya existe con este correo electrónico', 'Mit dieser E-Mail existiert bereits ein Schulkoordinator', 'Koordinator škole već postoji s ovom e-poštom', NULL, NULL, NULL, NULL, NULL),
(308, 'message', 'msg_no_email_found', 'No such email found', 'No se encontró ese correo electrónico', 'Keine solche E-Mail gefunden', 'Nema takve adrese e-pošte', NULL, NULL, NULL, NULL, NULL),
(309, 'general', 'gn_email', 'Email', 'Correo electrónico', 'Email', 'E-mail', NULL, NULL, NULL, NULL, NULL),
(310, 'validation', 'validate_education_plan', 'Please select an Education Plan', 'Por favor seleccione un plan educativo', 'Bitte wählen Sie einen Bildungsplan', 'Odaberite plan obrazovanja', NULL, NULL, NULL, NULL, NULL),
(311, 'message', 'education_plan_already_added', 'Education Plan already added', 'Plan de educación ya agregado', 'Bildungsplan bereits hinzugefügt', 'Obrazovni plan već dodan', NULL, NULL, NULL, NULL, NULL),
(312, 'message', 'msg_school_update_success', 'School Successfully Update', 'Actualización exitosa de la escuela', 'Schule erfolgreich aktualisiert', 'Ažuriranje škole uspješno', NULL, NULL, NULL, NULL, NULL),
(313, 'general', 'gn_view_details', 'View Details', 'Ver detalles', 'Details anzeigen', 'Pregledavati pojedinosti', NULL, NULL, NULL, NULL, NULL),
(314, 'general', 'gn_education_plans_n_programs', 'Education Plans & Programs', 'Planes y programas educativos', 'Bildungspläne und -programme', 'Obrazovni planovi i programi', NULL, NULL, NULL, NULL, NULL),
(315, 'message', 'msg_invalid_pass_token', 'Invalid reset password token', 'Token de restablecimiento de contraseña no válido', 'Ungültiges Passwort zum Zurücksetzen', 'Nevažeći token resetiranja lozinke', NULL, NULL, NULL, NULL, NULL),
(316, 'message', 'msg_reset_pass_success', 'Reset Password Successful', 'Restablecer contraseña exitosa', 'Passwort zurücksetzen erfolgreich', 'Ponovno postavljanje lozinke', NULL, NULL, NULL, NULL, NULL),
(317, 'message', 'msg_invalid_verify_key', 'Invalid Verification Key', 'Clave de verificacion no valida', 'Ungültiger Bestätigungscode', 'Nevažeći ključ za potvrdu', NULL, NULL, NULL, NULL, NULL),
(318, 'message', 'msg_pass_match_fail', 'Entered password is incorrect, Your password doesn\'t match', 'La contraseña ingresada es incorrecta, su contraseña no coincide', 'Das eingegebene Passwort ist falsch. Ihr Passwort stimmt nicht überein', 'Unesena lozinka nije ispravna, zaporka se ne podudara', NULL, NULL, NULL, NULL, NULL),
(319, 'message', 'msg_pass_update_success', 'Password Updated Successfully', 'Contraseña actualizada exitosamente', 'Passwort erfolgreich aktualisiert', 'lozinka je uspješno ažurirana', NULL, NULL, NULL, NULL, NULL),
(320, 'message', 'msg_account_not_exist', 'Sorry, your account does not exist in the system', 'Lo sentimos, tu cuenta no existe en el sistema', 'Ihr Konto ist leider nicht im System vorhanden', 'Nažalost, vaš račun ne postoji u sustavu', NULL, NULL, NULL, NULL, NULL),
(321, 'sidebar', 'sidebar_nav_certification', 'Certification', 'Certificación', 'Zertifizierung', 'potvrda', NULL, NULL, NULL, NULL, NULL),
(322, 'sidebar', 'sidebar_nav_course_orders', 'Course Orders', 'Órdenes de curso', 'Kursbestellungen', 'Redoslijed kursa', NULL, NULL, NULL, NULL, NULL),
(323, 'sidebar', 'sidebar_nav_class_creation', 'Class Creation', 'Creación de clase', 'Klassenerstellung', 'Stvaranje klase', NULL, NULL, NULL, NULL, NULL),
(324, 'sidebar', 'sidebar_nav_exam_result', 'Exam Result', 'Resultado del examen', 'Prüfungsergebnis', 'Rezultat ispita', NULL, NULL, NULL, NULL, NULL),
(325, 'sidebar', 'sidebar_nav_my_school', 'My School', 'Mi escuela', 'Meine Schule', 'Moja škola', NULL, NULL, NULL, NULL, NULL),
(326, 'sidebar', 'sidebar_nav_main_books', 'Main Book', 'Libros principales', 'Hauptbücher', 'Glavne knjige', NULL, NULL, NULL, NULL, NULL),
(327, 'sidebar', 'sidebar_nav_sub_admins', 'Sub Admins', 'Subadministrador', 'Sub Admins', 'Pod administrator', NULL, NULL, NULL, NULL, NULL),
(328, 'sidebar', 'sidebar_nav_school', 'School', 'Colegio', 'Schule', 'Škola', NULL, NULL, NULL, NULL, NULL),
(329, 'general', 'gn_teachers', 'Teachers', 'Maestros', 'Lehrer', 'Učitelji', NULL, NULL, NULL, NULL, NULL),
(330, 'general', 'gn_qualifications', 'Qualifications', 'Calificaciones', 'Qualifikationen', 'Kvalifikacije', NULL, NULL, NULL, NULL, NULL),
(331, 'general', 'gn_work_experience', 'Work Experience', 'Experiencia laboral', 'Arbeitserfahrung', 'Radno iskustvo', NULL, NULL, NULL, NULL, NULL),
(332, 'general', 'gn_nationality', 'Nationality', 'Nacionalidad', 'Staatsangehörigkeit', 'Nacionalnost', NULL, NULL, NULL, NULL, NULL),
(333, 'general', 'gn_citizenship', 'Citizenship', 'Ciudadanía', 'Staatsbürgerschaft', 'Građanstvo', NULL, NULL, NULL, NULL, NULL),
(334, 'general', 'gn_municipality', 'Municipality', 'Municipio', 'Gemeinde', 'Općina', NULL, NULL, NULL, NULL, NULL),
(335, 'general', 'gn_designation', 'Designation', 'Designacion', 'Bezeichnung', 'Oznaka', NULL, NULL, NULL, NULL, NULL),
(336, 'general', 'gn_place_of_birth', 'Place of Birth', 'Lugar de nacimiento', 'Geburtsort', 'Mjesto rođenja', NULL, NULL, NULL, NULL, NULL),
(337, 'general', 'gn_class', 'Class', 'Clase', 'Klasse', 'Klasa', NULL, NULL, NULL, NULL, NULL),
(338, 'general', 'gn_education_program', 'Education Program', 'Programa educativo', 'Erziehungsprogramm', 'Obrazovni program', NULL, NULL, NULL, NULL, NULL),
(339, 'general', 'gn_postal_code', 'Postal Code', 'Código postal', 'Postleitzahl', 'Poštanski broj', NULL, NULL, NULL, NULL, NULL),
(340, 'general', 'gn_education_qualifications', 'Education Qualifications', 'Calificaciones Educativas', 'Bildungsabschlüsse', 'Obrazovanje Kvalifikacija', NULL, NULL, NULL, NULL, NULL),
(341, 'general', 'gn_document', 'Document', 'Documento', 'Dokumentieren', 'Dokument', NULL, NULL, NULL, NULL, NULL),
(342, 'general', 'gn_college', 'College', 'Universidad', 'Hochschule', 'Koledž', NULL, NULL, NULL, NULL, NULL),
(343, 'general', 'gn_faculty', 'Faculty', 'Facultad', 'Fakultät', 'Fakultet', NULL, NULL, NULL, NULL, NULL),
(344, 'general', 'gn_year_of_passing', 'Year of passing', 'Año de fallecimiento', 'Jahr des Vergehens', 'Godina prolaska', NULL, NULL, NULL, NULL, NULL),
(345, 'general', 'gn_homeroom_teacher', 'Homeroom Teacher', 'Profesor de aula', 'Klassenlehrer', 'Kućna nastavnica', NULL, NULL, NULL, NULL, NULL),
(346, 'general', 'gn_employee', 'Employee', 'Empleado', 'Mitarbeiter', 'Zaposlenik', NULL, NULL, NULL, NULL, NULL),
(347, 'general', 'gn_temp_citizen_id', 'Temp. Citizen ID', 'Ciudadano Temporal ID', 'Temporärer Bürger ID', 'Privremeni Građanin ID', NULL, NULL, NULL, NULL, NULL),
(348, 'general', 'gn_phone_number', 'Phone Number', 'Número de teléfono', 'Telefonnummer', 'Broj telefona', NULL, NULL, NULL, NULL, NULL),
(349, 'general', 'gn_type_of_engagement', 'Type of Engagement', 'Tipo de compromiso', 'Art des Engagements', 'Vrsta zaruka', NULL, NULL, NULL, NULL, NULL),
(350, 'general', 'gn_date_of_engagement', 'Date of Engagement', 'Fecha de compromiso', 'Datum der Verlobung', 'Datum zaruka', NULL, NULL, NULL, NULL, NULL),
(351, 'general', 'gn_hourly_rate', 'Hourly Rate', 'Tarifa por hora', 'Stundensatz', 'Satnica', NULL, NULL, NULL, NULL, NULL),
(352, 'general', 'gn_date_of_engagement_end', 'Date of Engagement End', 'Fecha de finalización del compromiso', 'Datum des Verlobungsende', 'Datum završetka zaruka', NULL, NULL, NULL, NULL, NULL),
(353, 'general', 'gn_date_of_enrollment', 'Date of Enrollment', 'Fecha de inscripción', 'Datum der Registrierung', 'Datum upisa', NULL, NULL, NULL, NULL, NULL),
(354, 'general', 'gn_current_school_name', 'Current School Name', 'Nombre actual de la escuela', 'Aktueller Schulname', 'Trenutačno ime škole', NULL, NULL, NULL, NULL, NULL),
(355, 'general', 'gn_school_contact_no', 'School Contact No.', 'Número de contacto de la escuela', 'Schulkontaktnummer', 'Kontakt broj škole', NULL, NULL, NULL, NULL, NULL),
(356, 'general', 'gn_academic_degree', 'Academic Degree', 'Titulo academico', 'Hochschulabschluss', 'Akademska titula', NULL, NULL, NULL, NULL, NULL),
(357, 'general', 'gn_qualification_degree', 'Qualification Degree', 'Grado de calificación', 'Qualifikationsgrad', 'Stupanj Kvalifikacije', NULL, NULL, NULL, NULL, NULL),
(358, 'general', 'gn_number_of_semesters', 'Number of semesters', 'Numero de semestres', 'Anzahl der Semester', 'Broj semestra', NULL, NULL, NULL, NULL, NULL),
(359, 'general', 'gn_short_title', 'Short title', 'Título corto', 'Kurzer Titel', 'Kratki naslov', NULL, NULL, NULL, NULL, NULL),
(360, 'general', 'gn_ect_points', 'ECT points', 'Puntos ECT', 'ECT-Punkte', 'ECT bodovi', NULL, NULL, NULL, NULL, NULL),
(361, 'message', 'msg_please_add_qualification', 'Please add a Qualification', 'Por favor agregue una calificación', 'Bitte fügen Sie eine Qualifikation hinzu', 'Dodajte kvalifikaciju', NULL, NULL, NULL, NULL, NULL),
(362, 'general', 'gn_upload', 'Upload', 'Subir', 'Hochladen', 'Učitaj', NULL, NULL, NULL, NULL, NULL),
(363, 'message', 'msg_qualification_update_success', 'Qualification Successfully Updated', 'Calificación actualizada con éxito', 'Qualifikation erfolgreich aktualisiert', 'Kvalifikacija je uspješno ažurirana', NULL, NULL, NULL, NULL, NULL),
(364, 'message', 'msg_employee_id_exist', 'The Employee Id already exist, Please try with a different Employee Id', 'El Id. De empleado ya existe. Intente con un Id. De empleado diferente.', 'Die Mitarbeiter-ID ist bereits vorhanden. Bitte versuchen Sie es mit einer anderen Mitarbeiter-ID', 'Id zaposlenika već postoji, pokušajte s drugim ID-om zaposlenika', NULL, NULL, NULL, NULL, NULL),
(365, 'message', 'msg_temp_citizen_id_exist', 'The Temp Citizen Id already exists, Please try with a different Temp Citizen Id', 'El ID de ciudadano temporal ya existe. Intente con un ID de ciudadano temporal diferente.', 'Die temporäre Bürger-ID ist bereits vorhanden. Bitte versuchen Sie es mit einer anderen temporären Bürger-ID', 'Privremeni građanin ID već postoji. Pokušajte s drugim Temp Citizen Id', NULL, NULL, NULL, NULL, NULL),
(366, 'general', 'gn_religion', 'Religion', 'Religión', 'Religion', 'Religija', NULL, NULL, NULL, NULL, NULL),
(367, 'general', 'gn_national_education_plan', 'National Education Plan', 'Plan nacional de educación', 'Nationaler Bildungsplan', 'Nacionalni obrazovni plan', NULL, NULL, NULL, NULL, NULL),
(368, 'general', 'gn_education_profile', 'Education Profile', 'Perfil Educativo', 'Bildungsprofil', 'Profil obrazovanja', NULL, NULL, NULL, NULL, NULL),
(369, 'general', 'gn_basic_information', 'Basic Information', 'Información básica', 'Grundinformation', 'Osnovne informacije', NULL, NULL, NULL, NULL, NULL),
(370, 'general', 'gn_about', 'About', 'Acerca de', 'Über', 'Oko', NULL, NULL, NULL, NULL, NULL),
(371, 'general', 'gn_start_date', 'Start Date', 'Fecha de inicio', 'Anfangsdatum', 'Početni datum', NULL, NULL, NULL, NULL, NULL),
(372, 'general', 'gn_end_date', 'End Date', 'Fecha final', 'Endtermin', 'Datum završetka', NULL, NULL, NULL, NULL, NULL),
(373, 'general', 'gn_principal', 'Principal', 'Principal', 'Schulleiter', 'Glavni', NULL, NULL, NULL, NULL, NULL),
(374, 'general', 'gn_duration', 'Duration', 'Duración', 'Dauer', 'Trajanje', NULL, NULL, NULL, NULL, NULL),
(375, 'general', 'gn_browse', 'Browse', 'Vistazo', 'Durchsuche', 'Pretraživati', NULL, NULL, NULL, NULL, NULL),
(376, 'general', 'gn_zipcode', 'Zip Code', 'Código postal', 'Postleitzahl', 'Poštanski broj', NULL, NULL, NULL, NULL, NULL),
(377, 'general', 'gn_photos_of_school', 'Photos of School', 'Fotos de la escuela', 'Fotos der Schule', 'Fotografije škole', NULL, NULL, NULL, NULL, NULL),
(378, 'general', 'gn_upload_new_photo', 'Upload New Photo', 'Subir nueva foto', 'Neues Foto hochladen', 'Prenesite novu fotografiju', NULL, NULL, NULL, NULL, NULL),
(379, 'message', 'msg_school_id_exist', 'The School Id already exists, Please try with a different School Id', 'El ID de la escuela ya existe. Intente con un ID de escuela diferente.', 'Die Schul-ID ist bereits vorhanden. Bitte versuchen Sie es mit einer anderen Schul-ID', 'Školski identitet već postoji. Pokušajte s drugim školskim identitetom', NULL, NULL, NULL, NULL, NULL),
(380, 'message', 'msg_school_exist', 'School already exists with this name', 'La escuela ya existe con este nombre', 'Die Schule existiert bereits mit diesem Namen', 'Škola već postoji s ovim imenom', NULL, NULL, NULL, NULL, NULL),
(381, 'general', 'gn_founder', 'Founder', 'Fundador', 'Gründer', 'Osnivač', NULL, NULL, NULL, NULL, NULL),
(382, 'general', 'gn_founding_date', 'Founding Date', 'Fecha de fundación', 'Gründungsdatum', 'Datum osnivanja', NULL, NULL, NULL, NULL, NULL),
(383, 'general', 'gn_employees', 'Employees', 'Empleados', 'Angestellte', 'zaposlenici', NULL, NULL, NULL, NULL, NULL),
(384, 'general', 'gn_select_existing_employee', 'Select an existing employee', 'Seleccione un empleado existente', 'Wählen Sie einen vorhandenen Mitarbeiter aus', 'Odaberite postojećeg zaposlenika', NULL, NULL, NULL, NULL, NULL),
(385, 'message', 'msg_user_exist', 'User already exists with this name', 'El usuario ya existe con este nombre.', 'Benutzer existiert bereits mit diesem Namen', 'Korisnik već postoji s ovim imenom', NULL, NULL, NULL, NULL, NULL),
(386, 'message', 'msg_principal_assign_exist', 'The selected employee is already assigned as Principal to the school', 'El empleado seleccionado ya está asignado como director de la escuela.', 'Der ausgewählte Mitarbeiter ist der Schule bereits als Schulleiter zugeordnet', 'Izabrani zaposlenik je već imenovan kao ravnatelj škole', NULL, NULL, NULL, NULL, NULL),
(387, 'general', 'gn_present', 'Present', 'Presente', 'Geschenk', 'Predstaviti', NULL, NULL, NULL, NULL, NULL),
(388, 'general', 'gn_residence', 'Residence', 'residencia', 'Residenz', 'Prebivalište', NULL, NULL, NULL, NULL, NULL),
(389, 'general', 'gn_main_school', 'Main School', 'Escuela principal', 'Hauptschule', 'Glavna škola', NULL, NULL, NULL, NULL, NULL),
(390, 'message', 'msg_village_school_add_success', 'Village School Successfully Added', 'Escuela de pueblo añadida con éxito', 'Dorfschule erfolgreich hinzugefügt', 'Seoska škola uspješno je dodana', NULL, NULL, NULL, NULL, NULL),
(391, 'message', 'msg_village_school_exist', 'Village School already exists with this name', 'Village School ya existe con este nombre', 'Village School existiert bereits mit diesem Namen', 'Seoska škola već postoji s ovim imenom', NULL, NULL, NULL, NULL, NULL),
(392, 'message', 'msg_village_school_update_success', 'Village School Successfully Updated', 'Village School se actualizó con éxito', 'Dorfschule erfolgreich aktualisiert', 'Seoska škola uspješno je ažurirana', NULL, NULL, NULL, NULL, NULL),
(393, 'general', 'gn_opening_date', 'Opening Date', 'Fecha de apertura', 'Eröffnungsdatum', 'Datum otvaranja', NULL, NULL, NULL, NULL, NULL),
(394, 'message', 'msg_sub_admin_add_success', 'Sub Admin Successfully Added', 'Subadministrador agregado con éxito', 'Sub Admin erfolgreich hinzugefügt', 'Sub Admin uspješno je dodan', NULL, NULL, NULL, NULL, NULL),
(395, 'message', 'msg_sub_admin_update_success', 'Sub Admin Successfully Updated', 'Subadministrador actualizado correctamente', 'Sub Admin erfolgreich aktualisiert', 'Sub Admin uspješno je ažuriran', NULL, NULL, NULL, NULL, NULL),
(396, 'general', 'gn_or', 'OR', 'O', 'Oder', 'Ili', NULL, NULL, NULL, NULL, NULL),
(397, 'general', 'gn_existing_user', 'Existing User', 'Usuario existente', 'Existierender Benutzer', 'Postojeći korisnik', NULL, NULL, NULL, NULL, NULL),
(398, 'general', 'gn_existing_user_msg', 'If you want to give an access to existing user then please select existing user', 'Si desea dar acceso a un usuario existente, seleccione un usuario existente', 'Wenn Sie einem vorhandenen Benutzer Zugriff gewähren möchten, wählen Sie bitte einen vorhandenen Benutzer aus', 'Ako želite dati pristup postojećem korisniku, molimo odaberite postojećeg korisnika', NULL, NULL, NULL, NULL, NULL),
(399, 'general', 'gn_qualification', 'Qualification', 'Calificación', 'Qualifikation', 'Kvalifikacija', NULL, NULL, NULL, NULL, NULL),
(400, 'general', 'gn_preview', 'Preview', 'Avance', 'Vorschau', 'Pregled', NULL, NULL, NULL, NULL, NULL),
(401, 'message', 'msg_academic_degree_delete_prompt', 'Sorry, the selected academic title cannot be deleted as it is already being used in the employee education details', 'Lo sentimos, el título académico seleccionado no se puede eliminar ya que ya se está utilizando en los detalles de educación del empleado', 'Der ausgewählte akademische Titel kann leider nicht gelöscht werden, da er bereits in den Ausbildungsdetails des Mitarbeiters verwendet wird', 'Nažalost, odabrani akademski naziv ne može se izbrisati, jer se već koristi u pojedinostima o obrazovanju zaposlenika', NULL, NULL, NULL, NULL, NULL),
(402, 'message', 'msg_country_delete_prompt', 'Sorry, the selected country cannot be deleted as it is already being used by the employees, admins, colleges, citizenships, states, cantons, universities', 'Lo sentimos, el país seleccionado no se puede eliminar, ya que los empleados, administradores, colegios, ciudadanías, estados, cantones, universidades ya lo están utilizando.', 'Das ausgewählte Land kann leider nicht gelöscht werden, da es bereits von Mitarbeitern, Administratoren, Hochschulen, Staatsbürgerschaften, Staaten, Kantonen und Universitäten verwendet wird', 'Nažalost, odabrana zemlja se ne može izbrisati jer je već koriste zaposlenici, administratori, fakulteti, državljanstva, države, kantoni, sveučilišta', NULL, NULL, NULL, NULL, NULL),
(403, 'message', 'msg_state_delete_prompt', 'Sorry, the selected state cannot be deleted as it is already being used by cantons', 'Lo sentimos, el estado seleccionado no se puede eliminar porque los cantones ya lo están utilizando', 'Der ausgewählte Status kann leider nicht gelöscht werden, da er bereits von Kantonen verwendet wird', 'Nažalost, odabrano stanje ne može se izbrisati jer ga kantoni već koriste', NULL, NULL, NULL, NULL, NULL),
(404, 'message', 'msg_canton_delete_prompt', 'Sorry, the selected canton cannot be deleted as it is already being used by admins, municipalities', 'Lo sentimos, el cantón seleccionado no se puede eliminar porque ya lo están utilizando los administradores, municipios', 'Der ausgewählte Kanton kann leider nicht gelöscht werden, da er bereits von Administratoren und Gemeinden verwendet wird', 'Nažalost, odabrani kanton nije moguće izbrisati jer ga već koriste administratori, općine', NULL, NULL, NULL, NULL, NULL),
(405, 'message', 'msg_municipality_delete_prompt', 'Sorry, the selected municipality cannot be deleted as it is already being used by postal offices, employees', 'Lo sentimos, el municipio seleccionado no se puede eliminar ya que ya está siendo utilizado por oficinas postales, empleados', 'Die ausgewählte Gemeinde kann leider nicht gelöscht werden, da sie bereits von Postämtern und Mitarbeitern genutzt wird', 'Nažalost, odabrana općina ne može se izbrisati jer je poštanska služba već koristi', NULL, NULL, NULL, NULL, NULL),
(406, 'message', 'msg_postal_code_delete_prompt', 'Sorry, the selected postal code cannot be deleted as it is already being used by schools, employees, village schools', 'Lo sentimos, el código postal seleccionado no se puede eliminar porque ya lo están utilizando escuelas, empleados, escuelas de la aldea.', 'Die ausgewählte Postleitzahl kann leider nicht gelöscht werden, da sie bereits von Schulen, Mitarbeitern und Dorfschulen verwendet wird', 'Nažalost, odabrani poštanski broj ne može se izbrisati, jer ga već koriste škole, zaposlenici, seoske škole', NULL, NULL, NULL, NULL, NULL),
(407, 'message', 'msg_ownershiptype_delete_prompt', 'Sorry, the selected ownership cannot be deleted as it is already being used by the schools, colleges, universities', 'Lo sentimos, la propiedad seleccionada no se puede eliminar, ya que las escuelas, colegios, universidades ya la están utilizando.', 'Der ausgewählte Eigentümer kann leider nicht gelöscht werden, da er bereits von Schulen, Hochschulen und Universitäten verwendet wird', 'Nažalost, odabrano vlasništvo ne može se izbrisati jer ga već koriste škole, fakulteti, sveučilišta', NULL, NULL, NULL, NULL, NULL),
(408, 'message', 'msg_university_delete_prompt', 'Sorry, the selected university cannot be deleted as it is already being used by the colleges, employees education details', 'Lo sentimos, la universidad seleccionada no se puede eliminar ya que ya está siendo utilizada por las universidades, los detalles de educación de los empleados', 'Die ausgewählte Universität kann leider nicht gelöscht werden, da sie bereits von den Colleges verwendet wird', 'Nažalost, odabrano sveučilište ne može se izbrisati jer ga već koriste fakulteti, detalji obrazovanja zaposlenika', NULL, NULL, NULL, NULL, NULL),
(409, 'message', 'msg_university_delete_success', 'University Successfully Deleted', 'Universidad eliminada con éxito', 'Universität erfolgreich gelöscht', 'Sveučilište je uspješno izbrisano', NULL, NULL, NULL, NULL, NULL),
(410, 'message', 'msg_ownership_delete_success', 'Ownership Successfully Deleted', 'Propiedad eliminada con éxito', 'Eigentümer erfolgreich gelöscht', 'Vlasništvo je uspješno izbrisano', NULL, NULL, NULL, NULL, NULL),
(411, 'message', 'msg_postal_code_delete_success', 'Postal Code Successfully deleted', 'Código postal eliminado con éxito', 'Postleitzahl Erfolgreich gelöscht', 'Poštanski broj uspješno je obrisan', NULL, NULL, NULL, NULL, NULL),
(412, 'message', 'msg_municipality_delete_success', 'Municipality Successfully deleted', 'Municipio eliminado con éxito', 'Gemeinde Erfolgreich gelöscht', 'Općina je uspješno izbrisana', NULL, NULL, NULL, NULL, NULL),
(413, 'message', 'msg_canton_delete_success', 'Canton Successfully deleted', 'Cantón eliminado con éxito', 'Kanton Erfolgreich gelöscht', 'Kanton je uspješno izbrisan', NULL, NULL, NULL, NULL, NULL),
(414, 'message', 'msg_state_delete_success', 'State Successfully deleted', 'Estado eliminado con éxito', 'Status Erfolgreich gelöscht', 'Država je uspješno izbrisana', NULL, NULL, NULL, NULL, NULL),
(415, 'message', 'msg_job_work_delete_success', 'Job & Work Successfully deleted', 'Trabajo y trabajo eliminado con éxito', 'Job & Arbeit Erfolgreich gelöscht', 'Posao i rad uspješno su izbrisani', NULL, NULL, NULL, NULL, NULL),
(416, 'message', 'msg_college_delete_success', 'College Successfully Deleted', 'Colegio eliminado exitosamente', 'College erfolgreich gelöscht', 'Fakultet je uspješno izbrisan', NULL, NULL, NULL, NULL, NULL),
(417, 'message', 'msg_college_delete_prompt', 'Sorry, the selected university cannot be deleted as it is already being used by employees education details', 'Lo sentimos, la universidad seleccionada no se puede eliminar porque ya está siendo utilizada por los detalles de educación de los empleados', 'Die ausgewählte Universität kann leider nicht gelöscht werden, da sie bereits von den Schulungsdetails der Mitarbeiter verwendet wird', 'Nažalost, odabrano sveučilište nije moguće izbrisati jer ga pojedinosti o obrazovanju zaposlenih već koriste', NULL, NULL, NULL, NULL, NULL),
(418, 'message', 'msg_nep_delete_success', 'National Education Plan Successfully Deleted', 'Plan nacional de educación eliminado con éxito', 'Nationaler Bildungsplan erfolgreich gelöscht', 'Nacionalni obrazovni plan uspješno je izbrisan', NULL, NULL, NULL, NULL, NULL),
(419, 'message', 'msg_nep_delete_prompt', 'Sorry, the selected national education plan cannot be deleted as it is already being used by school education plans', 'Lo sentimos, el plan educativo nacional seleccionado no se puede eliminar porque ya lo están utilizando los planes educativos escolares', 'Der ausgewählte nationale Bildungsplan kann leider nicht gelöscht werden, da er bereits von Schulbildungsplänen verwendet wird', 'Nažalost, odabrani nacionalni obrazovni plan ne može se izbrisati, jer ga već koriste školski planovi obrazovanja', NULL, NULL, NULL, NULL, NULL),
(420, 'message', 'msg_academic_degree_delete_success', 'Academic Degree Successfully Deleted', 'Título académico eliminado con éxito', 'Akademischer Abschluss erfolgreich gelöscht', 'Uspješno je izbrisan akademski stupanj', NULL, NULL, NULL, NULL, NULL),
(421, 'message', 'msg_education_profile_delete_success', 'Education Profile Successfully Deleted', 'Perfil educativo eliminado con éxito', 'Bildungsprofil erfolgreich gelöscht', 'Profil obrazovanja uspješno je obrisan', NULL, NULL, NULL, NULL, NULL),
(422, 'message', 'msg_education_profile_delete_prompt', 'Sorry, the selected education profile cannot be deleted as it is already being used by school education plans', 'Lo sentimos, el perfil educativo seleccionado no se puede eliminar ya que ya está siendo utilizado por los planes de educación escolar.', 'Das ausgewählte Bildungsprofil kann leider nicht gelöscht werden, da es bereits von Schulbildungsplänen verwendet wird', 'Nažalost, odabrani profil obrazovanja ne može se izbrisati jer se već koristi u školskim planovima obrazovanja', NULL, NULL, NULL, NULL, NULL),
(423, 'message', 'msg_qualification_degree_delete_prompt', 'Sorry, the selected qualification degree cannot be deleted as it is already being used by school education plans, employees education details', 'Lo sentimos, el título de calificación seleccionado no se puede eliminar ya que ya está siendo utilizado por los planes de educación escolar, los detalles de educación de los empleados', 'Der ausgewählte Qualifikationsgrad kann leider nicht gelöscht werden, da er bereits von Schulbildungsplänen und Angaben zur Mitarbeiterausbildung verwendet wird', 'Nažalost, odabrani stupanj kvalifikacije ne može se izbrisati jer se već koristi planovima školskog obrazovanja, pojedinostima obrazovanja zaposlenika', NULL, NULL, NULL, NULL, NULL),
(424, 'message', 'msg_qualification_degree_delete_success', 'Qualification Degree Successfully Deleted', 'Título de calificación eliminado con éxito', 'Qualifikationsgrad erfolgreich gelöscht', 'Stupanj kvalifikacije uspješno je izbrisan', NULL, NULL, NULL, NULL, NULL),
(425, 'message', 'msg_education_plan_delete_success', 'Education Plan Successfully Deleted', 'Plan educativo eliminado con éxito', 'Bildungsplan erfolgreich gelöscht', 'Obrazovni plan uspješno je obrisan', NULL, NULL, NULL, NULL, NULL),
(426, 'message', 'msg_education_plan_delete_prompt', 'Sorry, the selected education plan cannot be deleted as it is already being used by school education plans, student enrollments', 'Lo sentimos, el plan educativo seleccionado no se puede eliminar ya que ya está siendo utilizado por los planes educativos de la escuela, las inscripciones de los estudiantes.', 'Der ausgewählte Bildungsplan kann leider nicht gelöscht werden, da er bereits von Schulbildungsplänen und Einschreibungen von Schülern verwendet wird', 'Nažalost, odabrani plan obrazovanja ne može se izbrisati, jer se već koristi planovima školovanja, upisima učenika', NULL, NULL, NULL, NULL, NULL),
(427, 'message', 'msg_grade_delete_prompt', 'Sorry, the selected grade cannot be deleted as it is already being used by school education plans', 'Lo sentimos, la calificación seleccionada no se puede eliminar ya que ya está siendo utilizada por los planes de educación escolar.', 'Die ausgewählte Klasse kann leider nicht gelöscht werden, da sie bereits von Schulbildungsplänen verwendet wird', 'Nažalost, odabranu ocjenu nije moguće izbrisati jer je već korištena u školskim planovima obrazovanja', NULL, NULL, NULL, NULL, NULL),
(428, 'message', 'msg_grade_delete_success', 'Grade Successfully Deleted', 'Calificación eliminada exitosamente', 'Note erfolgreich gelöscht', 'Ocjena je uspješno izbrisana', NULL, NULL, NULL, NULL, NULL),
(429, 'message', 'msg_class_delete_prompt', 'Sorry, the selected class cannot be deleted as it is already being used by class creation, exams, attendance', 'Lo sentimos, la clase seleccionada no se puede eliminar porque ya está siendo utilizada por la creación de la clase, los exámenes y la asistencia.', 'Die ausgewählte Klasse kann leider nicht gelöscht werden, da sie bereits für die Klassenerstellung, Prüfungen und Teilnahme verwendet wird', 'Nažalost, odabrani razred se ne može izbrisati jer se već koristi kreiranjem nastave, ispitima, pohađanjem nastave', NULL, NULL, NULL, NULL, NULL),
(430, 'message', 'msg_class_delete_success', 'Class Successfully Deleted', 'Clase eliminada con éxito', 'Klasse erfolgreich gelöscht', 'Klasa je uspješno izbrisana', NULL, NULL, NULL, NULL, NULL),
(431, 'message', 'msg_citizenship_delete_success', 'Citizenship Successfully Deleted', 'Ciudadanía eliminada exitosamente', 'Staatsbürgerschaft erfolgreich gelöscht', 'Državljanstvo je uspješno izbrisano', NULL, NULL, NULL, NULL, NULL),
(432, 'message', 'msg_citizenship_delete_prompt', 'Sorry, the selected citizenship cannot be deleted as it is already being used by the employees, students', 'Lo sentimos, la ciudadanía seleccionada no se puede eliminar, ya que los empleados y estudiantes ya la están utilizando.', 'Die ausgewählte Staatsbürgerschaft kann leider nicht gelöscht werden, da sie bereits von den Mitarbeitern und Studenten verwendet wird', 'Nažalost, odabrano državljanstvo ne može se izbrisati jer ga već koriste zaposlenici, studenti', NULL, NULL, NULL, NULL, NULL),
(433, 'message', 'msg_nationality_delete_success', 'Nationality Successfully Deleted', 'Nacionalidad eliminada exitosamente', 'Nationalität erfolgreich gelöscht', 'Nacionalnost je uspješno izbrisana', NULL, NULL, NULL, NULL, NULL),
(434, 'message', 'msg_nationality_delete_prompt', 'Sorry, the selected nationality cannot be deleted as it is already being used by the employees, students', 'Lo sentimos, la nacionalidad seleccionada no se puede eliminar, ya que los empleados y estudiantes ya la están utilizando.', 'Die ausgewählte Nationalität kann leider nicht gelöscht werden, da sie bereits von den Mitarbeitern und Studenten verwendet wird', 'Nažalost, odabrano državljanstvo ne može se izbrisati jer ga već koriste zaposlenici, studenti', NULL, NULL, NULL, NULL, NULL),
(435, 'message', 'msg_religion_delete_success', 'Religion Successfully Deleted', 'Religión eliminada con éxito', 'Religion erfolgreich gelöscht', 'Religija je uspješno izbrisana', NULL, NULL, NULL, NULL, NULL),
(436, 'message', 'msg_religion_delete_prompt', 'Sorry, the selected religion cannot be deleted as it is already being used by the employees, students', 'Lo sentimos, la religión seleccionada no se puede eliminar, ya que los empleados y estudiantes ya la están utilizando.', 'Die ausgewählte Religion kann leider nicht gelöscht werden, da sie bereits von den Mitarbeitern und Studenten verwendet wird', 'Nažalost, odabranu religiju nije moguće izbrisati jer je već koriste zaposlenici, studenti', NULL, NULL, NULL, NULL, NULL),
(437, 'message', 'msg_school_year_delete_prompt', 'Sorry, the selected school year cannot be deleted as students are already enrolled in the school year', 'Lo sentimos, el año escolar seleccionado no se puede eliminar ya que los estudiantes ya están inscritos en el año escolar', 'Das ausgewählte Schuljahr kann leider nicht gelöscht werden, da die Schüler bereits im Schuljahr eingeschrieben sind', 'Nažalost, odabranu školsku godinu nije moguće izbrisati jer su učenici već upisani u školsku godinu', NULL, NULL, NULL, NULL, NULL),
(438, 'message', 'msg_school_year_delete_success', 'School Year Successfully Deleted', 'Año escolar eliminado con éxito', 'Schuljahr erfolgreich gelöscht', 'Školska godina uspješno je izbrisana', NULL, NULL, NULL, NULL, NULL),
(439, 'message', 'msg_education_program_delete_prompt', 'Sorry, the selected education program cannot be deleted as it is already being used by schools', 'Lo sentimos, el programa educativo seleccionado no se puede eliminar ya que las escuelas ya lo están utilizando.', 'Das ausgewählte Bildungsprogramm kann leider nicht gelöscht werden, da es bereits von Schulen verwendet wird', 'Nažalost, odabrani obrazovni program nije moguće izbrisati jer ga škole već koriste', NULL, NULL, NULL, NULL, NULL),
(440, 'message', 'msg_education_program_delete_success', 'Education Program Successfully Deleted', 'Programa educativo eliminado con éxito', 'Bildungsprogramm erfolgreich gelöscht', 'Obrazovni program uspješno je obrisan', NULL, NULL, NULL, NULL, NULL),
(441, 'message', 'msg_school_delete_success', 'School Successfully Deleted', 'Escuela eliminada exitosamente', 'Schule erfolgreich gelöscht', 'Škola je uspješno izbrisana', NULL, NULL, NULL, NULL, NULL),
(442, 'message', 'msg_school_delete_prompt', 'Sorry, the selected school cannot be deleted as it already has employees, village school, main book', 'Lo sentimos, la escuela seleccionada no se puede eliminar porque ya tiene empleados, escuela del pueblo, libro principal', 'Die ausgewählte Schule kann leider nicht gelöscht werden, da sie bereits Mitarbeiter, Dorfschule und Hauptbuch enthält', 'Nažalost, odabrana škola ne može se izbrisati, jer ona već ima zaposlenike, seosku školu, glavnu knjigu', NULL, NULL, NULL, NULL, NULL),
(443, 'general', 'gn_end_date_note', 'Only enter \"Date of Engagement End\" date field if you wish to inactive the employee', 'Solo ingrese el campo de fecha \"Fecha de finalización del compromiso\" si desea inactivar al empleado', 'Geben Sie das Datumsfeld \"Datum des Engagements\" nur ein, wenn Sie den Mitarbeiter inaktivieren möchten', 'Unesite datum datuma \"Datum završetka zaruke\" samo ako želite neaktivno zaposlenika', NULL, NULL, NULL, NULL, NULL),
(444, 'general', 'gn_engagement_type', 'Engagement Type', 'Tipo de compromiso', 'Verlobungsart', 'Vrsta zaruka', NULL, NULL, NULL, NULL, NULL),
(445, 'general', 'gn_employee_type', 'Employee Type', 'tipo de empleado', 'Mitarbeitertyp', 'Vrsta zaposlenika', NULL, NULL, NULL, NULL, NULL),
(446, 'general', 'gn_engage_employee', 'Engage Employee', 'Comprometer Empleado', 'Mitarbeiter Engagieren', 'Angažirati Zaposlenika', NULL, NULL, NULL, NULL, NULL),
(447, 'general', 'gn_engage_employee_note', 'If the employee is already registered with system than you can Engage with your school', 'Si el empleado ya está registrado en el sistema, puede comprometerse con su escuela', 'Wenn der Mitarbeiter bereits beim System registriert ist, können Sie sich an Ihrer Schule beteiligen', 'Ako je zaposlenik već registriran u sustavu, tada se možete uključiti u svoju školu', NULL, NULL, NULL, NULL, NULL),
(448, 'general', 'gn_engagement', 'Engagement', 'Compromiso', 'Engagement', 'Angažman', NULL, NULL, NULL, NULL, NULL),
(449, 'general', 'gn_search_teachers', 'Search Teachers', 'Buscar maestros', 'Suche Lehrer', 'Traži učitelje', NULL, NULL, NULL, NULL, NULL),
(450, 'general', 'gn_engagement_details', 'Details for Engagement', 'Detalles para el compromiso', 'Details zum Engagement', 'Pojedinosti za zaruke', NULL, NULL, NULL, NULL, NULL),
(451, 'general', 'gn_week_hourly_rate', 'Week Hourly Rate', 'Semana Tarifa por hora', 'Wochenstundensatz', 'Tjedni sat po satu', NULL, NULL, NULL, NULL, NULL),
(452, 'sidebar', 'sidebar_nav_sa_sa', 'Student Attendance & Syllabus Accomplishment', 'Asistencia estudiantil y realización del plan de estudios', 'Teilnahme an Studenten und Lehrplanerfüllung', 'Pohađanje studentske nastave i nastavni plan i program', NULL, NULL, NULL, NULL, NULL),
(453, 'sidebar', 'sidebar_nav_extracurricular_activity', 'Extracurricular Activity', 'Actividad Extracurricular', 'Außerschulische Aktivitäten', 'Izvannastavna Aktivnost', NULL, NULL, NULL, NULL, NULL),
(454, 'sidebar', 'sidebar_nav_discipline_measure', 'Discipline Measure', 'Medida Disciplinaria', 'Disziplin Maßnahme', 'Mjera Discipline', NULL, NULL, NULL, NULL, NULL),
(455, 'sidebar', 'sidebar_nav_allocated_class', 'Allocated Class', 'Clase Asignada', 'Zugewiesene Klasse', 'Dodijeljena Klasa', NULL, NULL, NULL, NULL, NULL),
(456, 'sidebar', 'sidebar_nav_exam', 'Exam', 'Examen', 'Prüfung', 'Ispit', NULL, NULL, NULL, NULL, NULL),
(457, 'general', 'gn_student_name', 'Student Name', 'nombre del estudiante', 'Name des Studenten', 'ime studenta', NULL, NULL, NULL, NULL, NULL),
(458, 'general', 'gn_student_surname', 'Student Surname', 'Apellido del estudiante', 'Student Nachname', 'Prezime učenika', NULL, NULL, NULL, NULL, NULL),
(459, 'general', 'gn_student_id', 'Student ID', 'Identificación del Estudiante', 'Student ID', 'studentska iskaznica', NULL, NULL, NULL, NULL, NULL),
(460, 'general', 'gn_havent_identification_number', 'Havent Identification Number', 'Número de identificación de Havent', 'Havent Identifikationsnummer', 'Identifikacijski broj Havent', NULL, NULL, NULL, NULL, NULL),
(461, 'general', 'gn_date_Of_birth', 'Date Of Birth', 'Fecha de nacimiento', 'Geburtsdatum', 'Datum rođenja', NULL, NULL, NULL, NULL, NULL),
(462, 'general', 'gn_father_name', 'Father Name', 'Nombre del Padre', 'Der Name des Vaters', 'Ime Oca', NULL, NULL, NULL, NULL, NULL),
(463, 'general', 'gn_mother_name', 'Mother Name', 'Nombre de la madre', 'Name der Mutter', 'Ime majke', NULL, NULL, NULL, NULL, NULL),
(464, 'general', 'gn_father_job', 'Father Job', 'Padre trabajo', 'Vater Job', 'Otac Job', NULL, NULL, NULL, NULL, NULL),
(465, 'general', 'gn_mother_job', 'Mother Job', 'Madre trabajo', 'Mutter Job', 'Majka Job', NULL, NULL, NULL, NULL, NULL),
(466, 'general', 'gn_parent_email', 'Parent Email', 'Correo electrónico de los padres', 'Übergeordnete E-Mail', 'Roditeljski email', NULL, NULL, NULL, NULL, NULL),
(467, 'general', 'gn_Parent_phone_no', 'Parent Phone No.', 'número de teléfono de los padres', 'übergeordnete Telefonnummer', 'matični telefonski broj', NULL, NULL, NULL, NULL, NULL),
(468, 'general', 'gn_date_Of_abandoning', 'Date Of Abandoning', 'Fecha de abandono', 'Datum der Aufgabe', 'Datum napuštanja', NULL, NULL, NULL, NULL, NULL),
(469, 'general', 'gn_date_of_expelling', 'Date Of Expelling', 'Fecha de expulsión', 'Datum des Ausschlusses', 'Datum istjerivanja', NULL, NULL, NULL, NULL, NULL),
(470, 'general', 'gn_reason', 'Reason', 'Razón', 'Grund', 'Razlog', NULL, NULL, NULL, NULL, NULL),
(471, 'general', 'gn_special_needs', 'Special Needs', 'Necesidades especiales', 'Besondere Bedürfnisse', 'Posebne potrebe', NULL, NULL, NULL, NULL, NULL),
(472, 'general', 'gn_distance_in_kilometers', 'Distance In Kilometers', 'Distancia en kilómetros', 'Entfernung in Kilometern', 'Udaljenost u kilometrima', NULL, NULL, NULL, NULL, NULL),
(473, 'general', 'gn_mobile_phone_number', 'Mobile Phone Number', 'Número de teléfono móvil', 'Handynummer', 'Broj mobitela', NULL, NULL, NULL, NULL, NULL),
(474, 'general', 'gn_student_email', 'Student Email', 'Email del estudiante', 'Schüler-E-Mail', 'Studentski e-mail', NULL, NULL, NULL, NULL, NULL),
(475, 'message', 'msg_data_already_exist', 'Data Already Exist', 'Los datos ya existen', 'Daten sind bereits vorhanden', 'Podaci već postoje', NULL, NULL, NULL, NULL, NULL),
(476, 'message', 'msg_main_book_exist', 'Main Book already exists with this name', 'El libro principal ya existe con este nombre', 'Hauptbuch existiert bereits mit diesem Namen', 'Glavna knjiga već postoji s ovim imenom', NULL, NULL, NULL, NULL, NULL),
(477, 'message', 'msg_main_book_update_success', 'Main Book Successfully Updated', 'Libro principal actualizado con éxito', 'Hauptbuch erfolgreich aktualisiert', 'Glavna knjiga je uspješno ažurirana', NULL, NULL, NULL, NULL, NULL),
(478, 'message', 'msg_main_book_add_success', 'Main Book Successfully Added', 'Libro principal agregado con éxito', 'Hauptbuch erfolgreich hinzugefügt', 'Glavna knjiga uspješno je dodana', NULL, NULL, NULL, NULL, NULL),
(479, 'sidebar', 'sidebar_nav_employees', 'Employees', 'Empleados', 'Angestellte', 'zaposlenici', NULL, NULL, NULL, NULL, NULL),
(480, 'general', 'gn_search_employees', 'Search Employees', 'Buscar empleados', 'Mitarbeiter suchen', 'Pretražite zaposlene', NULL, NULL, NULL, NULL, NULL),
(481, 'message', 'msg_emp_sel_exist', 'An employee is already selected', 'Un empleado ya está seleccionado', 'Ein Mitarbeiter ist bereits ausgewählt', 'Zaposlenik je već odabran', NULL, NULL, NULL, NULL, NULL),
(482, 'message', 'msg_sel_emp', 'Please select an employee', 'Por favor seleccione un empleado', 'Bitte wählen Sie einen Mitarbeiter aus', 'Odaberite zaposlenika', NULL, NULL, NULL, NULL, NULL),
(483, 'message', 'msg_employee_engage_success', 'Employee successfully engaged', 'Empleado comprometido exitosamente', 'Mitarbeiter erfolgreich engagiert', 'Zaposlenik se uspješno angažirao', NULL, NULL, NULL, NULL, NULL),
(484, 'message', 'msg_please_add_engagment', 'Please add an engagment', 'Por favor agregue un compromiso', 'Bitte fügen Sie eine Verpflichtung hinzu', 'Dodajte angažman', NULL, NULL, NULL, NULL, NULL),
(485, 'message', 'msg_work_exp_update_success', 'Work Experience Successfully Updated', 'Experiencia laboral actualizada con éxito', 'Berufserfahrung erfolgreich aktualisiert', 'Radno iskustvo uspješno je ažurirano', NULL, NULL, NULL, NULL, NULL),
(486, 'message', 'msg_no_data_available', 'No data available', 'Datos no disponibles', 'Keine Daten verfügbar', 'Nema dostupnih podataka', NULL, NULL, NULL, NULL, NULL),
(487, 'message', 'msg_student_id_exist', 'Student Id already exists, Please try with a different Student Id', 'El ID del estudiante ya existe. Intente con un ID de estudiante diferente.', 'Studentenausweis existiert bereits. Bitte versuchen Sie es mit einem anderen Studentenausweis', 'Student Student već postoji. Pokušajte s drugim Student ID-om', NULL, NULL, NULL, NULL, NULL),
(488, 'general', 'gn_add_new_student', 'Add New Student', 'Agregar nuevo alumno', 'Neuen Schüler hinzufügen', 'Dodajte novog učenika', NULL, NULL, NULL, NULL, NULL),
(489, 'message', 'msg_student_sel_exist', 'A student is already selected', 'Un estudiante ya esta seleccionado', 'Ein Student ist bereits ausgewählt', 'Student je već odabran', NULL, NULL, NULL, NULL, NULL),
(490, 'message', 'msg_sel_student', 'Please select a student', 'Por favor seleccione un estudiante', 'Bitte wählen Sie einen Schüler aus', 'Odaberite učenika', NULL, NULL, NULL, NULL, NULL),
(491, 'general', 'gn_student', 'Student', 'Alumna', 'Studentin', 'Student', NULL, NULL, NULL, NULL, NULL),
(492, 'general', 'gn_enroll_student_note', 'Enroll Student Note', 'Inscribir nota del estudiante', 'Schülernotiz einschreiben', 'Upisati studentske bilješke', NULL, NULL, NULL, NULL, NULL),
(493, 'general', 'gn_enroll_student', 'Enroll Student', 'Matricular estudiante', 'Schüler einschreiben', 'Upis studenta', NULL, NULL, NULL, NULL, NULL),
(494, 'general', 'gn_enroll', 'Enroll', 'Inscribirse', 'Einschreiben', 'Upisati', NULL, NULL, NULL, NULL, NULL),
(495, 'general', 'gn_surname', 'Surname', 'Apellido', 'Nachname', 'Prezime', NULL, NULL, NULL, NULL, NULL),
(496, 'general', 'gn_details_enrollment', 'Details Enrollment', 'Inscripción de detalles', 'Details Einschreibung', 'Detalji Upis', NULL, NULL, NULL, NULL, NULL),
(497, 'message', 'msg_image_validation', 'Please select a valid image', 'Por favor seleccione una imagen válida', 'Bitte wählen Sie ein gültiges Bild', 'Odaberite valjanu sliku', NULL, NULL, NULL, NULL, NULL),
(498, 'message', 'msg_select_education_plan', 'Please select education plan', 'Por favor seleccione el plan educativo', 'Bitte wählen Sie einen Bildungsplan', 'Odaberite plan obrazovanja', NULL, NULL, NULL, NULL, NULL),
(499, 'message', 'msg_Teacher_add_success', 'Teacher add success', 'Maestro agrega éxito', 'Lehrer fügen Erfolg hinzu', 'Učitelj dodaje uspjeh', NULL, NULL, NULL, NULL, NULL),
(500, 'message', 'msg_Teacher_update_success', 'Teacher update success', 'Actualización del maestro exitosa', 'Erfolg der Lehreraktualisierung', 'Učitelj ažurira uspjeh', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `translations` (`id`, `section`, `key`, `value_en`, `value_sr`, `value_ba`, `value_hr`, `value_Hn`, `value_trr`, `value_Te`, `value_tes`, `deleted_at`) VALUES
(501, 'message', 'msg_admin_staff_delete_success', 'Admin staff successfully deleted', 'El personal administrativo se eliminó correctamente', 'Verwaltungsmitarbeiter erfolgreich gelöscht', 'Osoblje administratora uspješno je izbrisano', NULL, NULL, NULL, NULL, NULL),
(502, 'general', 'gn_joining_date', 'Joining Date', 'Dia de ingreso', 'Beitrittsdatum', 'Datum pridruženja', NULL, NULL, NULL, NULL, NULL),
(503, 'sidebar', 'sidebar_nav_admin_staff', 'Admin Staff', 'Personal administrativo', 'Verwaltungspersonal', 'Administrativno osoblje', NULL, NULL, NULL, NULL, NULL),
(504, 'general', 'gn_admin_staff', 'Admin Staff', 'Personal administrativo', 'Verwaltungspersonal', 'Administrativno osoblje', NULL, NULL, NULL, NULL, NULL),
(505, 'general', 'gn_not_engaged', 'Not Engaged', 'No comprometido', 'Nicht verlobt', 'Nije zaručen', NULL, NULL, NULL, NULL, NULL),
(506, 'general', 'gn_add_engagement', 'Add Engagement', 'Agregar compromiso', 'Engagement hinzufügen', 'Dodajte angažman', NULL, NULL, NULL, NULL, NULL),
(507, 'message', 'msg_add_engagement', 'Add Engagement', 'Agregar compromiso', 'Engagement hinzufügen', 'Dodajte angažman', NULL, NULL, NULL, NULL, NULL),
(508, 'general', 'gn_edit_engagement', 'Edit Engagement', 'Editar compromiso', 'Engagement bearbeiten', 'Uređivanje angažmana', NULL, NULL, NULL, NULL, NULL),
(509, 'message', 'msg_access_prohibited', 'Access Prohibited', 'Acceso prohibido', 'Zugriff verboten', 'Zabranjen pristup', NULL, NULL, NULL, NULL, NULL),
(510, 'general', 'gn_engaged', 'Engaged', 'Comprometido', 'Beschäftigt, verlobt', 'zauzet', NULL, NULL, NULL, NULL, NULL),
(511, 'general', 'gn_main_book_number', 'Main Book No.', 'Número de libro principal', 'Hauptbuchnummer', 'Glavni broj knjige', NULL, NULL, NULL, NULL, NULL),
(512, 'general', 'gn_order_no', 'Order No.', 'Número de orden', 'Bestellnummer', 'Broj narudžbe', NULL, NULL, NULL, NULL, NULL),
(513, 'general', 'gn_school_year', 'School Year', 'Año escolar', 'Schuljahr', 'Školska godina', NULL, NULL, NULL, NULL, NULL),
(514, 'general', 'gn_expelling_date', 'Expelling Date', 'Fecha de expulsión', 'Ausweisungsdatum', 'Datum istjerivanja', NULL, NULL, NULL, NULL, NULL),
(515, 'general', 'gn_breaking_date', 'Breaking Date', 'Fecha de ruptura', 'Breaking Date', 'Datum razbijanja', NULL, NULL, NULL, NULL, NULL),
(516, 'general', 'gn_finishing_date', 'Finishing Date', 'Fecha de finalización', 'Enddatum', 'Datum završetka', NULL, NULL, NULL, NULL, NULL),
(517, 'general', 'gn_ste_Reason', 'Reason', 'Razón', 'Grund', 'Razlog', NULL, NULL, NULL, NULL, NULL),
(518, 'general', 'gn_enroll_based_on', 'Enroll Based On', 'Inscripción basada en', 'Anmeldung basierend auf', 'Upis na temelju', NULL, NULL, NULL, NULL, NULL),
(519, 'message', 'msg_please_add_student', 'Please Add Student', 'Por favor, agregue estudiante', 'Bitte Schüler hinzufügen', 'Molimo dodajte Student', NULL, NULL, NULL, NULL, NULL),
(520, 'message', 'msg_student_already_selected_same_school', 'Student already exists in the selected school and school year', 'El estudiante ya existe en la escuela y el año escolar seleccionados.', 'Der Schüler existiert bereits in der ausgewählten Schule und im ausgewählten Schuljahr', 'Učenik već postoji u odabranoj školskoj i školskoj godini', NULL, NULL, NULL, NULL, NULL),
(521, 'sidebar', 'sidebar_nav_organization', 'Organization', 'Organización', 'Organisation', 'Organizacija', NULL, NULL, NULL, NULL, NULL),
(522, 'message', 'msg_id_does_not_exist', 'Employee Id Does Not exists', 'La identificación del empleado no existe', 'Mitarbeiter-ID existiert nicht', 'ID zaposlenika ne postoji', NULL, NULL, NULL, NULL, NULL),
(523, 'general', 'gn_semester', 'Semester', 'Semestre', 'Semester', 'Semestar', NULL, NULL, NULL, NULL, NULL),
(524, 'general', 'gn_school_grade', 'School Grade', 'Grado escolar', 'Schulnote', 'školska ocjena', NULL, NULL, NULL, NULL, NULL),
(525, 'general', 'gn_village_school', 'Village School', 'Colegio de pueblo', 'Dorfschule', 'Seoska škola', NULL, NULL, NULL, NULL, NULL),
(526, 'message', 'msg_student_update_success', 'Student Successfully Updated', 'Estudiante actualizado con éxito', 'Student erfolgreich aktualisiert', 'Student uspješno ažuriran', NULL, NULL, NULL, NULL, NULL),
(527, 'general', 'gn_is_village_school', 'Is it a Village School ?', '¿Es una escuela del pueblo', 'Ist es eine Dorfschule ?', 'Je li to seoska škola ?', NULL, NULL, NULL, NULL, NULL),
(528, 'message', 'msg_student_add_success', 'Student add success', 'Estudiante agrega éxito', 'Schüler fügen Erfolg hinzu', 'Učenici dodaju uspjeh', NULL, NULL, NULL, NULL, NULL),
(529, 'message', 'msg_student_delete_success', 'Student delete success', 'Estudiante eliminar éxito', 'Schüler löschen Erfolg', 'Uspjeh brisanja učenika', NULL, NULL, NULL, NULL, NULL),
(530, 'message', 'msg_student_enrolled_success', 'Student enrolled success', 'Estudiante matriculado éxito', 'Student eingeschriebener Erfolg', 'Student upisao uspjeh', NULL, NULL, NULL, NULL, NULL),
(531, 'general', 'gn_religions', 'Religions', 'Religiones', 'Religionen', 'religije', NULL, NULL, NULL, NULL, NULL),
(532, 'general', 'gn_clerk', 'Clerk', 'Empleada', 'Schreiberin', 'Službenik', NULL, NULL, NULL, NULL, NULL),
(533, 'general', 'gn_school_sub_admin', 'School Sub Admin', 'Subadministrador escolar', 'School Sub Admin', 'Školski sub administrator', NULL, NULL, NULL, NULL, NULL),
(534, 'general', 'gn_search_student', 'Search Student', 'студент за претрагу', 'Student za pretragu', 'Student za pretraživanje', NULL, NULL, NULL, NULL, NULL),
(535, 'general', 'gn_selected_students', 'Selected Students', 'Изабрани студенти', 'Odabrani studenti', 'Odabrani studenti', NULL, NULL, NULL, NULL, NULL),
(536, 'message', 'msg_student_select_valid', 'The student already selected', 'Студент је већ изабран', 'Student je već odabran', 'Student već odabran', NULL, NULL, NULL, NULL, NULL),
(537, 'message', 'msg_sel_stu', 'Please select a student', 'Изаберите ученика', 'Molimo odaberite učenika', 'Odaberite učenika', NULL, NULL, NULL, NULL, NULL),
(538, 'message', 'msg_class_creation_step_1_success', 'Class Creation Step 1 Successful', 'Стварање класе 1. корак је успешан', 'Stvaranje klase 1. korak je uspešan', 'Stvaranje klase 1. korak je uspješan', NULL, NULL, NULL, NULL, NULL),
(539, 'message', 'msg_class_creation_step_2_success', 'Class Creation Step 2 Successful', 'Стварање класе 2. корак је успешан', 'Stvaranje klase 2. korak je uspešan', 'Stvaranje klase 2. korak je uspješan', NULL, NULL, NULL, NULL, NULL),
(540, 'message', 'msg_class_creation_step_3_success', 'Class Creation Step 3 Successful', 'Стварање класе 3. корак је успешан', 'Stvaranje klase 3. korak je uspešan', 'Stvaranje klase 3. korak je uspješan', NULL, NULL, NULL, NULL, NULL),
(541, 'message', 'msg_class_creation_step_4_success', 'Class Creation Step 4 Successful', 'Стварање класе 4. корак је успешан', 'Stvaranje klase 4. korak je uspešan', 'Stvaranje klase 4. korak je uspješan', NULL, NULL, NULL, NULL, NULL),
(542, 'sidebar', 'sidebar_nav_listing_class', 'Listing of Class', 'Списак класе', 'Spisak klase', 'Popis klasa', NULL, NULL, NULL, NULL, NULL),
(543, 'general', 'gn_no_of_students', 'No. of Students', 'Број студената', 'Broj studenata', 'Broj studenata', NULL, NULL, NULL, NULL, NULL),
(544, 'sidebar', 'sidebar_nav_class_creations', 'Class Creations', 'Цреатионс Цреатионс', 'Klasne kreacije', 'Klasne kreacije', NULL, NULL, NULL, NULL, NULL),
(545, 'message', 'msg_class_creation_delete_prompt', 'Sorry, the selected class creation cannot be deleted', 'Нажалост, изабрано стварање класе не може се избрисати', 'Nažalost, odabrano stvaranje klase ne može se izbrisati', 'Nažalost, odabrano stvaranje klase nije moguće izbrisati', NULL, NULL, NULL, NULL, NULL),
(546, 'message', 'msg_class_creation_delete_success', 'Class Creation Successfully Deleted', 'Креирање класе је успешно избрисано', 'Stvaranje klase uspješno je izbrisano', 'Stvaranje klase uspješno je izbrisano', NULL, NULL, NULL, NULL, NULL),
(547, 'general', 'gn_class_creation_step_3_subtext', 'Allocate Teachers for all Courses', 'Доделите наставнике за све курсеве', 'Dodijelite nastavnike za sve tečajeve', 'Dodijelite nastavnike za sve tečajeve', NULL, NULL, NULL, NULL, NULL),
(548, 'message', 'msg_no_result_found', 'No result found', 'нема резултата', 'Nije pronađen rezultat', 'Nije pronađen rezultat', NULL, NULL, NULL, NULL, NULL),
(549, 'general', 'gn_chief_student', 'Chief student', 'Главни студент', 'Glavni student', 'Glavni student', NULL, NULL, NULL, NULL, NULL),
(550, 'general', 'gn_treasure_student', 'Treasure student', 'Треасуре студент', 'Treasure student', 'Učenik blaga', NULL, NULL, NULL, NULL, NULL),
(551, 'validation', 'validate_max', 'Please enter a value less than or equal to {0}.', 'Унесите вредност мању или једнаку {0}.', 'Unesite vrijednost manju ili jednaku {0}.', 'Unesite vrijednost manju ili jednaku {0}.', NULL, NULL, NULL, NULL, NULL),
(552, 'validation', 'validate_min', 'Please enter a value greater than or equal to {0}.', 'Унесите вредност већу или једнаку {0}.', 'Unesite vrijednost veću ili jednaku {0}.', 'Unesite vrijednost veću ili jednaku {0}.', NULL, NULL, NULL, NULL, NULL),
(553, 'message', 'msg_no_data_available_table', 'No data available in table', 'Нема података у табели', 'Nema podataka u tabeli', 'Nema podataka u tablici', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `universities`
--

CREATE TABLE `universities` (
  `pkUni` int(11) NOT NULL,
  `fkUniCny` int(11) DEFAULT NULL,
  `fkUniOty` int(11) DEFAULT NULL,
  `uni_Uid` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `uni_UniversityName_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uni_UniversityName_sr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uni_UniversityName_ba` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uni_UniversityName_hr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uni_UniversityName_Hn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uni_YearStartedFounded` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `uni_PicturePath` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `uni_Notes` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `universities`
--

INSERT INTO `universities` (`pkUni`, `fkUniCny`, `fkUniOty`, `uni_Uid`, `uni_UniversityName_en`, `uni_UniversityName_sr`, `uni_UniversityName_ba`, `uni_UniversityName_hr`, `uni_UniversityName_Hn`, `uni_YearStartedFounded`, `uni_PicturePath`, `uni_Notes`, `deleted_at`) VALUES
(1, 1, 2, 'UNI1', 'RTU', 'RTU', 'RTU', 'RTU', NULL, '2004', '1588152944.jpg', 'note for uni', NULL),
(2, 4, 3, 'UNI2', 'University of Mostar', 'University of Mostar 1', 'University of Mostar 2', 'University of Mostar 3', NULL, '1977', NULL, NULL, NULL),
(3, 4, 1, 'UNI3', 'University of Zenica', 'University of Zenica', 'University of Zenica', 'University of Zenica', NULL, '2000', NULL, NULL, NULL),
(4, 1, 1, 'UNI4', 'GTU', 'GTU', 'GTU', 'GTU', NULL, '2007', NULL, 'A university in gujarat', NULL),
(5, 2, 2, 'UNI5', 'NMUe', 'NMUsss', 'NMUgggg', 'NMUc', NULL, '2000', NULL, 'test note', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `villageschools`
--

CREATE TABLE `villageschools` (
  `pkVsc` int(11) NOT NULL,
  `fkVscSch` int(11) DEFAULT NULL,
  `fkVscPof` int(11) DEFAULT NULL,
  `vsc_Uid` varchar(50) DEFAULT NULL,
  `vsc_VillageSchoolName_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vsc_VillageSchoolName_sr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vsc_VillageSchoolName_de` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vsc_VillageSchoolName_hr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vsc_VillageSchoolName_ba` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vsc_Residence` varchar(255) DEFAULT NULL,
  `vsc_PhoneNumber` varchar(20) DEFAULT NULL,
  `vsc_Address` text,
  `vsc_Notes` text,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `villageschools`
--

INSERT INTO `villageschools` (`pkVsc`, `fkVscSch`, `fkVscPof`, `vsc_Uid`, `vsc_VillageSchoolName_en`, `vsc_VillageSchoolName_sr`, `vsc_VillageSchoolName_de`, `vsc_VillageSchoolName_hr`, `vsc_VillageSchoolName_ba`, `vsc_Residence`, `vsc_PhoneNumber`, `vsc_Address`, `vsc_Notes`, `deleted_at`) VALUES
(1, 3, 3, 'VSC1', 'Alpha School EN', 'Alpha School SP', 'Alpha School', 'Alpha School', '', '124 lorem ipsum', '684864848', '124 lorem ipsum', 'ds', '2020-07-27 18:36:31'),
(2, 4, 4, 'VSC2', 'Paul\'s Junior High E', 'Paul\'s Junior High S', 'Paul\'s Junior High G', 'Paul\'s Junior High C', '', '122 lorem ipsum', '18324232423', '122 lorem ipsum', 'ss', NULL),
(3, 4, 1, 'VSC3', 'Paul\'s beta school', 'St Paul\'s beta', 'Paul\'s beta school', 'Paul\'s beta school', '', '124 lorem ipsum', '67867867868', '124 lorem ipsum', 'ds', NULL),
(4, 3, 2, 'VSC4', 'Beta school', 'Beta school', 'Beta school', 'Beta school', '', '124 lorem ipsum', '84684648484', '122 lorem ipsum', 'ds', '2020-07-27 18:36:35'),
(5, 3, 2, 'VSC5', 'New junior High', 'New junior High', 'New junior High', 'New junior High', '', '134 leorm ipusm', '86468464', '134 leorm ipusm', 'ss', '2020-07-27 18:36:38'),
(6, 8, 4, 'VSC6', 'checkinggg', 'Village Schools SS', 'Village Schools GG', 'Village Schools CC', '', 'India', '84653212313', 'Dharangaon', 'Checking the records', NULL),
(7, 8, 3, 'VSC7', 'Testtest', 'testtestSS', 'testtestGG', 'testtestCC', '', 'UKK', '846132313231', 'Ahmedabad', 'Checki the resilt', NULL),
(8, 8, 4, 'VSC8', 'Nil', 'Nil', 'Nil', 'Nil', '', 'Indiaaaa', '53154132623', 'Dharangaon', 'Checking the resulttttt', '2020-06-30 19:05:14');

-- --------------------------------------------------------

--
-- Table structure for table `vocations`
--

CREATE TABLE `vocations` (
  `pkVct` int(11) NOT NULL,
  `vct_Uid` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `vct_VocationName_en` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `vct_VocationName_sr` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vct_VocationName_ba` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vct_VocationName_hr` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vct_VocationName_Hn` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vct_Notes` text CHARACTER SET latin1,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vocations`
--

INSERT INTO `vocations` (`pkVct`, `vct_Uid`, `vct_VocationName_en`, `vct_VocationName_sr`, `vct_VocationName_ba`, `vct_VocationName_hr`, `vct_VocationName_Hn`, `vct_Notes`, `deleted_at`) VALUES
(1, 'VOC1', 'vocation', 'vocation', 'vocation', 'vocation', NULL, 'note', NULL),
(2, 'VOC2', 'My new Vocation', 'Mi nueva vocación', 'Mi nueva vocación', 'Mi nueva vocación', NULL, 'New nots', NULL),
(3, 'VOC3', 'Cypress', 'Ciprés', 'Zypresse', 'Čempres', NULL, 'kjdfhkdjq', '2020-06-30 18:15:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academicdegrees`
--
ALTER TABLE `academicdegrees`
  ADD PRIMARY KEY (`pkAcd`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cantons`
--
ALTER TABLE `cantons`
  ADD PRIMARY KEY (`pkCan`);

--
-- Indexes for table `citizenships`
--
ALTER TABLE `citizenships`
  ADD PRIMARY KEY (`pkCtz`);

--
-- Indexes for table `classcreation`
--
ALTER TABLE `classcreation`
  ADD PRIMARY KEY (`pkClr`);

--
-- Indexes for table `classcreationgrades`
--
ALTER TABLE `classcreationgrades`
  ADD PRIMARY KEY (`pkCcg`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`pkCla`);

--
-- Indexes for table `classstudentsallocation`
--
ALTER TABLE `classstudentsallocation`
  ADD PRIMARY KEY (`pkCsa`);

--
-- Indexes for table `classteachersandcourseallocation`
--
ALTER TABLE `classteachersandcourseallocation`
  ADD PRIMARY KEY (`pkCtc`);

--
-- Indexes for table `colleges`
--
ALTER TABLE `colleges`
  ADD PRIMARY KEY (`pkCol`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`pkCny`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`pkCrs`);

--
-- Indexes for table `educationperiods`
--
ALTER TABLE `educationperiods`
  ADD PRIMARY KEY (`pkEdp`);

--
-- Indexes for table `educationplans`
--
ALTER TABLE `educationplans`
  ADD PRIMARY KEY (`pkEpl`);

--
-- Indexes for table `educationplansforeignlanguage`
--
ALTER TABLE `educationplansforeignlanguage`
  ADD PRIMARY KEY (`pkEfl`);

--
-- Indexes for table `educationplansmandatorycourses`
--
ALTER TABLE `educationplansmandatorycourses`
  ADD PRIMARY KEY (`pkEmc`);

--
-- Indexes for table `educationplansoptionalcourses`
--
ALTER TABLE `educationplansoptionalcourses`
  ADD PRIMARY KEY (`pkEoc`);

--
-- Indexes for table `educationprofiles`
--
ALTER TABLE `educationprofiles`
  ADD PRIMARY KEY (`pkEpr`);

--
-- Indexes for table `educationprograms`
--
ALTER TABLE `educationprograms`
  ADD PRIMARY KEY (`pkEdp`);

--
-- Indexes for table `employeedesignations`
--
ALTER TABLE `employeedesignations`
  ADD PRIMARY KEY (`pkEde`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employeeseducationdetails`
--
ALTER TABLE `employeeseducationdetails`
  ADD PRIMARY KEY (`pkEed`);

--
-- Indexes for table `employeesengagement`
--
ALTER TABLE `employeesengagement`
  ADD PRIMARY KEY (`pkEen`);

--
-- Indexes for table `employeetypes`
--
ALTER TABLE `employeetypes`
  ADD PRIMARY KEY (`pkEpty`);

--
-- Indexes for table `engagementtypes`
--
ALTER TABLE `engagementtypes`
  ADD PRIMARY KEY (`pkEty`);

--
-- Indexes for table `extracurricuralactivitytypes`
--
ALTER TABLE `extracurricuralactivitytypes`
  ADD PRIMARY KEY (`pkSat`);

--
-- Indexes for table `facultativecoursesgroups`
--
ALTER TABLE `facultativecoursesgroups`
  ADD PRIMARY KEY (`pkFcg`);

--
-- Indexes for table `foreignlanguagegroups`
--
ALTER TABLE `foreignlanguagegroups`
  ADD PRIMARY KEY (`pkFon`);

--
-- Indexes for table `generalpurposegroups`
--
ALTER TABLE `generalpurposegroups`
  ADD PRIMARY KEY (`pkGpg`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`pkGra`);

--
-- Indexes for table `homeroomteacher`
--
ALTER TABLE `homeroomteacher`
  ADD PRIMARY KEY (`pkHrt`);

--
-- Indexes for table `jobandwork`
--
ALTER TABLE `jobandwork`
  ADD PRIMARY KEY (`pkJaw`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mainbooks`
--
ALTER TABLE `mainbooks`
  ADD PRIMARY KEY (`pkMbo`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `municipalities`
--
ALTER TABLE `municipalities`
  ADD PRIMARY KEY (`pkMun`);

--
-- Indexes for table `nationaleducationplans`
--
ALTER TABLE `nationaleducationplans`
  ADD PRIMARY KEY (`pkNep`);

--
-- Indexes for table `nationalities`
--
ALTER TABLE `nationalities`
  ADD PRIMARY KEY (`pkNat`);

--
-- Indexes for table `optionalcoursesgroups`
--
ALTER TABLE `optionalcoursesgroups`
  ADD PRIMARY KEY (`pkOcg`);

--
-- Indexes for table `ownershiptypes`
--
ALTER TABLE `ownershiptypes`
  ADD PRIMARY KEY (`pkOty`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `postoffices`
--
ALTER TABLE `postoffices`
  ADD PRIMARY KEY (`pkPof`);

--
-- Indexes for table `qualificationsdegrees`
--
ALTER TABLE `qualificationsdegrees`
  ADD PRIMARY KEY (`pkQde`);

--
-- Indexes for table `religions`
--
ALTER TABLE `religions`
  ADD PRIMARY KEY (`pkRel`);

--
-- Indexes for table `schooleducationplanassignment`
--
ALTER TABLE `schooleducationplanassignment`
  ADD PRIMARY KEY (`pkSep`);

--
-- Indexes for table `schoolphotos`
--
ALTER TABLE `schoolphotos`
  ADD PRIMARY KEY (`pkSph`);

--
-- Indexes for table `schoolprincipals`
--
ALTER TABLE `schoolprincipals`
  ADD PRIMARY KEY (`pkScp`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`pkSch`);

--
-- Indexes for table `schoolyears`
--
ALTER TABLE `schoolyears`
  ADD PRIMARY KEY (`pkSye`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`pkSta`);

--
-- Indexes for table `studentbehaviours`
--
ALTER TABLE `studentbehaviours`
  ADD PRIMARY KEY (`pkSbe`);

--
-- Indexes for table `studentdisciplinemeasuretypes`
--
ALTER TABLE `studentdisciplinemeasuretypes`
  ADD PRIMARY KEY (`pkSmt`);

--
-- Indexes for table `studentenrollments`
--
ALTER TABLE `studentenrollments`
  ADD PRIMARY KEY (`pkSte`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `universities`
--
ALTER TABLE `universities`
  ADD PRIMARY KEY (`pkUni`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `villageschools`
--
ALTER TABLE `villageschools`
  ADD PRIMARY KEY (`pkVsc`);

--
-- Indexes for table `vocations`
--
ALTER TABLE `vocations`
  ADD PRIMARY KEY (`pkVct`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academicdegrees`
--
ALTER TABLE `academicdegrees`
  MODIFY `pkAcd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `cantons`
--
ALTER TABLE `cantons`
  MODIFY `pkCan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `citizenships`
--
ALTER TABLE `citizenships`
  MODIFY `pkCtz` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `classcreation`
--
ALTER TABLE `classcreation`
  MODIFY `pkClr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `classcreationgrades`
--
ALTER TABLE `classcreationgrades`
  MODIFY `pkCcg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `pkCla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `classstudentsallocation`
--
ALTER TABLE `classstudentsallocation`
  MODIFY `pkCsa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `classteachersandcourseallocation`
--
ALTER TABLE `classteachersandcourseallocation`
  MODIFY `pkCtc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `colleges`
--
ALTER TABLE `colleges`
  MODIFY `pkCol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `pkCny` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `pkCrs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `educationperiods`
--
ALTER TABLE `educationperiods`
  MODIFY `pkEdp` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `educationplans`
--
ALTER TABLE `educationplans`
  MODIFY `pkEpl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `educationplansforeignlanguage`
--
ALTER TABLE `educationplansforeignlanguage`
  MODIFY `pkEfl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `educationplansmandatorycourses`
--
ALTER TABLE `educationplansmandatorycourses`
  MODIFY `pkEmc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `educationplansoptionalcourses`
--
ALTER TABLE `educationplansoptionalcourses`
  MODIFY `pkEoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `educationprofiles`
--
ALTER TABLE `educationprofiles`
  MODIFY `pkEpr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `educationprograms`
--
ALTER TABLE `educationprograms`
  MODIFY `pkEdp` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `employeedesignations`
--
ALTER TABLE `employeedesignations`
  MODIFY `pkEde` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `employeeseducationdetails`
--
ALTER TABLE `employeeseducationdetails`
  MODIFY `pkEed` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;

--
-- AUTO_INCREMENT for table `employeesengagement`
--
ALTER TABLE `employeesengagement`
  MODIFY `pkEen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `employeetypes`
--
ALTER TABLE `employeetypes`
  MODIFY `pkEpty` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `engagementtypes`
--
ALTER TABLE `engagementtypes`
  MODIFY `pkEty` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `extracurricuralactivitytypes`
--
ALTER TABLE `extracurricuralactivitytypes`
  MODIFY `pkSat` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `facultativecoursesgroups`
--
ALTER TABLE `facultativecoursesgroups`
  MODIFY `pkFcg` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `foreignlanguagegroups`
--
ALTER TABLE `foreignlanguagegroups`
  MODIFY `pkFon` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `generalpurposegroups`
--
ALTER TABLE `generalpurposegroups`
  MODIFY `pkGpg` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `pkGra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `homeroomteacher`
--
ALTER TABLE `homeroomteacher`
  MODIFY `pkHrt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobandwork`
--
ALTER TABLE `jobandwork`
  MODIFY `pkJaw` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `mainbooks`
--
ALTER TABLE `mainbooks`
  MODIFY `pkMbo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `municipalities`
--
ALTER TABLE `municipalities`
  MODIFY `pkMun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `nationaleducationplans`
--
ALTER TABLE `nationaleducationplans`
  MODIFY `pkNep` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `nationalities`
--
ALTER TABLE `nationalities`
  MODIFY `pkNat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `optionalcoursesgroups`
--
ALTER TABLE `optionalcoursesgroups`
  MODIFY `pkOcg` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ownershiptypes`
--
ALTER TABLE `ownershiptypes`
  MODIFY `pkOty` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `postoffices`
--
ALTER TABLE `postoffices`
  MODIFY `pkPof` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `qualificationsdegrees`
--
ALTER TABLE `qualificationsdegrees`
  MODIFY `pkQde` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `religions`
--
ALTER TABLE `religions`
  MODIFY `pkRel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `schooleducationplanassignment`
--
ALTER TABLE `schooleducationplanassignment`
  MODIFY `pkSep` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `schoolphotos`
--
ALTER TABLE `schoolphotos`
  MODIFY `pkSph` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `schoolprincipals`
--
ALTER TABLE `schoolprincipals`
  MODIFY `pkScp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `pkSch` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `schoolyears`
--
ALTER TABLE `schoolyears`
  MODIFY `pkSye` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `pkSta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `studentbehaviours`
--
ALTER TABLE `studentbehaviours`
  MODIFY `pkSbe` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `studentdisciplinemeasuretypes`
--
ALTER TABLE `studentdisciplinemeasuretypes`
  MODIFY `pkSmt` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `studentenrollments`
--
ALTER TABLE `studentenrollments`
  MODIFY `pkSte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=554;

--
-- AUTO_INCREMENT for table `universities`
--
ALTER TABLE `universities`
  MODIFY `pkUni` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `villageschools`
--
ALTER TABLE `villageschools`
  MODIFY `pkVsc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vocations`
--
ALTER TABLE `vocations`
  MODIFY `pkVct` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
