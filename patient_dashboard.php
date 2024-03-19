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

    $mysqli = new mysqli($hostname, $username, $password, $database_name);

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    return $mysqli;
}

$input_location = $_SESSION['location'];
$mysqli = connectToDatabase($input_location);

$query = "SELECT FullName FROM User WHERE UserID = " . $_SESSION['user_id'];
$result = $mysqli->query($query);

if ($result && $row = $result->fetch_assoc()) {
    $patientName = $row['FullName'];
} else {
    $patientName = "Patient Not Found";
}

$query = "SELECT PatientID FROM Patient JOIN User ON Patient.UserID = User.UserID WHERE User.UserID = " . $_SESSION['user_id'];
$result = $mysqli->query($query);

if ($result && $row = $result->fetch_assoc()) {
    $patientID = $row['PatientID'];
} else {
    $patientID = "Patient ID Not Found";
}

$result->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="new.css">
    <link
      href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet"
    />
    <title>Patient Dashboard</title>
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
            <div class="welcome-text"><?php echo $patientName; ?>!</div>
        </div>
    </div>
    <div class="nav-links">
        <a class="nav-link" href="patient_dashboard.php">Home <i class="material-icons">home</i></a>
        <a class="nav-link" href="appointments.php">Appointments <i class="material-icons">date_range</i></a>
        <a class="nav-link" href="treatments.php">Treatments <i class="material-icons">vaccines</i></a>
        <a class="nav-link" href="prescriptions.php">Prescriptions <i class="material-icons">receipt</i></a>
        <a class="nav-link" href="billing.php">Billing <i class="material-icons">monetization_on</i></a>
        <a class="nav-link" href="logout.php">Logout <i class="material-icons">exit_to_app</i></a>
    </div>
</nav>

<section>
    <h2>My Appointments</h2>
    <div class="data-container">
        <?php
        $appointmentQuery = "SELECT Appointment.* FROM Appointment WHERE Status = 'Scheduled' AND PatientID = $patientID";
        $appointmentResult = $mysqli->query($appointmentQuery);

        while ($appointmentRow = $appointmentResult->fetch_assoc()) {
            echo '<div class="data-box">';
            echo '<h3>' . $appointmentRow['Description'] . '</h3>';
            echo '<p>Date: ' . $appointmentRow['AppointmentDate'] . '</p>';
            echo '<p>Status: ' . $appointmentRow['Status'] . '</p>';
            echo '</div>';
        }

        $appointmentResult->close();
        ?>
    </div>
</section>

<section>
    <h2>My Treatments</h2>
    <div class="data-container">
        <?php
        $treatmentQuery = "SELECT Treat.* FROM Treat WHERE Status = 'Active' AND PatientID = $patientID";
        $treatmentResult = $mysqli->query($treatmentQuery);

        while ($treatmentRow = $treatmentResult->fetch_assoc()) {
            echo '<div class="data-box">';
            echo '<h3>Treatment: ' . $treatmentRow['Treatment'] . '</h3>';
            echo '<p>Status: ' . $treatmentRow['Status'] . '</p>';
            echo '</div>';
        }

        $treatmentResult->close();
        ?>
    </div>
</section>


<section>
    <h2>My Billing Information</h2>
    <div class="data-container">
        <?php
        $billingQuery = "SELECT * FROM Billing WHERE PaymentStatus = 'Pending' AND PatientID = $patientID";
        $billingResult = $mysqli->query($billingQuery);

        while ($billingRow = $billingResult->fetch_assoc()) {
            echo '<div class="data-box">';
            echo '<h3>Billing ID: ' . $billingRow['BillingID'] . '</h3>';
            echo '<p>Amount: $' . $billingRow['Amount'] . '</p>';
            echo '<p>Due Date: ' . $billingRow['DueDate'] . '</p>';
            echo '<p>Payment Status: ' . $billingRow['PaymentStatus'] . '</p>';
            echo '</div>';
        }

        $billingResult->close();
        ?>
    </div>
</section>

<section>
    <h2>My Prescriptions</h2>
    <div class="data-container">
        <?php
        $prescriptionQuery = "SELECT * FROM Prescription WHERE PatientID = $patientID";
        $prescriptionResult = $mysqli->query($prescriptionQuery);

        while ($prescriptionRow = $prescriptionResult->fetch_assoc()) {
            echo '<div class="data-box">';
            echo '<h3>' . $prescriptionRow['PrescriptionName'] . '</h3>';
            echo '<p>Dosage: ' . $prescriptionRow['Dosage'] . '</p>';
            echo '<p>Frequency: ' . $prescriptionRow['Frequency'] . '</p>';
            echo '</div>';
        }

        $prescriptionResult->close();
        ?>
    </div>
</section>

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
