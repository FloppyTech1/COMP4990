<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="new.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <title>About Us</title>
  </head>
  <body>
    <?php
      session_start();
      if(isset($_SESSION['user_type'])) {
        if($_SESSION['user_type'] == 'Doctor') {
          $dashboard_link = "doctor_dashboard.php";
          $patients_link = "view_patients.php";
          $appointments_link = "view_appointments.php";
          $treatments_link = "view_treatments.php";
          $dashboard_title = "Home";
          $patients_title = "Patients";
          $appointments_title = "Appointments";
          $treatments_title = "Treatments";
        } elseif($_SESSION['user_type'] == 'Patient') {
          $dashboard_link = "patient_dashboard.php";
          $patients_link = "appointments.php";
          $appointments_link = "treatments.php";
          $treatments_link = "prescriptions.php";
          $dashboard_title = "Home";
          $patients_title = "Appointments"; 
          $appointments_title = "Treatments"; 
          $treatments_title = "Prescriptions"; 
        }
      }
    ?>
    <header>
      <img src="logo.jpg" alt="Hospital Logo"> Elysian Medical Hospital
    </header>
    <nav>
      <div class="welcome-container">
        <div class="profile-icon">
          <i class="material-icons">person</i>
        </div>
        <div class="welcome-text">Welcome!</div>
      </div>
      <div class="nav-links">
        <a class="nav-link" href="<?php echo $dashboard_link; ?>"><?php echo $dashboard_title; ?> <i class="material-icons">home</i>
        </a>
          <a class="nav-link" href="<?php echo $patients_link; ?>"><?php echo $patients_title; ?> <i class="material-icons">people</i>
          </a>
          <a class="nav-link" href="<?php echo $appointments_link; ?>"><?php echo $appointments_title; ?> <i class="material-icons">date_range</i>
          </a>
          <a class="nav-link" href="<?php echo $treatments_link; ?>"><?php echo $treatments_title; ?> <i class="material-icons">vaccines</i>
          </a>
        <a class="nav-link" href="logout.php">Logout <i class="material-icons">exit_to_app</i>
        </a>
      </div>
    </nav>
    <section>
      <h2>About Us</h2>
      <div class="data-container">
        <div class="data-box">
          <h3>Welcome to Elysian Medical Hospital!</h3>
          <p>Welcome to Elysian Medical Hospital, where compassionate care meets cutting-edge innovation. At Elysian, we pride ourselves on providing exceptional medical services tailored to meet the unique needs of each patient. From routine check-ups to complex surgical procedures, our dedicated team of healthcare professionals is committed to ensuring your well-being every step of the way. Situated in a serene environment designed to promote healing and comfort, we strive to exceed expectations and redefine the standard of excellence in healthcare. Your journey to optimal health begins here at Elysian Medical Hospital, where your wellness is our priority.</p>
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
