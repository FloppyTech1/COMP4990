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
  <title>Contact Us</title>
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
    <h2>Contact Us</h2>
    <div class="data-container">
      <div class="data-box">
        <h3>Get in Touch</h3>
        <p>If you have any questions or inquiries, feel free to reach out to us. Our dedicated team is here to
          assist you.</p>
        <ul>
          <li><?php echo $HospitalName; ?></li>
          <li><strong>Address:</strong> 123 Street Name, City, State, Country POS COD</li>
          <li><strong>Phone:</strong> (123) 456-7890</li>
          <li><strong>Email:</strong> info@hospital.com</li>
        </ul>
        <p>We value your feedback and strive to provide the best healthcare services to our community.</p>
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
