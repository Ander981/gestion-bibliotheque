<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth_check.php';


// Récupérer les livres disponibles
$stmtLivres = $pdo->query("SELECT id, titre FROM livres WHERE disponible = 1 ORDER BY titre");
$livres = $stmtLivres->fetchAll(PDO::FETCH_ASSOC);

// Récupérer tous les membres
$stmtMembres = $pdo->query("SELECT id, nom, prenom FROM membres ORDER BY nom, prenom");
$membres = $stmtMembres->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $livre_id = $_POST['livre_id'];
    $membre_id = $_POST['membre_id'];
    $date_emprunt = $_POST['date_emprunt'];
    $date_retour_prevue = $_POST['date_retour_prevue'];

    // Vérifier que le livre est toujours disponible (au cas où)
    $check = $pdo->prepare("SELECT disponible FROM livres WHERE id = ?");
    $check->execute([$livre_id]);
    $livre = $check->fetch();
    if (!$livre || !$livre['disponible']) {
        $error = "Ce livre n'est pas disponible.";
    } else {
        // Commencer une transaction pour assurer la cohérence
        $pdo->beginTransaction();
        try {
            // Insérer l'emprunt
            $sql = "INSERT INTO emprunts (livre_id, membre_id, date_emprunt, date_retour_prevue) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$livre_id, $membre_id, $date_emprunt, $date_retour_prevue]);

            // Mettre à jour la disponibilité du livre
            $update = $pdo->prepare("UPDATE livres SET disponible = 0 WHERE id = ?");
            $update->execute([$livre_id]);

            $pdo->commit();
            header('Location: index.php');
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = "Erreur lors de l'enregistrement : " . $e->getMessage();
        }
    }
}
?>