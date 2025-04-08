<?php
// Include config file
require_once 'config/config.php';

// Include required classes
require_once 'classes/User.php';
require_once 'classes/Donation.php';

// Create objects
$userObj = new User($conn);
$donationObj = new Donation($conn);

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $recipient_id = isset($_POST['recipient_id']) ? intval($_POST['recipient_id']) : 0;
    $coffee_amount = isset($_POST['coffee_amount']) ? intval($_POST['coffee_amount']) : 1;
    $name = isset($_POST['name']) ? sanitize($_POST['name']) : '';
    $message = isset($_POST['message']) ? sanitize($_POST['message']) : '';
    $is_monthly = isset($_POST['is_monthly']) && $_POST['is_monthly'] == '1' ? 1 : 0;

    // Validate recipient
    $recipient = $userObj->getUserById($recipient_id);
    if (!$recipient) {
        $_SESSION['flash_message'] = "Recipient not found.";
        $_SESSION['flash_message_type'] = "error";
        redirect('index.php');
        exit;
    }

    // Validate coffee amount
    if ($coffee_amount < 1) {
        $coffee_amount = 1;
    }

    // Calculate donation amount
    $amount = $coffee_amount * COFFEE_PRICE;

    // Check if user is logged in
    if (isLoggedIn()) {
        $supporter_id = $_SESSION['user_id'];

        // Check if trying to donate to self
        if ($supporter_id == $recipient_id) {
            $_SESSION['flash_message'] = "You cannot buy yourself coffee.";
            $_SESSION['flash_message_type'] = "error";
            redirect('creator.php?username=' . $recipient['username']);
            exit;
        }
    } else {
        // For guest donations, set supporter_id to 0
        $supporter_id = 0;
    }

    // In a real app, this is where you would integrate with PayPal, Stripe, etc.
    // For this example, we'll just create the donation record directly

    // Process donation
    if ($donationObj->create($supporter_id, $recipient_id, $amount, $message, $coffee_amount, $is_monthly)) {
        // Success
        $_SESSION['flash_message'] = "Thank you for supporting " . $recipient['username'] . "!";
        $_SESSION['flash_message_type'] = "success";
        redirect('creator.php?username=' . $recipient['username']);
        exit;
    } else {
        // Error
        $_SESSION['flash_message'] = "There was a problem processing your donation. Please try again.";
        $_SESSION['flash_message_type'] = "error";
        redirect('creator.php?username=' . $recipient['username']);
        exit;
    }
} else {
    // Not a POST request, redirect to home
    redirect('index.php');
    exit;
}
