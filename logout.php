<?php
// Include config file
require_once 'config/config.php';

// Include User class
require_once 'classes/User.php';

// Create user object
$user = new User($conn);

// Logout user
$user->logout();

// Set flash message
$_SESSION['flash_message'] = "You have been logged out successfully";
$_SESSION['flash_message_type'] = "info";

// Redirect to home page
redirect('index.php');
exit;
