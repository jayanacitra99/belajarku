-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2022 at 08:36 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `belajarku`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignmentlog`
--

CREATE TABLE `assignmentlog` (
  `id` int(11) NOT NULL,
  `assignmentID` int(11) NOT NULL,
  `studentID` int(11) NOT NULL,
  `answer` text DEFAULT NULL,
  `grade` int(11) DEFAULT NULL,
  `files` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assignmentlog`
--

INSERT INTO `assignmentlog` (`id`, `assignmentID`, `studentID`, `answer`, `grade`, `files`, `created_at`, `updated_at`) VALUES
(40, 1, 2, NULL, NULL, 'a:2:{i:0;s:22:\"08a Deep Learning.pptx\";i:1;s:12:\"08b CNN.pptx\";}', '2022-07-06 13:17:27', '2022-07-06 13:17:27'),
(41, 2, 2, 'a:3:{i:1;a:1:{s:6:\"answer\";s:1:\"B\";}i:2;a:1:{s:6:\"answer\";s:1:\"B\";}i:3;a:1:{s:6:\"answer\";s:1:\"C\";}}', 67, NULL, '2022-07-06 13:30:17', '2022-07-06 13:30:17'),
(42, 3, 2, 'a:3:{i:1;a:1:{s:6:\"answer\";s:9:\"hjgkjgkjh\";}i:2;a:1:{s:6:\"answer\";s:10:\"ljknlknkjn\";}i:3;a:1:{s:6:\"answer\";s:4:\"NULL\";}}', 13, NULL, '2022-07-06 13:31:58', '2022-07-06 13:31:58');

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `courseID` int(11) NOT NULL,
  `classID` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `type` enum('ASSIGNMENT','QUIZ','MODULE','ESSAY') NOT NULL,
  `files` text DEFAULT NULL,
  `link` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `voice` text DEFAULT NULL,
  `question` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `courseID`, `classID`, `title`, `description`, `type`, `files`, `link`, `start_date`, `end_date`, `voice`, `question`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'ASSIGNMENT', 'ASSIGNMENT', 'ASSIGNMENT', 'a:4:{i:0;s:40:\"waldemar-brandt-rhaS97NhnHg-unsplash.jpg\";i:1;s:37:\"gareth-david-KREQ7J7nsNw-unsplash.jpg\";i:2;s:39:\"behnam-norouzi-5qQoYE6Yiwc-unsplash.jpg\";i:3;s:38:\"kenny-eliason-XEsx2NVpqWY-unsplash.jpg\";}', 'https://www.instagram.com/', '2022-06-25', '2022-07-14', 'a:2:{i:0;s:54:\"After_Last_Night_(with_Thundercat__Bootsy_Collins).mp3\";i:1;s:13:\"Blast_Off.mp3\";}', 'a:3:{i:0;a:7:{s:5:\"voice\";s:4:\"TRUE\";s:8:\"question\";s:1:\"1\";s:6:\"answer\";s:1:\"D\";s:7:\"optionA\";s:1:\"1\";s:7:\"optionB\";s:1:\"1\";s:7:\"optionC\";s:1:\"1\";s:7:\"optionD\";s:1:\"1\";}i:1;a:7:{s:5:\"voice\";s:5:\"FALSE\";s:8:\"question\";s:1:\"2\";s:6:\"answer\";s:1:\"C\";s:7:\"optionA\";s:1:\"2\";s:7:\"optionB\";s:1:\"2\";s:7:\"optionC\";s:1:\"2\";s:7:\"optionD\";s:1:\"2\";}i:2;a:7:{s:5:\"voice\";s:4:\"TRUE\";s:8:\"question\";s:1:\"3\";s:6:\"answer\";s:1:\"B\";s:7:\"optionA\";s:1:\"3\";s:7:\"optionB\";s:1:\"3\";s:7:\"optionC\";s:1:\"3\";s:7:\"optionD\";s:1:\"3\";}}', NULL, NULL),
(2, 2, 1, 'QUIZ', 'QUIZ', 'QUIZ', 'a:2:{i:0;s:39:\"behnam-norouzi-5qQoYE6Yiwc-unsplash.jpg\";i:1;s:38:\"kenny-eliason-XEsx2NVpqWY-unsplash.jpg\";}', 'https://www.instagram.com/', '2022-06-30', '2022-07-08', 'a:2:{i:0;s:14:\"All_I_Want.mp3\";i:1;s:19:\"All_Out_of_Love.mp3\";}', 'a:3:{i:0;a:7:{s:5:\"voice\";s:4:\"TRUE\";s:8:\"question\";s:1:\"1\";s:6:\"answer\";s:1:\"A\";s:7:\"optionA\";s:1:\"1\";s:7:\"optionB\";s:1:\"1\";s:7:\"optionC\";s:1:\"1\";s:7:\"optionD\";s:1:\"1\";}i:1;a:7:{s:5:\"voice\";s:5:\"FALSE\";s:8:\"question\";s:1:\"2\";s:6:\"answer\";s:1:\"B\";s:7:\"optionA\";s:1:\"2\";s:7:\"optionB\";s:1:\"2\";s:7:\"optionC\";s:1:\"2\";s:7:\"optionD\";s:1:\"2\";}i:2;a:7:{s:5:\"voice\";s:4:\"TRUE\";s:8:\"question\";s:1:\"3\";s:6:\"answer\";s:1:\"C\";s:7:\"optionA\";s:1:\"3\";s:7:\"optionB\";s:1:\"3\";s:7:\"optionC\";s:1:\"3\";s:7:\"optionD\";s:1:\"3\";}}', NULL, NULL),
(3, 2, 1, 'ESSAY', 'ESSAY', 'ESSAY', 'a:3:{i:0;s:37:\"gareth-david-KREQ7J7nsNw-unsplash.jpg\";i:1;s:39:\"behnam-norouzi-5qQoYE6Yiwc-unsplash.jpg\";i:2;s:38:\"kenny-eliason-XEsx2NVpqWY-unsplash.jpg\";}', 'https://www.instagram.com/', '2022-06-28', '2022-07-08', NULL, 'a:3:{i:0;a:1:{s:8:\"question\";s:6:\"111111\";}i:1;a:1:{s:8:\"question\";s:3:\"222\";}i:2;a:1:{s:8:\"question\";s:3:\"333\";}}', NULL, NULL),
(4, 2, 1, 'MODULE', 'MODULE', 'MODULE', 'a:2:{i:0;s:21:\"KRS POLINEMA (12).pdf\";i:1;s:21:\"KRS POLINEMA (10).pdf\";}', 'https://www.instagram.com/', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 2, 1, 'adsfasdf', 'asdfasdf', 'ASSIGNMENT', 'a:7:{i:0;s:25:\"Aku_Milikmu_Malam_Ini.mp3\";i:1;s:23:\"Berita_Kepada_Kawan.mp3\";i:2;s:24:\"Bila_Aku_Jatuh_Cinta.mp3\";i:3;s:20:\"Bintang_Di_Surga.mp3\";i:4;s:20:\"Cinta_Luar_Biasa.mp3\";i:5;s:20:\"Cobalah_Mengerti.mp3\";i:6;s:19:\"Elegi_Esok_Pagi.mp3\";}', 'https://www.instagram.com/', '2022-06-30', '2022-07-07', 'a:1:{i:0;s:20:\"Bintang_Di_Surga.mp3\";}', 'a:3:{i:0;a:7:{s:5:\"voice\";s:4:\"TRUE\";s:8:\"question\";s:1:\"1\";s:6:\"answer\";s:1:\"A\";s:7:\"optionA\";s:1:\"1\";s:7:\"optionB\";s:1:\"1\";s:7:\"optionC\";s:1:\"1\";s:7:\"optionD\";s:1:\"1\";}i:1;a:7:{s:5:\"voice\";s:5:\"FALSE\";s:8:\"question\";s:1:\"2\";s:6:\"answer\";s:1:\"B\";s:7:\"optionA\";s:1:\"2\";s:7:\"optionB\";s:1:\"2\";s:7:\"optionC\";s:1:\"2\";s:7:\"optionD\";s:1:\"2\";}i:2;a:7:{s:5:\"voice\";s:4:\"TRUE\";s:8:\"question\";s:1:\"3\";s:6:\"answer\";s:1:\"C\";s:7:\"optionA\";s:1:\"3\";s:7:\"optionB\";s:1:\"3\";s:7:\"optionC\";s:1:\"3\";s:7:\"optionD\";s:1:\"3\";}}', NULL, NULL),
(6, 2, 1, 'MODULE2', 'MODULE2', 'MODULE', 'a:4:{i:0;s:19:\"All_Out_of_Love.mp3\";i:1;s:26:\"Almost_Is_Never_Enough.mp3\";i:2;s:16:\"Almost_Lover.mp3\";i:3;s:31:\"Always_Remember_Us_This_Way.mp3\";}', 'https://www.w3schools.com/php/phptryit.asp?filename=tryphp_func_var_serialize', NULL, NULL, NULL, NULL, '2022-06-24 23:28:19', '2022-06-24 23:28:19');

-- --------------------------------------------------------

--
-- Table structure for table `attendancelog`
--

CREATE TABLE `attendancelog` (
  `id` int(11) NOT NULL,
  `studentID` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendancelog`
--

INSERT INTO `attendancelog` (`id`, `studentID`, `time`) VALUES
(1, 2, '2022-06-28 18:22:25'),
(2, 2, '2022-07-06 13:09:17');

-- --------------------------------------------------------

--
-- Table structure for table `classcourses`
--

CREATE TABLE `classcourses` (
  `id` int(11) NOT NULL,
  `classID` int(11) NOT NULL,
  `courseID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classcourses`
--

INSERT INTO `classcourses` (`id`, `classID`, `courseID`) VALUES
(2, 1, 2),
(3, 2, 3),
(4, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `class` enum('X','XI','XII') NOT NULL,
  `indexClass` varchar(2) NOT NULL,
  `quota` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `class`, `indexClass`, `quota`) VALUES
(1, 'X', 'B', 10),
(2, 'XI', 'A', 10),
(3, 'XII', 'C', 12);

-- --------------------------------------------------------

--
-- Table structure for table `classmember`
--

CREATE TABLE `classmember` (
  `id` int(11) NOT NULL,
  `classID` int(11) NOT NULL,
  `studentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classmember`
--

INSERT INTO `classmember` (`id`, `classID`, `studentID`) VALUES
(1, 1, 2),
(2, 1, 4),
(3, 1, 5),
(4, 1, 6),
(6, 1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id_course` int(11) NOT NULL,
  `teacherID` int(11) NOT NULL,
  `courseName` text NOT NULL,
  `courseClass` enum('X','XI','XII') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id_course`, `teacherID`, `courseName`, `courseClass`) VALUES
(2, 3, 'Machine Learning 2', 'X'),
(3, 3, 'Machine LearningGG', 'XI'),
(4, 8, 'Sant', 'XII');

-- --------------------------------------------------------

--
-- Table structure for table `forums`
--

CREATE TABLE `forums` (
  `id` int(11) NOT NULL,
  `classID` int(11) NOT NULL,
  `courseID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `chat` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `forums`
--

INSERT INTO `forums` (`id`, `classID`, `courseID`, `userID`, `chat`, `timestamp`) VALUES
(1, 1, 2, 2, 'Haloo ini saya', '2022-07-06 09:55:12'),
(2, 1, 2, 3, 'Halo ini Bapak', '2022-07-06 10:07:18'),
(3, 1, 2, 3, 'Ini Bapak Budi', '2022-07-06 10:20:44'),
(4, 1, 2, 2, 'Halo pak budi', '2022-07-06 10:22:01'),
(5, 1, 2, 2, 'Halo ini saya pak', '2022-07-06 13:28:52'),
(6, 1, 2, 3, 'Iya nak', '2022-07-06 13:29:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `role` enum('ADMIN','STUDENT','TEACHER') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'ADMIN', 'admin@gmail.com', '$2a$12$3X5i0Ln3QFX1Ue9Zp5VBqee37ucFAo4JiJaqWrbS3MNTVoxYVlzRa', 'ADMIN', NULL, NULL),
(2, 'STUDENT', 'student@gmail.com', '$2a$12$3X5i0Ln3QFX1Ue9Zp5VBqee37ucFAo4JiJaqWrbS3MNTVoxYVlzRa', 'STUDENT', NULL, '2022-06-14 16:55:16'),
(3, 'TEACHER', 'teacher@gmail.com', '$2a$12$3X5i0Ln3QFX1Ue9Zp5VBqee37ucFAo4JiJaqWrbS3MNTVoxYVlzRa', 'TEACHER', NULL, NULL),
(4, 'Jayana Citra Agung Pramu Putra', 'jayanacitra99@gmail.com', '$2y$10$SYXelH2DTz4Rb9T4s1DQEODWPcSLx.pe0Hzje66WEHUmcrnWT9iim', 'STUDENT', NULL, NULL),
(5, 'ARIS FAJAR PURNOMO', 'aris@gmail.com', '$2y$10$wsD6rBzf3Lu1aKtRxjskJOumcvFUH0Qc3S4o52aHMvyD0H3u4wXEK', 'STUDENT', NULL, NULL),
(6, 'AGUS SETIYONO', 'agus@gmail.com', '$2y$10$u3pFPjp7bp2L3pgTOZIkT.DxKikM53RCpEiyk9.h.gt4MhVQJ7DQ6', 'STUDENT', '2022-06-14 17:32:33', '2022-06-14 17:32:33'),
(7, 'SUMARJANA', 'sumarjana@gmail.com', '$2y$10$M3dnIRgEM55EHS1w3NBB6.44U5Nd1DunuYwcbOBQfAbmn25hc0diu', 'TEACHER', '2022-06-14 17:34:36', '2022-06-14 17:34:36'),
(8, 'Guru Santdikna', 'sant@gmail.com', '$2y$10$/mXE/2.0ty4xcPKwiwdczuhWqdCbDcSJczYvGn2xgG994A/KQhgEO', 'TEACHER', '2022-07-06 13:21:54', '2022-07-06 13:21:54'),
(9, 'AGUS SETIYONO', 'willy61@example.org', '$2y$10$9/VAHlholjNOquMH/0xi..9eQB.sdi0wbmmK/YVsYZaeKU0gk5tEm', 'STUDENT', '2022-07-06 13:25:15', '2022-07-06 13:25:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignmentlog`
--
ALTER TABLE `assignmentlog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `studentID` (`studentID`),
  ADD KEY `assignmentID` (`assignmentID`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classID` (`classID`),
  ADD KEY `courseID` (`courseID`);

--
-- Indexes for table `attendancelog`
--
ALTER TABLE `attendancelog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `studentID` (`studentID`);

--
-- Indexes for table `classcourses`
--
ALTER TABLE `classcourses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classID` (`classID`),
  ADD KEY `courseID` (`courseID`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classmember`
--
ALTER TABLE `classmember`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classID` (`classID`),
  ADD KEY `studentID` (`studentID`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id_course`),
  ADD KEY `teacherID` (`teacherID`);

--
-- Indexes for table `forums`
--
ALTER TABLE `forums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classID` (`classID`),
  ADD KEY `courseID` (`courseID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignmentlog`
--
ALTER TABLE `assignmentlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `attendancelog`
--
ALTER TABLE `attendancelog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `classcourses`
--
ALTER TABLE `classcourses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `classmember`
--
ALTER TABLE `classmember`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id_course` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `forums`
--
ALTER TABLE `forums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignmentlog`
--
ALTER TABLE `assignmentlog`
  ADD CONSTRAINT `assignmentlog_ibfk_2` FOREIGN KEY (`studentID`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assignmentlog_ibfk_3` FOREIGN KEY (`assignmentID`) REFERENCES `assignments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`classID`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assignments_ibfk_2` FOREIGN KEY (`courseID`) REFERENCES `courses` (`id_course`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attendancelog`
--
ALTER TABLE `attendancelog`
  ADD CONSTRAINT `attendancelog_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `classcourses`
--
ALTER TABLE `classcourses`
  ADD CONSTRAINT `classcourses_ibfk_1` FOREIGN KEY (`classID`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `classcourses_ibfk_2` FOREIGN KEY (`courseID`) REFERENCES `courses` (`id_course`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `classmember`
--
ALTER TABLE `classmember`
  ADD CONSTRAINT `classmember_ibfk_1` FOREIGN KEY (`classID`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `classmember_ibfk_2` FOREIGN KEY (`studentID`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`teacherID`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `forums`
--
ALTER TABLE `forums`
  ADD CONSTRAINT `forums_ibfk_1` FOREIGN KEY (`classID`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `forums_ibfk_2` FOREIGN KEY (`courseID`) REFERENCES `courses` (`id_course`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `forums_ibfk_3` FOREIGN KEY (`userID`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
