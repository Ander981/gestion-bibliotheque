<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/header.php';

$stmt = $pdo->query("
    SELECT e.*, l.titre AS livre_titre, m.nom AS membre_nom, m.prenom AS membre_prenom
    FROM emprunts e
    JOIN livres l ON e.livre_id = l.id
    JOIN membres m ON e.membre_id = m.id
    ORDER BY e.date_emprunt DESC
");
$emprunts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Historique des emprunts</h2>
<a href="index.php" class="btn">Retour aux emprunts en cours</a>

<table>
    <thead>
        <tr>
            <th>Livre</th>
            <th>Membre</th>
            <th>Date emprunt</th>
            <th>Retour prévu</th>
            <th>Retour effectif</th>
            <th>Statut</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($emprunts as $emp): ?>
        <tr>
            <td><?= htmlspecialchars($emp['livre_titre']) ?></td>
            <td><?= htmlspecialchars($emp['membre_prenom'] . ' ' . $emp['membre_nom']) ?></td>
            <td><?= htmlspecialchars($emp['date_emprunt']) ?></td>
            <td><?= htmlspecialchars($emp['date_retour_prevue']) ?></td>
            <td><?= $emp['date_retour_effective'] ? htmlspecialchars($emp['date_retour_effective']) : '-' ?></td>
            <td>
                <?php if ($emp['date_retour_effective']): ?>
                Retourné
                <?php elseif (strtotime($emp['date_retour_prevue']) < time()): ?>
                <span style="color:red;">En retard</span>
                <?php else: ?>
                <span style="color:green;">En cours</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>