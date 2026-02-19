<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/header.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];

// Vérifier si le livre est actuellement emprunté (non retourné)
$stmt = $pdo->prepare("SELECT id FROM emprunts WHERE livre_id = ? AND date_retour_effective IS NULL");
$stmt->execute([$id]);
if ($stmt->fetch()) {
    // Rediriger avec un message d'erreur (utiliser une session pour message)
    session_start();
    $_SESSION['error'] = "Impossible de supprimer ce livre car il est actuellement emprunté.";
    header('Location: index.php');
    exit;
}

// Supprimer le livre
$stmt = $pdo->prepare("DELETE FROM livres WHERE id = ?");
$stmt->execute([$id]);

header('Location: index.php');
exit;