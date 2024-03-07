-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 06, 2024 at 11:42 AM
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
-- Database: `nguyen43_HospitalDataWarehouse`
--

-- --------------------------------------------------------

--
-- Table structure for table `AppointmentDim`
--

CREATE TABLE `AppointmentDim` (
  `AppointmentDimID` int(11) NOT NULL,
  `AppointmentID` int(11) DEFAULT NULL,
  `PatientID` int(11) DEFAULT NULL,
  `AppointmentDate` date DEFAULT NULL,
  `AppointmentType` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `Room` varchar(50) DEFAULT NULL,
  `ETLTimestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `BillingDim`
--

CREATE TABLE `BillingDim` (
  `BillingDimID` int(11) NOT NULL,
  `BillingID` int(11) DEFAULT NULL,
  `PatientID` int(11) DEFAULT NULL,
  `DoctorID` int(11) DEFAULT NULL,
  `Amount` double DEFAULT NULL,
  `DueDate` date DEFAULT NULL,
  `PaymentStatus` varchar(20) DEFAULT NULL,
  `ETLTimestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `DoctorDim`
--

CREATE TABLE `DoctorDim` (
  `DoctorDimID` int(11) NOT NULL,
  `DoctorID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `HospitalID` int(11) DEFAULT NULL,
  `DoctorSpecialization` varchar(255) DEFAULT NULL,
  `ETLTimestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `HospitalDim`
--

CREATE TABLE `HospitalDim` (
  `HospitalDimID` int(11) NOT NULL,
  `HospitalID` int(11) DEFAULT NULL,
  `HospitalName` varchar(255) DEFAULT NULL,
  `PatientCapacity` int(11) DEFAULT NULL,
  `ETLTimestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `HospitalDim`
--

INSERT INTO `HospitalDim` (`HospitalDimID`, `HospitalID`, `HospitalName`, `PatientCapacity`, `ETLTimestamp`) VALUES
(1, 1, 'General Hospital', 200, '2024-02-25 22:23:09'),
(2, 2, 'City Medical Center', 150, '2024-02-25 22:23:09'),
(3, 1, 'General Hospital', 200, '2024-02-25 22:24:07'),
(4, 2, 'City Medical Center', 150, '2024-02-25 22:24:07'),
(5, 1, 'General Hospital', 200, '2024-02-25 22:24:25'),
(6, 2, 'City Medical Center', 150, '2024-02-25 22:24:25'),
(7, 1, 'General Hospital', 200, '2024-02-25 22:42:24'),
(8, 2, 'City Medical Center', 150, '2024-02-25 22:42:24'),
(9, 1, 'General Hospital', 200, '2024-02-25 22:42:25'),
(10, 2, 'City Medical Center', 150, '2024-02-25 22:42:25'),
(11, 1, 'General Hospital', 200, '2024-02-25 22:42:36'),
(12, 2, 'City Medical Center', 150, '2024-02-25 22:42:36'),
(13, 1, 'General Hospital', 200, '2024-02-25 22:42:37'),
(14, 2, 'City Medical Center', 150, '2024-02-25 22:42:37'),
(15, 1, 'General Hospital', 200, '2024-02-25 22:42:37'),
(16, 2, 'City Medical Center', 150, '2024-02-25 22:42:37'),
(17, 1, 'General Hospital', 200, '2024-02-25 22:42:38'),
(18, 2, 'City Medical Center', 150, '2024-02-25 22:42:38');

-- --------------------------------------------------------

--
-- Table structure for table `PatientDim`
--

CREATE TABLE `PatientDim` (
  `PatientDimID` int(11) NOT NULL,
  `PatientID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Disease` varchar(255) DEFAULT NULL,
  `AdmissionDate` date DEFAULT NULL,
  `DischargeDate` date DEFAULT NULL,
  `ETLTimestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `PrescriptionDim`
--

CREATE TABLE `PrescriptionDim` (
  `PrescriptionDimID` int(11) NOT NULL,
  `PrescriptionID` int(11) DEFAULT NULL,
  `PrescriptionName` varchar(255) DEFAULT NULL,
  `Dosage` varchar(50) DEFAULT NULL,
  `Frequency` varchar(50) DEFAULT NULL,
  `PatientID` int(11) DEFAULT NULL,
  `DoctorID` int(11) DEFAULT NULL,
  `ETLTimestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TreatDim`
--

CREATE TABLE `TreatDim` (
  `TreatDimID` int(11) NOT NULL,
  `PatientID` int(11) DEFAULT NULL,
  `DoctorID` int(11) DEFAULT NULL,
  `Treatment` varchar(255) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `AppointmentID` int(11) DEFAULT NULL,
  `ETLTimestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TreatFact`
--

CREATE TABLE `TreatFact` (
  `FactID` int(11) NOT NULL,
  `UserDimID` int(11) DEFAULT NULL,
  `PatientDimID` int(11) DEFAULT NULL,
  `DoctorDimID` int(11) DEFAULT NULL,
  `AppointmentDimID` int(11) DEFAULT NULL,
  `BillingDimID` int(11) DEFAULT NULL,
  `PrescriptionDimID` int(11) DEFAULT NULL,
  `TreatDimID` int(11) DEFAULT NULL,
  `Disease` varchar(255) DEFAULT NULL,
  `Treatment` varchar(255) DEFAULT NULL,
  `Amount` double DEFAULT NULL,
  `PrescriptionName` varchar(255) DEFAULT NULL,
  `Dosage` varchar(50) DEFAULT NULL,
  `Frequency` varchar(50) DEFAULT NULL,
  `TotalDaysAdmitted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `UserDim`
--

CREATE TABLE `UserDim` (
  `UserDimID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `FullName` varchar(255) DEFAULT NULL,
  `Username` varchar(25) DEFAULT NULL,
  `Password` varchar(25) DEFAULT NULL,
  `user_type` varchar(25) DEFAULT NULL,
  `PhoneNum` varchar(25) DEFAULT NULL,
  `EmailAdd` varchar(255) DEFAULT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `Sex` char(1) DEFAULT NULL,
  `DateCreated` datetime DEFAULT NULL,
  `UserAge` int(11) DEFAULT NULL,
  `AccountAge` int(11) DEFAULT NULL,
  `ETLTimestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `UserDim`
--

INSERT INTO `UserDim` (`UserDimID`, `UserID`, `FullName`, `Username`, `Password`, `user_type`, `PhoneNum`, `EmailAdd`, `DateOfBirth`, `Sex`, `DateCreated`, `UserAge`, `AccountAge`, `ETLTimestamp`) VALUES
(1, 1, 'John Doe', 'john_doe', 'password1', 'Patient', '123-456-7890', 'john.doe@example.com', '1990-01-15', 'M', '2024-02-25 17:49:51', 34, 8, '2024-02-25 22:49:51'),
(2, 2, 'Jane Doe', 'jane_doe', 'password2', 'Patient', '987-654-3210', 'jane.doe@example.com', '1985-05-20', 'F', '2024-02-25 17:49:51', 38, 8, '2024-02-25 22:49:51'),
(3, 3, 'Bob Johnson', 'bob_johnson', 'password3', 'Patient', '555-123-4567', 'bob.johnson@example.com', '1978-11-10', 'M', '2024-02-25 17:49:51', 45, 8, '2024-02-25 22:49:51'),
(4, 4, 'Alice Smith', 'alice_smith', 'password4', 'Patient', '111-222-3333', 'alice.smith@example.com', '1995-09-08', 'F', '2024-02-25 17:49:51', 28, 8, '2024-02-25 22:49:51'),
(5, 5, 'Charlie Brown', 'charlie_brown', 'password5', 'Patient', '444-555-6666', 'charlie.brown@example.com', '1980-03-25', 'M', '2024-02-25 17:49:51', 43, 8, '2024-02-25 22:49:51'),
(6, 6, 'Eva Rodriguez', 'eva_rodriguez', 'password6', 'Patient', '777-888-9999', 'eva.rodriguez@example.com', '1992-07-14', 'F', '2024-02-25 17:49:51', 31, 8, '2024-02-25 22:49:51'),
(7, 7, 'Michael Williams', 'michael_williams', 'password7', 'Patient', '333-111-2222', 'michael.williams@example.com', '1988-12-30', 'M', '2024-02-25 17:49:51', 35, 8, '2024-02-25 22:49:51'),
(8, 8, 'Olivia Taylor', 'olivia_taylor', 'password8', 'Patient', '666-777-8888', 'olivia.taylor@example.com', '1993-04-18', 'F', '2024-02-25 17:49:51', 30, 8, '2024-02-25 22:49:51'),
(9, 9, 'William Martinez', 'william_martinez', 'password9', 'Patient', '222-444-5555', 'william.martinez@example.com', '1982-08-02', 'M', '2024-02-25 17:49:51', 41, 8, '2024-02-25 22:49:51'),
(10, 10, 'Sophia Anderson', 'sophia_anderson', 'password10', 'Patient', '999-333-4444', 'sophia.anderson@example.com', '1997-06-05', 'F', '2024-02-25 17:49:51', 26, 8, '2024-02-25 22:49:51'),
(11, 11, 'Aiden Moore', 'aiden_moore', 'password11', 'Patient', '888-555-6666', 'aiden.moore@example.com', '1991-09-22', 'M', '2024-02-25 17:49:51', 32, 8, '2024-02-25 22:49:51'),
(12, 12, 'Emma Scott', 'emma_scott', 'password12', 'Patient', '444-111-2222', 'emma.scott@example.com', '1986-02-12', 'F', '2024-02-25 17:49:51', 38, 8, '2024-02-25 22:49:51'),
(13, 13, 'Liam Johnson', 'liam_johnson', 'password13', 'Patient', '777-888-9999', 'liam.johnson@example.com', '1984-07-28', 'M', '2024-02-25 17:49:51', 39, 8, '2024-02-25 22:49:51'),
(14, 14, 'Olivia Lewis', 'olivia_lewis', 'password14', 'Patient', '555-333-4444', 'olivia.lewis@example.com', '1994-11-14', 'F', '2024-02-25 17:49:51', 29, 8, '2024-02-25 22:49:51'),
(15, 15, 'Noah White', 'noah_white', 'password15', 'Patient', '666-222-3333', 'noah.white@example.com', '1999-03-06', 'M', '2024-02-25 17:49:51', 24, 8, '2024-02-25 22:49:52'),
(16, 16, 'Sophia Davis', 'sophia_davis', 'password16', 'Patient', '333-444-5555', 'sophia.davis@example.com', '1989-05-30', 'F', '2024-02-25 17:49:51', 34, 8, '2024-02-25 22:49:52'),
(17, 17, 'Jackson Wilson', 'jackson_wilson', 'password17', 'Patient', '222-555-6666', 'jackson.wilson@example.com', '1983-10-18', 'M', '2024-02-25 17:49:51', 40, 8, '2024-02-25 22:49:52'),
(18, 18, 'Ava Brown', 'ava_brown', 'password18', 'Patient', '444-777-8888', 'ava.brown@example.com', '1996-12-02', 'F', '2024-02-25 17:49:51', 27, 8, '2024-02-25 22:49:52'),
(19, 19, 'Liam Taylor', 'liam_taylor', 'password19', 'Patient', '999-111-2222', 'liam.taylor@example.com', '1987-04-25', 'M', '2024-02-25 17:49:51', 36, 8, '2024-02-25 22:49:52'),
(20, 20, 'Isabella Moore', 'isabella_moore', 'password20', 'Patient', '666-333-4444', 'isabella.moore@example.com', '1998-08-09', 'F', '2024-02-25 17:49:51', 25, 8, '2024-02-25 22:49:52'),
(21, 21, 'Michael Smith', 'cardiologist_michael', 'password1', 'Doctor', '123-456-7890', 'michael.smith@example.com', '1980-01-15', 'M', '2024-02-25 17:49:51', 44, 8, '2024-02-25 22:49:52'),
(22, 22, 'Jennifer Johnson', 'orthopedic_jennifer', 'password2', 'Doctor', '987-654-3210', 'jennifer.johnson@example.com', '1975-05-20', 'F', '2024-02-25 17:49:51', 48, 8, '2024-02-25 22:49:52'),
(23, 23, 'David Davis', 'pediatrician_david', 'password3', 'Doctor', '555-123-4567', 'david.davis@example.com', '1970-11-10', 'M', '2024-02-25 17:49:51', 53, 8, '2024-02-25 22:49:52'),
(24, 24, 'Jessica Anderson', 'dermatologist_jessica', 'password4', 'Doctor', '111-222-3333', 'jessica.anderson@example.com', '1985-09-08', 'F', '2024-02-25 17:49:51', 38, 8, '2024-02-25 22:49:52'),
(25, 25, 'Matthew Martinez', 'neurologist_matthew', 'password5', 'Doctor', '444-555-6666', 'matthew.martinez@example.com', '1988-03-25', 'M', '2024-02-25 17:49:51', 35, 8, '2024-02-25 22:49:52'),
(26, 26, 'Emily White', 'ophthalmologist_emily', 'password6', 'Doctor', '777-888-9999', 'emily.white@example.com', '1972-07-14', 'F', '2024-02-25 17:49:51', 51, 8, '2024-02-25 22:49:52'),
(27, 27, 'Daniel Harris', 'gastroenterologist_daniel', 'password7', 'Doctor', '333-111-2222', 'daniel.harris@example.com', '1982-12-30', 'M', '2024-02-25 17:49:51', 41, 8, '2024-02-25 22:49:52'),
(28, 28, 'Ashley Miller', 'rheumatologist_ashley', 'password8', 'Doctor', '666-777-8888', 'ashley.miller@example.com', '1987-08-02', 'F', '2024-02-25 17:49:51', 36, 8, '2024-02-25 22:49:52'),
(29, 29, 'Christopher Allen', 'urologist_christopher', 'password9', 'Doctor', '999-333-4444', 'christopher.allen@example.com', '1984-06-05', 'M', '2024-02-25 17:49:51', 39, 8, '2024-02-25 22:49:52'),
(30, 30, 'Elizabeth Bennett', 'endocrinologist_elizabeth', 'password10', 'Doctor', '888-555-6666', 'elizabeth.bennett@example.com', '1978-09-22', 'F', '2024-02-25 17:49:51', 45, 8, '2024-02-25 22:49:52'),
(31, 31, 'Ryan Carter', 'psychiatrist_ryan', 'password11', 'Doctor', '444-111-2222', 'ryan.carter@example.com', '1990-02-12', 'M', '2024-02-25 17:49:51', 34, 8, '2024-02-25 22:49:52'),
(32, 32, 'Stephanie Green', 'hematologist_stephanie', 'password12', 'Doctor', '777-888-9999', 'stephanie.green@example.com', '1986-07-28', 'F', '2024-02-25 17:49:51', 37, 8, '2024-02-25 22:49:52'),
(33, 33, 'Brandon Lee', 'nephrologist_brandon', 'password13', 'Doctor', '555-333-4444', 'brandon.lee@example.com', '1976-11-14', 'M', '2024-02-25 17:49:51', 47, 8, '2024-02-25 22:49:52'),
(34, 34, 'Rebecca Turner', 'pulmonologist_rebecca', 'password14', 'Doctor', '666-222-3333', 'rebecca.turner@example.com', '1991-03-06', 'F', '2024-02-25 17:49:51', 32, 8, '2024-02-25 22:49:52'),
(35, 35, 'Jacob Ward', 'otolaryngologist_jacob', 'password15', 'Doctor', '333-444-5555', 'jacob.ward@example.com', '1983-05-30', 'M', '2024-02-25 17:49:51', 40, 8, '2024-02-25 22:49:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `AppointmentDim`
--
ALTER TABLE `AppointmentDim`
  ADD PRIMARY KEY (`AppointmentDimID`);

--
-- Indexes for table `BillingDim`
--
ALTER TABLE `BillingDim`
  ADD PRIMARY KEY (`BillingDimID`);

--
-- Indexes for table `DoctorDim`
--
ALTER TABLE `DoctorDim`
  ADD PRIMARY KEY (`DoctorDimID`);

--
-- Indexes for table `HospitalDim`
--
ALTER TABLE `HospitalDim`
  ADD PRIMARY KEY (`HospitalDimID`);

--
-- Indexes for table `PatientDim`
--
ALTER TABLE `PatientDim`
  ADD PRIMARY KEY (`PatientDimID`);

--
-- Indexes for table `PrescriptionDim`
--
ALTER TABLE `PrescriptionDim`
  ADD PRIMARY KEY (`PrescriptionDimID`);

--
-- Indexes for table `TreatDim`
--
ALTER TABLE `TreatDim`
  ADD PRIMARY KEY (`TreatDimID`);

--
-- Indexes for table `TreatFact`
--
ALTER TABLE `TreatFact`
  ADD PRIMARY KEY (`FactID`),
  ADD KEY `UserDimID` (`UserDimID`),
  ADD KEY `PatientDimID` (`PatientDimID`),
  ADD KEY `DoctorDimID` (`DoctorDimID`),
  ADD KEY `AppointmentDimID` (`AppointmentDimID`),
  ADD KEY `BillingDimID` (`BillingDimID`),
  ADD KEY `PrescriptionDimID` (`PrescriptionDimID`),
  ADD KEY `TreatDimID` (`TreatDimID`);

--
-- Indexes for table `UserDim`
--
ALTER TABLE `UserDim`
  ADD PRIMARY KEY (`UserDimID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `AppointmentDim`
--
ALTER TABLE `AppointmentDim`
  MODIFY `AppointmentDimID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `BillingDim`
--
ALTER TABLE `BillingDim`
  MODIFY `BillingDimID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `DoctorDim`
--
ALTER TABLE `DoctorDim`
  MODIFY `DoctorDimID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `HospitalDim`
--
ALTER TABLE `HospitalDim`
  MODIFY `HospitalDimID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `PatientDim`
--
ALTER TABLE `PatientDim`
  MODIFY `PatientDimID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `PrescriptionDim`
--
ALTER TABLE `PrescriptionDim`
  MODIFY `PrescriptionDimID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TreatDim`
--
ALTER TABLE `TreatDim`
  MODIFY `TreatDimID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TreatFact`
--
ALTER TABLE `TreatFact`
  MODIFY `FactID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserDim`
--
ALTER TABLE `UserDim`
  MODIFY `UserDimID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `TreatFact`
--
ALTER TABLE `TreatFact`
  ADD CONSTRAINT `TreatFact_ibfk_1` FOREIGN KEY (`UserDimID`) REFERENCES `UserDim` (`UserDimID`),
  ADD CONSTRAINT `TreatFact_ibfk_2` FOREIGN KEY (`PatientDimID`) REFERENCES `PatientDim` (`PatientDimID`),
  ADD CONSTRAINT `TreatFact_ibfk_3` FOREIGN KEY (`DoctorDimID`) REFERENCES `DoctorDim` (`DoctorDimID`),
  ADD CONSTRAINT `TreatFact_ibfk_4` FOREIGN KEY (`AppointmentDimID`) REFERENCES `AppointmentDim` (`AppointmentDimID`),
  ADD CONSTRAINT `TreatFact_ibfk_5` FOREIGN KEY (`BillingDimID`) REFERENCES `BillingDim` (`BillingDimID`),
  ADD CONSTRAINT `TreatFact_ibfk_6` FOREIGN KEY (`PrescriptionDimID`) REFERENCES `PrescriptionDim` (`PrescriptionDimID`),
  ADD CONSTRAINT `TreatFact_ibfk_7` FOREIGN KEY (`TreatDimID`) REFERENCES `TreatDim` (`TreatDimID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
