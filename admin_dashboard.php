<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'Admin') {
    header('Location: login.php'); 
    exit();
}

$queryResult = null;
$queryError = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sqlQuery = $_POST['sql_query'];

    if (!empty($sqlQuery)) {
        $mysqli = new mysqli("localhost", "root", "MyNewPass", "dw_db");

        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        $result = $mysqli->query($sqlQuery);

        if ($result) {
            if (strpos(strtoupper($sqlQuery), 'SELECT') !== false) {
                $queryResult = [];

                while ($row = $result->fetch_assoc()) {
                    $queryResult[] = $row;
                }

                $result->close();
            } else {
                $queryResult = "Query executed successfully. Affected rows: " . $mysqli->affected_rows;
            }
        } else {
            $queryError = "Error executing query: " . $mysqli->error;
        }

        $mysqli->close();
    } else {
        $queryError = "Please enter a valid SQL query.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesadmin.css">
    <link
      href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet"
    />
    <title>Admin Query</title>
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
    <div class="query-section">
        <h2>Admin Query</h2>
        <div class="quick-actions">
            <button onclick="executeQuickAction('SELECT * FROM UserDim')">View All Users</button>
            <button onclick="executeQuickAction('SELECT * FROM HospitalDim')">View All Hospitals</button>
            <button onclick="executeQuickAction('SELECT * FROM UserDim WHERE user_type = \'Doctor\'')">View All Doctors</button>
            <button onclick="executeQuickAction('SELECT * FROM UserDim WHERE user_type = \'Patient\'')">View All Patients</button>
            <button onclick="executeQuickAction('SELECT * FROM AppointmentDim')">View All Appointments</button>
            <button onclick="executeQuickAction('SELECT * FROM BillingDim')">View All Billing Details</button>
            <button onclick="executeQuickAction('SELECT * FROM PrescriptionDim')">View Prescriptions</button>
            <button onclick="executeQuickAction('SELECT * FROM TreatDim')">View Treatments</button>
        </div>
        <br>
        <form method="post" action="admin_dashboard.php">
            <label for="sql_query">Enter SQL Query:</label>
            <textarea name="sql_query" rows="4" cols="50" required></textarea>
            <br>
            <input type="submit" value="Execute Query">
        </form>

        <?php
        if ($queryResult !== null) {
            echo '<h3>Query Results:</h3>';

            if (is_array($queryResult)) {
                echo '<table border="1">';
                echo '<tr>';
                foreach ($queryResult[0] as $key => $value) {
                    echo '<th>' . htmlspecialchars($key) . '</th>';
                }
                echo '</tr>';

                foreach ($queryResult as $row) {
                    echo '<tr>';
                    foreach ($row as $value) {
                        echo '<td>' . htmlspecialchars($value) . '</td>';
                    }
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<p>' . htmlspecialchars($queryResult) . '</p>';
            }
        } elseif ($queryError !== null) {
            echo '<h3>Error:</h3>';
            echo '<p>' . htmlspecialchars($queryError) . '</p>';
        }
        ?>
    </div>
</section>

<script>
    function executeQuickAction(sqlQuery) {
        document.querySelector('textarea[name="sql_query"]').value = sqlQuery;
        document.querySelector('form').submit();
    }
</script>

</body>
</html>
