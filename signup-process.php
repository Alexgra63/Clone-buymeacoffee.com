<?php
// Include config file
require_once 'config/config.php';

// Include User class
require_once 'classes/User.php';

// Create user object
$user = new User($conn);

// Check if form is submitted
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {
    // Get form data
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $password = $_POST['password']; // will be hashed in the User class

    // Validate terms acceptance
    if(!isset($_POST['terms'])) {
        $_SESSION['flash_message'] = "You must agree to the terms of service and privacy policy";
        $_SESSION['flash_message_type'] = "error";

        // Store form data for repopulation
        $_SESSION['signup_username'] = $username;
        $_SESSION['signup_email'] = $email;

        redirect('signup.php');
        exit;
    }

    // Validate username (alphanumeric and dash only)
    if(!preg_match('/^[a-zA-Z0-9-]+$/', $username)) {
        $_SESSION['flash_message'] = "Username can only contain letters, numbers, and dashes";
        $_SESSION['flash_message_type'] = "error";

        // Store form data for repopulation
        $_SESSION['signup_username'] = $username;
        $_SESSION['signup_email'] = $email;

        redirect('signup.php');
        exit;
    }

    // Validate email
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['flash_message'] = "Please enter a valid email address";
        $_SESSION['flash_message_type'] = "error";

        // Store form data for repopulation
        $_SESSION['signup_username'] = $username;
        $_SESSION['signup_email'] = $email;

        redirect('signup.php');
        exit;
    }

    // Validate password length
    if(strlen($password) < 8) {
        $_SESSION['flash_message'] = "Password must be at least 8 characters long";
        $_SESSION['flash_message_type'] = "error";

        // Store form data for repopulation
        $_SESSION['signup_username'] = $username;
        $_SESSION['signup_email'] = $email;

        redirect('signup.php');
        exit;
    }

    // Check if username is already taken
    if($user->findUserByUsername($username)) {
        $_SESSION['flash_message'] = "Username is already taken. Please choose another one.";
        $_SESSION['flash_message_type'] = "error";

        // Store form data for repopulation
        $_SESSION['signup_username'] = '';
        $_SESSION['signup_email'] = $email;

        redirect('signup.php');
        exit;
    }

    // Check if email is already registered
    if($user->findUserByEmail($email)) {
        $_SESSION['flash_message'] = "Email is already registered. Please login instead.";
        $_SESSION['flash_message_type'] = "error";

        // Store email for login
        $_SESSION['login_email'] = $email;

        redirect('login.php');
        exit;
    }

    // Register user
    if($user->register($username, $email, $password)) {
        // Registration successful, set session to login
        $_SESSION['login_email'] = $email;
        $_SESSION['flash_message'] = "Registration successful! Please enter your password to login.";
        $_SESSION['flash_message_type'] = "success";

        redirect('password.php');
        exit;
    } else {
        // Registration failed
        $_SESSION['flash_message'] = "Registration failed. Please try again.";
        $_SESSION['flash_message_type'] = "error";

        // Store form data for repopulation
        $_SESSION['signup_username'] = $username;
        $_SESSION['signup_email'] = $email;

        redirect('signup.php');
        exit;
    }
} else {
    // Not a POST request, redirect to signup page
    redirect('signup.php');
    exit;
}
