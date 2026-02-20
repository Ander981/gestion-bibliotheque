<?php

// Inclure les fichiers nécessaires
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
} 
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>