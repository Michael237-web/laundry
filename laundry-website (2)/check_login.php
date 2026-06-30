<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Login System Diagnostic Tool</h2>";

// Test 1: Check if db_config.php exists
echo "<h3>1. Checking Database Configuration:</h3>";
if (file_exists('db_config.php')) {
    echo "✅ db_config.php exists<br>";
    require_once 'db_config.php';
} else {
    die("❌ db_config.php not found!");
}

// Test 2: Test database connection
echo "<h3>2. Testing Database Connection:</h3>";
try {
    $pdo = getDBConnection();
    echo "✅ Database connected successfully!<br>";
} catch (Exception $e) {
    die("❌ Database connection failed: " . $e->getMessage() . "<br>Check your credentials in db_config.php");
}

// Test 3: Check if tables exist
echo "<h3>3. Checking Database Tables:</h3>";
$tables = ['admin_users', 'login_attempts', 'user_sessions'];
foreach ($tables as $table) {
    $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Table '$table' exists<br>";
    } else {
        echo "❌ Table '$table' does NOT exist!<br>";
    }
}

// Test 4: Check admin user
echo "<h3>4. Checking Admin User:</h3>";
$stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ?");
$stmt->execute(['admin']);
$user = $stmt->fetch();

if ($user) {
    echo "✅ Admin user found!<br>";
    echo "Username: " . $user['username'] . "<br>";
    echo "Email: " . $user['email'] . "<br>";
    echo "Role: " . $user['role'] . "<br>";
    echo "Active: " . ($user['is_active'] ? 'Yes' : 'No') . "<br>";
    
    // Test password verification
    echo "<h3>5. Testing Password Verification:</h3>";
    $test_password = 'admin123';
    if (password_verify($test_password, $user['password_hash'])) {
        echo "✅ Password 'admin123' is CORRECT!<br>";
        echo "You should be able to login with:<br>";
        echo "- Username: admin<br>";
        echo "- Password: admin123<br>";
    } else {
        echo "❌ Password 'admin123' is INCORRECT for this hash<br>";
        echo "Hash in database: " . $user['password_hash'] . "<br>";
        
        // Offer to fix the password
        echo "<h3>6. Fixing Password:</h3>";
        $new_hash = password_hash('admin123', PASSWORD_DEFAULT);
        $update = $pdo->prepare("UPDATE admin_users SET password_hash = ? WHERE username = 'admin'");
        $update->execute([$new_hash]);
        echo "✅ Password has been reset to 'admin123'!<br>";
        echo "Try logging in again now.<br>";
    }
} else {
    echo "❌ No admin user found with username 'admin'!<br>";
    
    // Insert admin user
    echo "<h3>5. Creating Admin User:</h3>";
    $hash = password_hash('admin123', PASSWORD_DEFAULT);
    $insert = $pdo->prepare("INSERT INTO admin_users (username, password_hash, email, full_name, role, is_active) VALUES (?, ?, ?, ?, ?, 1)");
    if ($insert->execute(['admin', $hash, 'admin@freshclean.com', 'System Administrator', 'super_admin'])) {
        echo "✅ Admin user created successfully!<br>";
        echo "Username: admin<br>";
        echo "Password: admin123<br>";
    } else {
        echo "❌ Failed to create admin user<br>";
    }
}

// Test 6: Check PHP sessions
echo "<h3>6. Testing PHP Sessions:</h3>";
session_start();
$_SESSION['test'] = 'working';
if (isset($_SESSION['test']) && $_SESSION['test'] == 'working') {
    echo "✅ PHP sessions are working correctly<br>";
} else {
    echo "❌ PHP sessions are NOT working! Check your PHP configuration<br>";
}
session_destroy();

echo "<hr>";
echo "<h3>Next Steps:</h3>";
echo "1. If you see '✅ Password 'admin123' is CORRECT', try logging in again<br>";
echo "2. If you still can't login, clear your browser cache and cookies<br>";
echo "3. Try a different browser or incognito mode<br>";
echo "4. <a href='login.php'>Go to Login Page</a><br>";
?>