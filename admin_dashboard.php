<?php
session_start();

// Check if the user is logged in and has admin privileges
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'Admin') {
    header('Location: index.php'); 
    exit();
}

// Includes
require_once 'includes/config.php';
require_once 'includes/common_functions.php';

// Initialize variables
$queryResult = null;
$queryError = null;

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sqlQuery = $_POST['sql_query'];

    $result = executeSelectQuery($db_conn, $sqlQuery);

    if ($result) {
        // Check if the query is a SELECT query
        if (strpos(strtoupper($sqlQuery), 'SELECT') !== false) {
            // Query is a SELECT, fetch results
            $queryResult = [];

            while ($row = $result->fetch_assoc()) {
                $queryResult[] = $row;
            }

            // Free result set
            $result->close();
        } else {
            // Query is not a SELECT, display success message
            $queryResult = "Query executed successfully. Affected rows: " . $db_conn->affected_rows;
        }
    } else {
        // Query execution failed
        $queryError = "Error executing query: " . $db_conn->error;
    }

    $db_conn->close();
} else {
    // Handle empty query case
    $queryError = "Please enter a valid SQL query.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
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
    <a class="nav-link" href="logout.php">Logout <i class="material-icons">exit_to_app</i></a>
</nav>

<section>
    <div class="query-section">
        <h2>Admin Query</h2>
        <form method="post" action="admin_dashboard.php">
            <label for="sql_query">Enter SQL Query:</label>
            <textarea name="sql_query" rows="4" cols="50" required></textarea>
            <br>
            <input type="submit" value="Execute Query">
        </form>

        <?php
        // Display query results or error message
        if ($queryResult !== null) {
            echo '<h3>Query Results:</h3>';

            if (is_array($queryResult)) {
                // Display results in a table
                echo '<table border="1">';
                // Display table header
                echo '<tr>';
                foreach ($queryResult[0] as $key => $value) {
                    echo '<th>' . htmlspecialchars($key) . '</th>';
                }
                echo '</tr>';

                // Display table rows
                foreach ($queryResult as $row) {
                    echo '<tr>';
                    foreach ($row as $value) {
                        echo '<td>' . htmlspecialchars($value) . '</td>';
                    }
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                // Display non-array result
                echo '<p>' . htmlspecialchars($queryResult) . '</p>';
            }
        } elseif ($queryError !== null) {
            echo '<h3>Error:</h3>';
            echo '<p>' . htmlspecialchars($queryError) . '</p>';
        }
        ?>
    </div>
</section>

</body>
</html>
