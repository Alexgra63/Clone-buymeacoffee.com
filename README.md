# Buy Me a Coffee Clone

A PHP clone of the popular [Buy Me a Coffee](https://www.buymeacoffee.com/) platform, which allows creators to accept donations, set up memberships, and sell digital products.

## Features

- User registration and authentication
- Creator profiles with customizable information
- Support creators by buying them virtual coffees
- Monthly subscription support
- Membership tiers with various benefits
- User dashboard for managing profiles and payments
- Responsive design that works on all devices

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)

## Installation

1. Clone the repository or download the source code
   ```
   git clone https://github.com/yourusername/buymeacoffee-clone.git
   ```

2. Create a MySQL database
   ```sql
   CREATE DATABASE buymeacoffee;
   ```

3. Import the database schema
   ```
   mysql -u username -p buymeacoffee < database.sql
   ```

4. Configure the database connection in `config/database.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   define('DB_NAME', 'buymeacoffee');
   ```

5. Configure the base URL in `config/config.php`:
   ```php
   define('BASE_URL', 'http://your-domain.com/buymeacoffee-clone');
   ```

6. Set the appropriate permissions for the uploads directory:
   ```
   chmod -R 755 uploads/
   ```

7. Set up your web server to point to the project directory

## Directory Structure

```
buymeacoffee-clone/
├── assets/
│   ├── css/          # Stylesheets
│   ├── js/           # JavaScript files
│   ├── img/          # Images and icons
│   └── fonts/        # Font files
├── classes/          # PHP classes
├── config/           # Configuration files
├── includes/         # Common includes (header, footer)
├── uploads/          # User-uploaded files
├── views/            # View templates
├── index.php         # Homepage
├── login.php         # Login page
├── signup.php        # Signup page
├── creator.php       # Creator profile page
├── dashboard.php     # User dashboard
├── donate.php        # Donation processor
└── README.md         # This file
```

## Usage

### For Creators

1. Sign up for an account
2. Set up your profile with a bio, avatar, and other details
3. Create membership tiers with different benefits and pricing
4. Share your profile link with your audience

### For Supporters

1. Visit a creator's profile page
2. Choose how many coffees you want to buy
3. Enter your message and complete the payment
4. Optionally, sign up for monthly support or membership tiers

## Default Login Credentials

For testing purposes, the following accounts are available:

**Admin:**
- Username: admin
- Email: admin@example.com
- Password: admin123

**Users:**
- Username: johndoe
- Email: john@example.com
- Password: password123

- Username: janedoe
- Email: jane@example.com
- Password: password123

- Username: bobsmith
- Email: bob@example.com
- Password: password123

## Security Considerations

For a production environment, please consider the following:

1. Enable HTTPS
2. Update the default credentials
3. Implement CSRF protection (already included in forms)
4. Set up proper error logging
5. Use a more secure payment gateway integration

## License

This project is open-source and available under the MIT License.

## Credits

- Original design inspiration: [Buy Me a Coffee](https://www.buymeacoffee.com/)
- Icons: [Font Awesome](https://fontawesome.com/)
