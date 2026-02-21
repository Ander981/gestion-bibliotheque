<?php
require_once __DIR__ . '/../config/database.php';
// require_once __DIR__ . '/../includes/auth_check.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $annee = $_POST['annee'] ?: null;
    $isbn = $_POST['isbn'] ?: null;

    $sql = "INSERT INTO livres (titre, auteur, annee, isbn) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titre, $auteur, $annee, $isbn]);
    exit;
}
?>