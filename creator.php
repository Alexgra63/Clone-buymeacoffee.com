<?php
// Include config file
require_once 'config/config.php';

// Include required classes
require_once 'classes/User.php';
require_once 'classes/Donation.php';
require_once 'classes/Membership.php';

// Create objects
$userObj = new User($conn);
$donationObj = new Donation($conn);
$membershipObj = new Membership($conn);

// Get username from URL
$username = isset($_GET['username']) ? sanitize($_GET['username']) : '';

// If no username provided, redirect to home
if (empty($username)) {
    redirect('index.php');
    exit;
}

// Find user by username
$creator = $userObj->findUserByUsername($username);

// If user not found, show 404
if (!$creator) {
    // Set page title
    $page_title = "Creator Not Found";

    // Include header
    include_once 'includes/header.php';

    // Display 404 message
    echo '<div class="container">';
    echo '<div class="error-page">';
    echo '<h1>Creator Not Found</h1>';
    echo '<p>The creator you are looking for does not exist.</p>';
    echo '<a href="' . BASE_URL . '" class="btn btn-primary">Go Home</a>';
    echo '</div>';
    echo '</div>';

    // Include footer
    include_once 'includes/footer.php';
    exit;
}

// Get supporter count
$supportersCount = $userObj->getSupportersCount($creator['id']);

// Get recent donations
$recentDonations = $donationObj->getByRecipient($creator['id'], 5);

// Get memberships
$memberships = $membershipObj->getByCreator($creator['id']);

// Set page title
$page_title = $creator['username'];

// Include header
include_once 'includes/header.php';

// Include creator view
include_once 'views/creator.php';

// Include footer
include_once 'includes/footer.php';
