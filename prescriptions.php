<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'Patient') {
    header('Location: logout.php'); 
    exit();
}

function connectToDatabase($location) {
    if ($location == 'Windsor Campus') {
        $hostname = "localhost";
        $username = "root";
        $password = "MyNewPass";
        $database_name = "main_db";
    } elseif ($location == 'London Campus') {
        $hostname = "localhost";
        $username = "root";
        $password = "MyNewPass";
        $database_name = "main2_db";
    } else {
        die("Invalid location specified.");
    }

    $mysqli_main_db = new mysqli($hostname, $username, $password, $database_name);

    if ($mysqli_main_db->connect_error) {
        die("Connection failed: " . $mysqli_main_db->connect_error);
    }

    return $mysqli_main_db;
}

$input_location = $_SESSION['location'];
$mysqli_main_db = connectToDatabase($input_location);

// Query to retrieve patient name from the main_db
$query_main_db = "SELECT FullName FROM User WHERE UserID = " . $_SESSION['user_id'];
$result_main_db = $mysqli_main_db->query($query_main_db);

if ($result_main_db && $row_main_db = $result_main_db->fetch_assoc()) {
    $patientName = $row_main_db['FullName'];
} else {
    $patientName = "Patient Not Found";
}

// Second Database Connection
$mysqli_dw_db = new mysqli("localhost", "root", "MyNewPass", "dw_db");

if ($mysqli_dw_db->connect_error) {
    die("Connection to second_db failed: " . $mysqli_dw_db->connect_error);
}

$query = "SELECT PatientID FROM Patient JOIN User ON Patient.UserID = User.UserID WHERE User.UserID = " . $_SESSION['user_id'];
$result = $mysqli_main_db->query($query);

if ($result && $row = $result->fetch_assoc()) {
    $patientID = $row['PatientID'];
} else {
    $patientID = "Patient ID Not Found";
}

// Get patient ID from the session
$patient_id = $_SESSION['user_id'];

$currentPrescriptionsQuery = "SELECT Prescription.* FROM Prescription WHERE Prescription.PatientID = $patientID";
$currentPrescriptionsResult = $mysqli_main_db->query($currentPrescriptionsQuery);

$pastPrescriptionsQuery = "SELECT PrescriptionDim.* FROM PrescriptionDim WHERE PrescriptionDim.PatientID = $patientID";
$pastPrescriptionsResult = $mysqli_dw_db->query($pastPrescriptionsQuery);

// Calculate counts
$numCurrentPrescriptions = $currentPrescriptionsResult->num_rows;
$numPastPrescriptions = $pastPrescriptionsResult->num_rows;

$query = "SELECT FullName FROM User WHERE UserID = " . $_SESSION['user_id'];
$result = $mysqli_main_db->query($query);

if ($result && $row = $result->fetch_assoc()) {
    $patientName = $row['FullName'];
} else {
    $patientName = "Patient Not Found";
}

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
    <title>Your Prescriptions</title>
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
            <!-- Display patient name or any other relevant information -->
            <div class="welcome-text"><?php echo $patientName; ?>!</div>
        </div>
    </div>
    <div class="nav-links">
        <!-- Add any relevant links for patient navigation -->
        <a class="nav-link" href="patient_dashboard.php">Home <i class="material-icons">home</i></a>
        <a class="nav-link" href="appointments.php">Appointments <i class="material-icons">date_range</i></a>
        <a class="nav-link" href="treatments.php">Treatments <i class="material-icons">vaccines</i></a>
        <a class="nav-link" href="prescriptions.php">Prescriptions <i class="material-icons">receipt</i></a>
        <a class="nav-link" href="billing.php">Billing <i class="material-icons">monetization_on</i></a>
        <a class="nav-link" href="logout.php">Logout <i class="material-icons">exit_to_app</i></a>
    </div>
</nav>

<section>
    <h2>Your Prescriptions</h2>

    <!-- Search or filter functionality -->
    <div class="search-container">
        <input type="text" id="searchBar" placeholder="Search prescriptions...">
    </div>

    <!-- Prescriptions -->
    <h2>Active Prescriptions</h2>
    <div class="data-container">
        <?php
        if ($numCurrentPrescriptions > 0) {
            while ($currentPrescriptionRow = $currentPrescriptionsResult->fetch_assoc()) {
                echo '<div class="data-box">';
                echo '<h4>' . $currentPrescriptionRow['PrescriptionName'] . '</h4>';
                echo '<p>Dosage: ' . $currentPrescriptionRow['Dosage'] . '</p>';
                echo '<p>Frequency: ' . $currentPrescriptionRow['Frequency'] . '</p>';
                echo '<p>Status: Active</p>';
                // Add more details as needed
                echo '</div>';
            }
        } else {
            echo '<p>No active prescriptions found.</p>';
        }
        ?>
    </div>

    <h2>Past Prescriptions</h2>
    <div class="data-container">
        <?php
        if ($numPastPrescriptions > 0) {
            while ($pastPrescriptionRow = $pastPrescriptionsResult->fetch_assoc()) {
                echo '<div class="data-box">';
                echo '<h4>' . $pastPrescriptionRow['PrescriptionName'] . '</h4>';
                echo '<p>Dosage: ' . $pastPrescriptionRow['Dosage'] . '</p>';
                echo '<p>Frequency: ' . $pastPrescriptionRow['Frequency'] . '</p>';
                echo '<p>Status: Completed</p>';
                // Add more details as needed
                echo '</div>';
            }
        } else {
            echo '<p>No past prescriptions found.</p>';
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
