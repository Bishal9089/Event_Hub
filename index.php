<?php
// index.php
session_start();

// Check if the user is already logged in, redirect to home.php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: home.php");
    exit();
}

// Generate and store CSRF token if not already set or if it's expired/used
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

// Determine which form to show based on URL parameter or default to login
$showForm = isset($_GET['form']) && $_GET['form'] === 'register' ? 'register' : 'login';
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventHub - Login / Register</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://placehold.co/16x16/000000/FFFFFF?text=E">

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom styles from your original index.html */
        html {
            scroll-behavior: smooth;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb; /* Tailwind's bg-gray-50 */
            color: #1f2937; /* Tailwind's text-gray-800 */
            display: flex;
            flex-direction: column; /* Allows footer to stick to bottom */
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        /* Hide scroll-to-top button by default */
        #scrollToTopBtn {
            display: none;
        }
        /* Basic form styling for better appearance */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db; /* Tailwind's border-gray-300 */
            border-radius: 0.375rem; /* Tailwind's rounded-md */
            outline: none;
            transition: box-shadow 0.2s, border-color 0.2s;
            margin-top: 0.25rem; /* Added for spacing */
            margin-bottom: 1rem; /* Added for spacing */
        }
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus {
            box-shadow: 0 0 0 2px #3b82f6; /* Tailwind's ring-2 ring-blue-500 */
            border-color: #3b82f6;
        }
        button[type="submit"] {
            background-color: #2563eb; /* Tailwind's bg-blue-600 */
            color: #fff;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            transition: background-color 0.3s;
            border: none;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #1d4ed8; /* Tailwind's bg-blue-700 */
        }

        /* Styles for the message display from PHP */
        .message-success {
            color: #15803d; /* Tailwind's text-green-700 */
            background-color: #dcfce7; /* Tailwind's bg-green-100 */
            padding: 0.75rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
            text-align: center;
        }
        .message-error {
            color: #b91c1c; /* Tailwind's text-red-700 */
            background-color: #fee2e2; /* Tailwind's bg-red-100 */
            padding: 0.75rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
            text-align: center;
        }
        .form-container {
            background-color: #ffffff;
            padding: 2.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            width: 100%;
            max-width: 420px; /* Max width for forms */
            margin: auto; /* Center the form container */
            flex-grow: 1; /* Allow it to take available space */
            display: flex;
            flex-direction: column;
            justify-content: center; /* Center vertically within its container */
        }
        .hidden { display: none; }

        /* The header and footer from your original index.html are NOT included here.
           They should be part of home.php once the user is logged in.
           This index.php will ONLY show login/register forms. */
    </style>
</head>
<body class="flex flex-col min-h-screen">
    <main id="main-content" class="flex-grow flex items-center justify-center container mx-auto px-4 py-8">
        <div id="login-form-container" class="form-container <?php echo ($showForm === 'login') ? '' : 'hidden'; ?>">
            <h2 class="text-2xl font-bold text-center text-gray-900 mb-6">Login to Your Account</h2>
            <form action="login.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                <div id="login-form-message" class="mt-4 text-center text-sm font-medium">
                    <?php
                    // Display messages from session variables
                    if (isset($_GET['timeout']) && $_GET['timeout'] === 'true') {
                        echo '<p class="message-error">Your session has expired. Please log in again.</p>';
                    }
                    if (isset($_SESSION['login_message'])) {
                        $message_class = (strpos($_SESSION['login_message'], 'successful') !== false) ? 'message-success' : 'message-error';
                        echo '<p class="' . $message_class . '">' . htmlspecialchars($_SESSION['login_message']) . '</p>';
                        unset($_SESSION['login_message']); // Clear the message after displaying
                    }
                    ?>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" id="email" name="email" required autocomplete="email" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Email address">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Password">
                </div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Sign in
                </button>
                <p class="mt-4 text-center text-sm text-gray-600">
                    Don't have an account? <a href="?form=register" id="show-register-form-link" class="font-medium text-indigo-600 hover:text-indigo-500">Register here</a>
                </p>
            </form>
        </div>

        <div id="registration-form-container" class="form-container <?php echo ($showForm === 'register') ? '' : 'hidden'; ?>">
            <h2 class="text-2xl font-bold text-center text-gray-900 mb-6">Create an Account</h2>
            <form action="register.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                <div id="registration-form-message" class="mt-4 text-center text-sm font-medium">
                    <?php
                    if (isset($_SESSION['registration_message'])) {
                        $message_class = (strpos($_SESSION['registration_message'], 'successful') !== false) ? 'message-success' : 'message-error';
                        echo '<p class="' . $message_class . '">' . htmlspecialchars($_SESSION['registration_message']) . '</p>';
                        unset($_SESSION['registration_message']);
                    }
                    ?>
                </div>
                <div>
                    <label for="reg-username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="reg-username" name="username" required autocomplete="username" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Username">
                </div>
                <div>
                    <label for="reg-email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" id="reg-email" name="email" required autocomplete="email" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Email address">
                </div>
                <div>
                    <label for="reg-password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="reg-password" name="password" required autocomplete="new-password" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Password">
                </div>
                <div>
                    <label for="reg-confirm-password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" id="reg-confirm-password" name="confirm_password" required autocomplete="new-password" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Confirm Password">
                </div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Register
                </button>
                <p class="mt-4 text-center text-sm text-gray-600">
                    Already have an account? <a href="?form=login" id="show-login-form-link" class="font-medium text-indigo-600 hover:text-indigo-500">Login here</a>
                </p>
            </form>
        </div>
    </main>

    <footer class="bg-gray-900 text-white py-8 mt-auto w-full">
        <div class="container mx-auto px-4 text-center">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                <div class="mb-4 md:mb-0">
                    <h3 class="text-2xl font-bold text-blue-400">EventHub</h3>
                    <p class="text-gray-400 text-sm">Organizing memorable experiences.</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Terms of Service</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">FAQ</a>
                </div>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-6 text-gray-500 text-sm">
                &copy; <span id="current-year-footer"></span> EventHub. All rights reserved.
            </div>
        </div>
    </footer>

    <button id="scrollToTopBtn" class="fixed bottom-8 right-8 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 transition-colors duration-300 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <script>
        document.getElementById('current-year-footer').textContent = new Date().getFullYear();

        const scrollToTopBtn = document.getElementById('scrollToTopBtn');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                scrollToTopBtn.style.display = 'block';
            } else {
                scrollToTopBtn.style.display = 'none';
            }
        });
        scrollToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // JavaScript for switching forms visibility without reloading the page
        document.addEventListener('DOMContentLoaded', () => {
            const loginFormContainer = document.getElementById('login-form-container');
            const registrationFormContainer = document.getElementById('registration-form-container');
            const showRegisterFormLink = document.getElementById('show-register-form-link');
            const showLoginFormLink = document.getElementById('show-login-form-link');
            const loginFormMessageDiv = document.getElementById('login-form-message');
            const registrationFormMessageDiv = document.getElementById('registration-form-message');

            function showForm(formType) {
                if (formType === 'login') {
                    loginFormContainer.classList.remove('hidden');
                    registrationFormContainer.classList.add('hidden');
                } else if (formType === 'register') {
                    registrationFormContainer.classList.remove('hidden');
                    loginFormContainer.classList.add('hidden');
                }
            }

            // Initial form display based on URL parameter (from PHP)
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('form') === 'register') {
                showForm('register');
            } else {
                showForm('login');
            }

            // Event listeners for switching forms using links (updates URL for user)
            if (showRegisterFormLink) {
                showRegisterFormLink.addEventListener('click', (e) => {
                    e.preventDefault();
                    showForm('register');
                    history.pushState(null, '', 'index.php?form=register');
                });
            }
            if (showLoginFormLink) {
                showLoginFormLink.addEventListener('click', (e) => {
                    e.preventDefault();
                    showForm('login');
                    history.pushState(null, '', 'index.php?form=login');
                });
            }

            // Function to clear messages after a delay for better UX
            function clearMessage(messageDiv) {
                if (messageDiv && messageDiv.innerHTML.trim() !== '') {
                    setTimeout(() => {
                        messageDiv.innerHTML = '';
                    }, 5000); // Clear after 5 seconds
                }
            }
            clearMessage(loginFormMessageDiv);
            clearMessage(registrationFormMessageDiv);
        });
    </script>
</body>
</html>
