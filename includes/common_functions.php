<?php

    /* Things that will need some consideration:
        - Disable Error Reporting

    */

    // Enable error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Include config.php for initial configuration
    require_once 'config.php';

    // Function to execute SELECT query
    function executeSelectQuery($conn, $query) {
        $result = $conn->query($query);
        
        if ($result === false) {
            die("Error executing query: " . $conn->error);
        }
    
        return $result;
        /* // Meant to differientiate between Select and Other queries
        $data = array();
    
        while ($row = $result->mysqli_fetch_assoc()) {
            $data[] = $row;
        }
    
        return $data;
        */
    }
    

    // Sample query
    /*
    $query = "SELECT * FROM Doctor";
    $resultData = executeSelectQuery($query);
    print_r($resultData);
    */

    // Function to execute INSERT, UPDATE, or DELETE query
    function executeOtherQuery($conn, $query) {
        $result = $conn->query($query);
    
        if ($result === false) {
            die("Error executing query: " . $conn->error);
        }
    
        return $result;     // True/False
    
        // i.e. UPDATE your_table SET column_name = 'new_value' WHERE condition
    }

    // Create Appointment for appointments.php
    function createAppointment($conn, $patientID, $appointmentDate, $description, $status, $room) {
        // Prepare the SQL statement
        $query = "INSERT INTO Appointment (PatientID, AppointmentDate, AppointmentType, Description, Status, Room)
                VALUE
                ('$patientID', '$appointmentDate', '$description', '$status', '$room')";
        
        return executeOtherQuery($conn, $query);
    }

?>