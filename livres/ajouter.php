<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/header.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $annee = $_POST['annee'] ?: null;
    $isbn = $_POST['isbn'] ?: null;

    $sql = "INSERT INTO livres (titre, auteur, annee, isbn) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titre, $auteur, $annee, $isbn]);
    header('Location: index.php');
    exit;
}
?>


<h2>Ajouter un livre</h2>
<form method="post">

    <div>
        <label for="titre">Titre :</label>
        <input type="text" name="titre" id="titre" required>
    </div>
    <div>
        <label for="auteur">Auteur :</label>
        <input type="text" name="auteur" id="auteur" required>
    </div>
    <div>
        <label for="annee">Année :</label>
        <select name="annee" id="annee">
            <option value="">-- Sélectionnez --</option>
            <?php for ($year = date('Y'); $year >= 0000; $year--): ?>
            <option value="<?= $year ?>"><?= $year ?></option>
            <?php endfor; ?>
        </select>

    </div>
    <div>
        <label for="isbn">ISBN :</label>
        <input type="text" name="isbn" id="isbn">
    </div>
    <button type="submit" class="btn">Ajouter</button>
    <a href="index.php" class="btn">Annuler</a>
    <?php if (isset($_SESSION['username'])): ?>
    <div class="top-user-bar">
        <span class="user-greeting">
            Bonjour, <?= htmlspecialchars($_SESSION['username']) ?>
        </span>

        <a class="logout-btn" href="/bibliotheque/auth/logout.php">
            Déconnexion
        </a>
    </div>
    <?php endif; ?>
</form>

<?php require_once '../includes/footer.php'; ?>