<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'Patient') {
    header('Location: index.php');
    exit();
}

// Includes
require_once 'includes/config.php';
require_once 'includes/common_functions.php';

// Query to retrieve patient name from the main_db
$query_main_db = "SELECT FullName FROM User WHERE UserID = " . $_SESSION['user_id'];
$result_main_db = executeSelectQuery($db_conn, $query_main_db);

if ($result_main_db && $row_main_db = $result_main_db->fetch_assoc()) {
    $patientName = $row_main_db['FullName'];
} else {
    $patientName = "Patient Not Found";
}

// Get patient ID from the session
$patient_id = $_SESSION['user_id'];

// Query to retrieve active appointments for the patient from second_db
$currentAppointmentsQuery = "SELECT * FROM Appointment WHERE PatientID = " . $_SESSION['user_id'];
if (isset($_POST['date_filter'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    if ($start_date && $end_date) {
        $currentAppointmentsQuery .= " AND AppointmentDate BETWEEN '$start_date' AND '$end_date'";
    }
}
$currentAppointmentsResult = executeSelectQuery($db_conn, $currentAppointmentsQuery);

$pastAppointmentsQuery = "SELECT * FROM AppointmentDim WHERE PatientID = $patient_id";
if (isset($_POST['date_filter'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    if ($start_date && $end_date) {
        $pastAppointmentsQuery .= " AND AppointmentDate BETWEEN '$start_date' AND '$end_date'";
    }
}
$pastAppointmentsResult = executeSelectQuery($dw_conn, $pastAppointmentsQuery);

$numCurrentAppointments = $currentAppointmentsResult->num_rows;
$numPastAppointments = $pastAppointmentsResult->num_rows;

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get appointment details from the form
    $conn = $db_conn;
    $appointmentDate = $_POST['appointment_date'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $room = $_POST['room'];

    // Get patient ID from session
    $patientID = $_SESSION['user_id'];

    // Create the appointment
    if (createAppointment($conn, $patientID, $appointmentDate, $description, $status, $room)) {
        echo "Appointment created successfully!";
    } else {
        echo "Failed to create appointment.";
    }
}

// Close both connections when done
$db_conn->close();
$dw_conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="old.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Your Appointments</title>
</head>
<body>

<header>
    <img src="logo.jpg" alt="Hospital Logo">
    Elysian Medical Hospital
</header>

<nav>
    <div class="welcome-container">
        <div class="profile-icon"><i class="material-icons">person</i></div>
        <div class="welcome-text">Welcome,</div>
        <div class="dropdown">
            <div class="welcome-text"><?php echo $patientName; ?>!</div>
        </div>
    </div>
    <div class="nav-links">
        <a class="nav-link" href="patient_dashboard.php">Home <i class="material-icons">home</i></a>
        <a class="nav-link" href="appointments.php">Appointments <i class="material-icons">date_range</i></a>
        <a class="nav-link" href="treatments.php">Treatments <i class="material-icons">vaccines</i></a>
        <a class="nav-link" href="prescriptions.php">Prescriptions <i class="material-icons">receipt</i></a>
        <a class="nav-link" href="Billing.php">Billing <i class="material-icons">monetization_on</i></a>
        <a class="nav-link" href="logout.php">Logout <i class="material-icons">exit_to_app</i></a>
    </div>
</nav>

<br>
<form class="date-filter-form" method="post" action="">
    <label for="start_date">Start Date:</label>
    <input type="date" id="start_date" name="start_date" class="date-input">
    <label for="end_date">End Date:</label>
    <input type="date" id="end_date" name="end_date" class="date-input">
    <button type="submit" name="date_filter" class="filter-button">Filter</button>
</form>

<section>
    <h2>Search Appointments</h2>
    <!-- Search or filter functionality -->
    <div class="search-container">
        <input type="text" id="searchBar" placeholder="Search appointments...">
    </div>

    <!-- Appointments -->
    <h2>Active Appointments</h2>
    <div class="data-container">
        <?php
        if ($numCurrentAppointments > 0) {
            while ($currentAppointmentsRow = $currentAppointmentsResult->fetch_assoc()) {
                echo '<div class="data-box">';
                echo '<h4>' . $currentAppointmentsRow['Description'] . '</h4>';
                echo '<p>Date: ' . $currentAppointmentsRow['AppointmentDate'] . '</p>';
                echo '<p>Status: ' . $currentAppointmentsRow['Status'] . '</p>';
                echo '<p>Room: ' . $currentAppointmentsRow['Room'] . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>No active appointments found.</p>';
        }
        ?>
    </div>

    <h2>Past Appointments</h2>
<div class="data-container">
    <?php
    if ($numPastAppointments > 0) {
        while ($pastAppointmentsRow = $pastAppointmentsResult->fetch_assoc()) {
            echo '<div class="data-box">';
            echo '<h4>' . $pastAppointmentsRow['Description'] . '</h4>';
            echo '<p>Date: ' . $pastAppointmentsRow['AppointmentDate'] . '</p>';
            echo '<p>Status: ' . $pastAppointmentsRow['Status'] . '</p>';
            echo '<p>Room: ' . $pastAppointmentsRow['Room'] . '</p>';
            echo '</div>';
        }
    } else {
        echo '<p>No past appointments found.</p>';
    }
    ?>
</div>
</section>

<br>
<section>
    <h2>Create Appointment</h2>
    <div class="data-container">
        <form method="post" action="">
            <label for="appointment_date">Appointment Date:</label>
            <input type="date" id="appointment_date" name="appointment_date" required>
            <label for="description">Description:</label>
            <input type="text" id="description" name="description" required>
            <label for="status">Status:</label>
            <input type="text" id="status" name="status" required>
            <label for="room">Room:</label>
            <input type="text" id="room" name="room" required>
            <button type="submit" name="create_appointment">Create Appointment</button>
        </form>
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
