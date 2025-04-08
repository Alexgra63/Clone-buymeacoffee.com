-- Create database
CREATE DATABASE IF NOT EXISTS buymeacoffee;
USE buymeacoffee;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    bio TEXT,
    avatar VARCHAR(255),
    website VARCHAR(255),
    banner VARCHAR(255),
    social_links JSON,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Donations table
CREATE TABLE IF NOT EXISTS donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    supporter_id INT,
    recipient_id INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    message TEXT,
    coffees INT NOT NULL DEFAULT 1,
    is_monthly BOOLEAN DEFAULT 0,
    status ENUM('pending', 'completed', 'refunded') DEFAULT 'completed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (supporter_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (recipient_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Memberships table
CREATE TABLE IF NOT EXISTS memberships (
    id INT AUTO_INCREMENT PRIMARY KEY,
    creator_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    benefits JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (creator_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Membership subscribers table
CREATE TABLE IF NOT EXISTS membership_subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    membership_id INT NOT NULL,
    subscriber_id INT NOT NULL,
    status ENUM('active', 'canceled', 'expired') DEFAULT 'active',
    start_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    end_date TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (membership_id) REFERENCES memberships(id) ON DELETE CASCADE,
    FOREIGN KEY (subscriber_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY (membership_id, subscriber_id)
);

-- Posts table
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    creator_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    type ENUM('public', 'members_only') DEFAULT 'public',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (creator_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    creator_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    type ENUM('digital', 'service', 'physical') DEFAULT 'digital',
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (creator_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Orders table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    buyer_id INT,
    seller_id INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'completed', 'refunded') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (buyer_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (seller_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Sample data
-- Admin user with hashed password 'admin123'
INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@example.com', '$2y$10$Yf5AHPfRev4htfyZZ2PX6.1aGzW8RGe3aQu3wvuXdG6J0QizyZ41K', 'admin');

-- Regular user with hashed password 'password123'
INSERT INTO users (username, email, password, bio) VALUES
('johndoe', 'john@example.com', '$2y$10$pD7uAdUDKPhbpHJhrB3nROLfWGnT7foifnNf2J4kO7JfNnMOGJsI2', 'Hi! I\'m John, a digital artist and content creator. I love creating illustrations and sharing my creative process.'),
('janedoe', 'jane@example.com', '$2y$10$pD7uAdUDKPhbpHJhrB3nROLfWGnT7foifnNf2J4kO7JfNnMOGJsI2', 'Writer, poet, and storyteller. I write about life, love, and everything in between.'),
('bobsmith', 'bob@example.com', '$2y$10$pD7uAdUDKPhbpHJhrB3nROLfWGnT7foifnNf2J4kO7JfNnMOGJsI2', 'Software developer sharing coding tips and tutorials.');

-- Memberships
INSERT INTO memberships (creator_id, title, description, price, benefits) VALUES
(2, 'Basic Supporter', 'Support my work and get exclusive content', 5.00, '["Early access to content", "Exclusive posts", "Monthly Q&A session"]'),
(2, 'Premium Supporter', 'Get premium content and perks', 15.00, '["All Basic tier benefits", "Custom digital artwork", "Behind-the-scenes content", "Direct messaging"]'),
(3, 'Reader\'s Club', 'Join my reader\'s club for exclusive stories', 8.00, '["Exclusive short stories", "Early access to chapters", "Monthly writing prompts"]'),
(4, 'Code Club', 'Access to premium coding tutorials', 10.00, '["Premium code examples", "Code reviews", "Monthly coding challenges"]');

-- Donations
INSERT INTO donations (supporter_id, recipient_id, amount, message, coffees) VALUES
(3, 2, 5.00, 'Love your work!', 1),
(4, 2, 15.00, 'Your art inspires me every day. Keep it up!', 3),
(2, 3, 10.00, 'Your stories are amazing!', 2),
(3, 4, 5.00, 'Thanks for the helpful tutorials!', 1);
