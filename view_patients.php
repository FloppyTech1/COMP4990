<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'Employee') {
    header('Location: login.php'); 
    exit();
}

// First Database Connection
$mysqli_main_db = new mysqli("localhost", "root", "MyNewPass", "main_db");

if ($mysqli_main_db->connect_error) {
    die("Connection to main_db failed: " . $mysqli_main_db->connect_error);
}

// Second Database Connection
$mysqli_dw_db = new mysqli("localhost", "root", "MyNewPass", "dw_db");

if ($mysqli_dw_db->connect_error) {
    die("Connection to second_db failed: " . $mysqli_dw_db->connect_error);
}

$query = "SELECT FullName FROM User WHERE UserID = " . $_SESSION['user_id'];
$result = $mysqli_main_db->query($query);

if ($result && $row = $result->fetch_assoc()) {
    $doctorName = $row['FullName'];
} else {
    $doctorName = "Doctor Not Found";
}

$query2 = "SELECT Doctor.DoctorID FROM Doctor JOIN User ON Doctor.UserID = User.UserID WHERE User.FullName = '$doctorName'";
$result = $mysqli_main_db->query($query2);

if ($result && $row = $result->fetch_assoc()) {
    $doctorID = $row['DoctorID'];
} else {
    $doctorID = "Doctor Not Found";
}

$result->close();

$currentPatientsQuery = "SELECT P.PatientID, U.FullName, P.Disease, P.AdmissionDate, P.DischargeDate
    FROM Patient P
    JOIN User U ON P.UserID = U.UserID
    JOIN Treat T ON P.PatientID = T.PatientID
    WHERE T.DoctorID = $doctorID";
$currentPatientsResult = $mysqli_main_db->query($currentPatientsQuery);

$pastPatientsQuery = "SELECT P.PatientID, U.FullName, P.Disease, P.AdmissionDate, P.DischargeDate
    FROM PatientDim P
    JOIN UserDim U ON P.UserID = U.UserID
    JOIN TreatDim T ON P.PatientID = T.PatientID
    WHERE T.DoctorID = $doctorID";
$pastPatientsResult = $mysqli_dw_db->query($pastPatientsQuery);

$numCurrentPatients = $currentPatientsResult->num_rows;
$numPastPatients = $pastPatientsResult->num_rows;

$mysqli_main_db->close();
$mysqli_dw_db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="old.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>View Patients</title>
</head>
<body>

<header>
    <img src="logo.jpg" alt="Hospital Logo">
    Elyisian Medical Hospital
</header>

<nav>
        <div class="welcome-container">
            <div class="profile-icon"><i class="material-icons">person</i></div>
            <div class="welcome-text">Welcome,</div>
            <div class="dropdown">
                <div class="welcome-text"><?php echo $doctorName; ?>!</div>
            </div>
        </div>
        <div class="nav-links">
            <a class="nav-link" href="employee_dashboard.php">Home <i class="material-icons">home</i></a>
            <a class="nav-link" href="view_patients.php">Patients <i class="material-icons">people</i></a>
            <a class="nav-link" href="view_appointments.php">Appointments <i class="material-icons">date_range</i></a>
            <a class="nav-link" href="view_treatments.php">Treatments <i class="material-icons">vaccines</i></a>
            <a class="nav-link" href="logout.php">Logout <i class="material-icons">exit_to_app</i></a>
</div>

    </nav>

<section>
    <h2>View Patients</h2>

    <!-- Search or filter functionality -->
    <div class="search-container">
        <input type="text" id="searchBar" placeholder="Search patients...">
    </div>

    <!-- Current Patients -->
    <h3>Current Patients (<?php echo $numCurrentPatients; ?>)</h3>
    <div class="data-container">
                <?php
        while ($currentPatientRow = $currentPatientsResult->fetch_assoc()) {
            echo '<div class="data-box">';
            echo '<h4>' . $currentPatientRow['FullName'] . '</h4>';
            echo '<p>Patient ID: ' . $currentPatientRow['PatientID'] . '</p>';
            echo '<p>Disease: ' . $currentPatientRow['Disease'] . '</p>';
            echo '<p>Admission Date: ' . $currentPatientRow['AdmissionDate'] . '</p>';
            echo '</div>';
        }
        ?>
    </div>

    <!-- Past Patients -->
    <h3>Past Patients (<?php echo $numPastPatients; ?>)</h3>
    <div class="data-container">
        <?php
        while ($pastPatientRow = $pastPatientsResult->fetch_assoc()) {
            echo '<div class="data-box">';
            echo '<h4>' . $pastPatientRow['FullName'] . '</h4>';
            echo '<p>Disease: ' . $pastPatientRow['Disease'] . '</p>';
            echo '<p>Admission Date: ' . $pastPatientRow['AdmissionDate'] . '</p>';
            echo '<p>Discharge Date: ' . $pastPatientRow['DischargeDate'] . '</p>';
            echo '</div>';
        }
        ?>
    </div>
</section>

<script>
    // Add JavaScript for search functionality
    document.getElementById('searchBar').addEventListener('input', function () {
        var input, filter, containers, boxes, h4, i, txtValue;
        input = document.getElementById('searchBar');
        filter = input.value.toUpperCase();
        containers = document.querySelectorAll('.data-container');

        containers.forEach(function (container) {
            boxes = container.querySelectorAll('.data-box');
            boxes.forEach(function (box) {
                h4 = box.querySelector('h4');
                txtValue = h4.textContent || h4.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    box.style.display = '';
                } else {
                    box.style.display = 'none';
                }
            });
        });
    });
</script>

<footer>
    <div class="footer-container">
        <div class="footer-link"><i class="material-icons">info</i><a href="about_us.php">About Us</a></div>
        <div class="footer-link"><i class="material-icons">mail</i><a href="contact_us.php">Contact Us</a></div>
        <div class="footer-link"><i class="material-icons">help</i><a href="faq.php">FAQ</a></div>
        <div class="footer-link"><i class="material-icons">build</i><a href="services.php">Services</a></div>
    </div>
</footer>

</body>
</html>
