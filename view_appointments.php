<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'Employee') {
    header('Location: login.php'); 
    exit();
}

$mysqli = new mysqli("localhost", "root", "MyNewPass", "main_db");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$query = "SELECT DoctorName FROM Doctor WHERE doctorID = " . $_SESSION['user_id'];
$result = $mysqli->query($query);

if ($result && $row = $result->fetch_assoc()) {
    $doctorName = $row['DoctorName'];
} else {
    $doctorName = "Doctor Not Found";
}

$result->close();

$currentAppointmentsQuery = "SELECT Appointment.*, Patient.PatientName FROM Appointment 
                             JOIN Patient ON Appointment.PatientID = Patient.PatientID 
                             WHERE Appointment.DoctorID = {$_SESSION['user_id']}";

$pastAppointmentsQuery = "SELECT AppointmentDim.*, PatientDim.PatientName FROM AppointmentDim 
                          JOIN PatientDim ON AppointmentDim.PatientID = PatientDim.PatientID 
                          WHERE AppointmentDim.DoctorID = {$_SESSION['user_id']}";

$currentAppointmentsResult = $mysqli->query($currentAppointmentsQuery);
$pastAppointmentsResult = $mysqli->query($pastAppointmentsQuery);

// Calculate the number of current and past appointments
$numCurrentAppointments = $currentAppointmentsResult->num_rows;
$numPastAppointments = $pastAppointmentsResult->num_rows;

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="old.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>View Appointments</title>
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
    <h2>View Appointments</h2>

    <!-- Search or filter functionality -->
    <div class="search-container">
        <input type="text" id="searchBar" placeholder="Search appointments...">
    </div>

    <!-- Appointments -->
    <h3>Current Appointments (<?php echo $numCurrentAppointments; ?>)</h3>
    <div class="data-container">
        <?php
        while ($currentAppointmentRow = $currentAppointmentsResult->fetch_assoc()) {
            echo '<div class="data-box">';
            echo '<h4>' . $currentAppointmentRow['Description'] . '</h4>';
            echo '<p>Date: ' . $currentAppointmentRow['AppointmentDate'] . '</p>';
            echo '<p>Status: ' . $currentAppointmentRow['Status'] . '</p>';
            echo '<p>Patient: ' . $currentAppointmentRow['PatientName'] . '</p>';
            echo '<p>Room: ' . $currentAppointmentRow['Room'] . '</p>';
            echo '</div>';
        }
        ?>
    </div>

    <h3>Past Appointments (<?php echo $numPastAppointments; ?>)</h3>
    <div class="data-container">
        <?php
        while ($pastAppointmentRow = $pastAppointmentsResult->fetch_assoc()) {
            echo '<div class="data-box">';
            echo '<h4>' . $pastAppointmentRow['Description'] . '</h4>';
            echo '<p>Date: ' . $pastAppointmentRow['AppointmentDate'] . '</p>';
            echo '<p>Status: ' . $pastAppointmentRow['Status'] . '</p>';
            echo '<p>Patient: ' . $pastAppointmentRow['PatientName'] . '</p>';
            echo '<p>Room: ' . $pastAppointmentRow['Room'] . '</p>';
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
