<?php
// db_config.php - Database configuration file

// Database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'laundry_db');
define('DB_USER', 'root');      // Change this to your MySQL username
define('DB_PASS', '');          // Change this to your MySQL password

// Create connection
function getDBConnection() {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
        return $pdo;
    } catch(PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}

// Function to clean up old login attempts
function cleanupOldAttempts($pdo) {
    $stmt = $pdo->prepare("DELETE FROM login_attempts WHERE attempt_time < DATE_SUB(NOW(), INTERVAL 1 HOUR)");
    $stmt->execute();
}

// Function to check rate limiting
function isRateLimited($pdo, $ip) {
    $stmt = $pdo->prepare("SELECT COUNT(*) as attempts FROM login_attempts WHERE ip_address = ? AND attempt_time > DATE_SUB(NOW(), INTERVAL 15 MINUTE) AND success = 0");
    $stmt->execute([$ip]);
    $result = $stmt->fetch();
    return $result['attempts'] >= 5; // Max 5 failed attempts per 15 minutes
}
?>