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

$query = "SELECT FullName FROM User WHERE UserID = " . $_SESSION['user_id'];
$result = $mysqli->query($query);

if ($result && $row = $result->fetch_assoc()) {
    $doctorName = $row['FullName'];
} else {
    $doctorName = "Doctor Not Found";
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
    <title>Employee Dashboard</title>
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
            <div class="welcome-text">Dr. <?php echo $doctorName; ?>!</div>
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
    <h2>My Patients</h2>
    <div class="data-container">
        <?php
            $patientQuery = "SELECT P.PatientID, U.FullName, P.Disease, P.AdmissionDate, P.DischargeDate
                FROM Patient P
                JOIN User U ON P.UserID = U.UserID
                JOIN Treat T ON P.PatientID = T.PatientID
                WHERE T.DoctorID = {$_SESSION['user_id']}";
            $patientResult = $mysqli->query($patientQuery);

            while ($patientRow = $patientResult->fetch_assoc()) {
                echo '<div class="data-box">';
                echo '<h3>' . $patientRow['FullName'] . '</h3>';
                echo '<p>Patient ID: ' . $patientRow['PatientID'] . '</p>';
                echo '<p>Disease: ' . $patientRow['Disease'] . '</p>';
                echo '<p>Admission Date: ' . $patientRow['AdmissionDate'] . '</p>';
                echo '</div>';
            }

            $patientResult->close();
        ?>
    </div>
</section>

<section>
    <h2>Upcoming Appointments</h2>
    <div class="data-container">
        <?php
        $appointmentQuery = "SELECT Appointment.* FROM Appointment JOIN Treat ON Appointment.AppointmentID
        = Treat.AppointmentID WHERE Treat.DoctorID = {$_SESSION['user_id']}";
        $appointmentResult = $mysqli->query($appointmentQuery);

        while ($appointmentRow = $appointmentResult->fetch_assoc()) {
            echo '<div class="data-box">';
            echo '<h3>' . $appointmentRow['Description'] . '</h3>';
            echo '<p>Date: ' . $appointmentRow['AppointmentDate'] . '</p>';
            echo '<p>Status: ' . $appointmentRow['Status'] . '</p>';
            echo '<p>Patient: ' . $appointmentRow['PatientName'] . '</p>';
            echo '</div>';
        }

        $appointmentResult->close();
        ?>
    </div>
</section>

<section>
    <h2>Upcoming Treatments</h2>
    <div class="data-container">
        <?php
            $treatmentQuery = "SELECT T.PatientID, T.DoctorID, T.Treatment, T.Status, A.AppointmentDate
            FROM Treat T
            JOIN Appointment A ON T.AppointmentID = A.AppointmentID
            WHERE T.DoctorID = {$_SESSION['user_id']}";
            
            $treatmentResult = $mysqli->query($treatmentQuery);

            while ($treatmentRow = $treatmentResult->fetch_assoc()) {
                echo '<div class="data-box">';
                echo '<h3>Treatment for ' . $treatmentRow['PatientName'] . '</h3>';
                echo '<p>Patient ID: ' . $treatmentRow['PatientID'] . '</p>';
                echo '<p>Treatment: ' . $treatmentRow['Treatment'] . '</p>';
                echo '</div>';
            }

            $treatmentResult->close();
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