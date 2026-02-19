<?php
require_once '../config/database.php';
require_once '../includes/auth_check.php';
require_once '../includes/header.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM livres WHERE id = ?");
$stmt->execute([$id]);
$livre = $stmt->fetch();

if (!$livre) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $annee = $_POST['annee'] ?: null;
    $isbn = $_POST['isbn'] ?: null;

    $sql = "UPDATE livres SET titre = ?, auteur = ?, annee = ?, isbn = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titre, $auteur, $annee, $isbn, $id]);

    header('Location: index.php');
    exit;
}
?>

<h2>Modifier le livre</h2>
<form method="post">
    <div>
        <label for="titre">Titre :</label>
        <input type="text" name="titre" id="titre" value="<?= htmlspecialchars($livre['titre']) ?>" required>
    </div>
    <div>
        <label for="auteur">Auteur :</label>
        <input type="text" name="auteur" id="auteur" value="<?= htmlspecialchars($livre['auteur']) ?>" required>
    </div>
    <div>
        <label for="annee">Année :</label>
        <input type="number" name="annee" id="annee" value="<?= htmlspecialchars($livre['annee']) ?>">
    </div>
    <div>
        <label for="isbn">ISBN :</label>
        <input type="text" name="isbn" id="isbn" value="<?= htmlspecialchars($livre['isbn']) ?>">
    </div>
    <button type="submit" class="btn">Modifier</button>
    <a href="index.php" class="btn">Annuler</a>
</form>

<?php require_once '../includes/footer.php'; ?>