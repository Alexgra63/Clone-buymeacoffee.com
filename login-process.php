<?php
// Include config file
require_once 'config/config.php';

// Include User class
require_once 'classes/User.php';

// Create user object
$user = new User($conn);

// Check if form is submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Email login
    if(isset($_POST['login_email'])) {
        // Get email
        $email = sanitize($_POST['email']);

        // Validate email
        if(empty($email)) {
            $_SESSION['flash_message'] = "Please enter your email address";
            $_SESSION['flash_message_type'] = "error";
            redirect('login.php');
            exit;
        }

        // Check if email exists
        $userExists = $user->findUserByEmail($email);

        if($userExists) {
            // In a real application, you would generate a token and send a password reset link
            // For this example, we'll just set a session variable and redirect to password entry page
            $_SESSION['login_email'] = $email;
            redirect('password.php');
            exit;
        } else {
            // Email doesn't exist, redirect to signup
            $_SESSION['signup_email'] = $email;
            $_SESSION['flash_message'] = "Email not found. Please sign up.";
            $_SESSION['flash_message_type'] = "info";
            redirect('signup.php');
            exit;
        }
    }

    // Password submission (this would be a separate form in a real application)
    if(isset($_POST['login_password'])) {
        // Get email and password
        $email = $_SESSION['login_email'] ?? '';
        $password = sanitize($_POST['password']);

        // Validate
        if(empty($email) || empty($password)) {
            $_SESSION['flash_message'] = "Please enter both email and password";
            $_SESSION['flash_message_type'] = "error";
            redirect('password.php');
            exit;
        }

        // Try to login
        if($user->login($email, $password)) {
            // Success, redirect to dashboard
            $_SESSION['flash_message'] = "Welcome back!";
            $_SESSION['flash_message_type'] = "success";
            redirect('dashboard.php');
            exit;
        } else {
            // Failed login
            $_SESSION['flash_message'] = "Invalid password. Please try again.";
            $_SESSION['flash_message_type'] = "error";
            redirect('password.php');
            exit;
        }
    }
} else {
    // Not a POST request, redirect to login page
    redirect('login.php');
    exit;
}
