<?php
// Set page title
$page_title = "Dashboard";

// Include header
include_once 'includes/header.php';

// Check if user is logged in
if (!isLoggedIn()) {
    $_SESSION['flash_message'] = "You must be logged in to access the dashboard";
    $_SESSION['flash_message_type'] = "error";
    redirect('login.php');
    exit;
}

// Include required classes
require_once 'classes/User.php';
require_once 'classes/Donation.php';
require_once 'classes/Membership.php';

// Create objects
$userObj = new User($conn);
$donationObj = new Donation($conn);
$membershipObj = new Membership($conn);

// Get user data
$user_id = $_SESSION['user_id'];
$user = $userObj->getUserById($user_id);

// Get donations received
$donationsReceived = $donationObj->getByRecipient($user_id, 10);

// Get donations made
$donationsMade = $donationObj->getBySupporter($user_id, 10);

// Get memberships created
$memberships = $membershipObj->getByCreator($user_id);

// Get supporter count
$supportersCount = $userObj->getSupportersCount($user_id);

// Get total coffees received
$totalCoffees = $donationObj->getTotalCoffees($user_id);

// Get total amount received
$totalAmount = $donationObj->getTotalAmount($user_id);

// Get monthly subscribers count
$monthlySubscribers = $donationObj->getMonthlySubscribers($user_id);
?>

<div class="container">
    <div class="dashboard">
        <div class="dashboard-header">
            <h1>Dashboard</h1>
            <div class="dashboard-actions">
                <a href="<?php echo BASE_URL; ?>/creator.php?username=<?php echo htmlspecialchars($user['username']); ?>" class="btn btn-outline">View Public Profile</a>
                <a href="<?php echo BASE_URL; ?>/edit-profile.php" class="btn btn-primary">Edit Profile</a>
            </div>
        </div>

        <div class="dashboard-stats">
            <div class="stat-card">
                <div class="stat-value"><?php echo $supportersCount; ?></div>
                <div class="stat-label">Supporters</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php echo $totalCoffees; ?></div>
                <div class="stat-label">Coffees</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">$<?php echo number_format($totalAmount, 2); ?></div>
                <div class="stat-label">Total Earnings</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php echo $monthlySubscribers; ?></div>
                <div class="stat-label">Monthly Subscribers</div>
            </div>
        </div>

        <div class="dashboard-content">
            <div class="dashboard-section">
                <h2>Recent Supporters</h2>

                <?php if (count($donationsReceived) > 0): ?>
                    <div class="dashboard-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Supporter</th>
                                    <th>Coffees</th>
                                    <th>Amount</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($donationsReceived as $donation): ?>
                                    <tr>
                                        <td>
                                            <?php echo !empty($donation['supporter_name']) ? htmlspecialchars($donation['supporter_name']) : 'Anonymous'; ?>
                                        </td>
                                        <td><?php echo $donation['coffees']; ?></td>
                                        <td>$<?php echo number_format($donation['amount'], 2); ?></td>
                                        <td>
                                            <?php echo !empty($donation['message']) ? htmlspecialchars(substr($donation['message'], 0, 50)) . (strlen($donation['message']) > 50 ? '...' : '') : 'No message'; ?>
                                        </td>
                                        <td><?php echo date('M j, Y', strtotime($donation['created_at'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="dashboard-more">
                        <a href="<?php echo BASE_URL; ?>/supporters.php" class="btn btn-text">View All Supporters</a>
                    </div>
                <?php else: ?>
                    <div class="dashboard-empty">
                        <p>You don't have any supporters yet. Share your profile link to get started!</p>
                        <div class="profile-link">
                            <input type="text" value="<?php echo BASE_URL; ?>/creator.php?username=<?php echo htmlspecialchars($user['username']); ?>" readonly>
                            <button class="btn btn-sm btn-copy" onclick="copyProfileLink()">Copy</button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="dashboard-section">
                <h2>Your Memberships</h2>

                <?php if (count($memberships) > 0): ?>
                    <div class="memberships-grid">
                        <?php foreach ($memberships as $membership): ?>
                            <div class="membership-card">
                                <div class="membership-header">
                                    <h3><?php echo htmlspecialchars($membership['title']); ?></h3>
                                    <div class="membership-price">$<?php echo number_format($membership['price'], 2); ?>/month</div>
                                </div>
                                <div class="membership-body">
                                    <p><?php echo htmlspecialchars($membership['description']); ?></p>
                                    <ul class="membership-benefits">
                                        <?php foreach ($membership['benefits'] as $benefit): ?>
                                            <li><?php echo htmlspecialchars($benefit); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <div class="membership-footer">
                                    <a href="<?php echo BASE_URL; ?>/edit-membership.php?id=<?php echo $membership['id']; ?>" class="btn btn-sm btn-outline">Edit</a>
                                    <a href="<?php echo BASE_URL; ?>/membership-subscribers.php?id=<?php echo $membership['id']; ?>" class="btn btn-sm btn-outline">Subscribers</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="dashboard-more">
                        <a href="<?php echo BASE_URL; ?>/create-membership.php" class="btn btn-primary">Create New Membership</a>
                    </div>
                <?php else: ?>
                    <div class="dashboard-empty">
                        <p>You don't have any membership tiers yet. Create one to offer exclusive content to your supporters!</p>
                        <a href="<?php echo BASE_URL; ?>/create-membership.php" class="btn btn-primary">Create Membership</a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="dashboard-section">
                <h2>Your Coffees</h2>

                <?php if (count($donationsMade) > 0): ?>
                    <div class="dashboard-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Creator</th>
                                    <th>Coffees</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($donationsMade as $donation): ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo BASE_URL; ?>/creator.php?username=<?php echo htmlspecialchars($donation['recipient_name']); ?>">
                                                <?php echo htmlspecialchars($donation['recipient_name']); ?>
                                            </a>
                                        </td>
                                        <td><?php echo $donation['coffees']; ?></td>
                                        <td>$<?php echo number_format($donation['amount'], 2); ?></td>
                                        <td><?php echo date('M j, Y', strtotime($donation['created_at'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="dashboard-empty">
                        <p>You haven't supported any creators yet. Find creators to support!</p>
                        <a href="<?php echo BASE_URL; ?>/discover.php" class="btn btn-primary">Discover Creators</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function copyProfileLink() {
    const profileLink = document.querySelector('.profile-link input');
    profileLink.select();
    document.execCommand('copy');

    const copyBtn = document.querySelector('.btn-copy');
    const originalText = copyBtn.innerText;
    copyBtn.innerText = 'Copied!';

    setTimeout(() => {
        copyBtn.innerText = originalText;
    }, 2000);
}
</script>

<?php
// Include footer
include_once 'includes/footer.php';
?>
