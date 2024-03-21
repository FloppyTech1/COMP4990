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
    require_once 'db_functions.php';
    require_once 'dw_functions.php';

    /*//Test executeOtherQuery
    $insertQuery = "INSERT INTO Hospital (HospitalID, HospitalName, PatientCapacity) 
                    VALUES
                    (1, 'General Hospital', 200),
                    (2, 'City Medical Center', 150);";

    $insertResult = executeOtherQuery($insertQuery, $db_conn);

    if ($insertResult === false) {
        echo "Error executing other query: " . $conn->error;
    } else {
        echo "Query executed successfully";
    }
    
    
    // Test executeSelectQuery
    $selectQueryDB = "SELECT * FROM Hospital";
    $selectResultDB = executeSelectQuery($selectQueryDB, $db_conn);

    // Display the data from the DB table
    echo "<h2>Data from the Database Table</h2>";
    echo "<table border='1'>";
    echo "<tr><th>HospitalID</th><th>HospitalName</th><th>PatientCapacity</th></tr>";
    foreach ($selectResultDB as $row) {
        echo "<tr>";
        echo "<td>".$row['HospitalID']."</td>";
        echo "<td>".$row['HospitalName']."</td>";
        echo "<td>".$row['PatientCapacity']."</td>";
        echo "</tr>";
    }
    echo "</table>";

    // Test performETLforAny()

    performETLforAny('Hospital');

    // Retrieve data from the DW table
    $selectQueryDW = "SELECT * FROM HospitalDim";
    $selectResultDW = executeSelectQuery($selectQueryDW, $dw_conn);

    // Display the data from the DW table
    echo "<h2>Data from the Data Warehouse Table</h2>";
    echo "<table border='1'>";
    echo "<tr><th>HospitalID</th><th>HospitalName</th><th>PatientCapacity</th></tr>";
    foreach ($selectResultDW as $row) {
        echo "<tr>";
        echo "<td>".$row['HospitalDimID']."</td>";
        echo "<td>".$row['HospitalID']."</td>";
        echo "<td>".$row['HospitalName']."</td>";
        echo "<td>".$row['PatientCapacity']."</td>";
        echo "</tr>";
    }
    echo "</table>";
    */

    /*// Test for User
    $insertQuery = "INSERT INTO User (UserID, FullName, Username, Password, user_type, PhoneNum, EmailAdd, DateOfBirth, Sex) VALUES
    (1, 'John Doe', 'john_doe', 'password1', 'Patient', '123-456-7890', 'john.doe@example.com', '1990-01-15', 'M'),
    (2, 'Jane Doe', 'jane_doe', 'password2', 'Patient', '987-654-3210', 'jane.doe@example.com', '1985-05-20', 'F'),
    (3, 'Bob Johnson', 'bob_johnson', 'password3', 'Patient', '555-123-4567', 'bob.johnson@example.com', '1978-11-10', 'M'),
    (4, 'Alice Smith', 'alice_smith', 'password4', 'Patient', '111-222-3333', 'alice.smith@example.com', '1995-09-08', 'F'),
    (5, 'Charlie Brown', 'charlie_brown', 'password5', 'Patient', '444-555-6666', 'charlie.brown@example.com', '1980-03-25', 'M'),
    (6, 'Eva Rodriguez', 'eva_rodriguez', 'password6', 'Patient', '777-888-9999', 'eva.rodriguez@example.com', '1992-07-14', 'F'),
    (7, 'Michael Williams', 'michael_williams', 'password7', 'Patient', '333-111-2222', 'michael.williams@example.com', '1988-12-30', 'M'),
    (8, 'Olivia Taylor', 'olivia_taylor', 'password8', 'Patient', '666-777-8888', 'olivia.taylor@example.com', '1993-04-18', 'F'),
    (9, 'William Martinez', 'william_martinez', 'password9', 'Patient', '222-444-5555', 'william.martinez@example.com', '1982-08-02', 'M'),
    (10, 'Sophia Anderson', 'sophia_anderson', 'password10', 'Patient', '999-333-4444', 'sophia.anderson@example.com', '1997-06-05', 'F'),
    (11, 'Aiden Moore', 'aiden_moore', 'password11', 'Patient', '888-555-6666', 'aiden.moore@example.com', '1991-09-22', 'M'),
    (12, 'Emma Scott', 'emma_scott', 'password12', 'Patient', '444-111-2222', 'emma.scott@example.com', '1986-02-12', 'F'),
    (13, 'Liam Johnson', 'liam_johnson', 'password13', 'Patient', '777-888-9999', 'liam.johnson@example.com', '1984-07-28', 'M'),
    (14, 'Olivia Lewis', 'olivia_lewis', 'password14', 'Patient', '555-333-4444', 'olivia.lewis@example.com', '1994-11-14', 'F'),
    (15, 'Noah White', 'noah_white', 'password15', 'Patient', '666-222-3333', 'noah.white@example.com', '1999-03-06', 'M'),
    (16, 'Sophia Davis', 'sophia_davis', 'password16', 'Patient', '333-444-5555', 'sophia.davis@example.com', '1989-05-30', 'F'),
    (17, 'Jackson Wilson', 'jackson_wilson', 'password17', 'Patient', '222-555-6666', 'jackson.wilson@example.com', '1983-10-18', 'M'),
    (18, 'Ava Brown', 'ava_brown', 'password18', 'Patient', '444-777-8888', 'ava.brown@example.com', '1996-12-02', 'F'),
    (19, 'Liam Taylor', 'liam_taylor', 'password19', 'Patient', '999-111-2222', 'liam.taylor@example.com', '1987-04-25', 'M'),
    (20, 'Isabella Moore', 'isabella_moore', 'password20', 'Patient', '666-333-4444', 'isabella.moore@example.com', '1998-08-09', 'F'),
    
    -- Doctor
    (21, 'Michael Smith', 'cardiologist_michael', 'password1', 'Doctor', '123-456-7890', 'michael.smith@example.com', '1980-01-15', 'M'),
    (22, 'Jennifer Johnson', 'orthopedic_jennifer', 'password2', 'Doctor', '987-654-3210', 'jennifer.johnson@example.com', '1975-05-20', 'F'),
    (23, 'David Davis', 'pediatrician_david', 'password3', 'Doctor', '555-123-4567', 'david.davis@example.com', '1970-11-10', 'M'),
    (24, 'Jessica Anderson', 'dermatologist_jessica', 'password4', 'Doctor', '111-222-3333', 'jessica.anderson@example.com', '1985-09-08', 'F'),
    (25, 'Matthew Martinez', 'neurologist_matthew', 'password5', 'Doctor', '444-555-6666', 'matthew.martinez@example.com', '1988-03-25', 'M'),
    (26, 'Emily White', 'ophthalmologist_emily', 'password6', 'Doctor', '777-888-9999', 'emily.white@example.com', '1972-07-14', 'F'),
    (27, 'Daniel Harris', 'gastroenterologist_daniel', 'password7', 'Doctor', '333-111-2222', 'daniel.harris@example.com', '1982-12-30', 'M'),
    (28, 'Ashley Miller', 'rheumatologist_ashley', 'password8', 'Doctor', '666-777-8888', 'ashley.miller@example.com', '1987-08-02', 'F'),
    (29, 'Christopher Allen', 'urologist_christopher', 'password9', 'Doctor', '999-333-4444', 'christopher.allen@example.com', '1984-06-05', 'M'),
    (30, 'Elizabeth Bennett', 'endocrinologist_elizabeth', 'password10', 'Doctor', '888-555-6666', 'elizabeth.bennett@example.com', '1978-09-22', 'F'),
    (31, 'Ryan Carter', 'psychiatrist_ryan', 'password11', 'Doctor', '444-111-2222', 'ryan.carter@example.com', '1990-02-12', 'M'),
    (32, 'Stephanie Green', 'hematologist_stephanie', 'password12', 'Doctor', '777-888-9999', 'stephanie.green@example.com', '1986-07-28', 'F'),
    (33, 'Brandon Lee', 'nephrologist_brandon', 'password13', 'Doctor', '555-333-4444', 'brandon.lee@example.com', '1976-11-14', 'M'),
    (34, 'Rebecca Turner', 'pulmonologist_rebecca', 'password14', 'Doctor', '666-222-3333', 'rebecca.turner@example.com', '1991-03-06', 'F'),
    (35, 'Jacob Ward', 'otolaryngologist_jacob', 'password15', 'Doctor', '333-444-5555', 'jacob.ward@example.com', '1983-05-30', 'M');";

    $insertResult = executeOtherQuery($insertQuery, $db_conn);

    if ($insertResult === false) {
        echo "Error executing other query: " . $conn->error;
    } else {
        echo "Query executed successfully";
    }
    */
    
    // Test executeSelectQuery
    $selectQueryDB = "SELECT * FROM User";
    $selectResultDB = executeSelectQuery($selectQueryDB, $db_conn);

    // Test performETLforAny()

    //performETLforAny('User');

    // Retrieve data from the DW table
    $selectQueryDW = "SELECT * FROM UserDim";
    $selectResultDW = executeSelectQuery($selectQueryDW, $dw_conn);

    // Display the data from the DB table
    echo "<h2>Data from the Database Table</h2>";
    echo "<table border='1'>";
    echo "<tr><th>UserID</th><th>FullName</th><th>Username</th><th>Password</th><th>user_type</th><th>PhoneNum</th><th>EmailAdd</th><th>DateOfBirth</th><th>Sex</th></tr>";
    foreach ($selectResultDB as $row) {
        echo "<tr>";
        echo "<td>".$row['UserID']."</td>";
        echo "<td>".$row['FullName']."</td>";
        echo "<td>".$row['Username']."</td>";
        echo "<td>".$row['Password']."</td>";
        echo "<td>".$row['user_type']."</td>";
        echo "<td>".$row['PhoneNum']."</td>";
        echo "<td>".$row['EmailAdd']."</td>";
        echo "<td>".$row['DateOfBirth']."</td>";
        echo "<td>".$row['Sex']."</td>";
        echo "</tr>";
    }
    echo "</table>";


    // Test run for updateUserDim()
    updateUserDim();
    
    // Display the data from the DW table
    echo "<h2>Data from the Data Warehouse Table</h2>";
    echo "<table border='1'>";
    echo "<tr><th>UserDimID</th><th>UserID</th><th>FullName</th><th>Username</th><th>Password</th><th>user_type</th><th>PhoneNum</th><th>EmailAdd</th><th>DateOfBirth</th><th>Sex</th><th>DateCreated</th><th>UserAge</th><th>AccountAge</th><th>ETLTimestamp</th></tr>";
    foreach ($selectResultDW as $row) {
        echo "<tr>";
        echo "<td>".$row['UserDimID']."</td>";
        echo "<td>".$row['UserID']."</td>";
        echo "<td>".$row['FullName']."</td>";
        echo "<td>".$row['Username']."</td>";
        echo "<td>".$row['Password']."</td>";
        echo "<td>".$row['user_type']."</td>";
        echo "<td>".$row['PhoneNum']."</td>";
        echo "<td>".$row['EmailAdd']."</td>";   
        echo "<td>".$row['DateOfBirth']."</td>";
        echo "<td>".$row['Sex']."</td>";
        echo "<td>".$row['DateCreated']."</td>";
        echo "<td>".$row['UserAge']."</td>";
        echo "<td>".$row['AccountAge']."</td>";
        echo "<td>".$row['ETLTimestamp']."</td>";
        echo "</tr>";
    }
    echo "</table>";
?>