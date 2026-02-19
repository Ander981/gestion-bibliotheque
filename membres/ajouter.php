<?php
require_once '../config/database.php';
require_once '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];

    // Vérifier si l'email existe déjà
    $check = $pdo->prepare("SELECT id FROM membres WHERE email = ?");
    $check->execute([$email]);
    if ($check->fetch()) {
        $error = "Cet email est déjà utilisé.";
    } else {
        $sql = "INSERT INTO membres (nom, prenom, email) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $prenom, $email]);
        header('Location: index.php');
        exit;
    }
}
?>

<h2>Ajouter un membre</h2>
<?php if (isset($error)): ?>
<p style="color:red;"><?= $error ?></p>
<?php endif; ?>
<form method="post">
    <div>
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" required>
    </div>
    <div>
        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" required>
    </div>
    <div>
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required>
    </div>
    <button type="submit" class="btn">Ajouter</button>
    <a href="index.php" class="btn">Annuler</a>
</form>

<?php require_once '../includes/footer.php'; ?>