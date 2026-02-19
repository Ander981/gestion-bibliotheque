<?php
// admin/ajouter_admin.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/header.php';

// Vérifier que l'utilisateur connecté est super_admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'super_admin') {
    header('Location: /bibliotheque/index.php');
    exit;
}

require_once '../includes/header.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Veuillez remplir tous les champs.";
    } else {
        // Vérifier si le nom d'utilisateur existe déjà
        $check = $pdo->prepare("SELECT id FROM utilisateurs WHERE username = ?");
        $check->execute([$username]);
        if ($check->fetch()) {
            $error = "Ce nom d'utilisateur est déjà pris.";
        } else {
            // Hasher le mot de passe
            $hash = password_hash($password, PASSWORD_DEFAULT);
            // Rôle 'admin'
            $role = 'admin';
            $sql = "INSERT INTO utilisateurs (username, password, role) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$username, $hash, $role])) {
                $message = "Administrateur '$username' créé avec succès.";
            } else {
                $error = "Erreur lors de la création.";
            }
        }
    }
}
?>

<h2>Ajouter un administrateur</h2>

<?php if ($message): ?>
<p style="color:green;"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>
<?php if ($error): ?>
<p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post">
    <div>
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" id="username" required>
    </div>
    <div>
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required>
    </div>
    <button type="submit" class="btn">Créer l'administrateur</button>
    <a href="/bibliotheque/index.php" class="btn">Annuler</a>
</form>

<?php require_once '../includes/footer.php'; ?>