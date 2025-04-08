<?php
// Set page title
$page_title = "Sign Up";

// Include header
include_once 'includes/header.php';

// Redirect if already logged in
if(isLoggedIn()) {
    redirect('dashboard.php');
    exit;
}

// Include signup view
include_once 'views/signup.php';

// Include footer
include_once 'includes/footer.php';
?>
