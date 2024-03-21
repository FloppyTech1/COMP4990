<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'Doctor') {
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

$currentAppointmentsQuery = "SELECT Appointment.* FROM Appointment JOIN Treat ON Appointment.AppointmentID
= Treat.AppointmentID WHERE Appointment.Status = 'Scheduled' AND Treat.DoctorID = $doctorID";
if (isset($_POST['date_filter'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    if ($start_date && $end_date) {
        $currentAppointmentsQuery .= " AND AppointmentDate BETWEEN '$start_date' AND '$end_date'";
    }
}
$pastAppointmentsQuery = "SELECT AppointmentDim.* FROM AppointmentDim JOIN TreatDim ON AppointmentDim.AppointmentID
= TreatDim.AppointmentID WHERE AppointmentDim.Status = 'Completed' AND TreatDim.DoctorID = $doctorID";
if (isset($_POST['date_filter'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    if ($start_date && $end_date) {
        $pastAppointmentsQuery .= " AND AppointmentDate BETWEEN '$start_date' AND '$end_date'";
    }
}
$currentAppointmentsResult = $mysqli_main_db->query($currentAppointmentsQuery);
$pastAppointmentsResult = $mysqli_dw_db->query($pastAppointmentsQuery);

$numCurrentAppointments = $currentAppointmentsResult->num_rows;
$numPastAppointments = $pastAppointmentsResult->num_rows;

if (isset($_POST['create_appointment'])) {
    $patientID = $_POST['patient_id'];
    $appointmentDate = $_POST['appointment_date'];
    $description = $mysqli_main_db->real_escape_string($_POST['description']);
    $status = $mysqli_main_db->real_escape_string($_POST['status']);
    $room = $mysqli_main_db->real_escape_string($_POST['room']);
    $appointmentType = $mysqli_main_db->real_escape_string($_POST['appointmentType']);

    $createAppointmentQuery = "INSERT INTO Appointment (PatientID, AppointmentDate, AppointmentType, Description, Status, Room) 
    VALUES ('$patientID', '$appointmentDate', '$appointmentType', '$description', '$status', '$room')";
    $createTreatQuery = "INSERT INTO Treat (PatientID, DoctorID, Treatment, Status, AppointmentID)
    VALUES ('$patientID', '$doctorID', '$description', '$status', (SELECT AppointmentID FROM Appointment ORDER BY AppointmentID DESC LIMIT 1))";

    if ($mysqli_main_db->query($createAppointmentQuery)) {
        if ($mysqli_main_db->query($createTreatQuery)) {
            header('Location: view_appointments.php');
            exit();
        } else {
            echo "Error creating treatment: " . $mysqli_main_db->error;
        }
    } else {
        echo "Error creating appointment: " . $mysqli_main_db->error;
    }
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

<br>
    <form class="date-filter-form" method="post" action="">
    <label for="start_date">Start Date:</label>
    <input type="date" id="start_date" name="start_date" class="date-input">
    <label for="end_date">End Date:</label>
    <input type="date" id="end_date" name="end_date" class="date-input">
    <button type="submit" name="date_filter" class="filter-button">Filter</button>
</form>

<section>
    <h2>View Appointments</h2>

    <div class="search-container">
        <input type="text" id="searchBar" placeholder="Search appointments...">
    </div>

    <h3>Current Appointments (<?php echo $numCurrentAppointments; ?>)</h3>
    <div class="data-container">
        <?php

        if ($numCurrentAppointments == 0) {
            echo '<p>No current appointments found.</p>';
        }

        while ($currentAppointmentRow = $currentAppointmentsResult->fetch_assoc()) {
            echo '<div class="data-box">';
            echo '<h4>' . $currentAppointmentRow['Description'] . '</h4>';
            echo '<p>Date: ' . $currentAppointmentRow['AppointmentDate'] . '</p>';
            echo '<p>Status: ' . $currentAppointmentRow['Status'] . '</p>';
            echo '<p>Room: ' . $currentAppointmentRow['Room'] . '</p>';
            echo '</div>';
        }
        ?>
    </div>

    <h3>Past Appointments (<?php echo $numPastAppointments; ?>)</h3>
    <div class="data-container">
        <?php

        if ($numPastAppointments == 0) {
            echo '<p>No past appointments found.</p>';
        }

        while ($pastAppointmentRow = $pastAppointmentsResult->fetch_assoc()) {
            echo '<div class="data-box">';
            echo '<h4>' . $pastAppointmentRow['Description'] . '</h4>';
            echo '<p>Date: ' . $pastAppointmentRow['AppointmentDate'] . '</p>';
            echo '<p>Status: ' . $pastAppointmentRow['Status'] . '</p>';
            echo '<p>Room: ' . $pastAppointmentRow['Room'] . '</p>';
            echo '</div>';
        }
        ?>
    </div>
</section>
<br>
<section class="appointment-form">
    <h2>Create Appointment</h2>
    <div class="data-container">
    <form method="POST" action="view_appointments.php">
        <label for="patient_id">Patient ID:</label><br>
        <input type="text" id="patient_id" name="patient_id" required><br><br>

        <label for="appointment_date">Appointment Date:</label><br>
        <input type="date" id="appointment_date" name="appointment_date" required><br><br>
        
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>
        
        <label for="status">Status:</label><br>
        <select id="status" name="status" required>
            <option value="Scheduled">Scheduled</option>
            <option value="Completed">Completed</option>
        </select><br><br>

        <label for="appointmentType">Appointment Type:</label><br>
        <select id="appointmentType" name="appointmentType" required>
            <option value="Consultation">Consultation</option>
            <option value="Checkup">Checkup</option>
            <option value="Treatment">Treatment</option>
        </select><br><br>
        
        <label for="room">Room:</label><br>
        <input type="text" id="room" name="room" required><br><br>
        
        <input type="submit" name="create_appointment" value="Create Appointment">
    </form>
    </div>
</section>

<script>
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
