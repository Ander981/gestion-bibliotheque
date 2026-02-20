<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/header.php';

// Gestion de la recherche
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($search !== '') {
    // Solution 1 : Utiliser deux paramètres distincts
    $stmt = $pdo->prepare("SELECT * FROM livres WHERE titre LIKE :titre OR auteur LIKE :auteur ORDER BY titre");
    $stmt->execute([
        'titre' => "%$search%",
        'auteur' => "%$search%"
    ]);
} else {
    $stmt = $pdo->query("SELECT * FROM livres ORDER BY titre");
}

$livres = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<h2>Liste des livres</h2>
<a href="ajouter.php" class="btn">Ajouter un livre</a>

<!-- Formulaire de recherche -->
<form method="get" action="index.php" style="margin: 1rem 0;">
    <input type="text" name="search" placeholder="Rechercher par titre ou auteur..."
        value="<?= htmlspecialchars($search) ?>">
    <button type="submit" class="btn">Rechercher</button>
    <?php if ($search !== ''): ?>
    <a href="index.php" class="btn">Effacer</a>
    <?php endif; ?>
</form>
<div class="table-scroll">
    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Année</th>
                <th>ISBN</th>
                <th>Disponible</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($livres as $livre): ?>
            <tr>
                <td><?= htmlspecialchars($livre['titre']) ?></td>
                <td><?= htmlspecialchars($livre['auteur']) ?></td>
                <td><?= htmlspecialchars($livre['annee']) ?></td>
                <td><?= htmlspecialchars($livre['isbn']) ?></td>
                <td><?= $livre['disponible'] ? 'Oui' : 'Non' ?></td>
                <td>
                    <a href="modifier.php?id=<?= $livre['id'] ?>">Modifier</a>
                    <a href="supprimer.php?id=<?= $livre['id'] ?>"
                        onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>