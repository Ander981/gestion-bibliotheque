<?php
// config/database.php

$host = 'localhost';
$dbname = 'bibliotheque';
$username = 'root';       // par défaut 
$password = '';           // par défaut

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>