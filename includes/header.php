<?php
// includes/header.php

// S'assurer que la session est démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Définir le chemin de base en fonction de l'environnement
$base_path = '';
if (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
    $base_path = '/bibliotheque';
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de bibliothèque</title>
    <link rel="stylesheet" href="<?= $base_path ?>/assets/css/style.css">
</head>

<body>
    <?php if (isset($_SESSION['username'])): ?>
    <div class="top-user-bar">
        <span class="user-greeting">
            Bonjour, <?= htmlspecialchars($_SESSION['username']) ?>
        </span>
        <a class="logout-btn" href="<?= $base_path ?>/auth/logout.php">
            Déconnexion
        </a>
    </div>
    <?php endif; ?>
    <header>
        <h1>📚 Gestion de bibliothèque</h1>
        <nav>
            <ul>
                <li><a href="<?= $base_path ?>/index.php">Accueil</a></li>
                <li><a href="<?= $base_path ?>/livres/index.php">Livres</a></li>
                <li><a href="<?= $base_path ?>/membres/index.php">Membres</a></li>
                <li><a href="<?= $base_path ?>/emprunts/index.php">Emprunts</a></li>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'super_admin'): ?>
                <li><a href="<?= $base_path ?>/admin/ajouter_admin.php">Ajouter un admin</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>