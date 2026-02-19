<?php
// config/database.php

$host = 'localhost';
$dbname = 'bibliotheque';     // Nom de votre base
$username = 'root';            // Utilisateur MySQL par défaut sous WAMP
$password = '';                // Mot de passe vide sous WAMP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>