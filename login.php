<?php
session_start();
require_once 'db_connect.php';

// Generate and store CSRF token if not already set
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // CSRF Token Validation
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['login_message'] = "Invalid request. Please try again.";
        error_log("CSRF token mismatch on login attempt from IP: " . $_SERVER['REMOTE_ADDR']);
        header("Location: index.php?form=login");
        exit();
    }

    // Sanitize and trim user input
    $email = trim(htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8'));
    $password = $_POST['password'];

    // --- Input Validation ---
    if (empty($email) || empty($password)) {
        $_SESSION['login_message'] = "Both email and password are required!";
        header("Location: index.php?form=login");
        exit();
    }

    // --- Brute-Force Protection (Conceptual - requires database/cache for persistent tracking) ---
    // This is a placeholder for a more complex implementation.
    // You would typically:
    // 1. Record failed login attempts (e.g., in a 'failed_logins' table with IP, email, timestamp).
    // 2. Check if the current IP/email has exceeded a certain number of attempts within a time window.
    // 3. If so, introduce a delay (e.g., sleep(2) for 2 seconds) or temporarily block the IP/email.
    // Example:
    // if (check_and_limit_login_attempts($email, $_SERVER['REMOTE_ADDR'])) {
    //     $_SESSION['login_message'] = "Too many failed login attempts. Please try again later.";
    //     header("Location: index.html?form=login");
    //     exit();
    // }

    // Prepare and execute the query to fetch user
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    if (!$stmt) {
        error_log("Login (prepare user fetch) failed: " . $conn->error);
        $_SESSION['login_message'] = "An unexpected error occurred. Please try again.";
        header("Location: index.php?form=login");
        exit();
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $username, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        // Verify password against the hashed password from the database
        if (password_verify($password, $hashed_password)) {
            // Password is correct, regenerate session ID for security (session fixation prevention)
            // 'true' parameter deletes the old session file immediately.
            session_regenerate_id(true);

            // Set session variables
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['last_activity'] = time(); // Track last activity for session timeout

            // Clear any lingering login messages
            unset($_SESSION['login_message']);
            // Clear CSRF token as it's now used/user is logged in.
            unset($_SESSION['csrf_token']);

            // Redirect to home page
            header("Location: home.php");
            exit();
        } else {
            // Invalid password
            $_SESSION['login_message'] = "Invalid email or password.";
            // Call function to record failed login attempt here for brute-force protection
            header("Location: index.php?form=login");
            exit();
        }
    } else {
        // User not found (invalid email)
        $_SESSION['login_message'] = "Invalid email or password.";
        // Call function to record failed login attempt here for brute-force protection
        header("Location: index.php?form=login");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    // If accessed directly without POST request, redirect to index
    header("Location: index.php");
    exit();
}
?>