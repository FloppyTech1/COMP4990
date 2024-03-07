<?php

    /* Things that will need some consideration:
        - Disable Error Reporting

    */

    // Enable error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Include config.php for initial configuration
    require_once 'config.php';
    require_once 'common_functions.php';

    // Perform Update to UserDim
    function updateUserDim() {
        global $dw_conn;

        $insertQuery = "-- Update for UserAge & AccountAge
        UPDATE UserDim 
        JOIN (
            SELECT
                UserID,
                TIMESTAMPDIFF(YEAR, DateOfBirth, CURRENT_DATE()) AS UserAge,
                TIMESTAMPDIFF(Day, DateCreated, CURRENT_DATE()) AS AccountAge
            FROM
                UserDim
        ) AS temp ON UserDim.UserID = temp.UserID
        SET UserDim.UserAge = temp.UserAge,
            UserDim.AccountAge = temp.AccountAge
        WHERE UserDim.UserDimID > 0;            -- MySQL Safemode";

        try {
            // Execute the query
            $updateResult = $dw_conn->query($insertQuery);
        
            // Check if the query executed successfully
            if ($updateResult === false) {
                throw new Exception("Error updating UserDim table: " . $dw_conn->error);
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Perform ETL from source to destination tables
    function performETLforAny($sourceTable) {
        global $db_conn, $dw_conn;
    
        $destinationTable = $sourceTable . "Dim";
        
        try {
            $extractQuery = "SELECT * FROM $sourceTable";
            $extractResult = executeSelectQuery($db_conn, $extractQuery);         // Holds all the data from $sourceTable - pos value
        
            if ($extractResult === false) {
                throw new Exception("Error extracting data from $sourceTable: " . $db_conn->error);
            }
        
            foreach ($extractResult as $row) {
                $columns = implode(", ", array_keys($row));
                $values = implode("', '", array_values($row));

                $insertQuery = "INSERT INTO $destinationTable ($columns) VALUES ('$values')";
                $insertResult = executeOtherQuery($dw_conn, $insertQuery);
    
                if ($insertResult === false) {
                    throw new Exception("Error inserting data into $destinationTable: " . $dw_conn->error);
                }
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        if ($destinationTable === "UserDim") {
            updateUserDim();
        }
    }
    












    // Convert to see Hospital Utilization as a %
    /*
    function hospitalCapacity () {
        global $conn;

        $extractQuery = "SELECT
                            HospitalName,
                            AdmissionDate,
                            ";
    }
    */

    // Graph Patient Demographic
    function demographicPatient () {
        global $conn;

        $extractQuery = "SELECT
                            AgeGroup,
                            Gender,
                            Disease,
                            COUNT(PatientID) AS PatientCount
                        FROM
                            (SELECT
                            CASE
                                WHEN UserAge BETWEEN 0 AND 18 THEN '0-18'
                                WHEN UserAge BETWEEN 19 AND 35 THEN '19-35'
                                WHEN UserAge BETWEEN 36 AND 50 THEN '36-50'
                                ELSE '51+'
                            END AS AgeGroup,
                            Sex AS Gender,
                            Disease
                            FROM 
                                PatientDim
                            JOIN 
                                UserDim ON PatientDim.UserDimID = UserDim.UserDimID
                            ) AS AgeGroupData
                        GROUP BY 
                            AgeGroup, Gender, Disease;)";
    }

    // 



?>