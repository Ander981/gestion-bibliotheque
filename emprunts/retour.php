<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/header.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];

// Récupérer l'emprunt pour connaître le livre
$stmt = $pdo->prepare("SELECT livre_id FROM emprunts WHERE id = ? AND date_retour_effective IS NULL");
$stmt->execute([$id]);
$emprunt = $stmt->fetch();

if ($emprunt) {
    $pdo->beginTransaction();
    try {
        // Mettre à jour la date de retour effective
        $updateEmprunt = $pdo->prepare("UPDATE emprunts SET date_retour_effective = CURDATE() WHERE id = ?");
        $updateEmprunt->execute([$id]);

        // Remettre le livre disponible
        $updateLivre = $pdo->prepare("UPDATE livres SET disponible = 1 WHERE id = ?");
        $updateLivre->execute([$emprunt['livre_id']]);

        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        // Gérer l'erreur (on peut rediriger avec message)
    }
}

header('Location: index.php');
exit;