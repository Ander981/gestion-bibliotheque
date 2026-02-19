<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/header.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM membres WHERE id = ?");
$stmt->execute([$id]);
$membre = $stmt->fetch();

if (!$membre) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];

    // Vérifier si l'email est déjà pris par un autre membre
    $check = $pdo->prepare("SELECT id FROM membres WHERE email = ? AND id != ?");
    $check->execute([$email, $id]);
    if ($check->fetch()) {
        $error = "Cet email est déjà utilisé par un autre membre.";
    } else {
        $sql = "UPDATE membres SET nom = ?, prenom = ?, email = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $prenom, $email, $id]);
        header('Location: index.php');
        exit;
    }
}
?>

<h2>Modifier le membre</h2>
<?php if (isset($error)): ?>
<p style="color:red;"><?= $error ?></p>
<?php endif; ?>
<form method="post">
    <div>
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($membre['nom']) ?>" required>
    </div>
    <div>
        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($membre['prenom']) ?>" required>
    </div>
    <div>
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($membre['email']) ?>" required>
    </div>
    <button type="submit" class="btn">Modifier</button>
    <a href="index.php" class="btn">Annuler</a>
</form>

<?php require_once '../includes/footer.php'; ?>