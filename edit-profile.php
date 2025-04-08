<?php
// Set page title
$page_title = "Edit Profile";

// Include header
include_once 'includes/header.php';

// Check if user is logged in
if (!isLoggedIn()) {
    $_SESSION['flash_message'] = "You must be logged in to edit your profile";
    $_SESSION['flash_message_type'] = "error";
    redirect('login.php');
    exit;
}

// Include User class
require_once 'classes/User.php';

// Create user object
$userObj = new User($conn);

// Get user data
$user_id = $_SESSION['user_id'];
$user = $userObj->getUserById($user_id);

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $username = sanitize($_POST['username']);
    $bio = sanitize($_POST['bio']);
    $website = sanitize($_POST['website']);

    // Validate username (alphanumeric and dash only)
    if (!preg_match('/^[a-zA-Z0-9-]+$/', $username)) {
        $_SESSION['flash_message'] = "Username can only contain letters, numbers, and dashes";
        $_SESSION['flash_message_type'] = "error";
    } else {
        // Check if username is already taken (if changed)
        if ($username != $user['username']) {
            $existingUser = $userObj->findUserByUsername($username);
            if ($existingUser) {
                $_SESSION['flash_message'] = "Username is already taken. Please choose another one.";
                $_SESSION['flash_message_type'] = "error";
            } else {
                // Username is available, proceed with update
                $data = [
                    'username' => $username,
                    'bio' => $bio,
                    'website' => $website
                ];

                // Handle avatar upload
                if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
                    $avatar = $_FILES['avatar'];

                    // Check file type
                    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                    if (in_array($avatar['type'], $allowed_types)) {
                        // Generate unique filename
                        $ext = pathinfo($avatar['name'], PATHINFO_EXTENSION);
                        $filename = $username . '_' . time() . '.' . $ext;

                        // Create uploads directory if not exists
                        if (!file_exists('uploads/avatars')) {
                            mkdir('uploads/avatars', 0755, true);
                        }

                        // Move uploaded file
                        if (move_uploaded_file($avatar['tmp_name'], 'uploads/avatars/' . $filename)) {
                            // Add avatar to data
                            $data['avatar'] = $filename;
                        } else {
                            $_SESSION['flash_message'] = "Failed to upload avatar. Please try again.";
                            $_SESSION['flash_message_type'] = "error";
                        }
                    } else {
                        $_SESSION['flash_message'] = "Invalid file type. Please upload JPG, PNG, or GIF.";
                        $_SESSION['flash_message_type'] = "error";
                    }
                }

                // Update profile
                if (!isset($_SESSION['flash_message'])) {
                    if ($userObj->updateProfile($user_id, $data)) {
                        $_SESSION['flash_message'] = "Profile updated successfully!";
                        $_SESSION['flash_message_type'] = "success";

                        // Update session username if changed
                        if ($username != $user['username']) {
                            $_SESSION['user_username'] = $username;
                        }

                        // Redirect to dashboard
                        redirect('dashboard.php');
                        exit;
                    } else {
                        $_SESSION['flash_message'] = "Failed to update profile. Please try again.";
                        $_SESSION['flash_message_type'] = "error";
                    }
                }
            }
        } else {
            // Username not changed, proceed with update
            $data = [
                'username' => $username,
                'bio' => $bio,
                'website' => $website
            ];

            // Handle avatar upload
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
                $avatar = $_FILES['avatar'];

                // Check file type
                $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                if (in_array($avatar['type'], $allowed_types)) {
                    // Generate unique filename
                    $ext = pathinfo($avatar['name'], PATHINFO_EXTENSION);
                    $filename = $username . '_' . time() . '.' . $ext;

                    // Create uploads directory if not exists
                    if (!file_exists('uploads/avatars')) {
                        mkdir('uploads/avatars', 0755, true);
                    }

                    // Move uploaded file
                    if (move_uploaded_file($avatar['tmp_name'], 'uploads/avatars/' . $filename)) {
                        // Add avatar to data
                        $data['avatar'] = $filename;
                    } else {
                        $_SESSION['flash_message'] = "Failed to upload avatar. Please try again.";
                        $_SESSION['flash_message_type'] = "error";
                    }
                } else {
                    $_SESSION['flash_message'] = "Invalid file type. Please upload JPG, PNG, or GIF.";
                    $_SESSION['flash_message_type'] = "error";
                }
            }

            // Update profile
            if (!isset($_SESSION['flash_message'])) {
                if ($userObj->updateProfile($user_id, $data)) {
                    $_SESSION['flash_message'] = "Profile updated successfully!";
                    $_SESSION['flash_message_type'] = "success";

                    // Redirect to dashboard
                    redirect('dashboard.php');
                    exit;
                } else {
                    $_SESSION['flash_message'] = "Failed to update profile. Please try again.";
                    $_SESSION['flash_message_type'] = "error";
                }
            }
        }
    }
}
?>

<div class="container">
    <div class="edit-profile">
        <div class="profile-header">
            <h1>Edit Profile</h1>
            <a href="<?php echo BASE_URL; ?>/dashboard.php" class="btn btn-outline">Back to Dashboard</a>
        </div>

        <form action="<?php echo BASE_URL; ?>/edit-profile.php" method="POST" enctype="multipart/form-data" class="profile-form">
            <div class="form-group">
                <label for="username">Username</label>
                <div class="username-input">
                    <span class="input-prefix">buymeacoffee.com/</span>
                    <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>
                <small class="form-text">Your username can only contain letters, numbers, and dashes.</small>
            </div>

            <div class="form-group">
                <label for="avatar">Profile Picture</label>
                <div class="avatar-preview">
                    <?php if (!empty($user['avatar'])): ?>
                        <img src="<?php echo BASE_URL; ?>/uploads/avatars/<?php echo $user['avatar']; ?>" alt="Profile Picture">
                    <?php else: ?>
                        <div class="avatar-placeholder"><?php echo strtoupper(substr($user['username'], 0, 1)); ?></div>
                    <?php endif; ?>
                </div>
                <input type="file" id="avatar" name="avatar" class="form-control-file">
                <small class="form-text">Upload JPG, PNG, or GIF. Max size: 2MB.</small>
            </div>

            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea id="bio" name="bio" class="form-control" rows="5"><?php echo htmlspecialchars($user['bio'] ?? ''); ?></textarea>
                <small class="form-text">Tell your supporters about yourself and what you create.</small>
            </div>

            <div class="form-group">
                <label for="website">Website</label>
                <input type="url" id="website" name="website" class="form-control" value="<?php echo htmlspecialchars($user['website'] ?? ''); ?>" placeholder="https://example.com">
                <small class="form-text">Add your website or blog URL.</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="<?php echo BASE_URL; ?>/dashboard.php" class="btn btn-link">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php
// Include footer
include_once 'includes/footer.php';
?>
