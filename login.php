<?php
// Set page title
$page_title = "Login";

// Include header
include_once 'includes/header.php';

// Redirect if already logged in
if(isLoggedIn()) {
    redirect('dashboard.php');
    exit;
}

// Include login view
include_once 'views/login.php';

// Include footer
include_once 'includes/footer.php';
?>
