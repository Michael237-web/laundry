<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

$log_file = '/opt/lampp/htdocs/laundry-website/backend/contact_log.txt';

try {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (!$data) {
        throw new Exception('No data received');
    }
    
    // Validate
    if (empty($data['name']) || empty($data['email']) || empty($data['subject']) || empty($data['message'])) {
        throw new Exception('All fields are required');
    }
    
    // Save to text file
    $contact_entry = "========================\n";
    $contact_entry .= "=== CONTACT MESSAGE ===\n";
    $contact_entry .= "Name: " . $data['name'] . "\n";
    $contact_entry .= "Email: " . $data['email'] . "\n";
    $contact_entry .= "Subject: " . $data['subject'] . "\n";
    $contact_entry .= "Message: " . $data['message'] . "\n";
    $contact_entry .= "Time: " . date('Y-m-d H:i:s') . "\n";
    $contact_entry .= "========================\n\n";
    
    file_put_contents($log_file, $contact_entry, FILE_APPEND);
    
    echo json_encode([
        'success' => true,
        'message' => 'Message sent successfully!'
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>