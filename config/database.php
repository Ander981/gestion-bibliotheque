<?php
// config/database.php

// Détection de l'environnement
if (isset($_ENV['VERCEL'])) {
    // Nous sommes sur Vercel, on utilise les variables d'env.
  $host = isset($_ENV['DB_HOST']) ? $_ENV['DB_HOST'] : getenv('DB_HOST');
   $dbname = isset($_ENV['DB_NAME']) ? $_ENV['DB_NAME'] : getenv('DB_NAME');
$user   = isset($_ENV['DB_USER']) ? $_ENV['DB_USER'] : getenv('DB_USER');
$pass   = isset($_ENV['DB_PASSWORD']) ? $_ENV['DB_PASSWORD'] : getenv('DB_PASSWORD');

} else {
    // Nous sommes en local (WAMP/XAMPP)
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