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

    // Maybe implement a display table function?
    function displayTable($data, $tableName, $columnHeaders, $columnName) {
        echo "<h2>$tableName Table</h2>";
        echo "<table border='1'>
                <tr>";
    
        // Display column headers
        foreach ($columnName as $header) {
            echo "<th>$header</th>";
        }
        echo "</tr>";

        // Display data rows
        foreach ($data as $row) {
            echo "<tr>";
    
            // Display individual columns
            foreach ($columnHeaders as $header) {
                echo "<td>{$row[$header]}</td>";
            }
    
            echo "</tr>";
        }
    
        echo "</table>";
    }

    function listUser () {

    }

    

    // Pagination: retrieve subset of records at a time, prevent large no. of record being push out at once
    // Should we sort in PHP (more option/flexible later on?) or MySQL (faster)




?>