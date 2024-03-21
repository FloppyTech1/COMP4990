<?php
$mysqli_dw = new mysqli("localhost", "root", "MyNewPass", "dw_db");

if ($mysqli_dw->connect_error) {
    die("Connection to data warehouse failed: " . $mysqli_dw->connect_error);
}

$query_appointments_by_type = "SELECT AppointmentType, COUNT(*) AS TotalAppointments 
                               FROM AppointmentDim 
                               GROUP BY AppointmentType";
$result_appointments_by_type = $mysqli_dw->query($query_appointments_by_type);

$query_patients_by_disease = "SELECT p.Disease, COUNT(*) AS TotalPatients
                              FROM PatientDim p
                              GROUP BY p.Disease";
$result_patients_by_disease = $mysqli_dw->query($query_patients_by_disease);

$query_revenue_by_doctor = "SELECT d.FullName AS DoctorName, SUM(b.Amount) AS TotalRevenue
                            FROM BillingDim b
                            JOIN DoctorDim dd ON b.DoctorID = dd.DoctorID
                            JOIN UserDim d ON dd.UserID = d.UserID
                            GROUP BY d.FullName";
$result_revenue_by_doctor = $mysqli_dw->query($query_revenue_by_doctor);

$query_avg_length_of_stay = "SELECT p.Disease, AVG(DATEDIFF(p.DischargeDate, p.AdmissionDate)) AS AvgLengthOfStay
                             FROM PatientDim p
                             WHERE p.AdmissionDate IS NOT NULL AND p.DischargeDate IS NOT NULL
                             GROUP BY p.Disease";
$result_avg_length_of_stay = $mysqli_dw->query($query_avg_length_of_stay);

$query_appointment_status_counts = "SELECT Status, COUNT(*) AS StatusCount
                                    FROM AppointmentDim
                                    GROUP BY Status";
$result_appointment_status_counts = $mysqli_dw->query($query_appointment_status_counts);

$query_doctor_patient_counts = "SELECT d.FullName AS DoctorName, COUNT(*) AS PatientCount
                                FROM TreatDim t
                                JOIN DoctorDim dd ON t.DoctorID = dd.DoctorID
                                JOIN UserDim d ON dd.UserID = d.UserID
                                GROUP BY d.FullName";
$result_doctor_patient_counts = $mysqli_dw->query($query_doctor_patient_counts);

$query_daily_revenue = "SELECT DATE(ETLTimestamp) AS Date, SUM(Amount) AS TotalRevenue
                        FROM BillingDim
                        GROUP BY DATE(ETLTimestamp)
                        ORDER BY Date";
$result_daily_revenue = $mysqli_dw->query($query_daily_revenue);

$query_prescription_counts = "SELECT PrescriptionName, COUNT(*) AS PrescriptionCount
                               FROM PrescriptionDim
                               GROUP BY PrescriptionName";
$result_prescription_counts = $mysqli_dw->query($query_prescription_counts);

$query_demographics_by_sex = "SELECT Sex, COUNT(*) AS Count
                              FROM UserDim
                              WHERE user_type = 'Patient'
                              GROUP BY Sex";
$result_demographics_by_sex = $mysqli_dw->query($query_demographics_by_sex);

$query_demographics_by_age = "SELECT 
                                  CASE
                                      WHEN TIMESTAMPDIFF(YEAR, DateOfBirth, CURDATE()) BETWEEN 0 AND 9 THEN '0-9'
                                      WHEN TIMESTAMPDIFF(YEAR, DateOfBirth, CURDATE()) BETWEEN 10 AND 19 THEN '10-19'
                                      WHEN TIMESTAMPDIFF(YEAR, DateOfBirth, CURDATE()) BETWEEN 20 AND 29 THEN '20-29'
                                      WHEN TIMESTAMPDIFF(YEAR, DateOfBirth, CURDATE()) BETWEEN 30 AND 39 THEN '30-39'
                                      WHEN TIMESTAMPDIFF(YEAR, DateOfBirth, CURDATE()) BETWEEN 40 AND 49 THEN '40-49'
                                      WHEN TIMESTAMPDIFF(YEAR, DateOfBirth, CURDATE()) BETWEEN 50 AND 59 THEN '50-59'
                                      WHEN TIMESTAMPDIFF(YEAR, DateOfBirth, CURDATE()) BETWEEN 60 AND 69 THEN '60-69'
                                      ELSE '70+'
                                  END AS AgeGroup,
                                  COUNT(*) AS Count
                              FROM UserDim
                              WHERE user_type = 'Patient'
                              GROUP BY AgeGroup";
$result_demographics_by_age = $mysqli_dw->query($query_demographics_by_age);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesadmin.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <title>Admin Analytics</title>
</head>
<body>
<header>
    <img src="logo.jpg" alt="Hospital Logo"> Elyisian Medical Hospital
</header>
<nav>
    <a class="nav-link" href="admin_dashboard.php">Queries <i class="material-icons">search</i></a>
    <a class="nav-link" href="analytics.php">Analytics <i class="material-icons">bar_chart</i></a>
    <a class="nav-link" href="logout.php">Logout <i class="material-icons">exit_to_app</i></a>
</nav>
<section>
    <div class="data-container"> 
        <h3>Appointments by Type</h3>
        <?php
        if ($result_appointments_by_type->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Appointment Type</th><th>Total Appointments</th></tr>";
            while ($row = $result_appointments_by_type->fetch_assoc()) {
                echo "<tr><td>".$row["AppointmentType"]."</td><td>".$row["TotalAppointments"]."</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No data available";
        }
        ?>
    </div>
    <div class="data-container"> 
        <h3>Patients by Disease</h3>
        <?php
        if ($result_patients_by_disease->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Disease</th><th>Total Patients</th></tr>";
            while ($row = $result_patients_by_disease->fetch_assoc()) {
                echo "<tr><td>".$row["Disease"]."</td><td>".$row["TotalPatients"]."</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No data available";
        }
        ?>
    </div>
    <div class="data-container"> 
        <h3>Revenue by Doctor</h3>
        <?php
        if ($result_revenue_by_doctor->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Doctor Name</th><th>Total Revenue</th></tr>";
            while ($row = $result_revenue_by_doctor->fetch_assoc()) {
                echo "<tr><td>".$row["DoctorName"]."</td><td>".$row["TotalRevenue"]."</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No data available";
        }
        ?>
    </div>
    <div class="data-container"> 
        <h3>Average Length of Stay by Disease</h3>
        <?php
        if ($result_avg_length_of_stay->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Disease</th><th>Avg Length of Stay</th></tr>";
            while ($row = $result_avg_length_of_stay->fetch_assoc()) {
                echo "<tr><td>".$row["Disease"]."</td><td>".$row["AvgLengthOfStay"]."</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No data available";
        }
        ?>
    </div>
    <div class="data-container"> 
    <h3>Appointment Status Counts</h3>
    <?php
    if ($result_appointment_status_counts->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Status</th><th>Count</th></tr>";
        while ($row = $result_appointment_status_counts->fetch_assoc()) {
            echo "<tr><td>".$row["Status"]."</td><td>".$row["StatusCount"]."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No data available";
    }
    ?>
</div>
<div class="data-container"> 
    <h3>Doctor-wise Patient Counts</h3>
    <?php
    if ($result_doctor_patient_counts->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Doctor Name</th><th>Patient Count</th></tr>";
        while ($row = $result_doctor_patient_counts->fetch_assoc()) {
            echo "<tr><td>".$row["DoctorName"]."</td><td>".$row["PatientCount"]."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No data available";
    }
    ?>
</div>
<div class="data-container"> 
    <h3>Prescription Counts</h3>
    <?php
    if ($result_prescription_counts->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Prescription Name</th><th>Count</th></tr>";
        while ($row = $result_prescription_counts->fetch_assoc()) {
            echo "<tr><td>".$row["PrescriptionName"]."</td><td>".$row["PrescriptionCount"]."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No data available";
    }
    ?>
</div>
<div class="data-container"> 
    <h3>Daily Revenue</h3>
    <?php
    if ($result_daily_revenue->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Date</th><th>Total Revenue</th></tr>";
        while ($row = $result_daily_revenue->fetch_assoc()) {
            echo "<tr><td>".$row["Date"]."</td><td>".$row["TotalRevenue"]."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No data available";
    }
    ?>
</div>
<div class="data-container"> 
    <h3>Demographics by Sex</h3>
    <?php
    if ($result_demographics_by_sex->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Sex</th><th>Count</th></tr>";
        while ($row = $result_demographics_by_sex->fetch_assoc()) {
            echo "<tr><td>".$row["Sex"]."</td><td>".$row["Count"]."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No data available";
    }
    ?>
</div>
<div class="data-container"> 
    <h3>Demographics by Age</h3>
    <?php
    if ($result_demographics_by_age->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Age Group</th><th>Count</th></tr>";
        while ($row = $result_demographics_by_age->fetch_assoc()) {
            echo "<tr><td>".$row["AgeGroup"]."</td><td>".$row["Count"]."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No data available";
    }
    ?>
</div>
</section>
</body>
</html>

<?php
$mysqli_dw->close();
?>
