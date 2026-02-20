<?php

// Détection de l'environnement pour les chemins
if (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
    $base_path = '/bibliotheque';
} else {
    $base_path = '';
}

// Inclure les fichiers nécessaires (sans api/index.php !)
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/includes/header.php';
?>

<h2>Bienvenue dans l'application de gestion de bibliothèque</h2>
<p>Utilisez le menu ci-dessus pour naviguer.</p>

<?php
// Afficher le type d'utilisateur connecté (optionnel)
if (isset($_SESSION['user_id'])) {
    echo "<p>Connecté en tant qu'administrateur : " . htmlspecialchars($_SESSION['username']) . "</p>";
} elseif (isset($_SESSION['membre_id'])) {
    echo "<p>Connecté en tant que membre : " . htmlspecialchars($_SESSION['membre_prenom'] . ' ' . $_SESSION['membre_nom']) . "</p>";
}
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>