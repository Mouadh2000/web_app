<?php

// CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Send a 200 OK response without processing the request further
    http_response_code(200);
    exit();
}
// Load Composer's autoloader (adjust the path if necessary)
require __DIR__ . '/../vendor/autoload.php';

// Initialize your application or framework (if applicable)
// Example: $app = new MyApp();

// Include your router or dispatcher
require __DIR__ . '/../routes/api.php';

