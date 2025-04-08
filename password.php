<?php
// Set page title
$page_title = "Enter Password";

// Include header
include_once 'includes/header.php';

// Redirect if already logged in
if(isLoggedIn()) {
    redirect('dashboard.php');
    exit;
}

// Check if we have the email in session
if(!isset($_SESSION['login_email'])) {
    redirect('login.php');
    exit;
}

$email = $_SESSION['login_email'];
?>

<div class="auth-container">
    <div class="auth-header">
        <a href="<?php echo BASE_URL; ?>" class="auth-logo">
            <img src="<?php echo BASE_URL; ?>/assets/img/logo.svg" alt="Buy Me a Coffee">
        </a>
    </div>

    <div class="auth-form">
        <h1>Enter your password</h1>
        <p class="auth-email"><?php echo htmlspecialchars($email); ?></p>

        <form action="<?php echo BASE_URL; ?>/login-process.php" method="POST">
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <div class="form-group">
                <button type="submit" name="login_password" class="form-button yellow-btn">Login</button>
            </div>

            <div class="form-footer">
                <a href="<?php echo BASE_URL; ?>/forgot-password.php">Forgot password?</a>
            </div>
        </form>
    </div>
</div>

<?php
// Include footer
include_once 'includes/footer.php';
?>
