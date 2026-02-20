<?php
// config/config.php

// Détection de l'environnement pour définir le chemin de base pour les URL.
// Ceci est crucial pour que l'application fonctionne à la fois sous WAMP (dans un sous-dossier)
// et avec le serveur de développement de PHP (à la racine).

if (php_sapi_name() === 'cli-server') {
    // Serveur de développement PHP (`php -S ...`) : la racine est le dossier du projet.
    // Les URL sont relatives à la racine, donc le chemin de base est vide.
    // Ex: http://localhost:8000/livres/index.php
    $base_path = '';
} elseif (isset($_SERVER['HTTP_HOST']) && (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false)) {
    // Environnement local type WAMP/MAMP : le projet est dans un sous-dossier.
    // Le chemin de base est le nom de ce sous-dossier.
    // Ex: http://localhost/bibliotheque/livres/index.php
    $base_path = '/bibliotheque';
} else {
    // Environnement de production (Vercel, etc.) : le projet est à la racine du domaine.
    $base_path = '';
}
?>