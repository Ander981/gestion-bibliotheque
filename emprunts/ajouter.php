<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/header.php';

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

<h2>Nouvel emprunt</h2>
<?php if (isset($error)): ?>
<p style="color:red;"><?= $error ?></p>
<?php endif; ?>

<form method="post">
    <div>
        <label for="livre_id">Livre :</label>
        <select name="livre_id" id="livre_id" required>
            <option value="">Choisissez un livre</option>
            <?php foreach ($livres as $livre): ?>
            <option value="<?= $livre['id'] ?>"><?= htmlspecialchars($livre['titre']) ?></option>
            <?php endforeach; ?>
        </select>
        <?php if (empty($livres)): ?>
        <p style="color:orange;">Aucun livre disponible pour le moment.</p>
        <?php endif; ?>
    </div>
    <div>
        <label for="membre_id">Membre :</label>
        <select name="membre_id" id="membre_id" required>
            <option value="">Choisissez un membre</option>
            <?php foreach ($membres as $membre): ?>
            <option value="<?= $membre['id'] ?>"><?= htmlspecialchars($membre['prenom'] . ' ' . $membre['nom']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label for="date_emprunt">Date d'emprunt :</label>
        <input type="date" name="date_emprunt" id="date_emprunt" value="<?= date('Y-m-d') ?>" required>
    </div>
    <div>
        <label for="date_retour_prevue">Date de retour prévue :</label>
        <input type="date" name="date_retour_prevue" id="date_retour_prevue"
            value="<?= date('Y-m-d', strtotime('+15 days')) ?>" required>
    </div>
    <button type="submit" class="btn">Enregistrer l'emprunt</button>
    <a href="index.php" class="btn">Annuler</a>
</form>

<?php require_once '../includes/footer.php'; ?>