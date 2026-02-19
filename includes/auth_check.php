<?php

// includes/auth_check.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get the current request URI (the actual URL being accessed)
$request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';

// Define public routes that don't require authentication
$public_routes = array(
    '/auth/login.php',
    '/auth/logout.php',
    '/bibliotheque/auth/login.php',
    '/bibliotheque/auth/logout.php',
);

// Check if current page is a public route
$is_public_route = false;
foreach ($public_routes as $route) {
    if (strpos($request_uri, $route) !== false) {
        $is_public_route = true;
        break;
    }
}

// Only redirect if not on a public route and user is not logged in
if (!$is_public_route && !isset($_SESSION['user_id'])) {
    // Check if we're in a subdirectory
    $redirect_path = '/bibliotheque/auth/login.php';
    
    // If the current script already has /bibliotheque prefix, use that
    if (strpos($current_script, '/bibliotheque') !== false) {
        $redirect_path = '/bibliotheque/auth/login.php';
    } else {
        $redirect_path = '/auth/login.php';
    }
    
    header('Location: ' . $redirect_path); 
    exit;
}
?>