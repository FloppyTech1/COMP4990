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
    function executeSelectQuery($query, $conn) {
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
    function executeOtherQuery($query, $conn) {
        $result = $conn->query($query);
    
        if ($result === false) {
            die("Error executing query: " . $conn->error);
        }
    
        return $result;     // True/False
    
        // i.e. UPDATE your_table SET column_name = 'new_value' WHERE condition
    }

?>