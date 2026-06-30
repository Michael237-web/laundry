<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// Use absolute path that we know works
$log_file = '/opt/lampp/htdocs/laundry-website/backend/booking_log.txt';

try {
    // Get POST data
    $input = file_get_contents('php://input');
    
    $data = json_decode($input, true);
    
    if (!$data) {
        throw new Exception('No data received or invalid JSON');
    }
    
    // Validate required fields
    $required = ['name', 'email', 'phone', 'address', 'service_type', 'pickup_date'];
    foreach ($required as $field) {
        if (empty($data[$field])) {
            throw new Exception("Missing field: $field");
        }
    }
    
    // Save to text file
    $booking_entry = "========================\n";
    $booking_entry .= "=== NEW BOOKING ===\n";
    $booking_entry .= "Name: " . $data['name'] . "\n";
    $booking_entry .= "Email: " . $data['email'] . "\n";
    $booking_entry .= "Phone: " . $data['phone'] . "\n";
    $booking_entry .= "Address: " . $data['address'] . "\n";
    $booking_entry .= "Service: " . $data['service_type'] . "\n";
    $booking_entry .= "Pickup Date: " . $data['pickup_date'] . "\n";
    $booking_entry .= "Instructions: " . ($data['special_instructions'] ?? 'None') . "\n";
    $booking_entry .= "Time: " . date('Y-m-d H:i:s') . "\n";
    $booking_entry .= "========================\n\n";
    
    // Write to file
    file_put_contents($log_file, $booking_entry, FILE_APPEND);
    
    // Also create a test to confirm file is writable
    if (!file_exists($log_file)) {
        throw new Exception('Could not create log file. Check permissions.');
    }
    
    // Return success
    echo json_encode([
        'success' => true,
        'booking_id' => rand(10000, 99999),
        'message' => 'Booking saved successfully!'
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>