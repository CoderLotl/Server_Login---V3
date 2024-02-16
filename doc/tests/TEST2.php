<?php

require __DIR__ . '/../../vendor/autoload.php';
use Firebase\JWT\JWT;

// Your secret key (should be kept secret and secure)
$secretKey = 'your_secret_key';

// Create a sample payload
$payload = array(
    'data' => 'example_data',
    'exp' => time() + 3600 // Token expiration time (1 hour from now)
);

// Encode the JWT using HS256 algorithm
$token = JWT::encode($payload, $secretKey);

// Display the token
echo "Generated Token: " . $token . "\n\n";

// Verify the token
try {
    // Decode the token and verify its signature
    $decoded = JWT::decode($token, $secretKey, array('HS256'));

    // If successful, display the decoded data
    echo "Decoded Data:\n";
    print_r($decoded);
} catch (Exception $e) {
    // If verification fails, display an error message
    echo "Verification failed: " . $e->getMessage();
}
?>