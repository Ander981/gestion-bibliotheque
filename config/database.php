<?php
// config/database.php

// Détection de l'environnement Vercel
if (isset($_ENV['VERCEL']) || getenv('VERCEL')) {
    // Récupération des variables d'environnement (plusieurs méthodes pour la compatibilité)
   $host = getenv('DB_HOST');
if ($host === false) {
    $host = isset($_ENV['DB_HOST']) ? $_ENV['DB_HOST'] : null;
}

$dbname = getenv('DB_NAME');
if ($dbname === false) {
    $dbname = isset($_ENV['DB_NAME']) ? $_ENV['DB_NAME'] : null;
}

$username = getenv('DB_USER');
if ($username === false) {
    $username = isset($_ENV['DB_USER']) ? $_ENV['DB_USER'] : null;
}

$password = getenv('DB_PASSWORD');
if ($password === false) {
    $password = isset($_ENV['DB_PASSWORD']) ? $_ENV['DB_PASSWORD'] : null;
}


    // Vérification que les variables existent
    if (!$host || !$dbname || !$username || !$password) {
        die("Erreur : Variables d'environnement de base de données manquantes.");
    }
} else {
    // Environnement local (WAMP)
    $host = 'localhost';
    $dbname = 'bibliotheque';
    $username = 'root';
    $password = '';
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>