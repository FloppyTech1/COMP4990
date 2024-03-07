<?php
session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Includes
require_once 'includes/config.php';
require_once 'includes/common_functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];
    $input_user_type = $_POST['user_type'];

    $query = "SELECT * FROM User WHERE username = '$input_username' AND user_type = '$input_user_type'";
    $result = executeSelectQuery($db_conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if ($input_password == $user['Password']) {
            $_SESSION['user_id'] = $user['UserID'];
            $_SESSION['user_type'] = $user['user_type'];    

            if ($user['user_type'] == 'Doctor') {
              header('Location: employee_dashboard.php');
            } elseif ($user['user_type'] == 'Patient') {
                header('Location: patient_dashboard.php');
            }
              else if ($user['user_type'] == 'Admin') {
                header('Location: admin_dashboard.php');
            }
            exit();
        }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f7f7f7;
      margin: 0;
      padding: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .container {
      max-width: 400px;
      padding: 40px;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
    }

    .error-message {
      text-align: center;
      color: #ff0000;
      margin-bottom: 20px;
    }

    h1, h2 {
      text-align: center;
      color: #333;
    }

    label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
      color: #555;
    }

    input[type="text"], input[type="password"], select {
      width: 100%;
      padding: 15px;
      margin-bottom: 20px;
      border: 1px solid #ddd;
      border-radius: 5px;
      background-color: #f9f9f9;
      transition: border-color 0.3s ease;
      box-sizing: border-box;
    }

    input[type="text"]:focus, input[type="password"]:focus, select:focus {
      border-color: #007bff;
    }

    select {
      height: 50px;
    }

    input[type="submit"] {
      width: 100%;
      background-color: #007bff;
      color: #fff;
      padding: 15px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      box-sizing: border-box;
    }

    input[type="submit"]:hover {
      background-color: #0056b3;
    }

    .form-links {
      text-align: center;
      margin-left: -85px;
      margin-top: 20px;
      color: #777;
    }

    .form-links a {
      margin: 0 45px;
      color: #007bff;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .form-links a:hover {
      color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="container">
  <div class="error-message">
      <?php
      // Added part to check for passW not match
      if ($_SERVER['REQUEST_METHOD'] == 'POST' && (empty($result) || mysqli_num_rows($result) == 0 || $input_password != $user['Password'])) {
          echo "Invalid username or password.";
      }
      ?>
    </div>
    <h1>Elysian Medical Hospital</h1>
    <h2>Login Portal</h2>
    <form method="post" action="index.php">
      <label for="username">Username:</label>
      <input type="text" name="username" required />

      <label for="password">Password:</label>
      <input type="password" name="password" required />

      <label for="user_type">Login as:</label>
      <select name="user_type">
        <option value="Employee">Employee</option>
        <option value="Patient">Patient</option>
        <option value="Admin">Admin</option>
      </select>
      
      <input type="submit" value="Login" />
      <div class="form-links">
        <a href="#"><a href="forgot_password.php">Forgot Password?</a></a>
      </div>
    </form>
  </div>
</body>
</html>


