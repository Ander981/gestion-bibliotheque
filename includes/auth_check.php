<?php
// includes/auth_check.php

// Inclure la configuration pour avoir $base_path
require_once __DIR__ . '/../config/config.php';

// Démarrer la session si pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Nettoyer le buffer de sortie pour éviter les erreurs de headers
if (ob_get_level()) {
    ob_clean();
}

// Définir les pages publiques (sans authentification)
$public_routes = [
    '/auth/login.php',
    '/auth/logout.php'
];

// Récupérer l'URI actuelle
$current_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';


// Vérifier si la page actuelle est publique
$is_public = false;
foreach ($public_routes as $route) {
    if (strpos($current_uri, $route) !== false) {
        $is_public = true;
        break;
    }
}

// Si la page n'est pas publique et que l'utilisateur n'est pas connecté
if (!$is_public && !isset($_SESSION['user_id']) && !isset($_SESSION['membre_id'])) {
    // Rediriger vers la page de connexion
    header('Location: ' . $base_path . '/auth/login.php');
    exit;
}

// L'utilisateur est autorisé à continuer
?>