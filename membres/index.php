<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/includes/header.php';

// Récupérer tous les membres
$stmt = $pdo->query("SELECT * FROM membres ORDER BY nom, prenom");
$membres = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Liste des membres</h2>
<a href="ajouter.php" class="btn">Ajouter un membre</a>
<div class="table-scroll">
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Date d'inscription</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($membres as $membre): ?>
            <tr>
                <td><?= htmlspecialchars($membre['nom']) ?></td>
                <td><?= htmlspecialchars($membre['prenom']) ?></td>
                <td><?= htmlspecialchars($membre['email']) ?></td>
                <td><?= htmlspecialchars($membre['date_inscription']) ?></td>
                <td>
                    <a href="modifier.php?id=<?= $membre['id'] ?>">Modifier</a>
                    <a href="supprimer.php?id=<?= $membre['id'] ?>"
                        onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once '../includes/footer.php'; ?>