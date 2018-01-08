-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 14, 2017 at 03:12 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `intranet`
--

-- --------------------------------------------------------

--
-- Table structure for table `administration`
--

CREATE TABLE `administration` (
  `fonction` text NOT NULL,
  `phone` varchar(255) NOT NULL,
  `office` varchar(255) NOT NULL,
  `schedules` text NOT NULL,
  `id_Person` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `administration`
--

INSERT INTO `administration` (`fonction`, `phone`, `office`, `schedules`, `id_Person`, `id`) VALUES
('Gestion des finances', '00 1345 29 777 000', 'Cafétaria PUIO', 'Lundi au vendredi: 5h à 6h PM.\r\nSamedi et dimanche: absente.', 14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `alias`
--

CREATE TABLE `alias` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `private` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alias`
--

INSERT INTO `alias` (`id`, `name`, `private`) VALUES
(1, 'et4', 0);

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `id_message` int(11) NOT NULL,
  `id_person` int(11) NOT NULL,
  `id_question` int(11) NOT NULL,
  `answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `code` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code_TU` int(11) NOT NULL,
  `coefficient` int(11) NOT NULL,
  `class_Hours` int(11) NOT NULL,
  `TD_Hours` int(11) NOT NULL,
  `TP_Hours` int(11) NOT NULL,
  `project_Hours` int(11) NOT NULL,
  `internship` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`code`, `name`, `code_TU`, `coefficient`, `class_Hours`, `TD_Hours`, `TP_Hours`, `project_Hours`, `internship`) VALUES
(0, 'Compléments objet', 0, 5, 14, 12, 10, 0, 0),
(1, 'C++', 0, 5, 20, 0, 22, 0, 0),
(2, 'Informatique théorique', 1, 3, 12, 18, 0, 0, 0),
(3, 'Compilation', 1, 4, 18, 12, 0, 4, 0),
(4, 'Projet compilation', 1, 4, 0, 0, 0, 24, 0);

-- --------------------------------------------------------

--
-- Table structure for table `course_description`
--

CREATE TABLE `course_description` (
  `code_Course` int(11) NOT NULL,
  `id_Teacher` int(11) NOT NULL,
  `prerequisites` text NOT NULL,
  `content` text NOT NULL,
  `equipment` text NOT NULL,
  `evaluation` text NOT NULL,
  `bibliography` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `eval`
--

CREATE TABLE `eval` (
  `ID` int(11) NOT NULL,
  `Description` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eval`
--

INSERT INTO `eval` (`ID`, `Description`) VALUES
(1, 'S7 - C++'),
(2, 'S7 - Projet compilation'),
(3, 'S7 - Compilation');

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `ID` int(11) NOT NULL,
  `ID_Student` varchar(50) NOT NULL,
  `ID_Eval` int(11) NOT NULL,
  `Date` datetime NOT NULL,
  `Score` double NOT NULL,
  `Comment` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`ID`, `ID_Student`, `ID_Eval`, `Date`, `Score`, `Comment`) VALUES
(3, '007', 1, '2017-05-04 00:00:00', 20, ''),
(4, '007', 2, '2017-05-04 00:00:00', 20, 'Excellent'),
(5, '007', 3, '2017-05-04 00:00:00', 20, 'Parfait'),
(6, '042', 1, '2017-05-14 00:00:00', 10, 'moyen');

-- --------------------------------------------------------

--
-- Table structure for table `member_alias`
--

CREATE TABLE `member_alias` (
  `id_Alias` int(11) NOT NULL,
  `id_Person` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member_alias`
--

INSERT INTO `member_alias` (`id_Alias`, `id_Person`) VALUES
(1, 10),
(1, 11),
(1, 12),
(1, 13);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `id_Sender` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `id_Sender`, `title`, `body`, `date`) VALUES
(2, 15, 'Cours d\'hier', 'Bonjour,\n\nLe cours d\'hier est annulé.\nMerci de votre compréhension.\n\nCordialement,\n\nJean Prof', '2017-05-04 00:09:42'),
(3, 12, 'Test de message', 'Ceci est un test:\nQuestions ouvertes: <0> <1>\n\nQuestions à choix multiple: <2> <3>', '2017-05-04 00:23:54'),
(4, 11, 'Deuxième test', 'Test: <0>', '2017-05-04 00:27:28'),
(5, 11, 'Autre test', '<0><1><2>', '2017-05-04 00:31:48'),
(6, 11, 'Test', 'Test<0>', '2017-05-04 00:33:34'),
(7, 11, 'Test', 'Test<0><1><2><3>', '2017-05-04 00:35:29');

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`id`, `name`, `first_name`, `mail`, `login`, `password`, `salt`) VALUES
(10, 'Fabioux', 'Vincent', 'vincent.fabioux@u-psud.fr', 'vincent.fabioux', '$2y$10$Qu3nk1nOQvTrD1gN8UC14OGRohcIR9B.lJUpmqn39..8Z8arWTguO', 'B???Y?B??X\r?@??42=?d?m\r{??X?i?/?:?O????	:?@\0[7??\'?'),
(11, 'Montoro', 'Nicolas', 'nicolas.montoro@u-psud.fr', 'nicolas.montoro', '$2y$10$Qwg0cZvWvH//AWKptppfoO65E/PAKkEsDgW0Vv/aM6ufgh4Bb/JoG', 'C4q???b???_??aRhq<MraH?o??Y???7???Z??a?BA6 ?D???n?'),
(12, 'Nappert', 'Olivier', 'olivier.nappert@u-psud.fr', 'olivier.nappert', '$2y$10$FK2.8Q/2oLEzi5aDHFykPu/tOaSPZFXGyjZTD9RtE01hLfe8bqKoG', '??????3???\\????O?>?|??:7?Rs?{?r??,??k??8?p@[?ca????'),
(13, 'Samson', 'Maxime', 'maxime.samson@u-psud.fr', 'maxime.samson', '$2y$10$VQ7Ne2MbM5NmLMEiHZSl9uuvP4yQEa37u2I2ug2mSSPmS6gcbGxgK', 'U?{c3?f,?\"????M?g?f??{q????????c\\Q??\\Qa>?????'),
(14, 'Pillon', 'Fénéloffe', 'feneloffe.pillon@u-psud.fr', 'admin', '$2y$10$9vIudqozT8jCzdzCvJIvbufpF0EDusswA9Kod4BDQpZywSckGQtsS', '??.v?3O????¼?/o\Zs???M}1J??G???\"|??-o??I?Y[\"T??^??C???u'),
(15, 'Prof', 'Jean', 'jean.prof@u-psud.fr', 'teacher', '$2y$10$PwGgfZzKz6wjfojkqIjrq.EosRlr0HATDqAJb46E23m6BgEqLSk0u', '??}???#~????*|?/c,?#k?~k????C?HB?g[?h)R8??\n7?k??)???');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id_message` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `type` tinyint(1) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id_message`, `id`, `name`, `type`, `content`) VALUES
(4, 0, 'Test', 0, 'AAA'),
(5, 0, 'Test', 1, 'A,2,3'),
(5, 1, 'Test #2', 1, 'A,2,3'),
(5, 2, 'Test #3', 1, 'A,2,3'),
(7, 0, 'Test', 0, 'test'),
(7, 1, 'Test #2', 0, 'test'),
(7, 2, 'Test #3', 0, 'test'),
(7, 3, 'Test #4', 0, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `receiver`
--

CREATE TABLE `receiver` (
  `id_Message` int(11) NOT NULL,
  `id_Person` int(11) NOT NULL,
  `message_Read` tinyint(1) NOT NULL,
  `archived` tinyint(1) NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `receiver`
--

INSERT INTO `receiver` (`id_Message`, `id_Person`, `message_Read`, `archived`, `deleted`) VALUES
(2, 10, 1, 0, 0),
(2, 11, 1, 0, 0),
(2, 12, 1, 0, 0),
(2, 13, 1, 0, 0),
(3, 11, 1, 0, 0),
(4, 13, 0, 0, 0),
(5, 12, 0, 0, 0),
(6, 12, 0, 0, 0),
(7, 12, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_Number` varchar(50) NOT NULL,
  `department` varchar(255) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `id_Person` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_Number`, `department`, `branch`, `year`, `id_Person`) VALUES
('007', 'Info', 'ET', 4, 10),
('042', 'Info', 'ET', 4, 13),
('069', 'Info', 'ET', 4, 11),
('666', 'Info', 'ET', 4, 12);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `id_Person` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id_Person`) VALUES
(15);

-- --------------------------------------------------------

--
-- Table structure for table `teaching_unit`
--

CREATE TABLE `teaching_unit` (
  `year` int(11) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `code` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `ects` int(11) NOT NULL,
  `threshold` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teaching_unit`
--

INSERT INTO `teaching_unit` (`year`, `branch`, `department`, `code`, `name`, `ects`, `threshold`) VALUES
(4, 'ET', 'INFO', 0, 'Génie logiciel', 6, 10),
(4, 'ET', 'INFO', 1, 'Langages et calculs', 6, 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administration`
--
ALTER TABLE `administration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_Person` (`id_Person`);

--
-- Indexes for table `alias`
--
ALTER TABLE `alias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD KEY `id_person7` (`id_person`),
  ADD KEY `id_message4` (`id_message`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`code`),
  ADD KEY `code_TU` (`code_TU`);

--
-- Indexes for table `course_description`
--
ALTER TABLE `course_description`
  ADD KEY `code_course` (`code_Course`),
  ADD KEY `id_teacher` (`id_Teacher`);

--
-- Indexes for table `eval`
--
ALTER TABLE `eval`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `idStudent` (`ID_Student`),
  ADD KEY `idEval` (`ID_Eval`);

--
-- Indexes for table `member_alias`
--
ALTER TABLE `member_alias`
  ADD KEY `id_Alias` (`id_Alias`),
  ADD KEY `id_Person3` (`id_Person`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_Person4` (`id_Sender`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD KEY `id_message8` (`id_message`);

--
-- Indexes for table `receiver`
--
ALTER TABLE `receiver`
  ADD KEY `id_Message` (`id_Message`),
  ADD KEY `id_Person5` (`id_Person`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_Number`),
  ADD KEY `id_Person6` (`id_Person`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD KEY `id_Person2` (`id_Person`);

--
-- Indexes for table `teaching_unit`
--
ALTER TABLE `teaching_unit`
  ADD PRIMARY KEY (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administration`
--
ALTER TABLE `administration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `alias`
--
ALTER TABLE `alias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `eval`
--
ALTER TABLE `eval`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `administration`
--
ALTER TABLE `administration`
  ADD CONSTRAINT `id_Person` FOREIGN KEY (`id_Person`) REFERENCES `person` (`id`);

--
-- Constraints for table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `id_message4` FOREIGN KEY (`id_message`) REFERENCES `message` (`id`),
  ADD CONSTRAINT `id_person7` FOREIGN KEY (`id_person`) REFERENCES `person` (`id`);

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `code_TU` FOREIGN KEY (`code_TU`) REFERENCES `teaching_unit` (`code`);

--
-- Constraints for table `course_description`
--
ALTER TABLE `course_description`
  ADD CONSTRAINT `code_course` FOREIGN KEY (`code_Course`) REFERENCES `course` (`code`),
  ADD CONSTRAINT `id_teacher` FOREIGN KEY (`id_Teacher`) REFERENCES `teacher` (`id_Person`);

--
-- Constraints for table `member_alias`
--
ALTER TABLE `member_alias`
  ADD CONSTRAINT `id_Alias` FOREIGN KEY (`id_Alias`) REFERENCES `alias` (`id`),
  ADD CONSTRAINT `id_Person3` FOREIGN KEY (`id_Person`) REFERENCES `person` (`id`);

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `id_Person4` FOREIGN KEY (`id_Sender`) REFERENCES `person` (`id`);

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `id_message8` FOREIGN KEY (`id_message`) REFERENCES `message` (`id`);

--
-- Constraints for table `receiver`
--
ALTER TABLE `receiver`
  ADD CONSTRAINT `id_Message` FOREIGN KEY (`id_Message`) REFERENCES `message` (`id`),
  ADD CONSTRAINT `id_Person5` FOREIGN KEY (`id_Person`) REFERENCES `person` (`id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `id_Person6` FOREIGN KEY (`id_Person`) REFERENCES `person` (`id`);

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `id_Person2` FOREIGN KEY (`id_Person`) REFERENCES `person` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
