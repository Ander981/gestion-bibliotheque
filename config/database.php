<?php
// config/database.php

// Détection de l'environnement Vercel (basée sur la présence de la variable d'env VERCEL)
if (getenv('VERCEL')) {
    $host = getenv('DB_HOST');
    $dbname = getenv('DB_NAME');
    $username = getenv('DB_USER');
    $password = getenv('DB_PASSWORD');

    // Vérification que toutes les variables sont définies
    if (!$host || !$dbname || !$username || !$password) {
        // Optionnel : journaliser les noms manquants
        error_log("DB_HOST: " . ($host ?: 'manquant'));
        error_log("DB_NAME: " . ($dbname ?: 'manquant'));
        error_log("DB_USER: " . ($username ?: 'manquant'));
        error_log("DB_PASSWORD: " . ($password ?: 'manquant'));
        die("Erreur : Variables d'environnement de base de données manquantes.");
    }
} else {
    // Local
    $host = 'localhost';
    $dbname = 'bibliotheque';
    $username = 'root';
    $password = '';
}

// Connexion...