<?php
// api/index.php

// Démarrer la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Récupérer le chemin demandé
$request_uri = $_SERVER['REQUEST_URI'];
$script_name = $_SERVER['SCRIPT_NAME'];

// Nettoyer l'URI (enlever les paramètres GET)
$path = parse_url($request_uri, PHP_URL_PATH);

// Debug (à supprimer après test)
error_log("API: Path demandé = " . $path);

// Routeur simple
switch (true) {
    case strpos($path, '/livres/') === 0:
        if ($path === '/livres/index.php' || $path === '/livres/') {
            require_once __DIR__ . '/../livres/index.php';
        } elseif ($path === '/livres/ajouter.php') {
            require_once __DIR__ . '/../livres/ajouter.php';
             } 
        elseif ($path === '/bibliotheque/livres/ajout_livre.php') {
            require_once __DIR__ . '/bibliotheque/livres/ajout_livre.php';
        } elseif ($path === '/livres/modifier.php') {
            require_once __DIR__ . '/../livres/modifier.php';
        } elseif ($path === '/livres/supprimer.php') {
            require_once __DIR__ . '/../livres/supprimer.php';
        } else {
            // Par défaut, la liste des livres
            require_once __DIR__ . '/../livres/index.php';
        }
        break;
        
    case strpos($path, '/membres/') === 0:
        if ($path === '/membres/index.php' || $path === '/membres/') {
            require_once __DIR__ . '/../membres/index.php';
        } elseif ($path === '/membres/ajouter.php') {
            require_once __DIR__ . '/../membres/ajouter.php';
        } elseif ($path === '/membres/modifier.php') {
            require_once __DIR__ . '/../membres/modifier.php';
        } elseif ($path === '/membres/supprimer.php') {
            require_once __DIR__ . '/../membres/supprimer.php';
        } else {
            require_once __DIR__ . '/../membres/index.php';
        }
        break;
        
    case strpos($path, '/emprunts/') === 0:
        if ($path === '/emprunts/index.php' || $path === '/emprunts/') {
            require_once __DIR__ . '/../emprunts/index.php';
        } elseif ($path === '/emprunts/ajouter.php') {
            require_once __DIR__ . '/../emprunts/ajouter.php';
        } elseif ($path === '/emprunts/retour.php') {
            require_once __DIR__ . '/../emprunts/retour.php';
        } elseif ($path === '/emprunts/historique.php') {
            require_once __DIR__ . '/../emprunts/historique.php';
        } else {
            require_once __DIR__ . '/../emprunts/index.php';
        }
        break;
        
    case strpos($path, '/auth/') === 0:
        if ($path === '/auth/login.php') {
            require_once __DIR__ . '/../auth/login.php';
        } elseif ($path === '/auth/logout.php') {
            require_once __DIR__ . '/../auth/logout.php';
        } else {
            require_once __DIR__ . '/../auth/login.php';
        }
        break;
        
    case strpos($path, '/admin/') === 0:
        if ($path === '/admin/ajouter_admin.php') {
            require_once __DIR__ . '/../admin/ajouter_admin.php';
        } else {
            require_once __DIR__ . '/../index.php';
        }
        break;
        
    default:
        // Page d'accueil
        // require_once __DIR__ . '/../index.php';
        break;
}
?>