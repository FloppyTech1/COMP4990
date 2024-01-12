<?php

    // Include any .php?
    // require_once 'includes/name.php';

    require_once 'includes/db_function.php';    # Regular query that might be use

    // Login
    //if ($_SERVER["REQUEST_METHOD"] == "POST" )

    echo "Hello World!";

    // Test db_function getAllDoctors
    $doctors = getAllDoctors();
    foreach ($doctors as $doctor) {
        echo "Doctor Name: {$doctor['DoctorName']}, 
        Specialization: {$doctor['DoctorSpecialization']}<br>";
    }

?>