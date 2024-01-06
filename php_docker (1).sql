-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Jan 06, 2024 at 04:10 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_docker`
--

-- --------------------------------------------------------

--
-- Table structure for table `Appointment`
--

CREATE TABLE `Appointment` (
  `AppointmentID` int NOT NULL,
  `AppointmentDate` date DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `Room` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Appointment`
--

INSERT INTO `Appointment` (`AppointmentID`, `AppointmentDate`, `Description`, `Status`, `Room`) VALUES
(5001, '2023-01-10', 'Cardiology Checkup', 'Confirmed', 'Room 101'),
(5002, '2023-02-15', 'Orthopedic Consultation', 'Confirmed', 'Room 202'),
(5003, '2023-03-01', 'Pediatric Checkup', 'Confirmed', 'Room 303');

-- --------------------------------------------------------

--
-- Table structure for table `AppointmentDim`
--

CREATE TABLE `AppointmentDim` (
  `AppointmentID` int NOT NULL,
  `AppointmentDate` date DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `Room` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `AppointmentDim`
--

INSERT INTO `AppointmentDim` (`AppointmentID`, `AppointmentDate`, `Description`, `Status`, `Room`) VALUES
(5001, '2023-01-10', 'Cardiology Checkup', 'Confirmed', 'Room 101'),
(5002, '2023-02-15', 'Orthopedic Consultation', 'Confirmed', 'Room 202'),
(5003, '2023-03-01', 'Pediatric Checkup', 'Confirmed', 'Room 303');

-- --------------------------------------------------------

--
-- Table structure for table `Billing`
--

CREATE TABLE `Billing` (
  `BillingID` int NOT NULL,
  `Amount` double DEFAULT NULL,
  `DueDate` date DEFAULT NULL,
  `PaymentStatus` varchar(50) DEFAULT NULL,
  `PatientID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Billing`
--

INSERT INTO `Billing` (`BillingID`, `Amount`, `DueDate`, `PaymentStatus`, `PatientID`) VALUES
(3001, 1500, '2023-02-01', 'Paid', 1001),
(3002, 800, '2023-03-15', 'Pending', 1002),
(3003, 100, '2023-03-10', 'Paid', 1003);

-- --------------------------------------------------------

--
-- Table structure for table `BillingDim`
--

CREATE TABLE `BillingDim` (
  `BillingID` int NOT NULL,
  `Amount` double DEFAULT NULL,
  `DueDate` date DEFAULT NULL,
  `PaymentStatus` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `BillingDim`
--

INSERT INTO `BillingDim` (`BillingID`, `Amount`, `DueDate`, `PaymentStatus`) VALUES
(3001, 1500, '2023-02-01', 'Paid'),
(3002, 800, '2023-03-15', 'Pending'),
(3003, 100, '2023-03-10', 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `Doctor`
--

CREATE TABLE `Doctor` (
  `DoctorID` int NOT NULL,
  `DoctorName` varchar(255) DEFAULT NULL,
  `DoctorSpecialization` varchar(255) DEFAULT NULL,
  `HospitalID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Doctor`
--

INSERT INTO `Doctor` (`DoctorID`, `DoctorName`, `DoctorSpecialization`, `HospitalID`) VALUES
(101, 'Dr. Smith', 'Cardiologist', 1),
(102, 'Dr. Johnson', 'Orthopedic Surgeon', 2),
(103, 'Dr. Davis', 'Pediatrician', 1);

-- --------------------------------------------------------

--
-- Table structure for table `DoctorDim`
--

CREATE TABLE `DoctorDim` (
  `DoctorID` int NOT NULL,
  `DoctorName` varchar(255) DEFAULT NULL,
  `DoctorSpecialization` varchar(255) DEFAULT NULL,
  `HospitalID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `DoctorDim`
--

INSERT INTO `DoctorDim` (`DoctorID`, `DoctorName`, `DoctorSpecialization`, `HospitalID`) VALUES
(101, 'Dr. Smith', 'Cardiologist', 1),
(102, 'Dr. Johnson', 'Orthopedic Surgeon', 2),
(103, 'Dr. Davis', 'Pediatrician', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Hospital`
--

CREATE TABLE `Hospital` (
  `HospitalID` int NOT NULL,
  `HospitalName` varchar(255) DEFAULT NULL,
  `PatientCapacity` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Hospital`
--

INSERT INTO `Hospital` (`HospitalID`, `HospitalName`, `PatientCapacity`) VALUES
(1, 'General Hospital', 200),
(2, 'City Medical Center', 150);

-- --------------------------------------------------------

--
-- Table structure for table `HospitalDim`
--

CREATE TABLE `HospitalDim` (
  `HospitalID` int NOT NULL,
  `HospitalName` varchar(255) DEFAULT NULL,
  `PatientsCapacity` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `HospitalDim`
--

INSERT INTO `HospitalDim` (`HospitalID`, `HospitalName`, `PatientsCapacity`) VALUES
(1, 'General Hospital', 200),
(2, 'City Medical Center', 150);

-- --------------------------------------------------------

--
-- Table structure for table `Patient`
--

CREATE TABLE `Patient` (
  `PatientID` int NOT NULL,
  `PatientName` varchar(255) DEFAULT NULL,
  `PatientPhoneNum` varchar(20) DEFAULT NULL,
  `Disease` varchar(255) DEFAULT NULL,
  `AdmissionDate` date DEFAULT NULL,
  `DischargeDate` date DEFAULT NULL,
  `TotalDays` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Patient`
--

INSERT INTO `Patient` (`PatientID`, `PatientName`, `PatientPhoneNum`, `Disease`, `AdmissionDate`, `DischargeDate`, `TotalDays`) VALUES
(1001, 'John Doe', '123-456-7890', 'Heart Disease', '2023-01-15', '2023-02-01', 17),
(1002, 'Jane Doe', '987-654-3210', 'Fractured Leg', '2023-02-10', '2023-03-01', 19),
(1003, 'Bob Johnson', '555-123-4567', 'Common Cold', '2023-03-05', '2023-03-10', 5);

-- --------------------------------------------------------

--
-- Table structure for table `PatientDim`
--

CREATE TABLE `PatientDim` (
  `PatientID` int NOT NULL,
  `PatientName` varchar(255) DEFAULT NULL,
  `PatientPhoneNum` varchar(20) DEFAULT NULL,
  `Disease` varchar(255) DEFAULT NULL,
  `AdmissionDate` date DEFAULT NULL,
  `DischargeDate` date DEFAULT NULL,
  `TotalDays` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `PatientDim`
--

INSERT INTO `PatientDim` (`PatientID`, `PatientName`, `PatientPhoneNum`, `Disease`, `AdmissionDate`, `DischargeDate`, `TotalDays`) VALUES
(1001, 'John Doe', '123-456-7890', 'Heart Disease', '2023-01-15', '2023-02-01', 17),
(1002, 'Jane Doe', '987-654-3210', 'Fractured Leg', '2023-02-10', '2023-03-01', 19),
(1003, 'Bob Johnson', '555-123-4567', 'Common Cold', '2023-03-05', '2023-03-10', 5);

-- --------------------------------------------------------

--
-- Table structure for table `Prescription`
--

CREATE TABLE `Prescription` (
  `PrescriptionID` int NOT NULL,
  `PrescriptionName` varchar(255) DEFAULT NULL,
  `Dosage` varchar(50) DEFAULT NULL,
  `Frequency` varchar(50) DEFAULT NULL,
  `PatientID` int DEFAULT NULL,
  `DoctorID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Prescription`
--

INSERT INTO `Prescription` (`PrescriptionID`, `PrescriptionName`, `Dosage`, `Frequency`, `PatientID`, `DoctorID`) VALUES
(2001, 'Aspirin', '10mg', 'Once a day', 1001, 101),
(2002, 'Painkiller', '5mg', 'As needed', 1002, 102),
(2003, 'Cold Medicine', '15mg', 'Twice a day', 1003, 103);

-- --------------------------------------------------------

--
-- Table structure for table `PrescriptionDim`
--

CREATE TABLE `PrescriptionDim` (
  `PrescriptionID` int NOT NULL,
  `PrescriptionName` varchar(255) DEFAULT NULL,
  `Dosage` varchar(50) DEFAULT NULL,
  `Frequency` varchar(50) DEFAULT NULL,
  `PatientID` int DEFAULT NULL,
  `DoctorID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `PrescriptionDim`
--

INSERT INTO `PrescriptionDim` (`PrescriptionID`, `PrescriptionName`, `Dosage`, `Frequency`, `PatientID`, `DoctorID`) VALUES
(2001, 'Aspirin', '10mg', 'Once a day', 1001, 101),
(2002, 'Painkiller', '5mg', 'As needed', 1002, 102),
(2003, 'Cold Medicine', '15mg', 'Twice a day', 1003, 103);

-- --------------------------------------------------------

--
-- Table structure for table `TimeDim`
--

CREATE TABLE `TimeDim` (
  `DateID` int NOT NULL,
  `Date` date DEFAULT NULL,
  `Day` int DEFAULT NULL,
  `Month` int DEFAULT NULL,
  `Year` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Treat`
--

CREATE TABLE `Treat` (
  `PatientID` int NOT NULL,
  `DoctorID` int NOT NULL,
  `Treatment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Treat`
--

INSERT INTO `Treat` (`PatientID`, `DoctorID`, `Treatment`) VALUES
(1001, 101, 'Medication, Rest'),
(1002, 102, 'Cast, Physical Therapy'),
(1003, 103, 'Prescribed Medication');

-- --------------------------------------------------------

--
-- Table structure for table `TreatmentFact`
--

CREATE TABLE `TreatmentFact` (
  `FactID` int NOT NULL,
  `PatientID` int DEFAULT NULL,
  `DoctorID` int DEFAULT NULL,
  `AppointmentID` int DEFAULT NULL,
  `BillingID` int DEFAULT NULL,
  `TreatmentDate` date DEFAULT NULL,
  `TreatmentDescription` varchar(255) DEFAULT NULL,
  `TotalDaysAdmitted` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `TreatmentFact`
--

INSERT INTO `TreatmentFact` (`FactID`, `PatientID`, `DoctorID`, `AppointmentID`, `BillingID`, `TreatmentDate`, `TreatmentDescription`, `TotalDaysAdmitted`) VALUES
(1, 1001, 101, 5001, 3001, '2023-04-19', 'Medication', 19),
(2, 1002, 102, 5002, 3002, '2023-02-19', 'Colonoscopy', 29),
(3, 1003, 103, 5003, 3003, '2023-01-11', 'Surgery', 42);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Appointment`
--
ALTER TABLE `Appointment`
  ADD PRIMARY KEY (`AppointmentID`);

--
-- Indexes for table `AppointmentDim`
--
ALTER TABLE `AppointmentDim`
  ADD PRIMARY KEY (`AppointmentID`);

--
-- Indexes for table `Billing`
--
ALTER TABLE `Billing`
  ADD PRIMARY KEY (`BillingID`),
  ADD KEY `PatientID` (`PatientID`);

--
-- Indexes for table `BillingDim`
--
ALTER TABLE `BillingDim`
  ADD PRIMARY KEY (`BillingID`);

--
-- Indexes for table `Doctor`
--
ALTER TABLE `Doctor`
  ADD PRIMARY KEY (`DoctorID`),
  ADD KEY `HospitalID` (`HospitalID`);

--
-- Indexes for table `DoctorDim`
--
ALTER TABLE `DoctorDim`
  ADD PRIMARY KEY (`DoctorID`);

--
-- Indexes for table `Hospital`
--
ALTER TABLE `Hospital`
  ADD PRIMARY KEY (`HospitalID`);

--
-- Indexes for table `HospitalDim`
--
ALTER TABLE `HospitalDim`
  ADD PRIMARY KEY (`HospitalID`);

--
-- Indexes for table `Patient`
--
ALTER TABLE `Patient`
  ADD PRIMARY KEY (`PatientID`);

--
-- Indexes for table `PatientDim`
--
ALTER TABLE `PatientDim`
  ADD PRIMARY KEY (`PatientID`);

--
-- Indexes for table `Prescription`
--
ALTER TABLE `Prescription`
  ADD PRIMARY KEY (`PrescriptionID`),
  ADD KEY `PatientID` (`PatientID`),
  ADD KEY `DoctorID` (`DoctorID`);

--
-- Indexes for table `PrescriptionDim`
--
ALTER TABLE `PrescriptionDim`
  ADD PRIMARY KEY (`PrescriptionID`);

--
-- Indexes for table `TimeDim`
--
ALTER TABLE `TimeDim`
  ADD PRIMARY KEY (`DateID`);

--
-- Indexes for table `Treat`
--
ALTER TABLE `Treat`
  ADD PRIMARY KEY (`PatientID`,`DoctorID`),
  ADD KEY `DoctorID` (`DoctorID`);

--
-- Indexes for table `TreatmentFact`
--
ALTER TABLE `TreatmentFact`
  ADD PRIMARY KEY (`FactID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Billing`
--
ALTER TABLE `Billing`
  ADD CONSTRAINT `Billing_ibfk_1` FOREIGN KEY (`PatientID`) REFERENCES `Patient` (`PatientID`);

--
-- Constraints for table `Doctor`
--
ALTER TABLE `Doctor`
  ADD CONSTRAINT `Doctor_ibfk_1` FOREIGN KEY (`HospitalID`) REFERENCES `Hospital` (`HospitalID`);

--
-- Constraints for table `Prescription`
--
ALTER TABLE `Prescription`
  ADD CONSTRAINT `Prescription_ibfk_1` FOREIGN KEY (`PatientID`) REFERENCES `Patient` (`PatientID`),
  ADD CONSTRAINT `Prescription_ibfk_2` FOREIGN KEY (`DoctorID`) REFERENCES `Doctor` (`DoctorID`);

--
-- Constraints for table `Treat`
--
ALTER TABLE `Treat`
  ADD CONSTRAINT `Treat_ibfk_1` FOREIGN KEY (`PatientID`) REFERENCES `Patient` (`PatientID`),
  ADD CONSTRAINT `Treat_ibfk_2` FOREIGN KEY (`DoctorID`) REFERENCES `Doctor` (`DoctorID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
