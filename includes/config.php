<?php
    // Some help were needed from https://github.com/vlucas/phpdotenv to be able to use .env

    // Enable error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once __DIR__ . '/../vendor/autoload.php';           // Included the dotenv library

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../'); // Directory of .env file
    $dotenv->load();                                            // Load .env file

    // Retrieve db info from .env file
    $db_host = $_ENV['DB_HOST'];
    $db_name = $_ENV['DB_NAME'];
    $db_user = $_ENV['DB_USER'];
    $db_password = $_ENV['DB_PASSWORD'];

    $dw_host = $_ENV['DW_HOST'];
    $dw_name = $_ENV['DW_NAME'];
    $dw_user = $_ENV['DW_USER'];
    $dw_password = $_ENV['DW_PASSWORD'];


    // Try/catch implementation maybe
    
    // Connect to the DB
    $db_conn = new mysqli($db_host, $db_user, $db_password, $db_name);

    // Connect to the DW
    $dw_conn = new mysqli($dw_host, $dw_user, $dw_password, $dw_name);

?>