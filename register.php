<?php
session_start();
require_once 'db_connect.php';

// Generate and store CSRF token if not already set or if it's expired/used
// For this simple example, we regenerate it to ensure a fresh one for each form load.
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // CSRF Token Validation
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['registration_message'] = "Invalid request. Please try again.";
        // Log this error for security monitoring
        error_log("CSRF token mismatch on registration attempt from IP: " . $_SERVER['REMOTE_ADDR']);
        header("Location: index.php?form=register");
        exit();
    }

    // Sanitize and trim user inputs
    $username = trim(htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8'));
    $email = trim(htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8'));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // --- Input Validation ---
    $errors = [];

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $errors[] = "All fields are required!";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format!";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match!";
    }

    if (strlen($password) < 8) { // Minimum password length
        $errors[] = "Password must be at least 8 characters long.";
    }
    // Optional: Add complexity requirements (e.g., must contain uppercase, lowercase, number, special char)
    // if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/", $password)) {
    //     $errors[] = "Password must be at least 8 characters, contain an uppercase, lowercase, number, and special character.";
    // }

    // Username validation (alphanumeric and underscore only)
    if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
        $errors[] = "Username can only contain letters, numbers, and underscores.";
    }

    if (!empty($errors)) {
        $_SESSION['registration_message'] = implode("<br>", $errors); // Join errors with line breaks
        header("Location: index.php?form=register");
        exit();
    }

    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    if (!$stmt) {
        // Error in preparing statement, log and show generic error
        error_log("Registration (prepare user check) failed: " . $conn->error);
        $_SESSION['registration_message'] = "An unexpected error occurred. Please try again.";
        header("Location: index.php?form=register");
        exit();
    }
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['registration_message'] = "Username or Email already exists!";
        $stmt->close();
        $conn->close();
        header("Location: index.php?form=register");
        exit();
    }
    $stmt->close();

    // Hash the password securely using the default algorithm (recommended)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if (!$stmt) {
        // Error in preparing statement
        error_log("Registration (prepare insert) failed: " . $conn->error);
        $_SESSION['registration_message'] = "An unexpected error occurred during registration. Please try again.";
        header("Location: index.php?form=register");
        exit();
    }
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION['registration_message'] = "Registration successful! You can now log in.";
        // On successful registration, it's good practice to clear the CSRF token,
        // as a new one will be generated on the next form load.
        unset($_SESSION['csrf_token']);
        header("Location: index.php?form=login");
    } else {
        // Log the actual database error for debugging purposes (not for end-user)
        error_log("Database error during registration: " . $stmt->error);
        $_SESSION['registration_message'] = "Registration failed. Please try again later.";
        header("Location: index.php?form=register");
    }

    $stmt->close();
    $conn->close();
} else {
    // If accessed directly without POST request, redirect to index
    header("Location: index.php");
    exit();
}
?>