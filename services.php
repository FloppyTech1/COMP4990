<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'Patient') {   //|| $_SESSION['user_type'] !== 'Doctor'
    header('Location: index.php');
    exit();
}

// Includes
require_once 'includes/config.php';
require_once 'includes/common_functions.php';

/*
// Query to retrieve hospital name from the main_db
$query_db_name = "SELECT HospitalName FROM Hospital WHERE HospitalID = " . $db_name;    // Or something else...
$result_db_name = executeSelectQuery($db_conn, $query_main_db);
*/
$HospitalName = "Elysian Medical";

// Query to retrieve name from the main_db
$query_main_db = "SELECT FullName FROM User WHERE UserID = " . $_SESSION['user_id'];
$result_main_db = executeSelectQuery($db_conn, $query_main_db);

if ($result_main_db && $row_main_db = $result_main_db->fetch_assoc()) {
    $Name = $row_main_db['FullName'];
} else {
    $Name = "Name Not Found";
}

$db_conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="new.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
  <title>Our Services</title>
</head>

<body>
  <header>
    <img src="logo.jpg" alt="Hospital Logo"> Elyisian Medical Hospital
  </header>
  
  <nav>
    <div class="welcome-container">
        <div class="profile-icon"><i class="material-icons">person</i></div>
        <div class="welcome-text">Welcome,</div>
        <div class="dropdown">
            <!-- Display patient name or any other relevant information -->
            <div class="welcome-text"><?php echo $Name; ?>!</div>
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
    <h2>Our Services</h2>
    <div class="data-container">
      <div class="data-box">
        <h3>1. Consultations</h3>
        <p>Our experienced team of doctors provides comprehensive medical consultations to address your health concerns
          and provide personalized treatment plans.</p>
      </div>
      <div class="data-box">
        <h3>2. Diagnostic Tests</h3>
        <p>We offer a range of diagnostic tests, including blood tests, imaging, and screenings, to aid in accurate
          diagnosis and treatment.</p>
      </div>
      <div class="data-box">
        <h3>3. Inpatient Care</h3>
        <p>For patients requiring hospitalization, we provide dedicated inpatient care with 24/7 medical supervision and
          support.</p>
      </div>
      <div class="data-box">
        <h3>4. Surgeries</h3>
        <p>Our skilled surgeons perform various surgical procedures using advanced techniques to ensure optimal
          outcomes for our patients.</p>
      </div>
      <div class="data-box">
        <h3>5. Emergency Services</h3>
        <p>We have a dedicated emergency department equipped to handle medical emergencies and provide immediate care to
          those in need.</p>
      </div>
    </div>
  </section>
  <footer>
    <div class="footer-container">
      <div class="footer-link">
        <i class="material-icons">info</i>
        <a href="about_us.php">About Us</a>
      </div>
      <div class="footer-link">
        <i class="material-icons">mail</i>
        <a href="contact_us.php">Contact Us</a>
      </div>
      <div class="footer-link">
        <i class="material-icons">help</i>
        <a href="faq.php">FAQ</a>
      </div>
      <div class="footer-link">
        <i class="material-icons">build</i>
        <a href="services.php">Services</a>
      </div>
    </div>
  </footer>
</body>

</html>
