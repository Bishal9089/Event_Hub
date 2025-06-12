<?php
// Define database credentials
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = "";     // Default XAMPP password (empty)
$dbname = "event_db"; // Your database name

// Enable error reporting for development (remove in production)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Attempt to establish database connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Set character set to UTF-8 for proper handling of international characters
    $conn->set_charset("utf8mb4");
    
    // Optional: Set SQL mode for better compatibility
    $conn->query("SET sql_mode = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'");
    
} catch (mysqli_sql_exception $e) {
    // Log the error with more details
    $error_message = "Database Connection Failed: " . $e->getMessage() . " (Code: " . $e->getCode() . ")";
    error_log($error_message, 3, "error_log.log");
    
    // Display user-friendly error message
    die("
    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px;'>
        <h2 style='color: #d32f2f;'>Database Connection Error</h2>
        <p>Unable to connect to the database. Please check:</p>
        <ul>
            <li>XAMPP/MySQL is running</li>
            <li>Database 'event_db' exists</li>
            <li>Database credentials are correct</li>
        </ul>
        <p><strong>Technical Details:</strong> " . htmlspecialchars($e->getMessage()) . "</p>
        <p><a href='javascript:history.back()' style='color: #1976d2;'>← Go Back</a></p>
    </div>
    ");
}

// Test the connection with a simple query
try {
    $test_query = $conn->query("SELECT 1");
    if (!$test_query) {
        throw new Exception("Connection test failed");
    }
} catch (Exception $e) {
    error_log("Database connection test failed: " . $e->getMessage(), 3, "error_log.log");
    die("Database connection test failed. Please check your database setup.");
}
?>