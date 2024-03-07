-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 06, 2024 at 11:41 AM
-- Server version: 10.4.31-MariaDB-log
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nguyen43_Hospital`
--

-- --------------------------------------------------------

--
-- Table structure for table `Appointment`
--

CREATE TABLE `Appointment` (
  `AppointmentID` int(11) NOT NULL,
  `PatientID` int(11) DEFAULT NULL,
  `AppointmentDate` date DEFAULT NULL,
  `AppointmentType` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `Room` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Billing`
--

CREATE TABLE `Billing` (
  `BillingID` int(11) NOT NULL,
  `Amount` double DEFAULT NULL,
  `DueDate` date DEFAULT NULL,
  `PaymentStatus` varchar(20) DEFAULT NULL,
  `PatientID` int(11) DEFAULT NULL,
  `DoctorID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Doctor`
--

CREATE TABLE `Doctor` (
  `DoctorID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `DoctorSpecialization` varchar(255) DEFAULT NULL,
  `HospitalID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Hospital`
--

CREATE TABLE `Hospital` (
  `HospitalID` int(11) NOT NULL,
  `HospitalName` varchar(255) DEFAULT NULL,
  `PatientCapacity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Hospital`
--

INSERT INTO `Hospital` (`HospitalID`, `HospitalName`, `PatientCapacity`) VALUES
(1, 'General Hospital', 200),
(2, 'City Medical Center', 150);

-- --------------------------------------------------------

--
-- Table structure for table `Patient`
--

CREATE TABLE `Patient` (
  `PatientID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Disease` varchar(255) DEFAULT NULL,
  `AdmissionDate` date DEFAULT NULL,
  `DischargeDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Prescription`
--

CREATE TABLE `Prescription` (
  `PrescriptionID` int(11) NOT NULL,
  `PrescriptionName` varchar(255) DEFAULT NULL,
  `Dosage` varchar(50) DEFAULT NULL,
  `Frequency` varchar(50) DEFAULT NULL,
  `PatientID` int(11) DEFAULT NULL,
  `DoctorID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Treat`
--

CREATE TABLE `Treat` (
  `PatientID` int(11) NOT NULL,
  `DoctorID` int(11) NOT NULL,
  `Treatment` varchar(255) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `AppointmentID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `UserID` int(11) NOT NULL,
  `FullName` varchar(255) DEFAULT NULL,
  `Username` varchar(25) DEFAULT NULL,
  `Password` varchar(25) DEFAULT NULL,
  `user_type` varchar(25) DEFAULT NULL,
  `PhoneNum` varchar(25) DEFAULT NULL,
  `EmailAdd` varchar(255) DEFAULT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `Sex` char(1) DEFAULT NULL,
  `DateCreated` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`UserID`, `FullName`, `Username`, `Password`, `user_type`, `PhoneNum`, `EmailAdd`, `DateOfBirth`, `Sex`, `DateCreated`) VALUES
(1, 'John Doe', 'john_doe', 'password1', 'Patient', '123-456-7890', 'john.doe@example.com', '1990-01-15', 'M', '2024-02-25 17:49:51'),
(2, 'Jane Doe', 'jane_doe', 'password2', 'Patient', '987-654-3210', 'jane.doe@example.com', '1985-05-20', 'F', '2024-02-25 17:49:51'),
(3, 'Bob Johnson', 'bob_johnson', 'password3', 'Patient', '555-123-4567', 'bob.johnson@example.com', '1978-11-10', 'M', '2024-02-25 17:49:51'),
(4, 'Alice Smith', 'alice_smith', 'password4', 'Patient', '111-222-3333', 'alice.smith@example.com', '1995-09-08', 'F', '2024-02-25 17:49:51'),
(5, 'Charlie Brown', 'charlie_brown', 'password5', 'Patient', '444-555-6666', 'charlie.brown@example.com', '1980-03-25', 'M', '2024-02-25 17:49:51'),
(6, 'Eva Rodriguez', 'eva_rodriguez', 'password6', 'Patient', '777-888-9999', 'eva.rodriguez@example.com', '1992-07-14', 'F', '2024-02-25 17:49:51'),
(7, 'Michael Williams', 'michael_williams', 'password7', 'Patient', '333-111-2222', 'michael.williams@example.com', '1988-12-30', 'M', '2024-02-25 17:49:51'),
(8, 'Olivia Taylor', 'olivia_taylor', 'password8', 'Patient', '666-777-8888', 'olivia.taylor@example.com', '1993-04-18', 'F', '2024-02-25 17:49:51'),
(9, 'William Martinez', 'william_martinez', 'password9', 'Patient', '222-444-5555', 'william.martinez@example.com', '1982-08-02', 'M', '2024-02-25 17:49:51'),
(10, 'Sophia Anderson', 'sophia_anderson', 'password10', 'Patient', '999-333-4444', 'sophia.anderson@example.com', '1997-06-05', 'F', '2024-02-25 17:49:51'),
(11, 'Aiden Moore', 'aiden_moore', 'password11', 'Patient', '888-555-6666', 'aiden.moore@example.com', '1991-09-22', 'M', '2024-02-25 17:49:51'),
(12, 'Emma Scott', 'emma_scott', 'password12', 'Patient', '444-111-2222', 'emma.scott@example.com', '1986-02-12', 'F', '2024-02-25 17:49:51'),
(13, 'Liam Johnson', 'liam_johnson', 'password13', 'Patient', '777-888-9999', 'liam.johnson@example.com', '1984-07-28', 'M', '2024-02-25 17:49:51'),
(14, 'Olivia Lewis', 'olivia_lewis', 'password14', 'Patient', '555-333-4444', 'olivia.lewis@example.com', '1994-11-14', 'F', '2024-02-25 17:49:51'),
(15, 'Noah White', 'noah_white', 'password15', 'Patient', '666-222-3333', 'noah.white@example.com', '1999-03-06', 'M', '2024-02-25 17:49:51'),
(16, 'Sophia Davis', 'sophia_davis', 'password16', 'Patient', '333-444-5555', 'sophia.davis@example.com', '1989-05-30', 'F', '2024-02-25 17:49:51'),
(17, 'Jackson Wilson', 'jackson_wilson', 'password17', 'Patient', '222-555-6666', 'jackson.wilson@example.com', '1983-10-18', 'M', '2024-02-25 17:49:51'),
(18, 'Ava Brown', 'ava_brown', 'password18', 'Patient', '444-777-8888', 'ava.brown@example.com', '1996-12-02', 'F', '2024-02-25 17:49:51'),
(19, 'Liam Taylor', 'liam_taylor', 'password19', 'Patient', '999-111-2222', 'liam.taylor@example.com', '1987-04-25', 'M', '2024-02-25 17:49:51'),
(20, 'Isabella Moore', 'isabella_moore', 'password20', 'Patient', '666-333-4444', 'isabella.moore@example.com', '1998-08-09', 'F', '2024-02-25 17:49:51'),
(21, 'Michael Smith', 'cardiologist_michael', 'password1', 'Doctor', '123-456-7890', 'michael.smith@example.com', '1980-01-15', 'M', '2024-02-25 17:49:51'),
(22, 'Jennifer Johnson', 'orthopedic_jennifer', 'password2', 'Doctor', '987-654-3210', 'jennifer.johnson@example.com', '1975-05-20', 'F', '2024-02-25 17:49:51'),
(23, 'David Davis', 'pediatrician_david', 'password3', 'Doctor', '555-123-4567', 'david.davis@example.com', '1970-11-10', 'M', '2024-02-25 17:49:51'),
(24, 'Jessica Anderson', 'dermatologist_jessica', 'password4', 'Doctor', '111-222-3333', 'jessica.anderson@example.com', '1985-09-08', 'F', '2024-02-25 17:49:51'),
(25, 'Matthew Martinez', 'neurologist_matthew', 'password5', 'Doctor', '444-555-6666', 'matthew.martinez@example.com', '1988-03-25', 'M', '2024-02-25 17:49:51'),
(26, 'Emily White', 'ophthalmologist_emily', 'password6', 'Doctor', '777-888-9999', 'emily.white@example.com', '1972-07-14', 'F', '2024-02-25 17:49:51'),
(27, 'Daniel Harris', 'gastroenterologist_daniel', 'password7', 'Doctor', '333-111-2222', 'daniel.harris@example.com', '1982-12-30', 'M', '2024-02-25 17:49:51'),
(28, 'Ashley Miller', 'rheumatologist_ashley', 'password8', 'Doctor', '666-777-8888', 'ashley.miller@example.com', '1987-08-02', 'F', '2024-02-25 17:49:51'),
(29, 'Christopher Allen', 'urologist_christopher', 'password9', 'Doctor', '999-333-4444', 'christopher.allen@example.com', '1984-06-05', 'M', '2024-02-25 17:49:51'),
(30, 'Elizabeth Bennett', 'endocrinologist_elizabeth', 'password10', 'Doctor', '888-555-6666', 'elizabeth.bennett@example.com', '1978-09-22', 'F', '2024-02-25 17:49:51'),
(31, 'Ryan Carter', 'psychiatrist_ryan', 'password11', 'Doctor', '444-111-2222', 'ryan.carter@example.com', '1990-02-12', 'M', '2024-02-25 17:49:51'),
(32, 'Stephanie Green', 'hematologist_stephanie', 'password12', 'Doctor', '777-888-9999', 'stephanie.green@example.com', '1986-07-28', 'F', '2024-02-25 17:49:51'),
(33, 'Brandon Lee', 'nephrologist_brandon', 'password13', 'Doctor', '555-333-4444', 'brandon.lee@example.com', '1976-11-14', 'M', '2024-02-25 17:49:51'),
(34, 'Rebecca Turner', 'pulmonologist_rebecca', 'password14', 'Doctor', '666-222-3333', 'rebecca.turner@example.com', '1991-03-06', 'F', '2024-02-25 17:49:51'),
(35, 'Jacob Ward', 'otolaryngologist_jacob', 'password15', 'Doctor', '333-444-5555', 'jacob.ward@example.com', '1983-05-30', 'M', '2024-02-25 17:49:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Appointment`
--
ALTER TABLE `Appointment`
  ADD PRIMARY KEY (`AppointmentID`),
  ADD KEY `PatientID` (`PatientID`);

--
-- Indexes for table `Billing`
--
ALTER TABLE `Billing`
  ADD PRIMARY KEY (`BillingID`),
  ADD KEY `PatientID` (`PatientID`,`DoctorID`),
  ADD KEY `DoctorID` (`DoctorID`);

--
-- Indexes for table `Doctor`
--
ALTER TABLE `Doctor`
  ADD PRIMARY KEY (`DoctorID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `HospitalID` (`HospitalID`);

--
-- Indexes for table `Hospital`
--
ALTER TABLE `Hospital`
  ADD PRIMARY KEY (`HospitalID`);

--
-- Indexes for table `Patient`
--
ALTER TABLE `Patient`
  ADD PRIMARY KEY (`PatientID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `Prescription`
--
ALTER TABLE `Prescription`
  ADD PRIMARY KEY (`PrescriptionID`),
  ADD KEY `PatientID` (`PatientID`,`DoctorID`),
  ADD KEY `DoctorID` (`DoctorID`);

--
-- Indexes for table `Treat`
--
ALTER TABLE `Treat`
  ADD PRIMARY KEY (`PatientID`,`DoctorID`),
  ADD KEY `DoctorID` (`DoctorID`),
  ADD KEY `AppointmentID` (`AppointmentID`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Billing`
--
ALTER TABLE `Billing`
  MODIFY `BillingID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Doctor`
--
ALTER TABLE `Doctor`
  MODIFY `DoctorID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Hospital`
--
ALTER TABLE `Hospital`
  MODIFY `HospitalID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Patient`
--
ALTER TABLE `Patient`
  MODIFY `PatientID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Prescription`
--
ALTER TABLE `Prescription`
  MODIFY `PrescriptionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Appointment`
--
ALTER TABLE `Appointment`
  ADD CONSTRAINT `Appointment_ibfk_1` FOREIGN KEY (`PatientID`) REFERENCES `Patient` (`PatientID`);

--
-- Constraints for table `Billing`
--
ALTER TABLE `Billing`
  ADD CONSTRAINT `Billing_ibfk_1` FOREIGN KEY (`PatientID`,`DoctorID`) REFERENCES `Treat` (`PatientID`, `DoctorID`),
  ADD CONSTRAINT `Billing_ibfk_2` FOREIGN KEY (`DoctorID`) REFERENCES `Doctor` (`DoctorID`),
  ADD CONSTRAINT `Billing_ibfk_3` FOREIGN KEY (`PatientID`) REFERENCES `Patient` (`PatientID`);

--
-- Constraints for table `Doctor`
--
ALTER TABLE `Doctor`
  ADD CONSTRAINT `Doctor_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `User` (`UserID`),
  ADD CONSTRAINT `Doctor_ibfk_2` FOREIGN KEY (`HospitalID`) REFERENCES `Hospital` (`HospitalID`);

--
-- Constraints for table `Patient`
--
ALTER TABLE `Patient`
  ADD CONSTRAINT `Patient_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `User` (`UserID`);

--
-- Constraints for table `Prescription`
--
ALTER TABLE `Prescription`
  ADD CONSTRAINT `Prescription_ibfk_1` FOREIGN KEY (`PatientID`,`DoctorID`) REFERENCES `Treat` (`PatientID`, `DoctorID`),
  ADD CONSTRAINT `Prescription_ibfk_2` FOREIGN KEY (`PatientID`) REFERENCES `Patient` (`PatientID`),
  ADD CONSTRAINT `Prescription_ibfk_3` FOREIGN KEY (`DoctorID`) REFERENCES `Doctor` (`DoctorID`);

--
-- Constraints for table `Treat`
--
ALTER TABLE `Treat`
  ADD CONSTRAINT `Treat_ibfk_1` FOREIGN KEY (`PatientID`) REFERENCES `Patient` (`PatientID`),
  ADD CONSTRAINT `Treat_ibfk_2` FOREIGN KEY (`DoctorID`) REFERENCES `Doctor` (`DoctorID`),
  ADD CONSTRAINT `Treat_ibfk_3` FOREIGN KEY (`AppointmentID`) REFERENCES `Appointment` (`AppointmentID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
