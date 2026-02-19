<?php

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de bibliothèque</title>
    <link rel="stylesheet" href="/bibliotheque/assets/css/style.css">
</head>

<body>
    <?php if (isset($_SESSION['username'])): ?>
    <div class="top-user-bar">
        <span class="user-greeting">
            Bonjour, <?= htmlspecialchars($_SESSION['username']) ?>
        </span>

        <a class="logout-btn" href="/bibliotheque/auth/logout.php">
            Déconnexion
        </a>
    </div>
    <?php endif; ?>
    <header>
        <h1>📚 Gestion de bibliothèque</h1>
        <nav>
            <ul>
                <li><a href="/../index.php">Accueil</a></li>
                <li><a href="/../livres/index.php">Livres</a></li>
                <li><a href="/../membres/index.php">Membres</a></li>
                <li><a href="/../emprunts/index.php">Emprunts</a></li>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'super_admin'): ?>
                <li><a href="/../admin/ajouter_admin.php">Ajouter un admin</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>