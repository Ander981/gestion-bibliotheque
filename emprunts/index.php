<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/header.php';

// Fonction pour déterminer la classe CSS en fonction de la date de retour
function getRetardClass($date_retour_prevue) {
    $today = new DateTime();
    $retour = new DateTime($date_retour_prevue);
    $interval = $today->diff($retour)->days;
    if ($retour < $today) {
        return 'retard'; // date passée
    } elseif ($interval <= 3) {
        return 'bientot'; // dans 3 jours ou moins
    } else {
        return 'en-cours'; // plus de 3 jours
    }
}

// Récupérer les emprunts en cours (non retournés)
$stmt = $pdo->query("
SELECT e.*, l.titre AS livre_titre, m.nom AS membre_nom, m.prenom AS membre_prenom
FROM emprunts e
JOIN livres l ON e.livre_id = l.id
JOIN membres m ON e.membre_id = m.id
WHERE e.date_retour_effective IS NULL
ORDER BY e.date_emprunt DESC
");
$emprunts_en_cours = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Emprunts en cours</h2>
<a href="ajouter.php" class="btn">Nouvel emprunt</a>

<?php if (empty($emprunts_en_cours)): ?>
<p>Aucun emprunt en cours.</p>
<?php else: ?>
<div class="table-scroll">
    <table>
        <thead>
            <tr>
                <th>Livre</th>
                <th>Membre</th>
                <th>Date d'emprunt</th>
                <th>Retour prévu</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($emprunts_en_cours as $emp): ?>
            <tr>
                <td><?= htmlspecialchars($emp['livre_titre']) ?></td>
                <td><?= htmlspecialchars($emp['membre_prenom'] . ' ' . $emp['membre_nom']) ?></td>
                <td><?= htmlspecialchars($emp['date_emprunt']) ?></td>
                <td><?= htmlspecialchars($emp['date_retour_prevue']) ?></td>
                <td>
                    <a href="retour.php?id=<?= $emp['id'] ?>" class="btn">Retourner</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<hr>

<h3>Historique complet</h3>
<p><a href="historique.php" class="btn">Voir tous les emprunts passés</a></p>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>