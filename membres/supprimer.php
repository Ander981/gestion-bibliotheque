<?php
require_once '../config/database.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];

// Vérifier si le membre a des emprunts en cours (non retournés)
$stmt = $pdo->prepare("SELECT id FROM emprunts WHERE membre_id = ? AND date_retour_effective IS NULL");
$stmt->execute([$id]);
if ($stmt->fetch()) {
    // Rediriger avec un message d'erreur (on peut utiliser une session pour message)
    header('Location: index.php?error=Ce membre a des emprunts en cours, suppression impossible');
    exit;
}

// Supprimer le membre
$stmt = $pdo->prepare("DELETE FROM membres WHERE id = ?");
$stmt->execute([$id]);

header('Location: index.php');
exit;