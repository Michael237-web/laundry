<?php
session_start();

// Simple hardcoded credentials
$valid_username = 'admin';
$valid_password = 'admin123';

$error = '';

// Check if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        $_SESSION['admin_role'] = 'super_admin';
        $_SESSION['admin_id'] = 1;
        $_SESSION['login_time'] = time();
        $_SESSION['session_token'] = bin2hex(random_bytes(32));
        
        session_regenerate_id(true);
        
        header('Location: admin.php');
        exit();
    } else {
        $error = 'Invalid username or password. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - FreshClean Laundry</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #2196F3 0%, #00BCD4 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }
        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            overflow: hidden;
            animation: fadeInUp 0.5s ease;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .login-header {
            background: linear-gradient(135deg, #2196F3, #00BCD4);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .login-header h1 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }
        .login-header p {
            opacity: 0.9;
            font-size: 0.9rem;
        }
        .login-body {
            padding: 2rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #2c3e50;
        }
        input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s;
            font-family: inherit;
        }
        input:focus {
            outline: none;
            border-color: #2196F3;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
        }
        .login-btn {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, #2196F3, #00BCD4);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(33, 150, 243, 0.3);
        }
        .error-message {
            background: #fee;
            color: #c0392b;
            padding: 0.75rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            border-left: 4px solid #c0392b;
            animation: slideIn 0.3s ease;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .error-message.fade-out {
            opacity: 0;
            visibility: hidden;
        }
        .info-text {
            text-align: center;
            margin-top: 1.5rem;
            color: #7f8c8d;
            font-size: 0.85rem;
        }
        .back-link {
            text-align: center;
            margin-top: 1rem;
        }
        .back-link a {
            color: #2196F3;
            text-decoration: none;
            font-size: 0.9rem;
            display: inline-block;
            padding: 0.5rem 1rem;
            background: #f0f7ff;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .back-link a:hover {
            background: #e3f2fd;
            text-decoration: none;
            transform: translateX(-5px);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>🧺 FreshClean Laundry</h1>
            <p>Admin Access Portal</p>
        </div>
        <div class="login-body">
            <?php if ($error): ?>
                <div class="error-message" id="errorMessage">
                    ⚠️ <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="" id="loginForm">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="login-btn">🔐 Login to Dashboard</button>
            </form>
            
            <div class="info-text">
                <p>Secure admin area. Unauthorized access is prohibited.</p>
            </div>
            
            <div class="back-link">
                <a href="../index.php">← Back to Website</a>
            </div>
        </div>
    </div>

    <script>
        <?php if ($error): ?>
        setTimeout(function() {
            const errorMessage = document.getElementById('errorMessage');
            if (errorMessage) {
                errorMessage.classList.add('fade-out');
                setTimeout(function() {
                    if (errorMessage.parentNode) {
                        errorMessage.style.display = 'none';
                    }
                }, 500);
            }
        }, 3000);
        <?php endif; ?>

        document.getElementById('loginForm')?.addEventListener('submit', function() {
            const submitBtn = this.querySelector('.login-btn');
            submitBtn.innerHTML = '⏳ Logging in...';
            submitBtn.disabled = true;
        });
    </script>
</body>
</html>