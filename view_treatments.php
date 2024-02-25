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

$currentTreatmentsQuery = "SELECT Treat.*, Patient.PatientID, Patient.PatientName FROM Treat 
                          JOIN Patient ON Treat.PatientID = Patient.PatientID
                          WHERE Treat.DoctorID = " . $_SESSION['user_id'];

$pastTreatmentsQuery = "SELECT TreatmentFact.*, Patient.PatientID, Patient.PatientName FROM TreatmentFact 
                       JOIN Patient ON TreatmentFact.PatientID = Patient.PatientID
                       WHERE TreatmentFact.DoctorID = " . $_SESSION['user_id'];

$currentTreatmentsResult = $mysqli->query($currentTreatmentsQuery);
$pastTreatmentsResult = $mysqli->query($pastTreatmentsQuery);

$numCurrentTreatments = $currentTreatmentsResult->num_rows;
$numPastTreatments = $pastTreatmentsResult->num_rows;

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="old.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>View Treatments</title>
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
    <h2>View Treatments</h2>

    <div class="search-container">
        <input type="text" id="searchBar" placeholder="Search treatments...">
    </div>

    <h3>Current Treatments (<?php echo $numCurrentTreatments; ?>)</h3>
    <div class="data-container">
        <?php
        while ($currentTreatmentRow = $currentTreatmentsResult->fetch_assoc()) {
            echo '<div class="data-box">';
            echo '<h4>Treatment for ' . $currentTreatmentRow['PatientName'] . '</h4>';
            echo '<p>Patient ID: ' . $currentTreatmentRow['PatientID'] . '</p>';
            echo '<p>Treatment: ' . $currentTreatmentRow['Treatment'] . '</p>';
            echo '</div>';
        }
        ?>
    </div>

    <h3>Past Treatments (<?php echo $numPastTreatments; ?>)</h3>
    <div class="data-container">
        <?php
        while ($pastTreatmentRow = $pastTreatmentsResult->fetch_assoc()) {
            echo '<div class="data-box">';
            echo '<h4>Treatment for ' . $pastTreatmentRow['PatientName'] . '</h4>';
            echo '<p>Patient ID: ' . $pastTreatmentRow['PatientID'] . '</p>';
            echo '<p>Treatment: ' . $pastTreatmentRow['TreatmentDescription'] . '</p>';
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
