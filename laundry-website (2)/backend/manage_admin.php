<?php
require_once 'db_config.php';
session_start();

// Only super admin can access this
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_role'] !== 'super_admin') {
    die('Access denied. Only super admin can manage users.');
}

$pdo = getDBConnection();
$message = '';

// Handle adding new admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_admin'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $email = trim($_POST['email']);
    $full_name = trim($_POST['full_name']);
    $role = $_POST['role'];
    
    // Validate
    if (strlen($password) < 6) {
        $message = 'Password must be at least 6 characters.';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("INSERT INTO admin_users (username, password_hash, email, full_name, role) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$username, $hash, $email, $full_name, $role])) {
            $message = 'Admin user created successfully!';
        } else {
            $message = 'Error creating admin user. Username may already exist.';
        }
    }
}

// Handle deleting admin
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    // Don't allow deleting own account
    if ($id != $_SESSION['admin_id']) {
        $stmt = $pdo->prepare("DELETE FROM admin_users WHERE id = ?");
        $stmt->execute([$id]);
        $message = 'Admin user deleted.';
    } else {
        $message = 'You cannot delete your own account.';
    }
}

// Get all admin users
$users = $pdo->query("SELECT * FROM admin_users ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Admin Users</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: #f5f5f5;
            padding: 2rem;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 1rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        input, select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background: #2196F3;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        table {
            width: 100%;
            margin-top: 2rem;
            border-collapse: collapse;
        }
        th, td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #f8f9fa;
        }
        .message {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 5px;
        }
        .success {
            background: #d4edda;
            color: #155724;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
        }
        .delete-btn {
            color: #dc3545;
            text-decoration: none;
        }
        .back-link {
            display: inline-block;
            margin-top: 1rem;
            color: #2196F3;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>👥 Manage Admin Users</h1>
        
        <?php if ($message): ?>
            <div class="message <?php echo strpos($message, 'success') !== false ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <h3>Add New Admin</h3>
            <div class="form-group">
                <label>Username *</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Password * (min 6 characters)</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email">
            </div>
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name">
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="role">
                    <option value="super_admin">Super Admin</option>
                    <option value="admin">Admin</option>
                    <option value="viewer">Viewer</option>
                </select>
            </div>
            <button type="submit" name="add_admin">Create Admin User</button>
        </form>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Full Name</th>
                    <th>Role</th>
                    <th>Last Login</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                    <td><?php echo $user['role']; ?></td>
                    <td><?php echo $user['last_login'] ?: 'Never'; ?></td>
                    <td><?php echo $user['is_active'] ? '✅' : '❌'; ?></td>
                    <td>
                        <?php if ($user['id'] != $_SESSION['admin_id']): ?>
                            <a href="?delete=<?php echo $user['id']; ?>" class="delete-btn" onclick="return confirm('Delete this admin?')">Delete</a>
                        <?php else: ?>
                            Current
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <a href="admin.php" class="back-link">← Back to Dashboard</a>
    </div>
</body>
</html>