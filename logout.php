<?php
session_start();

// Unset all session variables in the $_SESSION superglobal array
$_SESSION = array();

// Destroy the session cookie by setting its expiration to a time in the past
// This ensures the browser immediately invalidates the cookie.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 3600,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session data on the server
session_destroy();

// Redirect to the login page (index.html)
header("Location: index.php");
exit();
?>