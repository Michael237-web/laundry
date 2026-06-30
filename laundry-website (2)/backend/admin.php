<?php
session_start();

// Simple session check without database
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Check session timeout (30 minutes)
$timeout = 1800;
if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > $timeout)) {
    session_destroy();
    header('Location: login.php?timeout=1');
    exit();
}

// Update last activity time
$_SESSION['login_time'] = time();

// Generate CSRF token if not exists
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Function to get bookings from log file
function getBookingsFromLog() {
    $bookings = [];
    $log_file = __DIR__ . '/booking_log.txt';
    
    if (file_exists($log_file)) {
        $content = file_get_contents($log_file);
        $entries = explode("========================\n\n", $content);
        
        foreach ($entries as $entry) {
            if (trim($entry) != '' && strpos($entry, '=== NEW BOOKING ===') !== false) {
                $booking = [];
                $lines = explode("\n", $entry);
                foreach ($lines as $line) {
                    if (strpos($line, 'Name:') === 0) {
                        $booking['name'] = trim(substr($line, 5));
                    } elseif (strpos($line, 'Email:') === 0) {
                        $booking['email'] = trim(substr($line, 6));
                    } elseif (strpos($line, 'Phone:') === 0) {
                        $booking['phone'] = trim(substr($line, 6));
                    } elseif (strpos($line, 'Address:') === 0) {
                        $booking['address'] = trim(substr($line, 8));
                    } elseif (strpos($line, 'Service:') === 0) {
                        $booking['service'] = trim(substr($line, 8));
                    } elseif (strpos($line, 'Pickup Date:') === 0) {
                        $booking['pickup_date'] = trim(substr($line, 12));
                    } elseif (strpos($line, 'Instructions:') === 0) {
                        $booking['instructions'] = trim(substr($line, 13));
                    } elseif (strpos($line, 'Time:') === 0) {
                        $booking['time'] = trim(substr($line, 5));
                    }
                }
                if (!empty($booking)) {
                    $bookings[] = $booking;
                }
            }
        }
    }
    
    return array_reverse($bookings);
}

// Function to get messages from log file
function getMessagesFromLog() {
    $messages = [];
    $log_file = __DIR__ . '/contact_log.txt';
    
    if (file_exists($log_file)) {
        $content = file_get_contents($log_file);
        $entries = explode("========================\n\n", $content);
        
        foreach ($entries as $entry) {
            if (trim($entry) != '' && strpos($entry, '=== CONTACT MESSAGE ===') !== false) {
                $message = [];
                $lines = explode("\n", $entry);
                foreach ($lines as $line) {
                    if (strpos($line, 'Name:') === 0) {
                        $message['name'] = trim(substr($line, 5));
                    } elseif (strpos($line, 'Email:') === 0) {
                        $message['email'] = trim(substr($line, 6));
                    } elseif (strpos($line, 'Subject:') === 0) {
                        $message['subject'] = trim(substr($line, 8));
                    } elseif (strpos($line, 'Message:') === 0) {
                        $message['message'] = trim(substr($line, 8));
                    } elseif (strpos($line, 'Time:') === 0) {
                        $message['time'] = trim(substr($line, 5));
                    }
                }
                if (!empty($message)) {
                    $messages[] = $message;
                }
            }
        }
    }
    
    return array_reverse($messages);
}

// Function to delete a booking by index
function deleteBooking($index) {
    $log_file = __DIR__ . '/booking_log.txt';
    
    if (file_exists($log_file)) {
        $content = file_get_contents($log_file);
        $entries = explode("========================\n\n", $content);
        
        $new_entries = [];
        $current_index = 0;
        
        foreach ($entries as $entry) {
            if (trim($entry) != '' && strpos($entry, '=== NEW BOOKING ===') !== false) {
                if ($current_index != $index) {
                    $new_entries[] = $entry;
                }
                $current_index++;
            }
        }
        
        $new_content = implode("========================\n\n", $new_entries);
        if (!empty($new_entries)) {
            $new_content .= "========================\n\n";
        }
        
        file_put_contents($log_file, $new_content);
        return true;
    }
    return false;
}

// Function to delete a message by index
function deleteMessage($index) {
    $log_file = __DIR__ . '/contact_log.txt';
    
    if (file_exists($log_file)) {
        $content = file_get_contents($log_file);
        $entries = explode("========================\n\n", $content);
        
        $new_entries = [];
        $current_index = 0;
        
        foreach ($entries as $entry) {
            if (trim($entry) != '' && strpos($entry, '=== CONTACT MESSAGE ===') !== false) {
                if ($current_index != $index) {
                    $new_entries[] = $entry;
                }
                $current_index++;
            }
        }
        
        $new_content = implode("========================\n\n", $new_entries);
        if (!empty($new_entries)) {
            $new_content .= "========================\n\n";
        }
        
        file_put_contents($log_file, $new_content);
        return true;
    }
    return false;
}

// Handle delete requests with CSRF protection
if (isset($_GET['delete_booking']) && isset($_GET['csrf_token']) && $_GET['csrf_token'] === $_SESSION['csrf_token']) {
    $index = (int)$_GET['delete_booking'];
    deleteBooking($index);
    header('Location: admin.php');
    exit();
}

if (isset($_GET['delete_message']) && isset($_GET['csrf_token']) && $_GET['csrf_token'] === $_SESSION['csrf_token']) {
    $index = (int)$_GET['delete_message'];
    deleteMessage($index);
    header('Location: admin.php');
    exit();
}

// Handle bulk delete
if (isset($_POST['bulk_delete_bookings']) && isset($_POST['selected_bookings']) && isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
    $selected = json_decode($_POST['selected_bookings'], true);
    if (is_array($selected)) {
        rsort($selected);
        foreach ($selected as $index) {
            deleteBooking((int)$index);
        }
    }
    header('Location: admin.php');
    exit();
}

if (isset($_POST['bulk_delete_messages']) && isset($_POST['selected_messages']) && isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
    $selected = json_decode($_POST['selected_messages'], true);
    if (is_array($selected)) {
        rsort($selected);
        foreach ($selected as $index) {
            deleteMessage((int)$index);
        }
    }
    header('Location: admin.php');
    exit();
}

$bookings = getBookingsFromLog();
$messages = getMessagesFromLog();
$total_bookings = count($bookings);
$total_messages = count($messages);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FreshClean Laundry</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: #f5f5f5;
        }
        .navbar {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .navbar h2 {
            color: #2c3e50;
        }
        .navbar-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
            font-size: 0.9rem;
        }
        .btn-primary {
            background: #2196F3;
            color: white;
        }
        .btn-primary:hover {
            background: #00BCD4;
            transform: translateY(-2px);
        }
        .btn-danger {
            background: #ff7675;
            color: white;
        }
        .btn-danger:hover {
            background: #d63031;
            transform: translateY(-2px);
        }
        .btn-warning {
            background: #ffeaa7;
            color: #d63031;
        }
        .btn-warning:hover {
            background: #fdcb6e;
        }
        .container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        .welcome-card {
            background: linear-gradient(135deg, #2196F3, #00BCD4);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
        }
        .welcome-card h1 {
            margin-bottom: 0.5rem;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #2196F3;
        }
        .stat-label {
            color: #7f8c8d;
            margin-top: 0.5rem;
        }
        .section {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .section-header h2 {
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        th {
            background: #f8f9fa;
            font-weight: 600;
            position: sticky;
            top: 0;
        }
        tr:hover {
            background: #f8f9fa;
        }
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #7f8c8d;
        }
        .delete-btn {
            background: #ff7675;
            color: white;
            border: none;
            padding: 0.3rem 0.8rem;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        .delete-btn:hover {
            background: #d63031;
            transform: scale(1.05);
        }
        .checkbox-col {
            width: 40px;
            text-align: center;
        }
        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        .bulk-actions {
            margin-bottom: 1rem;
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }
        .message-content {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        @media (max-width: 768px) {
            .container {
                padding: 0 1rem;
            }
            .navbar {
                padding: 1rem;
            }
            .navbar-actions {
                width: 100%;
                justify-content: space-between;
            }
            .section-header {
                flex-direction: column;
                align-items: flex-start;
            }
            table, thead, tbody, th, td, tr {
                display: block;
            }
            thead {
                display: none;
            }
            tr {
                margin-bottom: 1rem;
                border: 1px solid #eee;
                border-radius: 8px;
                padding: 0.5rem;
                position: relative;
            }
            td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.5rem;
                border: none;
            }
            td:before {
                content: attr(data-label);
                font-weight: 600;
                margin-right: 1rem;
            }
            .checkbox-col {
                position: absolute;
                top: 0.5rem;
                right: 0.5rem;
                width: auto;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>🧺 FreshClean Laundry - Admin Panel</h2>
        <div class="navbar-actions">
            <span class="btn btn-primary" style="background: #48dbfb; color: #2c3e50;">
                👤 <?php echo htmlspecialchars($_SESSION['admin_username']); ?>
            </span>
            <button onclick="location.reload()" class="btn btn-primary">🔄 Refresh</button>
            <a href="logout.php" class="btn btn-danger">🚪 Logout</a>
        </div>
    </div>
    
    <div class="container">
        <div class="welcome-card">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>! 👋</h1>
            <p>Manage your bookings and customer messages from here.</p>
            <small>🔒 Last activity: <?php echo date('Y-m-d H:i:s', $_SESSION['login_time']); ?></small>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_bookings; ?></div>
                <div class="stat-label">Total Bookings</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_messages; ?></div>
                <div class="stat-label">Total Messages</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo date('Y-m-d'); ?></div>
                <div class="stat-label">Today's Date</div>
            </div>
        </div>
        
        <!-- Bookings Section -->
        <div class="section">
            <div class="section-header">
                <h2>📅 Bookings</h2>
                <?php if (!empty($bookings)): ?>
                <form method="POST" id="bulkDeleteBookingsForm">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <div class="bulk-actions">
                        <button type="button" onclick="toggleAllBookings()" class="btn btn-warning">☑️ Select All</button>
                        <button type="submit" name="bulk_delete_bookings" class="btn btn-danger">🗑️ Delete Selected</button>
                    </div>
                    <input type="hidden" name="selected_bookings" id="selected_bookings_input">
                </form>
                <?php endif; ?>
            </div>
            
            <?php if (empty($bookings)): ?>
                <div class="empty-state">
                    🗄️ No bookings yet.<br>
                    <small>Submit a booking from your website to see it here!</small>
                </div>
            <?php else: ?>
                <div style="overflow-x: auto;">
                    <table id="bookingsTable">
                        <thead>
                            <tr>
                                <th class="checkbox-col"><input type="checkbox" id="selectAllBookings" onchange="toggleAllBookings()"></th>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Service</th>
                                <th>Pickup Date</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $counter = 0; foreach($bookings as $index => $booking): ?>
                            <tr>
                                <td class="checkbox-col" data-label="Select">
                                    <input type="checkbox" class="booking-checkbox" value="<?php echo $index; ?>">
                                  </td>
                                <td data-label="#"><?php echo $counter + 1; ?></td>
                                <td data-label="Name"><?php echo htmlspecialchars($booking['name'] ?? 'N/A'); ?></td>
                                <td data-label="Email"><?php echo htmlspecialchars($booking['email'] ?? 'N/A'); ?></td>
                                <td data-label="Service"><?php echo htmlspecialchars($booking['service'] ?? 'N/A'); ?></td>
                                <td data-label="Pickup Date"><?php echo htmlspecialchars($booking['pickup_date'] ?? 'N/A'); ?></td>
                                <td data-label="Phone"><?php echo htmlspecialchars($booking['phone'] ?? 'N/A'); ?></td>
                                <td data-label="Address"><?php echo htmlspecialchars(substr($booking['address'] ?? 'N/A', 0, 30)); ?></td>
                                <td data-label="Time"><?php echo htmlspecialchars($booking['time'] ?? 'N/A'); ?></td>
                                <td data-label="Action">
                                    <a href="?delete_booking=<?php echo $index; ?>&csrf_token=<?php echo $_SESSION['csrf_token']; ?>" 
                                       class="delete-btn" 
                                       onclick="return confirm('⚠️ Delete this booking? This cannot be undone!')">
                                        🗑️ Delete
                                    </a>
                                </td>
                            </tr>
                            <?php $counter++; endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Contact Messages Section -->
        <div class="section">
            <div class="section-header">
                <h2>💬 Contact Messages</h2>
                <?php if (!empty($messages)): ?>
                <form method="POST" id="bulkDeleteMessagesForm">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <div class="bulk-actions">
                        <button type="button" onclick="toggleAllMessages()" class="btn btn-warning">☑️ Select All</button>
                        <button type="submit" name="bulk_delete_messages" class="btn btn-danger">🗑️ Delete Selected</button>
                    </div>
                    <input type="hidden" name="selected_messages" id="selected_messages_input">
                </form>
                <?php endif; ?>
            </div>
            
            <?php if (empty($messages)): ?>
                <div class="empty-state">
                    ✉️ No messages yet.<br>
                    <small>Send a message from your contact page to see it here!</small>
                </div>
            <?php else: ?>
                <div style="overflow-x: auto;">
                    <table id="messagesTable">
                        <thead>
                            <tr>
                                <th class="checkbox-col"><input type="checkbox" id="selectAllMessages" onchange="toggleAllMessages()"></th>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $counter = 0; foreach($messages as $index => $message): ?>
                            <tr>
                                <td class="checkbox-col" data-label="Select">
                                    <input type="checkbox" class="message-checkbox" value="<?php echo $index; ?>">
                                </td>
                                <td data-label="#"><?php echo $counter + 1; ?></td>
                                <td data-label="Name"><?php echo htmlspecialchars($message['name'] ?? 'N/A'); ?></td>
                                <td data-label="Email"><?php echo htmlspecialchars($message['email'] ?? 'N/A'); ?></td>
                                <td data-label="Subject"><?php echo htmlspecialchars($message['subject'] ?? 'N/A'); ?></td>
                                <td data-label="Message" class="message-content"><?php echo htmlspecialchars(substr($message['message'] ?? '', 0, 50)) . '...'; ?></td>
                                <td data-label="Time"><?php echo htmlspecialchars($message['time'] ?? 'N/A'); ?></td>
                                <td data-label="Action">
                                    <a href="?delete_message=<?php echo $index; ?>&csrf_token=<?php echo $_SESSION['csrf_token']; ?>" 
                                       class="delete-btn" 
                                       onclick="return confirm('⚠️ Delete this message? This cannot be undone!')">
                                        🗑️ Delete
                                    </a>
                                </td>
                            </tr>
                            <?php $counter++; endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script>
        // Bulk delete for bookings
        function toggleAllBookings() {
            const selectAll = document.getElementById('selectAllBookings');
            const checkboxes = document.querySelectorAll('.booking-checkbox');
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
            updateSelectedBookings();
        }
        
        function updateSelectedBookings() {
            const checkboxes = document.querySelectorAll('.booking-checkbox:checked');
            const selected = Array.from(checkboxes).map(cb => cb.value);
            document.getElementById('selected_bookings_input').value = JSON.stringify(selected);
        }
        
        // Bulk delete for messages
        function toggleAllMessages() {
            const selectAll = document.getElementById('selectAllMessages');
            const checkboxes = document.querySelectorAll('.message-checkbox');
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
            updateSelectedMessages();
        }
        
        function updateSelectedMessages() {
            const checkboxes = document.querySelectorAll('.message-checkbox:checked');
            const selected = Array.from(checkboxes).map(cb => cb.value);
            document.getElementById('selected_messages_input').value = JSON.stringify(selected);
        }
        
        // Add event listeners to checkboxes
        document.querySelectorAll('.booking-checkbox').forEach(cb => {
            cb.addEventListener('change', updateSelectedBookings);
        });
        
        document.querySelectorAll('.message-checkbox').forEach(cb => {
            cb.addEventListener('change', updateSelectedMessages);
        });
    </script>
</body>
</html>